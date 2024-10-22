<?php

    require_once('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');
    require_once('custom/modules/TRI_TechnicalRequestItems/helper/TechnicalRequestItemsHelper.php');
    require_once('custom/modules/TRWG_TRWorkingGroup/helpers/TRWorkingGroupHelper.php');
    require_once('custom/modules/MKT_Markets/helpers/MarketsHelper.php');
    require_once('custom/modules/COMP_Competitor/helpers/CompetitorHelper.php');
    require_once('custom/modules/DSBTN_Distribution/helper/DistributionHelper.php');
    require_once('include/UploadFile.php');

	class TechnicalRequestAfterSaveHook {

        public function form_after_save(&$bean, $event, $arguments)
        {
            global $log;

            $this->_calculate_amounts($bean);
            $this->_calculate_opportunity_probability($bean);
            //$this->_redirect_to_technical_request($bean);
            $this->_handle_tr_closed($bean);
            $this->_duplicate_redirect_logic($bean);
        }

        public function handleDocumentUpload(&$bean, $event, $arguments)
        {
            global $current_user, $log, $sugar_config;
            $fields = array( array('name' => 'safety_data_sheet_new_c', 'label' => 'Safety Data Sheet'), 
                array('name' => 'technical_data_sheet_c', 'label' => 'Technical Data Sheet'));

            //Colormatch #310/309 - prevent from being executed during attachment deletion where entrypoint = deleteFFAttachment
            if(empty($_GET['entryPoint'])){ 

                foreach($fields as $field){
                   
                    if ($_POST['custom_rematch_type'] && in_array($_POST['custom_rematch_type'], ['rematch_rejected', 'copy_full'])) { //copy_full

                        $originalTrID = !empty($_POST['custom_rematch_original_tr'])
                            ?   $_POST['custom_rematch_original_tr']
                            :  $_POST['custom_reference_tr_id_nondb']; // custom_reference_tr_id_nondb is set in view.edit.php

                        if (!empty($bean->{$field['name']}) && file_exists($sugar_config['upload_dir'] . $originalTrID. '_' . $field['name'])) {
                            $oldFileName = $originalTrID. '_' . $field['name'];
                            $newFileName = $bean->id. '_' . $field['name'];
                            
                            // duplicate file with the new bean->id prefix
                            UploadFile::duplicate_file($oldFileName, $newFileName, $bean->{$field['name']});
                        }


                    }

                    if (!empty($bean->{$field['name']}) && file_exists($sugar_config['upload_dir'] . $bean->id . '_' . $field['name'])) {
                        $bean->load_relationship('tr_technicalrequests_documents');
                        $tr_documents = $bean->tr_technicalrequests_documents->getBeans();

                        $is_file_exist = false;
                        foreach($tr_documents as $tr_document){
                            if (html_entity_decode($tr_document->document_name) == html_entity_decode($bean->{$field['name']})) {
                                $is_file_exist = true;
                            }
                        }

                        if(!$is_file_exist){
                            $docBean = BeanFactory::newBean('Documents');
                            $docBean->status_id = 'Active';
                            $docBean->doc_type = 'Sugar';
                            $docBean->document_name = $bean->{$field['name']};
                            $docBean->assigned_user_id = $current_user->id;
                            $docBean->assigned_user_name = $current_user->name;
                            $docBean->upload_source_id = $bean->id;// Used by Document.php to properly rename file based on upload source id
                            $docBean->category_id = 'TechnicalRequest';
                            $docBean->subcategory_id = ($field['label'] == 'Technical Data Sheet') ? 'TechnicalRequest_TDS' : 'TechnicalRequest_SDS';
                            $docBean->parent_type = 'TR_TechnicalRequests';
                            $docBean->parent_id = $bean->id;

                            $docBean->save();

                            $docBean->load_relationship('tr_technicalrequests_documents');

                            if (isset($docBean->tr_technicalrequests_documents)) {				
                                $docBean->tr_technicalrequests_documents->add($bean->id); // Link document and the selected module
                            }

                            $docRevision = new DocumentRevision();
                            $docRevision->revision = 1;
                            $docRevision->document_id = $docBean->id;
                            $docRevision->filename = $bean->{$field['name']};
                            
                            require_once('include/utils/file_utils.php');
                            $extension = get_file_extension($_FILES[$field['name']]['name']);
                   
                            if (! empty($extension)) {
                                $docRevision->file_ext = $extension;
                                $docRevision->file_mime_type = get_mime_content_type_from_filename($_FILES[$field['name']]['name']);
                            }
                        
                            
                            $docRevision->save();

                            $file = $sugar_config['upload_dir'] . $bean->id . '_' . $field['name'];
                            $newfile =  $sugar_config['upload_dir'] . $docRevision->id;

                            if (!copy($file, $newfile)) {
                                $log->fatal('failed to copy' . $bean->id . '_' . $field['name']);
                            }
                        }
                    }
                }
            }
        }

        public function handleProductMasterStatusChange(&$bean, $event, $arguments)
        {
            $technicalRequestProductMasterBeanList = $bean->get_linked_beans(
                'tr_technicalrequests_aos_products_2',
                'AOS_Products',
                array(),
                0,
                -1,
                0,
                "tr_technicalrequests_aos_products_2_c.tr_technicalrequests_aos_products_2tr_technicalrequests_ida = '{$bean->id}'"
            );

            if ($technicalRequestProductMasterBeanList != null && count($technicalRequestProductMasterBeanList) > 0) {
                if ($bean->approval_stage != $bean->fetched_row['approval_stage']) {                
                    foreach ($technicalRequestProductMasterBeanList as $productMasterBean) {
                        if ($bean->approval_stage == 'closed_rejected') {
                            $productMasterBean->type = 'development';
                            $productMasterBean->status_c = 'rejected';
                        }
                        
                        if ($bean->approval_stage == 'closed_won') {
                            $productMasterBean->type = 'production';
                            $productMasterBean->status_c = 'active';
                        }
    
                        if ($productMasterBean->type != $productMasterBean->fetched_row['type'] || $productMasterBean->status_c != $productMasterBean->fetched_row['status_c']) {
                            $productMasterBean->save();
                        }
                    }
                }
            }
        }
        
        public function generate_workgroup($bean, $event, $arguments)
        {
            if ($_REQUEST['massupdate']) {
                return true;
            }
            
            $sortedList = [];
            
            // Always monitor changes for Sales Person, Manager, SAM, and MDM on save to make sure it matches what's currently on the Account level
            $sortedList['SalesPerson'] = 'Sales Person';
            $sortedList['SalesManager'] = 'Sales Manager';
            // Ontrack 1971: Removed SAM and MDM Capa Role creation
            /* $sortedList['MarketDevelopmentManager'] = 'Market Development Manager';
            $sortedList['StrategicAccountManager'] = 'Strategic Account Manager';*/

            if ($bean->approval_stage == 'development') {
                switch ($bean->status) {
                    case 'new':
                        $sortedList['ColorMatcher'] = 'Color Matcher';
                        break;
                    case 'approved':
                        $sortedList['RDManager'] = 'R&D Manager';
                        $sortedList['QuoteManager'] = 'Quote Manager';
                        $sortedList['ColorMatchCoordinator'] = 'Color Match Coordinator';
                        $sortedList['RegulatoryManager'] = 'Regulatory Manager';
                        break;
                    case 'awaiting_target_resin':
                        $sortedList['RDManager'] = 'R&D Manager';
                    default:
                        break;
                }
            }

            if (count($sortedList) > 0) {
                $sortedList['Creator'] = 'Creator';

                // sort TR Role array, transfer CREATOR role to end of Arrays
                foreach ($sortedList as $tr_role_key => $tr_role) {
                    if ($tr_role != '') {
                        TRWorkingGroupHelper::createOrUpdateTRRole($bean, $tr_role_key);
                    }
                }
            }
        }

        private function _calculate_amounts($bean)
        {
 
            $opportunity_ids = TechnicalRequestHelper::get_opportunity_ids($bean->id);

            if(count($opportunity_ids) > 0){
                foreach($opportunity_ids as $opportunity_id){
                    $related_trs = TechnicalRequestHelper::get_opportunity_trs($opportunity_id);
                    $related_trs_count = count($related_trs);

                    foreach($related_trs as $related_tr)
                    {
                        $probability_percentage = $related_tr->probability_c;

                        $amount_weighted = TechnicalRequestHelper::get_tr_annual_amount_weighted($related_tr->annual_amount_c, $probability_percentage);
                        
                        $probability_calculated = ($probability_percentage > 0) ? $probability_percentage / $related_trs_count : 0;

                        $this->_update_tr_amounts($related_tr->id, $amount_weighted, $probability_calculated);
                    }
                }
            }
        }

        public function sendEmailNotifications(&$bean, $event, $arguments)
        {
            global $sugar_config, $app_list_strings, $current_user, $db, $timedate, $log;
            
            $sendEmail = false;
            $valueIsUpdated = TechnicalRequestHelper::beanFieldValueChangeChecker($bean); // array of boolean values supplied when auditable field values are updated
            $customQABanner = $sugar_config['isQA'] == true ? '<span style="color: red;">***This is a test from the Empower QA System***</span><br><br>' : '';
            $recordURL = "<a href='{$sugar_config['site_url']}/index.php?module={$bean->module_name}&action=DetailView&record={$bean->id}'>{$sugar_config['site_url']}/index.php?module={$bean->module_name}&action=DetailView&record={$bean->id}</a>";
            $submittedBy = $bean->created_by_name ?? $current_user->name;            
            $dateEntered = handleRetrieveBeanDateEntered($bean);
            $customDateEnteredFormat = $dateEntered ? date("Y-m-d", strtotime($dateEntered)) : date("Y-m-d");

            $emailObj = new Email();
            $defaults = $emailObj->getSystemDefaultEmail();
            $mail = new SugarPHPMailer();
            $mail->setMailerForSystem();
            $mail->From = $defaults['email'];
            $mail->FromName = $defaults['name'];

            // TR - Account Bean
            if (is_object($bean->tr_technicalrequests_accountsaccounts_ida)) {
                $accountBean = $_REQUEST['tr_technicalrequests_accountsaccounts_ida'] ? BeanFactory::getBean('Accounts', $_REQUEST['tr_technicalrequests_accountsaccounts_ida']) : null;
            } else {
                $accountBean = $bean->tr_technicalrequests_accountsaccounts_ida ? BeanFactory::getBean('Accounts', $bean->tr_technicalrequests_accountsaccounts_ida) : null;
            }

            // TR - Opportunity Bean
            if (is_object($bean->tr_technicalrequests_opportunitiesopportunities_ida)) {
                $opportunityBean = $_REQUEST['tr_technicalrequests_opportunitiesopportunities_ida'] ? BeanFactory::getBean('Opportunities', $_REQUEST['tr_technicalrequests_opportunitiesopportunities_ida']) : null;
            } else {
                $opportunityBean = $bean->tr_technicalrequests_opportunitiesopportunities_ida ? BeanFactory::getBean('Opportunities', $bean->tr_technicalrequests_opportunitiesopportunities_ida) : null;
            }
            
            $accountName = ($accountBean && $accountBean->name) ? $accountBean->name : $bean->tr_technicalrequests_accounts_name;
            $opportunityName = ($opportunityBean && $opportunityBean->name) ? $opportunityBean->name : $bean->tr_technicalrequests_opportunities_name;

            // User Beans -- START

            // Created By
            $workGroupCreatedByList = $bean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'Creator' AND trwg_trworkinggroup.parent_type = 'Users'");
            $createdByUserBean = (!empty($workGroupCreatedByList) && count($workGroupCreatedByList) > 0) ? BeanFactory::getBean('Users', $workGroupCreatedByList[0]->parent_id) : null;
            
            // Sales Rep
            $workGroupSalesRepList = $bean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'SalesPerson' AND trwg_trworkinggroup.parent_type = 'Users'");
            $salesRepBean = (!empty($workGroupSalesRepList) && count($workGroupSalesRepList) > 0) ? BeanFactory::getBean('Users', $workGroupSalesRepList[0]->parent_id) : null;

            /*
             * Ontrack 1971: Removed SAM and MDM email notification recipients
             * // SAM
            $workGroupSAMList = $bean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'StrategicAccountManager' AND trwg_trworkinggroup.parent_type = 'Users'");
            $accountSAMBean = (!empty($workGroupSAMList) && count($workGroupSAMList) > 0) ? BeanFactory::getBean('Users', $workGroupSAMList[0]->parent_id) : null;

            // MDM
            $workGroupMDMList = $bean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'MarketDevelopmentManager' AND trwg_trworkinggroup.parent_type = 'Users'");
            $accountMDMBean = (!empty($workGroupMDMList) && count($workGroupMDMList) > 0) ? BeanFactory::getBean('Users', $workGroupMDMList[0]->parent_id) : null;*/

            // Sales Manager
            $workGroupSalesManagerList = $bean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'SalesManager' AND trwg_trworkinggroup.parent_type = 'Users'");
            $salesManagerBean = (!empty($workGroupSalesManagerList) && count($workGroupSalesManagerList) > 0) ? BeanFactory::getBean('Users', $workGroupSalesManagerList[0]->parent_id) : null;

            // R&D Manager
            // Ontrack #1934: Notification will be sent to Working group Lab Manager, ColorMatch Coordinator, and ColorMatcher roles
            if ($bean->approval_stage == 'development' && $bean->status == 'new') {
                $siteRDManagerBean = retrieveUserBySecurityGroupTypeDivision('R&D Manager', 'TRWorkingGroup', $bean->site, $bean->division);
            } else {
                $workGroupSiteRDManagerList = $bean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'RDManager' AND trwg_trworkinggroup.parent_type = 'Users'");
                $siteRDManagerBean = (!empty($workGroupSiteRDManagerList) && count($workGroupSiteRDManagerList) > 0) ? BeanFactory::getBean('Users', $workGroupSiteRDManagerList[0]->parent_id) : null;
            }

            // Color Match Coordinator
            $workGroupColormatchCoordinatorList = $bean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'ColorMatchCoordinator' AND trwg_trworkinggroup.parent_type = 'Users'");
            $siteColormatchCoordinatorBean = (!empty($workGroupColormatchCoordinatorList) && count($workGroupColormatchCoordinatorList) > 0) ? BeanFactory::getBean('Users', $workGroupColormatchCoordinatorList[0]->parent_id) : null;

            // Quote Manager
            $workGroupSiteQuoteManagerList = $bean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'QuoteManager' AND trwg_trworkinggroup.parent_type = 'Users'");
            $siteQuoteManagerBean = (!empty($workGroupSiteQuoteManagerList) && count($workGroupSiteQuoteManagerList) > 0) ? BeanFactory::getBean('Users', $workGroupSiteQuoteManagerList[0]->parent_id) : null; // Quote Manager

            // ColorMatcher
            $workGroupSiteColorMatcherList = $bean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'ColorMatcher' AND trwg_trworkinggroup.parent_type = 'Users'");
            $siteColorMatcherBean = (!empty($workGroupSiteColorMatcherList) && count($workGroupSiteColorMatcherList) > 0) ? BeanFactory::getBean('Users', $workGroupSiteColorMatcherList[0]->parent_id) : null;

            // If $createdByUserBean is empty, then Creator workgroup does not exist since it is equal to Sales Rep, therefore assign $createdByUserBean to $salesRepBean
            if ((! $createdByUserBean) || ($createdByUserBean && ! $createdByUserBean->id)) {
                $createdByUserBean = $salesRepBean;
            }

            // If $createdByUserBean and $salesRepBean exists and $createdByUserBean is not equal $salesRepBean, set $createdByUserBean = $salesRepBean
            // if (($createdByUserBean && $createdByUserBean->id) && ($salesRepBean && $salesRepBean->id) && $createdByUserBean->id != $salesRepBean->id) {
            //     $createdByUserBean = $salesRepBean;
            // }

            // User Beans -- END
            
            if ($bean->approval_stage == 'understanding_requirements') {
                $bean->assigned_user_id = $createdByUserBean->id;
                $sendEmail = false;
            }

            if ($bean->approval_stage == 'development') {
                switch ($bean->status) {
                    case 'new':

                        // Ontrack #1934: Notification will be sent to Working group Lab Manager, ColorMatch Coordinator, and ColorMatcher roles
                        if (empty($siteColormatchCoordinatorBean)) {
                            // By way of workflow, ColorMatch Coordinator working group is not yet generated at this status so retrieve ColorMatch Coordinator by way of the Roles
                            $siteColormatchCoordinatorBean = retrieveUserByRoleSiteDivision('Colormatch Coordinator', $bean->site, $bean->division);
                        }

                        if (empty($siteColorMatcherBean)) {
                            // By way of workflow, ColorMatch Coordinator working group is not yet generated at this status so retrieve ColorMatch Coordinator by way of the Roles
                            $siteColorMatcherBean = retrieveUserByRoleSiteDivision('Colormatcher', $bean->site, $bean->division);
                        }

                        if($siteRDManagerBean || $siteColormatchCoordinatorBean || $siteColorMatcherBean) {
                            $bean->assigned_user_id = isset($siteRDManagerBean->id) ? $siteRDManagerBean->id : $bean->assigned_user_id;
                            
                            if ($siteRDManagerBean->id != $current_user->id) {
                                // To Site R&D Manager
                                $mail->AddAddress($siteRDManagerBean->emailAddress->getPrimaryAddress($siteRDManagerBean), $siteRDManagerBean->name);

                            }

                            if ($siteColorMatcherBean->id != $current_user->id) {
                                // To Site R&D Manager
                                $mail->AddAddress($siteColorMatcherBean->emailAddress->getPrimaryAddress($siteColorMatcherBean), $siteColorMatcherBean->name);

                            }

                            if ($siteColormatchCoordinatorBean->id != $current_user->id) {
                                // To Site R&D Manager
                                $mail->AddAddress($siteColormatchCoordinatorBean->emailAddress->getPrimaryAddress($siteColormatchCoordinatorBean), $siteColormatchCoordinatorBean->name);

                            }

                            // CC Sales Rep, SAM, MDM
                            ($salesRepBean && $salesRepBean->id !== $bean->assigned_user_id && $current_user->id != $salesRepBean->id) ? $mail->addCC($salesRepBean->emailAddress->getPrimaryAddress($salesRepBean), $salesRepBean->name) : null;

                            if ($bean->type == 'color_match' && $opportunityBean && $opportunityBean->amount > 25000) {
                                ($salesManagerBean && $salesManagerBean->id !== $bean->assigned_user_id && $current_user->id != $salesManagerBean->id) ? $mail->addCC($salesManagerBean->emailAddress->getPrimaryAddress($salesManagerBean), $salesManagerBean->name) : null;
                            }

                            /*
                             * Send Notification when TR Item 'Colormatch' != 'Complete' && If values for any audited
                             * fields are update */
                            // Retrieve TR's Colormatch TR Item with Status = 'Complete'
                            $colormatchTri = $bean->get_linked_beans(
                                'tri_technicalrequestitems_tr_technicalrequests',
                                'TRI_TechnicalRequestItems',
                                array(), 0, -1, 0,
                                "tri_technicalrequestitems.name = 'colormatch_task' AND tri_technicalrequestitems.status = 'complete'"
                            );

                            $sendEmail = (empty($colormatchTri)); // False if Colormatch TRI is complete

                        }
                        break;
                    case 'more_information':
                        if ($salesRepBean) {
                            $bean->assigned_user_id = $salesRepBean->id;

                            if ($current_user->id != $salesRepBean->id) {
                                // To Sales Rep
                                $mail->AddAddress($salesRepBean->emailAddress->getPrimaryAddress($salesRepBean), $salesRepBean->name);
                                $sendEmail = true;

                            } else {
                                $sendEmail = false;
                            }

                            $bean->approval_stage = 'understanding_requirements';
                            $bean->probability_c = TechnicalRequestHelper::get_tr_probability_percentage($bean->approval_stage);
                            $this->setTRStageStatusProbability($bean);
                        }
                        break;
                    case 'awaiting_target_resin':
                        if ($siteRDManagerBean) {
                            $bean->assigned_user_id = $siteRDManagerBean->id;

                            if ($current_user->id != $siteRDManagerBean->id) {
                                // To Site R&D Manager
                                $mail->AddAddress($siteRDManagerBean->emailAddress->getPrimaryAddress($siteRDManagerBean), $siteRDManagerBean->name);
                                $sendEmail = true;

                            } else {
                                $sendEmail = false;
                            }
                        }
                        break;
                    case 'approved':

                        // Ontrack #1934: Notification will be sent to Working group Lab Manager, ColorMatch Coordinator, and ColorMatcher roles
                        if (empty($siteColormatchCoordinatorBean)) {
                            // By way of workflow, ColorMatch Coordinator working group is not yet generated at this status so retrieve ColorMatch Coordinator by way of the Roles
                            $siteColormatchCoordinatorBean = retrieveUserByRoleSiteDivision('Colormatch Coordinator', $bean->site, $bean->division);
                        }

                        if (empty($siteColorMatcherBean)) {
                            // By way of workflow, ColorMatch Coordinator working group is not yet generated at this status so retrieve ColorMatch Coordinator by way of the Roles
                            $siteColorMatcherBean = retrieveUserByRoleSiteDivision('Colormatcher', $bean->site, $bean->division);
                        }

                        if ($siteColormatchCoordinatorBean) {
                            $bean->assigned_user_id = $siteColormatchCoordinatorBean->id;

                            // To Colormatch Coordinator
                            $mail->AddAddress($siteColormatchCoordinatorBean->emailAddress->getPrimaryAddress($siteColormatchCoordinatorBean), $siteColormatchCoordinatorBean->name);

                            $mail->AddAddress($siteColorMatcherBean->emailAddress->getPrimaryAddress($siteColormatchCoordinatorBean), $siteColorMatcherBean->name);

                            $mail->AddAddress($siteRDManagerBean->emailAddress->getPrimaryAddress($siteRDManagerBean), $siteRDManagerBean->name);

                            // CC Sales Rep, SAM, MDM
                            ($salesRepBean && $salesRepBean->id !== $bean->assigned_user_id) ? $mail->addCC($salesRepBean->emailAddress->getPrimaryAddress($salesRepBean), $salesRepBean->name) : null;

                            $colormatchTri = $bean->get_linked_beans(
                                'tri_technicalrequestitems_tr_technicalrequests',
                                'TRI_TechnicalRequestItems',
                                array(), 0, -1, 0,
                                "tri_technicalrequestitems.name = 'colormatch_task' AND tri_technicalrequestitems.status = 'complete'"
                            );

                            $sendEmail = (empty($colormatchTri)); // False if Colormatch TRI is complete

                        }
                        break;
                    case 'in_process':
                        if ($siteColormatchCoordinatorBean) {
                            $bean->assigned_user_id = $siteColormatchCoordinatorBean->id;
                        }

                        // To Colormatch Coordinator
                        $mail->AddAddress($siteColormatchCoordinatorBean->emailAddress->getPrimaryAddress($siteColormatchCoordinatorBean), $siteColormatchCoordinatorBean->name);

                        $mail->AddAddress($siteColorMatcherBean->emailAddress->getPrimaryAddress($siteColormatchCoordinatorBean), $siteColorMatcherBean->name);

                        $mail->AddAddress($siteRDManagerBean->emailAddress->getPrimaryAddress($siteRDManagerBean), $siteRDManagerBean->name);

                        $colormatchTri = $bean->get_linked_beans(
                            'tri_technicalrequestitems_tr_technicalrequests',
                            'TRI_TechnicalRequestItems',
                            array(), 0, -1, 0,
                            "tri_technicalrequestitems.name = 'colormatch_task' AND tri_technicalrequestitems.status = 'complete'"
                        );

                        $sendEmail = (empty($colormatchTri)); // False if Colormatch TRI is complete

                        break;
                    case 'development_complete':
                        $this->handleSetDevelopmentClosedDate($bean);
                        $this->handleTRItemsOnTrDevelopmentComplete($bean);
                        
                        // If TR Type is Product Chips or Product Sample, set Stage to Closed and Status to Chips/Sample Complete, else trigger TR Type checker logic for Quoting/Proposing vs Sampling
                        if (in_array($bean->type, ['lab_items'])) {
                            $bean->approval_stage = 'closed';
                            $bean->status = 'chip_sample_complete';
                        } else {
                            // If Colormatch Type = Chips + Quote + Sample, set Stage to Sampling, else, set to Quoting/Proposing
                            $bean->approval_stage = ($bean->colormatch_type_c == 'chips_quote_sample') ? 'sampling' : 'quoting_or_proposing';
                            $bean->status = 'new';
                        }

                        $bean->probability_c = TechnicalRequestHelper::get_tr_probability_percentage($bean->approval_stage);
                        $this->setTRStageStatusProbability($bean);
                        break;
                    default:
                        break;
                }
            }

            if ($bean->approval_stage == 'closed') {
                switch ($bean->status) {
                    case 'chip_sample_complete':
                        if ($salesRepBean) {
                            $bean->assigned_user_id = $salesRepBean->id;
                            if ($bean->assigned_user_id != $current_user->id) {
                                // To Sales Rep, SAM, MDM, Site R&D Manager
                                ($salesRepBean && $salesRepBean->id && $current_user->id != $salesRepBean->id) ? $mail->AddAddress($salesRepBean->emailAddress->getPrimaryAddress($salesRepBean), $salesRepBean->name) : null;
                            }
                            
                            // CC Site Sales Manager
                            ($siteRDManagerBean && $siteRDManagerBean->id !== $bean->assigned_user_id && $current_user->id != $siteRDManagerBean->id) ? $mail->addCC($siteRDManagerBean->emailAddress->getPrimaryAddress($siteRDManagerBean), $siteRDManagerBean->name) : null;
                            $sendEmail = true;
                          
                        }
                        break;
                        break;
                    default:
                        break;
                }
            }

            if ($bean->approval_stage == 'quoting_or_proposing') {
                switch ($bean->status) {
                    case 'new':
                    case 'chips_submitted_for_customer_approval':
                    case 'chips_approved':
                    case 'quote_available':
                    case 'quote_submitted_for_customer_approval':
                    case 'quote_approved':
                        if ($bean->type == 'product_analysis') {
                            $salesRepBean = $createdByUserBean;
                        }

                        if ($salesRepBean) {
                            $bean->assigned_user_id = $salesRepBean->id;
                            if ($bean->assigned_user_id != $current_user->id) {
                                // To Sales Rep
                                $mail->AddAddress($salesRepBean->emailAddress->getPrimaryAddress($salesRepBean), $salesRepBean->name);
                            }

                            $sendEmail = false;
                        }
                        break;
                    default:
                        break;
                }
            }

            if ($bean->approval_stage == 'sampling') {
                switch ($bean->status) {
                    case 'new':
                        if ($salesRepBean) {
                            $bean->assigned_user_id = $salesRepBean->id;
                            if ($current_user->id != $bean->assigned_user_id) {
                                // To Sales Rep
                                $mail->AddAddress($salesRepBean->emailAddress->getPrimaryAddress($salesRepBean), $salesRepBean->name);
                            }

                            $sendEmail = false;
                        }
                        break;
                    case 'sample_submitted_for_customer_approval':
                        if ($salesRepBean) {
                            $bean->assigned_user_id = $salesRepBean->id;
                            if ($current_user->id != $bean->assigned_user_id) {
                                // To Sales Rep
                                $mail->AddAddress($salesRepBean->emailAddress->getPrimaryAddress($salesRepBean), $salesRepBean->name);
                            }

                            // CC Site R&D Manager
                            ($siteRDManagerBean && $siteRDManagerBean->id !== $bean->assigned_user_id && $current_user->id != $siteRDManagerBean->id) ? $mail->addCC($siteRDManagerBean->emailAddress->getPrimaryAddress($siteRDManagerBean), $siteRDManagerBean->name) : null;

                            $sendEmail = false;
                        }
                        break;
                    case 'sample_approved':
                        if ($salesRepBean) {
                            $bean->assigned_user_id = $salesRepBean->id;
                  
                            // To Sales Rep
                            ($salesRepBean && $salesRepBean->id && $current_user->id != $salesRepBean->id) ? $mail->AddAddress($salesRepBean->emailAddress->getPrimaryAddress($salesRepBean), $salesRepBean->name) : null;

                            $sendEmail = false;
                        }
                        break;
                    default:
                        break;
                }
            }

            if ($bean->approval_stage == 'production_trial') {
                switch ($bean->status) {
                    case 'new':
                        if ($salesRepBean) {
                            $bean->assigned_user_id = $salesRepBean->id;
                            
                            if ($current_user->id != $bean->assigned_user_id) {
                                // To Sales Rep, SAM, MDM
                                ($salesRepBean && $salesRepBean->id) ? $mail->AddAddress($salesRepBean->emailAddress->getPrimaryAddress($salesRepBean), $salesRepBean->name) : null;

                            }

                            // CC Site R&D Manager
                            ($siteRDManagerBean && $siteRDManagerBean->id !== $bean->assigned_user_id && $current_user->id != $siteRDManagerBean->id) ? $mail->addCC($siteRDManagerBean->emailAddress->getPrimaryAddress($siteRDManagerBean), $siteRDManagerBean->name) : null;

                            $sendEmail = false;
                        }
                        break;
                    case 'first_order_submitted_for_customer_approval':
                    case 'approved':
                        if ($salesRepBean) {
                            $bean->assigned_user_id = $salesRepBean->id;
                            
                            // To Sales Rep
                            ($salesRepBean && $salesRepBean->id && $current_user->id != $salesRepBean->id) ? $mail->AddAddress($salesRepBean->emailAddress->getPrimaryAddress($salesRepBean), $salesRepBean->name) : null;

                            $sendEmail = false;
                        }
                        break;
                    default:
                        break;
                }
            }

            if ($bean->approval_stage == 'award_eminent') {
                switch ($bean->status) {
                    case 'awaiting_award':
                        if ($salesRepBean) {
                            $bean->assigned_user_id = $salesRepBean->id;
                            
                            // To Sales Rep, Site Sales Manager
                            ($salesRepBean && $salesRepBean->id && $current_user->id != $salesRepBean->id) ? $mail->AddAddress($salesRepBean->emailAddress->getPrimaryAddress($salesRepBean), $salesRepBean->name) : null;

                            if ($bean->type == 'color_match' && $opportunityBean && $opportunityBean->amount > 25000) {
                                ($salesManagerBean && $salesManagerBean->id !== $bean->assigned_user_id && $current_user->id != $salesManagerBean->id) ? $mail->AddAddress($salesManagerBean->emailAddress->getPrimaryAddress($salesManagerBean), $salesManagerBean->name) : null;
                            }

                            $sendEmail = false;
                        }
                        break;
                    default:
                        break;
                }
            }

            if ($bean->approval_stage == 'closed_won') {
                switch ($bean->status) {
                    case 'qualified_source':
                    case 'order_received':
                        if ($salesRepBean) {
                            $bean->assigned_user_id = $salesRepBean->id;
                        
                            // To Sales Rep, Site R&D Manager, Site Sales Manager
                            ($salesRepBean && $salesRepBean->id && $current_user->id != $salesRepBean->id) ? $mail->AddAddress($salesRepBean->emailAddress->getPrimaryAddress($salesRepBean), $salesRepBean->name) : null;
                            ($siteRDManagerBean && $siteRDManagerBean->id !== $bean->assigned_user_id && $current_user->id != $siteRDManagerBean->id) ? $mail->AddAddress($siteRDManagerBean->emailAddress->getPrimaryAddress($siteRDManagerBean), $siteRDManagerBean->name) : null;

                            if ($bean->type == 'color_match' && $opportunityBean && $opportunityBean->amount > 25000) {
                                ($salesManagerBean && $salesManagerBean->id !== $bean->assigned_user_id && $current_user->id != $salesManagerBean->id) ? $mail->AddAddress($salesManagerBean->emailAddress->getPrimaryAddress($salesManagerBean), $salesManagerBean->name) : null;
                            }

                            $sendEmail = false;
                        }
                        break;
                    default:
                        break;
                }
            }

            if ($bean->approval_stage == 'closed_lost') {
                switch ($bean->status) {
                    case 'color':
                    case 'performance':
                    case 'service':
                    case 'competition':
                    case 'cancelled':
                        if ($salesRepBean) {
                            $bean->assigned_user_id = $salesRepBean->id;
                        
                            // To Sales Rep, Site R&D Manager, Site Sales Manager
                            ($salesRepBean && $salesRepBean->id && $current_user->id != $salesRepBean->id) ? $mail->AddAddress($salesRepBean->emailAddress->getPrimaryAddress($salesRepBean), $salesRepBean->name) : null;
                            ($siteRDManagerBean && $siteRDManagerBean->id !== $bean->assigned_user_id && $current_user->id != $siteRDManagerBean->id) ? $mail->AddAddress($siteRDManagerBean->emailAddress->getPrimaryAddress($siteRDManagerBean), $siteRDManagerBean->name) : null;

                            if ($bean->type == 'color_match' && $opportunityBean && $opportunityBean->amount > 25000) {
                                ($salesManagerBean && $salesManagerBean->id !== $bean->assigned_user_id && $current_user->id != $salesManagerBean->id) ? $mail->AddAddress($salesManagerBean->emailAddress->getPrimaryAddress($salesManagerBean), $salesManagerBean->name) : null;
                            }

                            $sendEmail = false;
                        }
                        break;
                    case 'price':
                        if ($salesRepBean) {
                            $bean->assigned_user_id = $salesRepBean->id;
                        
                            // To Sales Rep, Site R&D Manager, Site Sales Manager, Site Quote Manager
                            ($salesRepBean && $salesRepBean->id && $current_user->id != $salesRepBean->id) ? $mail->AddAddress($salesRepBean->emailAddress->getPrimaryAddress($salesRepBean), $salesRepBean->name) : null;
                            ($siteRDManagerBean && $siteRDManagerBean->id !== $bean->assigned_user_id && $current_user->id != $siteRDManagerBean->id) ? $mail->AddAddress($siteRDManagerBean->emailAddress->getPrimaryAddress($siteRDManagerBean), $siteRDManagerBean->name) : null;
                            ($siteQuoteManagerBean && $siteQuoteManagerBean->id !== $bean->assigned_user_id && $current_user->id != $siteQuoteManagerBean->id) ? $mail->AddAddress($siteQuoteManagerBean->emailAddress->getPrimaryAddress($siteQuoteManagerBean), $siteQuoteManagerBean->name) : null;
                            
                            if ($bean->type == 'color_match' && $opportunityBean && $opportunityBean->amount > 25000) {
                                ($salesManagerBean && $salesManagerBean->id !== $bean->assigned_user_id && $current_user->id != $salesManagerBean->id) ? $mail->AddAddress($salesManagerBean->emailAddress->getPrimaryAddress($salesManagerBean), $salesManagerBean->name) : null;
                            }

                            $sendEmail = false;
                        }
                        break;
                    default:
                        break;
                }
            }

            if ($bean->approval_stage == 'closed_rejected') {
                switch ($bean->status) {
                    case 'capability':
                        if ($salesRepBean) {
                            $bean->assigned_user_id = $salesRepBean->id;
                        
                            // To Sales Rep, Site R&D Manager, Site Sales Manager
                            ($salesRepBean && $salesRepBean->id && $current_user->id != $salesRepBean->id) ? $mail->AddAddress($salesRepBean->emailAddress->getPrimaryAddress($salesRepBean), $salesRepBean->name) : null;
                            ($siteRDManagerBean && $siteRDManagerBean->id !== $bean->assigned_user_id && $current_user->id != $siteRDManagerBean->id) ? $mail->AddAddress($siteRDManagerBean->emailAddress->getPrimaryAddress($siteRDManagerBean), $siteRDManagerBean->name) : null;

                            if ($bean->type == 'color_match' && $opportunityBean && $opportunityBean->amount > 25000) {
                                ($salesManagerBean && $salesManagerBean->id !== $bean->assigned_user_id && $current_user->id != $salesManagerBean->id) ? $mail->AddAddress($salesManagerBean->emailAddress->getPrimaryAddress($salesManagerBean), $salesManagerBean->name) : null;
                            }

                            $sendEmail = false;
                        }
                        break;
                    case 'capacity':
                    case 'created_in_error':
                        if ($salesRepBean) {
                            $bean->assigned_user_id = $salesRepBean->id;
                        }

                        if ($siteRDManagerBean) {

                            if ($current_user->id != $siteRDManagerBean->id) {
                                // To Site R&D Manager
                                $mail->AddAddress($siteRDManagerBean->emailAddress->getPrimaryAddress($siteRDManagerBean), $siteRDManagerBean->name);

                            }

                            // CC Sales Rep, SAM, MDM
                            ($salesRepBean && $salesRepBean->id && $current_user->id != $salesRepBean->id) ? $mail->addCC($salesRepBean->emailAddress->getPrimaryAddress($salesRepBean), $salesRepBean->name) : null;

                            $sendEmail = false;
                        }
                        break;
                    case 'credit_risk':
                        if ($salesRepBean) {
                            $bean->assigned_user_id = $salesRepBean->id;
                            
                            // To Sales Rep
                            ($salesRepBean && $salesRepBean->id && $current_user->id != $salesRepBean->id) ? $mail->AddAddress($salesRepBean->emailAddress->getPrimaryAddress($salesRepBean), $salesRepBean->name) : null;

                            // CC Site R&D Manager
                            ($siteRDManagerBean && $siteRDManagerBean->id !== $bean->assigned_user_id && $current_user->id != $siteRDManagerBean->id) ? $mail->addCC($siteRDManagerBean->emailAddress->getPrimaryAddress($siteRDManagerBean), $siteRDManagerBean->name) : null;

                            $sendEmail = false;
                        }
                        break;
                    default:
                        break;
                }
            }
            
            // Default Email Subject and Body Content
            if (! $bean->fetched_row['id']) {
                $subject = "EmpowerCRM Technical Request #{$bean->technicalrequests_number_c} - New";
                $customBodyContent = "You have been assigned to the new Technical Request";
            } else {
                $subject = "EmpowerCRM Technical Request #{$bean->technicalrequests_number_c} - Record Update";
                $customBodyContent = "The Technical Request has been updated by {$current_user->name}";
            }

            // Assigned user is changed but the status and site are the same
            if ($bean->fetched_row['id'] && $bean->assigned_user_id !== $bean->fetched_row['assigned_user_id'] && $bean->status == $bean->fetched_row['status'] && $bean->fetched_row['site'] == $bean->site) {
                $subject = "EmpowerCRM Technical Request #{$bean->technicalrequests_number_c} - Assignment Update";
                $customBodyContent = "A new user has been assigned to the Technical Request";
            }
            
            // Assigned user and site are the same but the status is changed
            if ($bean->fetched_row['id'] && $bean->assigned_user_id == $bean->fetched_row['assigned_user_id'] && $bean->status !== $bean->fetched_row['status'] && $bean->fetched_row['site'] == $bean->site) {
                $subject = "EmpowerCRM Technical Request #{$bean->technicalrequests_number_c} - Status Update";
                $customBodyContent = "A new status has been set to the Technical Request";
            }

            // Assigned user and status are the same but the site is changed
            if ($bean->fetched_row['id'] && $bean->assigned_user_id == $bean->fetched_row['assigned_user_id'] && $bean->status == $bean->fetched_row['status'] && $bean->fetched_row['site'] !== $bean->site) {
                $subject = "EmpowerCRM Technical Request #{$bean->technicalrequests_number_c} - Site Update";
                $customBodyContent = "A new site has been set to the Technical Request";
            }

            // Both assigned user and status are changed but site is the same
            if ($bean->fetched_row['id'] && $bean->assigned_user_id !== $bean->fetched_row['assigned_user_id'] && $bean->status !== $bean->fetched_row['status'] && $bean->fetched_row['site'] == $bean->site) {
                $subject = "EmpowerCRM Technical Request #{$bean->technicalrequests_number_c} - Assignment & Status Update";
                $customBodyContent = "A new user has been assigned and a new status has been set to the Technical Request";
            }
            
            // Both assigned user and site are changed but status is the same
            if ($bean->fetched_row['id'] && $bean->assigned_user_id !== $bean->fetched_row['assigned_user_id'] && $bean->status == $bean->fetched_row['status'] && $bean->fetched_row['site'] !== $bean->site) {
                $subject = "EmpowerCRM Technical Request #{$bean->technicalrequests_number_c} - Assignment & Site Update";
                $customBodyContent = "A new user has been assigned and a new site has been set to the Technical Request";
            }

            // Both status and site are changed but status is assigned user the same
            if ($bean->fetched_row['id'] && $bean->assigned_user_id == $bean->fetched_row['assigned_user_id'] && $bean->status !== $bean->fetched_row['status'] && $bean->fetched_row['site'] !== $bean->site) {
                $subject = "EmpowerCRM Technical Request #{$bean->technicalrequests_number_c} - Status & Site Update";
                $customBodyContent = "A new status and site has been set to the Technical Request";
            }
            
            // assigned user, status, and site are changed
            if ($bean->fetched_row['id'] && $bean->assigned_user_id !== $bean->fetched_row['assigned_user_id'] && $bean->status !== $bean->fetched_row['status'] && $bean->fetched_row['site'] !== $bean->site) {
                $subject = "EmpowerCRM Technical Request #{$bean->technicalrequests_number_c} - Assignment, Status, & Site Update";
                $customBodyContent = "A new assigned user, status, and site has been set to the Technical Request";
            }

            if ($sendEmail && $subject && $customBodyContent && in_array(true, $valueIsUpdated)) {
                
                // Needed since $bean->assigned_user_name still shows the old assigned user
                $newAssignedUserBean = BeanFactory::getBean('Users', $bean->assigned_user_id);
                $newAssignedUserName = $newAssignedUserBean ? $newAssignedUserBean->name : '';
                $techRequestUpdates = $bean->technical_request_update ? nl2br($bean->technical_request_update) : '';
                $statusValue = TechnicalRequestHelper::get_status($bean->approval_stage, $bean->approval_stage, $bean->status)[$bean->status];
                
                $techRequestUpdatesBodyContent = $techRequestUpdates ?
                    "<tr><td><br></td></tr>
                    <tr>
                        <td>Technical Request Update<td>
                        <td>{$techRequestUpdates}<td>
                    </tr>" : "";

                $tableInformation = "
                    <table>
                        <tbody>
                            <tr>
                                <td>TR #<td>
                                <td>{$bean->technicalrequests_number_c}<td>
                            </tr>

                            <tr>
                                <td>Version #<td>
                                <td>{$bean->version_c}<td>
                            </tr>

                            <tr>
                                <td>Product Name<td>
                                <td>{$bean->name}<td>
                            </tr>

                            <tr>
                                <td>Type<td>
                                <td>{$app_list_strings['tr_technicalrequests_type_dom'][$bean->type]}<td>
                            </tr>

                            <tr>
                                <td>Site<td>
                                <td>{$app_list_strings['lab_site_list'][$bean->site]}<td>
                            </tr>

                            <tr>
                                <td>Stage<td>
                                <td>{$app_list_strings['approval_stage_list'][$bean->approval_stage]}<td>
                            </tr>

                            <tr>
                                <td>Status<td>
                                <td>{$statusValue}<td>
                            </tr>

                            <tr>
                                <td>Account<td>
                                <td>{$accountName}<td>
                            </tr>

                            <tr>
                                <td>Opportunity<td>
                                <td>{$opportunityName}<td>
                            </tr>

                            <tr>
                                <td>Required Completion Date<td>
                                <td>{$bean->req_completion_date_c}<td>
                            </tr>

                            <tr>
                                <td>Submitted By<td>
                                <td>{$submittedBy}<td>
                            </tr>

                            <tr>
                                <td>Submitted Date<td>
                                <td>{$customDateEnteredFormat}<td>
                            </tr>

                            <tr>
                                <td>Assigned To<td>
                                <td>{$newAssignedUserName}<td>
                            </tr>

                            {$techRequestUpdatesBodyContent}
                        </tbody>
                    </table>
                    <br>
                ";

                $body = "
                    {$customQABanner}

                    Hello,
                    <br><br>
                    {$customBodyContent}
                    <br><br>
                    {$tableInformation}

                    Click here to access the record: {$recordURL}
                    <br><br>
                    Thanks,
                    <br>
                    {$mail->FromName}
                    <br>
                ";

                $mail->Subject = $subject;
                $mail->Body = from_html($body);
                ($newAssignedUserBean && $newAssignedUserBean->id !== $bean->assigned_user_id && $current_user->id != $newAssignedUserBean->id) ? $mail->addCC($newAssignedUserBean->emailAddress->getPrimaryAddress($newAssignedUserBean), $newAssignedUserBean->name) : null;
                // ($current_user) ? $mail->addCC($current_user->emailAddress->getPrimaryAddress($current_user), $current_user->name) : null;
                
                $mail->AddBCC($sugar_config['systemBCCEmailAddress']);
                $mail->isHTML(true);
                $mail->prepForOutbound();
                $mail->Send();
            }

            if (! $bean->fetched_row['id'] || $bean->assigned_user_id != $bean->fetched_row['assigned_user_id']) {
                $updateQuery = "UPDATE tr_technicalrequests SET assigned_user_id = '{$bean->assigned_user_id}' WHERE id = '{$bean->id}'";
                $db->query($updateQuery);
            }
        }
        
        public function handleTRItemsData(&$bean, $event, $arguments)
        {
            $bean && $bean->id ? TechnicalRequestItemsHelper::handleTRItemsCRUDWorkflow($bean) : null;
        }

        private function _update_tr_amounts($tr_id, $amount_weighted, $probability_calculated)
        {
            global $db, $log;

            $query = "update tr_technicalrequests t
                      join tr_technicalrequests_cstm tc
                        on tc.id_c = t.id
                      set tc.annual_amount_weighted_c = '$amount_weighted',
                        tc.probability_calculated_c = '{$probability_calculated}'
                      where t.deleted = 0 
                        and t.id = '$tr_id' ";
            
            $result = $db->query($query);

            return $result;
        }

        private function _redirect_to_technical_request($bean)
        {
            //If return module is Opportunities, route to TR as requested by the specs
            if(isset($_POST['return_module']) && $_POST['return_module'] == 'Opportunities'){
                $queryParams = array(
                    'module' => 'TR_TechnicalRequests',
                    'action' => 'DetailView',
                    'record' => $bean->id,
                );

                SugarApplication::redirect('index.php?' . http_build_query($queryParams));
            }
        }

        //redirect only if Created as New; not applicable for Edit
        private function _duplicate_redirect_logic($bean)
        {            
            if($bean->distro_type_c == 'new' && $bean->custom_is_edit_non_db == 'true')
            {
                $queryParams = array(
                    'module' => 'DSBTN_Distribution',
                    'action' => 'EditView',
                    'parent_id' => $bean->id,
                    'parent_module' => 'TR_TechnicalRequests',
                    'return_module' => 'TR_TechnicalRequests',
                    'return_id' => $bean->id,
                    'return_action' => 'DetailView',
                    'return_relationship' => 'get_distributions',
                );

                SugarApplication::redirect('index.php?' . http_build_query($queryParams));
            }
        }

        private function _calculate_opportunity_probability($bean)
        {
            global $log;
            
            $opportunity_ids = TechnicalRequestHelper::get_opportunity_ids($bean->id);

            if(count($opportunity_ids) > 0){
                foreach($opportunity_ids as $opportunity_id)
                {
                    TechnicalRequestHelper::opportunity_calculate_probability($opportunity_id);
                }
                
            }
        }

        // Send Mail to specific recipients when Markets set to To Be Defined
        public function send_mail_notification(&$bean, $event, $arguments)
        {
            global $sugar_config, $app_list_strings, $current_user, $log;
            
            if (($bean->market_c != $bean->fetched_rel_row['market_c']) && ($bean->market_c == 'To Be Defined (Chroma Color)' 
                || $bean->market_c == 'To Be Defined (Epolin)' )) {

                    global $sugar_config, $app_list_strings;

                    $mail = new SugarPHPMailer();
                    $emailObj = new Email();
                    $defaults = $emailObj->getSystemDefaultEmail();
                    $mail = new SugarPHPMailer();
                    $mail->setMailerForSystem();
                    $mail->From = $defaults['email'];
                    $mail->FromName = $defaults['name'];
                    $mail->Subject = 'EmpowerCRM New TBD market request';
                    
                    $mail->Body = from_html(TechnicalRequestHelper::tbdMarketEmailNotificationBody($bean));
                    MarketsHelper::attachRecipients('TR_TechnicalRequests', $bean, $mail);

                    $mail->AddBCC($sugar_config['systemBCCEmailAddress']);
                    $mail->isHTML(true);
                    $mail->prepForOutbound();
                    $mail->Send();
                
            }
        }

        public function setTRStageStatusProbability($bean)
        {
            global $db;
            $updateQuery = "UPDATE tr_technicalrequests 
                LEFT JOIN tr_technicalrequests_cstm 
                    ON tr_technicalrequests.id = tr_technicalrequests_cstm.id_c 
                SET tr_technicalrequests.approval_stage = '{$bean->approval_stage}', 
                    tr_technicalrequests.status = '{$bean->status}',
                    tr_technicalrequests_cstm.probability_c = '{$bean->probability_c}'
                WHERE tr_technicalrequests.id = '{$bean->id}'";
            $db->query($updateQuery);
        }

        public function handleRejectedTR(&$bean, $event, $arguments)
        {
            // If Stage or Status has been modified
            if ($bean->fetched_row['approval_stage'] != $bean->approval_stage || $bean->fetched_row['status'] != $bean->status) {
                // Stage is Closed Rejected or Development and Status is any of the Rejected: Chroma Capability, Product Capability, and Safety
                if ($bean->approval_stage == 'closed_rejected'){
                    TechnicalRequestHelper::closeIncompleteDistroAndTRItems($bean);
                }
            }
        }

        public function handleProductMasterReassignment(&$bean, $event, $arguments)
        {
            // Site R&D Manager
            $workGroupSiteRDManagerList = $bean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'RDManager' AND trwg_trworkinggroup.parent_type = 'Users'");
            $siteRDManagerBean = (!empty($workGroupSiteRDManagerList) && count($workGroupSiteRDManagerList) > 0) ? BeanFactory::getBean('Users', $workGroupSiteRDManagerList[0]->parent_id) : null;

            // If R&D Manager exists and Stage or Status has been modified
            if (($siteRDManagerBean && $siteRDManagerBean->id) && ($bean->fetched_row['approval_stage'] != $bean->approval_stage || $bean->fetched_row['status'] != $bean->status)) {
                // Stage is Development and Status is Approved
                if ($bean->approval_stage == 'development' && $bean->status == 'approved') {
                    $technicalRequestProductMasterBeanList = $bean->get_linked_beans(
                        'tr_technicalrequests_aos_products_2',
                        'AOS_Products',
                        array(),
                        0,
                        -1,
                        0,
                        "tr_technicalrequests_aos_products_2_c.tr_technicalrequests_aos_products_2tr_technicalrequests_ida = '{$bean->id}'"
                    );
        
                    if ($technicalRequestProductMasterBeanList != null && count($technicalRequestProductMasterBeanList) > 0) {
                        foreach ($technicalRequestProductMasterBeanList as $productMasterBean) {
                            $productMasterBean->assigned_user_id = $siteRDManagerBean->id;
                            $productMasterBean->save();
                        }
                    }
                }
            }
        }
        
        public function handleDistroItemReassignment(&$bean, $event, $arguments)
        {
            // Color Match Coordinator
            $workGroupColormatchCoordinatorList = $bean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'ColorMatchCoordinator' AND trwg_trworkinggroup.parent_type = 'Users'");
            $siteColormatchCoordinatorBean = (!empty($workGroupColormatchCoordinatorList) && count($workGroupColormatchCoordinatorList) > 0) ? BeanFactory::getBean('Users', $workGroupColormatchCoordinatorList[0]->parent_id) : null;

            // If Color Match Coordinator exists and Stage or Status has been modified
            if (($siteColormatchCoordinatorBean && $siteColormatchCoordinatorBean->id) && ($bean->fetched_row['approval_stage'] != $bean->approval_stage || $bean->fetched_row['status'] != $bean->status)) {
                // Stage is Development and Status is Approved
                if ($bean->approval_stage == 'development' && $bean->status == 'approved') {
                    $distroBean = BeanFactory::getBean('DSBTN_Distribution');
                    $distroBeanList = $distroBean->get_full_list("", "dsbtn_distribution_cstm.tr_technicalrequests_id_c = '{$bean->id}'", false, 0);

                    if ($distroBeanList != null && count($distroBeanList) > 0) {
                        foreach ($distroBeanList as $distroBean) {
                            $distroItemBean = BeanFactory::getBean('DSBTN_DistributionItems');
                            $distroItemBeanList = $distroItemBean->get_full_list("", "dsbtn_distributionitems_cstm.dsbtn_distribution_id_c = '{$distroBean->id}' AND dsbtn_distributionitems_cstm.status_c NOT IN ('complete', 'rejected') ", false, 0);

                            if ($distroItemBeanList != null && count($distroItemBeanList) > 0) {
                                foreach ($distroItemBeanList as $distroItemBean) {
                                    $distroItemBean->assigned_user_id = $siteColormatchCoordinatorBean->id;
                                    $distroItemBean->save();
                                }
                            }
                        }
                    }
                }
            }
        }
        
        public function handleEmailNotificationEstCompletionDateModified(&$bean, $event, $arguments) {
			global $current_user, $sugar_config;

            if (! $bean->fetched_row['id'] || $bean->fetched_row['est_completion_date_c'] == $bean->est_completion_date_c) {
                return;
            }
            
            $emailObj = new Email();
            $defaults = $emailObj->getSystemDefaultEmail();
            $mail = new SugarPHPMailer();
            $mail->setMailerForSystem();
            $mail->From = $defaults['email'];
            $mail->FromName = $defaults['name'];
            
            $customQABanner = $sugar_config['isQA'] == true ? '<span style="color: red;">***This is a test from the Empower QA System***</span><br><br>' : '';
            $recordURL = "<a href='{$sugar_config['site_url']}/index.php?module={$bean->module_name}&action=DetailView&record={$bean->id}'>{$sugar_config['site_url']}/index.php?module={$bean->module_name}&action=DetailView&record={$bean->id}</a>";
            
            // Sales Rep
            $workGroupSalesRepList = $bean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'SalesPerson' AND trwg_trworkinggroup.parent_type = 'Users'");
            $salesRepBean = (!empty($workGroupSalesRepList) && count($workGroupSalesRepList) > 0) ? BeanFactory::getBean('Users', $workGroupSalesRepList[0]->parent_id) : null;

            // SAM
            $workGroupSAMList = $bean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'StrategicAccountManager' AND trwg_trworkinggroup.parent_type = 'Users'");
            $accountSAMBean = (!empty($workGroupSAMList) && count($workGroupSAMList) > 0) ? BeanFactory::getBean('Users', $workGroupSAMList[0]->parent_id) : null;

            // MDM
            $workGroupMDMList = $bean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'MarketDevelopmentManager' AND trwg_trworkinggroup.parent_type = 'Users'");
            $accountMDMBean = (!empty($workGroupMDMList) && count($workGroupMDMList) > 0) ? BeanFactory::getBean('Users', $workGroupMDMList[0]->parent_id) : null;
            
            // Site R&D Manager
            if ($bean->approval_stage == 'development' && $bean->status == 'new') {
                $siteRDManagerBean = retrieveUserBySecurityGroupTypeDivision('R&D Manager', 'TRWorkingGroup', $bean->site, $bean->division);
            } else {
                $workGroupSiteRDManagerList = $bean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'RDManager' AND trwg_trworkinggroup.parent_type = 'Users'");
                $siteRDManagerBean = (!empty($workGroupSiteRDManagerList) && count($workGroupSiteRDManagerList) > 0) ? BeanFactory::getBean('Users', $workGroupSiteRDManagerList[0]->parent_id) : null;
            }
            
            // TR - Account Bean
            if (is_object($bean->tr_technicalrequests_accountsaccounts_ida)) {
                $accountBean = $_REQUEST['tr_technicalrequests_accountsaccounts_ida'] ? BeanFactory::getBean('Accounts', $_REQUEST['tr_technicalrequests_accountsaccounts_ida']) : null;
            } else {
                $accountBean = $bean->tr_technicalrequests_accountsaccounts_ida ? BeanFactory::getBean('Accounts', $bean->tr_technicalrequests_accountsaccounts_ida) : null;
            }

            // TR - Opportunity Bean
            if (is_object($bean->tr_technicalrequests_opportunitiesopportunities_ida)) {
                $opportunityBean = $_REQUEST['tr_technicalrequests_opportunitiesopportunities_ida'] ? BeanFactory::getBean('Opportunities', $_REQUEST['tr_technicalrequests_opportunitiesopportunities_ida']) : null;
            } else {
                $opportunityBean = $bean->tr_technicalrequests_opportunitiesopportunities_ida ? BeanFactory::getBean('Opportunities', $bean->tr_technicalrequests_opportunitiesopportunities_ida) : null;
            }

            if (! $bean->fetched_row['est_completion_date_c'] && $bean->est_completion_date_c) {
                $customBodyContent = "The Est Completion Date has been set to {$bean->est_completion_date_c}";
            } else if (! $bean->est_completion_date_c) {
                $customBodyContent = "The Est Completion Date has been removed";
            } else {
                $customBodyContent = "The Est Completion Date has been updated from {$bean->fetched_row['est_completion_date_c']} to {$bean->est_completion_date_c}";
            }

            if ($customBodyContent) {
                $customBodyContent .= " for this Technical Request #{$bean->technicalrequests_number_c} belonging to Opportunity ID #{$opportunityBean->oppid_c} and Customer {$accountBean->name}";
            }

            ($salesRepBean && $salesRepBean->id && $current_user->id != $salesRepBean->id) ? $mail->AddAddress($salesRepBean->emailAddress->getPrimaryAddress($salesRepBean), $salesRepBean->name) : null;
            ($accountSAMBean && $accountSAMBean->id && $current_user->id != $accountSAMBean->id) ? $mail->AddAddress($accountSAMBean->emailAddress->getPrimaryAddress($accountSAMBean), $accountSAMBean->name) : null;
            ($accountMDMBean && $accountMDMBean->id && $current_user->id != $accountMDMBean->id) ? $mail->AddAddress($accountMDMBean->emailAddress->getPrimaryAddress($accountMDMBean), $accountMDMBean->name) : null;
            ($siteRDManagerBean && $siteRDManagerBean->id && $current_user->id != $siteRDManagerBean->id) ? $mail->addCC($siteRDManagerBean->emailAddress->getPrimaryAddress($siteRDManagerBean), $siteRDManagerBean->name) : null;
            // ($current_user) ? $mail->addCC($current_user->emailAddress->getPrimaryAddress($current_user), $current_user->name) : null;

            $body = "
                {$customQABanner}
                
                Hello,
                <br><br>
                {$customBodyContent}
                <br><br>

                Click here to access the record: <br>{$recordURL}
                <br><br>
                Thanks,
                <br>
                {$mail->FromName}
                <br>
            ";

            $mail->Subject = "EmpowerCRM Technical Request #{$bean->technicalrequests_number_c} - Est Completion Date Update";
            $mail->Body = from_html($body);
            
            $mail->AddBCC($sugar_config['systemBCCEmailAddress']);
            $mail->isHTML(true);
            $mail->prepForOutbound();
            $mail->Send();
		}

        private function _handle_tr_closed($bean)
        {
            global $db;

            // If Stage has been modified to closed and actual closed date field is empty, set actual closed date to current date
            if ((! $bean->fetched_row['id'] && $bean->approval_stage) || ($bean->fetched_row['approval_stage'] != $bean->approval_stage)) {
                if (in_array($bean->approval_stage, ['closed', 'closed_won', 'closed_lost', 'closed_rejected'])) {
                    $bean->actual_close_date_c = (! $bean->actual_close_date_c) ? date('Y-m-d') : $bean->actual_close_date_c;
                } else {
                    $bean->actual_close_date_c = '';
                }

                $actualClosedDate = $bean->actual_close_date_c ? "'{$bean->actual_close_date_c}'" : "NULL";
                $updateQuery = "UPDATE tr_technicalrequests LEFT JOIN tr_technicalrequests_cstm ON tr_technicalrequests.id = tr_technicalrequests_cstm.id_c SET tr_technicalrequests_cstm.actual_close_date_c = {$actualClosedDate} WHERE tr_technicalrequests.id = '{$bean->id}'";
                $db->query($updateQuery);
            }
        }

        private function handleSetDevelopmentClosedDate($bean)
        {
            global $db;

            // If Stage or Status has been modified and value is set to Development - Development Complete, set Development Completed Date value to current date
            if (($bean->fetched_row['approval_stage'] !== $bean->approval_stage) || ($bean->fetched_row['status'] !== $bean->status)) {
                if ($bean->approval_stage == 'development' && $bean->status == 'development_complete') {
                    $bean->development_completed_date_c = ($bean->fetched_row['development_completed_date_c'] !== $bean->development_completed_date_c) ? date('Y-m-d') : $bean->development_completed_date_c;
    
                    $updateQuery = "UPDATE tr_technicalrequests LEFT JOIN tr_technicalrequests_cstm ON tr_technicalrequests.id = tr_technicalrequests_cstm.id_c SET tr_technicalrequests_cstm.development_completed_date_c = '{$bean->development_completed_date_c}' WHERE tr_technicalrequests.id = '{$bean->id}'";
                    $db->query($updateQuery);
                }
            }
        }

        /**
         * Hook to handle Updating TR Item and Distro Item status = On Hold when
         * TR status is updated to 'Awaiting More information' or 'Approved awaiting Target/Resin'.
         * Conversely, when TR Status is updated to ['new', 'approved', 'in_process'] AND prev status was 'Awaiting More information' or 'Approved awaiting Target/Resin'
         * it sets TR Items and Distro Items Status = 'new'
         * See OnTrack #1421 
         * @author Glaiza Obido
         * 
         */
        public function handleDistroTRItemOnHold(&$bean, $event, $arguments)
        {
            global $log, $db;

            // IF new status == Awaiting More information or status == Approved awaiting Target/Resin, Update related TR Items and Distro Items' status = 'On Hold'
            if (in_array($bean->status, ['awaiting_target_resin', 'more_information']) && $bean->fetched_row['status'] != $bean->status) {
                $updateStatus = 'onHold';
                $prevStatus = 'new';
            } elseif (in_array($bean->status, ['new', 'approved', 'in_process']) && in_array($bean->fetched_row['status'], ['awaiting_target_resin', 'more_information'])) {
                // If new status == new/approved/in_process AND prev status == Awaiting More information/Approved awaiting Target/Resin, set TR Item and Distro Items' status = New
                $updateStatus = 'new';
                $prevStatus = 'onHold';
            } else {
                // do nothing and do not execute the rest of the logic
                return true;
            }


            // GET TR > Distro Items where status == $prevStatus
            $distroBean = BeanFactory::getBean('DSBTN_Distribution');
            $distroBeanList = $distroBean->get_full_list('', "dsbtn_distribution_cstm.tr_technicalrequests_id_c = '{$bean->id}'", false, 0);

            if ($distroBeanList != null && count($distroBeanList) > 0) {
                foreach ($distroBeanList as $distroBean) {
                    $distroItemBean = BeanFactory::getBean('DSBTN_DistributionItems');
                    $distroItemBeanList = $distroItemBean->get_full_list('dsbtn_distributionitems_cstm.distribution_item_c', "dsbtn_distributionitems_cstm.dsbtn_distribution_id_c = '{$distroBean->id}' AND dsbtn_distributionitems_cstm.status_c = '{$prevStatus}'", false, 0);

                    if ($distroItemBeanList != null && count($distroItemBeanList) > 0) {

                        $distroItemIds = implode(",", array_map(function($item) {
                            return "'{$item}'";
                        }, array_column($distroItemBeanList, 'id')));

                        // Set the status of New Distro Items to On Hold
                        $updateSql = $db->query("
                            UPDATE dsbtn_distributionitems_cstm 
                            SET 
                                status_c = '{$updateStatus}'
                            WHERE
                                id_c IN ({$distroItemIds});
                        ");

                        TechnicalRequestHelper::customTRItemsDistroItemsStatusAudit(array_column($distroItemBeanList, 'id'), $prevStatus, $updateStatus, 'dsbtn_distribution_audit', 'status_c');
                        
                    }
                }
            }

            // GET TR> TR Items where status == $prevStatus
            $bean->load_relationship('tri_technicalrequestitems_tr_technicalrequests');
            if(isset($bean->tri_technicalrequestitems_tr_technicalrequests)) {

                $trItemIdList = $bean->tri_technicalrequestitems_tr_technicalrequests->get();

                if ($trItemIdList && count($trItemIdList) > 0) {
                    $trItemIds = implode(",", array_map(function($item) {
                        return "'{$item}'";
                    }, $trItemIdList));

                    $trItemBean = BeanFactory::getBean('TRI_TechnicalRequestItems');
                    $newTrItems =  $trItemBean->get_full_list('name', "tri_technicalrequestitems.id IN ({$trItemIds}) AND tri_technicalrequestitems.status = '{$prevStatus}'", false, 0);
                    
                    if ($newTrItems && count($newTrItems) > 0) {
                        $trItemIds = implode(",", array_map(function($item) {
                            return "'{$item}'";
                        }, array_column($newTrItems, 'id')));

                        // Set the status of New TR Items to On Hold
                        $trItemUpdateSql = $db->query("
                            UPDATE tri_technicalrequestitems 
                            SET 
                                status = '{$updateStatus}'
                            WHERE
                                id IN ({$trItemIds});
                        ");
                        TechnicalRequestHelper::customTRItemsDistroItemsStatusAudit(array_column($newTrItems, 'id'), $prevStatus, $updateStatus, 'tri_technicalrequestitems_audit', 'status');
                    }
                }
                
            }

        } // end of handleDistroTRItemOnHold

        public function handleAddCompetitorToTrAccount(&$bean, $event, $arguments)
        {
            global $log, $db, $current_user;
            
            // if competition is Updated and TR has Account ID
            if ($bean->fetched_row['comp_competition_id_c'] != $bean->comp_competition_id_c && isset($bean->tr_technicalrequests_accountsaccounts_ida) 
                && $bean->tr_technicalrequests_accountsaccounts_ida != '') {
                
                    $accountBean = BeanFactory::getBean('Accounts', $bean->tr_technicalrequests_accountsaccounts_ida);
                    $accountBean->load_relationship('accounts_comp_competitor_1');
                    // Load the TR <> COMP_Competitor module relationship
                    $bean->load_relationship('comp_competitor_tr_technicalrequests_1');

                    if ($bean->comp_competition_id_c != '') {
                        // Check new competition if it is already linked as COMPETITOR of the TR ACCOUNT
                        $competitorBean = CompetitorHelper::checkAccountCompetitors($accountBean, $bean->comp_competition_id_c); // checks if the Account already has this Competitor

                        if (!isset($competitorBean->id)) {
                            $competitor = BeanFactory::newBean('COMP_Competitor');
                            $competitor->competitor = $bean->comp_competition_id_c;
                            $competitor->save();
                            // $log->fatal("ADDED NEW", $competitor->id);
                        
                            $accountBean->accounts_comp_competitor_1->add($competitor); // if it's a new COMP_Competitor Bean, then add it to the account
                            $bean->comp_competitor_tr_technicalrequests_1->add($competitor);
                        } else {
                            // $log->fatal("ADDED EXISTING", $competitorBean->id);
                            $bean->comp_competitor_tr_technicalrequests_1->add($competitorBean);
    
                        }

                        
                    } 

                    // if $bean->fetched_row['comp_competition_id_c'] IS NOT EMPTY OR $bean->comp_competition_id_c IS ALSO Removed
                    // Check if previous competition exists from other TR's of the same Account, if none, remove from Account > Competitors link
                    if ($bean->fetched_row['comp_competition_id_c'] != '' || !empty($bean->fetched_row['comp_competition_id_c']) || empty($bean->comp_competition_id_c)) {
                        $existsOnOtherTR = CompetitorHelper::checkRelatedAccountTrCompetitors($accountBean, $bean->fetched_row['comp_competition_id_c'], $bean); // checks if the Account already has this Competitor

                        if (! $existsOnOtherTR) {
                            // Remove competitor from TR account
                            $competitorBean = CompetitorHelper::checkAccountCompetitors($accountBean, $bean->fetched_row['comp_competition_id_c']); // checks if the Account already has this Competitor
                            if (isset($competitorBean->id)) {
                                $accountBean = BeanFactory::getBean('Accounts', $bean->tr_technicalrequests_accountsaccounts_ida);
                                $accountBean->load_relationship('accounts_comp_competitor_1');
                                $accountBean->accounts_comp_competitor_1->delete($accountBean->id, $competitorBean);
                            }
                        }
                    }

            }
           
        } // end of handleAddCompetitorToTrAccount

        protected function handleTRItemsOnTrDevelopmentComplete($trBean) 
        {
            global $log, $current_user, $db;

            $distroItemsDocumentationList = DistributionHelper::$distro_items['Documentation'];
            $distroItemsDocumentationNameList = array_column($distroItemsDocumentationList, 'value');
            $impodedData = implode(',', $distroItemsDocumentationNameList);
            $formattedWhereInData = formatDataArrayForWhereInQuery($impodedData);

            if (! $formattedWhereInData) {
                return;
            }

            if ($trBean->status == 'development_complete') {
                // SET TR ITEMS where IN document group AND status = New to In - Process
                // Get all TR TR Items where status = New
                $tritems = $trBean->get_linked_beans(
                    'tri_technicalrequestitems_tr_technicalrequests',
                    'TRI_TechnicalRequestItems',
                    array(),
                    0,
                    10,
                    0,
                    "tri_technicalrequestitems.status = 'new' AND tri_technicalrequestitems.name IN ({$formattedWhereInData})");
                
                if (is_array($tritems) && count($tritems) > 0) {
                    $implodedTRItemIds = implode(',', array_column($tritems, 'id'));
                    $formattedWhereInTRItemIds = formatDataArrayForWhereInQuery($implodedTRItemIds);
                    
                    if (! $formattedWhereInTRItemIds) {
                        return;
                    }

                    $updateSql = "
                        UPDATE tri_technicalrequestitems
                        SET tri_technicalrequestitems.status = 'in_process'
                        WHERE tri_technicalrequestitems.id IN ({$formattedWhereInTRItemIds})
                    ";

                    $db->query($updateSql);
                }
            }
        }
	}
?>