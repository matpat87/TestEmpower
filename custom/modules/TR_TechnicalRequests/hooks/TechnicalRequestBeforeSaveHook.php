<?php
    require_once('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');
    require_once('custom/modules/DSBTN_Distribution/helper/DistributionHelper.php');
    require_once('include/SugarPHPMailer.php');

	class TechnicalRequestBeforeSaveHook {
		public function logTechnicalRequestUpdates($bean, $event, $arguments)
		{
            global $current_user;

            // Need to only call if request is from TR_TechnicalRequests as issues occur for updates with special characters when trBean->save() is triggered from other modules
            if ($_REQUEST['module'] == 'TR_TechnicalRequests') {
                $time_and_date = new TimeAndDateCustom();
                $current_datetime_timestamp = $time_and_date->customeDateFormatter($time_and_date->new_york_format, "D m/d/Y g:iA");
                
                if ($bean->technical_request_update != "" && html_entity_decode($bean->technical_request_update) != html_entity_decode($bean->fetched_row['technical_request_update'])) {
                    $conjunction = "<br/>";
                    $newLogUpdate = '<div style="font-size: 8pt;">('. $current_user->user_name . ' - '.  $current_datetime_timestamp .')</div>';
                    $newLogUpdate .= '<div style="font-size: 12pt;">'. nl2br($bean->technical_request_update) .'</div>';

                    $previousLogUpdates = $bean->fetched_row['updates'];
                    
                    $bean->updates = (! empty($previousLogUpdates)) ? "{$newLogUpdate} {$conjunction} {$previousLogUpdates}" : $newLogUpdate;
                    $bean->tr_update_date_c = date('Y-m-d H:i:s'); //Colormatch #314
                } else {
                    // On edit, the field becomes blank by default and triggers an audit change when saved as empty if it previously had a value
                    // Need to set it on the backend to set value based on fetched_row to prevent incorrect audit log
                    $bean->technical_request_update = html_entity_decode($bean->fetched_row['technical_request_update']);
                }
            }
        }

        public function form_before_save($bean, $event, $arguments)
        {
            global $log;

            // Since Stage and Status fields were disabled for non-admin users, manually set to Understanding Requirements - Draft for new TR's
            if (! $bean->fetched_row['id']) {
                $bean->approval_stage = $bean->approval_stage ? $bean->approval_stage : 'understanding_requirements';
                $bean->status = $bean->status ? $bean->status : 'in_process';
            }
            
            if(!$this->rematch_logic($bean)){
                $bean->technicalrequests_number_c = TechnicalRequestHelper::assign_technicalrequests_number($bean->id);
            }

            if(!TechnicalRequestHelper::is_id_exists($bean->id))
            {
                $bean->custom_is_edit_non_db = 'true';
            }

            $this->copy_distro_logic($bean);
            $this->assign_tr_contact($bean);

            $bean->probability_c = TechnicalRequestHelper::get_tr_probability_percentage($bean->approval_stage);

            if ($bean->type !== 'product_sample') {
                // If Product Name is empty or if Product # is changed, update Product Name to Product #
                // This is for cases where Product Name is hidden and Product # (Customer Products) relate field is displayed
                if ((! $bean->name && $bean->ci_customeritems_tr_technicalrequests_1_name) || $bean->ci_customeritems_tr_technicalrequests_1_name && $bean->ci_customeritems_tr_technicalrequests_1_name != $bean->fetched_rel_row['ci_customeritems_tr_technicalrequests_1_name']) {
                    $bean->name = $bean->ci_customeritems_tr_technicalrequests_1_name;
                }
            } else {
                // If Product Name is empty or if Product # is changed, update Product Name to Product #
                // This is for cases where Product Name is hidden and Product # (Product Master) relate field is displayed
                if ((! $bean->name && $bean->tr_technicalrequests_aos_products_2_name) || $bean->tr_technicalrequests_aos_products_2_name && $bean->tr_technicalrequests_aos_products_2_name != $bean->fetched_row['name']) {
                    $bean->name = $bean->tr_technicalrequests_aos_products_2_name;
                    
                    $aosProductsBean = BeanFactory::getBean('AOS_Products')->retrieve_by_string_fields(
                        array(
                            "product_number_c" => $bean->fetched_row['name'],
                        ), false, true
                    );

                    if ($aosProductsBean && $aosProductsBean->id) {
                        $bean->load_relationship('tr_technicalrequests_aos_products_2');
                        $bean->tr_technicalrequests_aos_products_2->delete($bean->id, $aosProductsBean->id);
                    }
                }   
            }
        }

        private function assign_tr_contact($bean)
        {
            global $log;

            if(!empty($bean->contact_id_c))
            {
                $contact_bean = BeanFactory::getBean('Contacts', $bean->contact_id_c);
                $bean->load_relationship('tr_technicalrequests_contacts_1');
                $bean->tr_technicalrequests_contacts_1->add($contact_bean);
            }
        } 

        private function get_rohs_val($is_rohs)
        {
            $result = '';

            if(!empty($is_rohs))
            {
                $result = ($is_rohs == 'yes') ? 1 : 0;
            }

            return $result;
        }

        private function status_updated(&$bean)
        {
            global $current_user;

            $rejected_approval_stages = array('rejected_capability', 'rejected_business_decision', 'rejected_capacity');

            if($bean->approval_stage == 'approved')
            {
                echo 'approved';
                $project_bean = BeanFactory::getBean('Project');
                $project_bean->id = create_guid();
                $distribution_item->new_with_id = true;
                $project_bean->name = $bean->name;
                $project_bean->project_type_c = $bean->type;
                $project_bean->account_id_c = $bean->tr_technicalrequests_accountsaccounts_ida;
                $project_bean->opportunity_id_c = $bean->tr_technicalrequests_opportunitiesopportunities_ida;
                $project_bean->created_by = $current_user->id;
                $project_bean->site_c = $bean->site;
                $project_bean->priority = $bean->priority_level_c;
                $project_bean->tr_technicalrequests_projecttr_technicalrequests_ida = $bean->id;
                $bean->tr_technicalrequests_projectproject_idb = $project_bean->id;
                $project_bean->save();

                $project_bean->load_relationship('tr_technicalrequests_project_c');
                $project_bean->tr_technicalrequests_project->add($bean);
            }
            else if(in_array($bean->approval_stage, $rejected_approval_stages))
            {

            }
        }

        private function send_rejected_email()
        {
            global $sugar_config;

            $emailObj = new Email();
            $defaults = $emailObj->getSystemDefaultEmail();
            $mail = new SugarPHPMailer();
            $mail->setMailerForSystem();
            $mail->From = $defaults['email'];
            $mail->FromName = $defaults['name'];

            $mail->Subject = 'EmpowerCRM New Empower Account';

            $customQABanner = $sugar_config['isQA'] == true ? '<span style="color: red;">***This is a test from the Empower QA System***</span><br><br>' : '';
            
            $mail->Body = from_html(
                '
                '.$customQABanner.'
                
                Welcome to Empower!
                <br><br>

                A user account has been created for you!
                <br><br>

                You may access the Empower system by clicking the link ' . $sugar_config['site_url'] . '.
                If the link does not work please copy and paste it into the address bar of your browser.
                The Empower system supports both Firefox and Chrome browsers.
                <br><br>
                
                Your credentials are:
                <br>
                Username: '.$bean->user_name.'
                <br>
                Password: '.$_REQUEST['new_password'].'
                
                <br><br>
                Your password must be changed upon logon as this is a generic password for all new user accounts.
                
                <br><br>
                If you have any issues please contact your local marketing representative.

                <br><br>
                Thank You!
                <br>
                Empower Support team'
            );

            $mail->AddAddress($bean->email1);
            $mail->AddBCC($sugar_config['systemBCCEmailAddress']);
            $mail->isHTML(true);
            $mail->prepForOutbound();
            $mail->Send();
        }

        private function rematch_logic($bean)
        {
            $result = false;
            //$technical_request_bean = BeanFactory::getBean('TR_TechnicalRequests')->retrieve_by_string_fields(array('id' => $bean->id));

            //For Rematch Version
            if(isset($bean->custom_rematch_type) && ($bean->custom_rematch_type == 'rematch_version' || $bean->custom_rematch_type == 'rematch_rejected'))
            {
                $technical_request_bean = BeanFactory::getBean('TR_TechnicalRequests', $bean->custom_rematch_original_tr);
                $bean->version_c = TechnicalRequestHelper::get_version($technical_request_bean->technicalrequests_number_c);
                $bean->system_version_c = TechnicalRequestHelper::get_related_tr_name($technical_request_bean);
                $bean->technicalrequests_number_c = $technical_request_bean->technicalrequests_number_c;
                $result = true;
            }
            else if(isset($bean->custom_rematch_type) && ($bean->custom_rematch_type == 'copy_full' || $bean->custom_rematch_type == 'production_rematch'))
            {
                //Colormatch #272
                if(!empty($_POST['sdsDocumentID']))
                {
                    $document = BeanFactory::getBean('Documents', $_POST['sdsDocumentID']);
                    $document->fetched_row['id'] = '';
                    $document->id = create_guid();
                    $document->new_with_id = true;
                    $document->save();
                    $bean->load_relationship('tr_technicalrequests_documents');
                    $bean->tr_technicalrequests_documents->add($document);
                }
            }

            return $result;
        }

        private function copy_distro_logic($bean)
        {
            if (! TechnicalRequestHelper::is_id_exists($bean->id) || ! $bean->fetched_row['distro_type_c']) {
                $source_technical_request_id = $_POST['opp_trs'];

                if ($source_technical_request_id && $bean->distro_type_c == 'copied') {
                    $this->copy_all_distributions($bean, $source_technical_request_id);
                }
            }
        }

        private function copy_all_distributions($bean, $source_technical_request_id)
        {
            $source_technical_request_bean = BeanFactory::getBean('TR_TechnicalRequests', $source_technical_request_id);
            $distroBean = BeanFactory::getBean('DSBTN_Distribution');
            $distroBeanList = $distroBean->get_full_list("", "dsbtn_distribution_cstm.tr_technicalrequests_id_c = '{$source_technical_request_id}'", false, 0);

            if ($distroBeanList != null && count($distroBeanList) > 0) {
                // Disable workflow since it causes issue where it generates duplicate TR items on every Distro Save
                $_REQUEST['skip_tr_items_crud_workflow'] = true;
                
                foreach ($distroBeanList as $distroBean) {
                    $parent_distribution_id = $distroBean->id;
                    $distroBean->fetched_row['id'] = '';
                    $distroBean->id = create_guid();
                    $distroBean->new_with_id = true;
                    $distroBean->tr_technicalrequests_id_c = $bean->id;
                    $distroBean->save();

                    $distribution_item_bean = BeanFactory::newBean('DSBTN_DistributionItems');
                    $distribution_item_list = $distribution_item_bean->get_full_list('', "dsbtn_distribution_id_c = '{$parent_distribution_id}'", false, 0);

                    if (isset($distribution_item_list) && count($distribution_item_list) > 0) {
                        foreach ($distribution_item_list as $distribution_item) {
                            $formattedDistroItemBean = DistributionHelper::GetDistroItemKeyEquivalentBeans($distribution_item);
                            $distroItemBean = BeanFactory::newBean('DSBTN_DistributionItems');
                            $distroItemBean->qty_c = $formattedDistroItemBean->fetched_row['qty_c'];
                            $distroItemBean->distribution_item_c = $formattedDistroItemBean->fetched_row['distribution_item_c'];
                            $distroItemBean->shipping_method_c = $formattedDistroItemBean->fetched_row['shipping_method_c'];
                            $distroItemBean->account_information_c = $formattedDistroItemBean->fetched_row['account_information_c'];
                            $distroItemBean->status_c = 'new';
                            $distroItemBean->uom_c = $formattedDistroItemBean->fetched_row['uom_c'];
                            $distroItemBean->row_order_c = $formattedDistroItemBean->fetched_row['row_order_c'];
                            $distroItemBean->dsbtn_distribution_id_c = $distroBean->id;
                            $distroItemBean->save();
                        }
                    }
                }

                // Re-enable workflow so that it generates the correct tr items on the handleTRItemsData logic hook
                $_REQUEST['skip_tr_items_crud_workflow'] = false;
            }
        }
        
        public function handleDocumentUpload(&$bean, $event, $arguments)
        {
            global $current_user;

            if ($bean->filename) {
                $date = date('Y-m-d');
                $dateTimeStr = strtotime(date('h:i:s'));

                $docBean = BeanFactory::newBean('Documents');
                $docBean->filename = $bean->filename;
                $docBean->status_id = 'Active';
                $docBean->doc_type = 'Sugar';
                $docBean->document_name = "Safety Data Sheet-{$date}-{$dateTimeStr}";
                $docBean->assigned_user_id = $current_user->id;
                $docBean->assigned_user_name = $current_user->name;
                $docBean->upload_source_id = $bean->id; // Used by Document.php to properly rename file based on upload source id
                $docBean->category_id = 'TechnicalRequest';
                $docBean->subcategory_id = 'TechnicalRequest_SDS';
                $docBean->save();

                $docBean->load_relationship('tr_technicalrequests_documents');

                if (isset($docBean->tr_technicalrequests_documents)) {				
                    $docBean->tr_technicalrequests_documents->add($bean->id); // Link document and the selected module
                }
            }
        }
	}
?>