<?php
    require_once('custom/modules/DSBTN_Distribution/helper/DistributionHelper.php');
    use Carbon\Carbon;

    class TechnicalRequestItemsHelper {
        public function sendTrItemUpdateEmail($trBean, $trItemBean, $action) 
        {
            global $current_user, $sugar_config, $app_list_strings;

            $recipients = self::retrieveRecipients($trBean, $trItemBean);

            if ($recipients) {
                $emailObj = new Email();
                $defaults = $emailObj->getSystemDefaultEmail();
                
                $trItemName = $app_list_strings['distro_item_list'][$trItemBean->name];

                $mail = new SugarPHPMailer();
                $mail->setMailerForSystem();
                $mail->From = $defaults['email'];
                $mail->FromName = $defaults['name'];
                $mail->Subject = "EmpowerCRM Updated Technical Request #{$trBean->technicalrequests_number_c} - Item {$trItemName}";

                $customQABanner = $sugar_config['isQA'] == true ? '<span style="color: red;">***This is a test from the Empower QA System***</span><br><br>' : '';

                if ($action == 'qty_update') {
                    $body = "
                        {$customQABanner}

                        <p><b>{$current_user->name}</b> has updated the quantity for TR #{$trBean->technicalrequests_number_c} - Item: {$trItemName}.</p>
                        <p>You may <a href='{$sugar_config['site_url']}/index.php?module=TRI_TechnicalRequestItems&action=DetailView&record={$trItemBean->id}'>review this Technical Request Item</a>.</p>
                    ";
                } else if ($action == 'tr_item_removed'){
                    $body = "
                        {$customQABanner}
                        
                        <p><b>{$current_user->name}</b> has removed the Item: {$trItemName} from TR #{$trBean->technicalrequests_number_c}.</p>
                    ";
                } else {
                    return false;
                }
                
                $mail->Body = from_html($body);
                foreach ($recipients as $key => $value) {
                    $mail->AddAddress($value, $key);
                }

                $mail->AddBCC($sugar_config['systemBCCEmailAddress']);
                $mail->isHTML(true);
                $mail->prepForOutbound();
                $mail->Send();
            }
        }

        private function retrieveRecipients($trBean, $trItemBean)
        {
            $recipientsArray = [];
            $assignedUserBean = BeanFactory::getBean('Users', $trItemBean->assigned_user_id);
            $siteRDManagerBean = retrieveUserBySecurityGroupTypeDivision('R&D Manager', 'TRWorkingGroup', $trBean->site, $trBean->division);
            $siteColormatchCoordinatorBean = retrieveUserBySecurityGroupTypeDivision('Color Match Coordinator', 'TRWorkingGroup', $trBean->site, $trBean->division);

            $assignedUserBean ? $recipientsArray[$assignedUserBean->name] = $assignedUserBean->emailAddress->getPrimaryAddress($assignedUserBean) : null;
            $siteRDManagerBean ? $recipientsArray[$siteRDManagerBean->name] = $siteRDManagerBean->emailAddress->getPrimaryAddress($siteRDManagerBean) : null;
            $siteColormatchCoordinatorBean ? $recipientsArray[$siteColormatchCoordinatorBean->name] = $siteColormatchCoordinatorBean->emailAddress->getPrimaryAddress($siteColormatchCoordinatorBean) : null;

            return $recipientsArray;
        }

        public function retrieveTRItemAssignedUser($trBean, $trItemName)
        {
            $assignedUserBean = null;
            
            $distroItemArray = [];
            $distroItemsDocumentationList = DistributionHelper::$distro_items['Documentation'];
            $distroItemsLabItemsList = DistributionHelper::$distro_items['Lab Items'];
            
            /**
             * Check if $trItemName exists on any of the two distribution dropdown groups: Documentation and Lab
             * If it exists, trigger array_filter on where it exists and return the Distro Item array
             * If Distro Item array is not empty, use category to fetch assigned user by way of TR workgroup
             * If Product Documentation - R&D Manager
             * If Regulatory Documentation - Regulatory Manager
             * If Lab - Color Matcher
             * If Quote - Quote Manager
             * If none, R&D Manager
             */
            
            if (in_array($trItemName, array_column($distroItemsDocumentationList, 'value'))) {
                $distroItemArray = array_filter($distroItemsDocumentationList, function ($distroItemsDocumentation) use ($trItemName) {
                    if ($distroItemsDocumentation['value'] === $trItemName) {
                        return $distroItemsDocumentation;
                    }
                });
            } else if (in_array($trItemName, array_column($distroItemsLabItemsList, 'value'))) {
                $distroItemArray = array_filter($distroItemsLabItemsList, function ($distroItemsLabItem) use ($trItemName) {
                    if ($distroItemsLabItem['value'] === $trItemName) {
                        return $distroItemsLabItem;
                    }
                });
            }

            if (isset($distroItemArray) && count($distroItemArray) > 0) {
                // Need to reset as keys may not be 0 (Ex 1,2,3...) then fetch first instance of array which is 0
                $distroItemArray = array_values($distroItemArray)[0];
                $category = $distroItemArray['category'];
                
                switch ($category) {
                    case 'product_documentation':
                        $workGroupSiteRDManagerList = $trBean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'RDManager' AND trwg_trworkinggroup.parent_type = 'Users'");

                        $assignedUserBean = (!empty($workGroupSiteRDManagerList) && count($workGroupSiteRDManagerList) > 0) ? BeanFactory::getBean('Users', $workGroupSiteRDManagerList[0]->parent_id) : null;
                        break;
                    case 'regulatory_documents':
                        $workGroupRegulatoryComplianceManagerList = $trBean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'RegulatoryManager' AND trwg_trworkinggroup.parent_type = 'Users'");

                        $assignedUserBean = (!empty($workGroupRegulatoryComplianceManagerList) && count($workGroupRegulatoryComplianceManagerList) > 0) ? BeanFactory::getBean('Users', $workGroupRegulatoryComplianceManagerList[0]->parent_id) : null;
                        break;
                    case 'lab':
                        $workGroupColorMatcherList = $trBean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'ColorMatcher' AND trwg_trworkinggroup.parent_type = 'Users'");

                        $assignedUserBean = (!empty($workGroupColorMatcherList) && count($workGroupColorMatcherList) > 0) ? BeanFactory::getBean('Users', $workGroupColorMatcherList[0]->parent_id) : null;
                        break;
                    case 'quote':
                        $workGroupQuoteManagerList = $trBean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'QuoteManager' AND trwg_trworkinggroup.parent_type = 'Users'");
                
                        $assignedUserBean = (!empty($workGroupQuoteManagerList) && count($workGroupQuoteManagerList) > 0) ? BeanFactory::getBean('Users', $workGroupQuoteManagerList[0]->parent_id) : null;
                        break;
                    default:
                        $workGroupSiteRDManagerList = $trBean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'RDManager' AND trwg_trworkinggroup.parent_type = 'Users'");

                        $assignedUserBean = (!empty($workGroupSiteRDManagerList) && count($workGroupSiteRDManagerList) > 0) ? BeanFactory::getBean('Users', $workGroupSiteRDManagerList[0]->parent_id) : null;
                        break;
                }
            }

            if (! $assignedUserBean) {
                $workGroupSiteRDManagerList = $trBean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'RDManager' AND trwg_trworkinggroup.parent_type = 'Users'");
                $assignedUserBean = (!empty($workGroupSiteRDManagerList) && count($workGroupSiteRDManagerList) > 0) ? BeanFactory::getBean('Users', $workGroupSiteRDManagerList[0]->parent_id) : null;
            }

            return $assignedUserBean;
        }

        public function handleTRItemsCRUDWorkflow($trBean)
        {
            global $app_list_strings;

            // Skip process if Stage is not Understanding Requirements, Development, Quoting/Proposing, Sampling OR if request skip_tr_items_crud_workflow is set
            if (
                (! in_array($trBean->approval_stage, ['understanding_requirements', 'development', 'quoting_or_proposing', 'sampling'])) ||  
                (isset($_REQUEST['skip_tr_items_crud_workflow']) && $_REQUEST['skip_tr_items_crud_workflow'])
            ) {
                return true;
            }

            $trBean->load_relationship('tri_technicalrequestitems_tr_technicalrequests');
            $trBean->load_relationship('tr_technicalrequests_aos_products_2');
            
            $trItemIds = $trBean->tri_technicalrequestitems_tr_technicalrequests->get();
            $productMasterIds = $trBean->tr_technicalrequests_aos_products_2->get();
            
            $productMasterBean = (isset($productMasterIds) && count($productMasterIds) > 0)
                ? BeanFactory::getBean('AOS_Products', $productMasterIds[0]) 
                : BeanFactory::newBean('AOS_Products');

            $productNumber = $productMasterBean->product_number_c ?? '';

            $trItemArray = [];

            if (isset($trItemIds) && count($trItemIds) > 0) {
                foreach ($trItemIds as $trItemId) {
                    array_push($trItemArray, "'{$trItemId}'");
                }
            }
            
            $trItemIdsWhereIn = (isset($trItemArray) && count($trItemArray) > 0)
                ? implode(', ', $trItemArray)
                : null;

            $trItemBean = BeanFactory::getBean('TRI_TechnicalRequestItems');
            $trItemBeanFilterQuery = $trItemIdsWhereIn ? "tri_technicalrequestitems.id IN ({$trItemIdsWhereIn}) AND tri_technicalrequestitems.status NOT IN ('complete', 'rejected') AND distro_generated_c = 1 AND tri_technicalrequestitems.name NOT LIKE '%_task'" : "1=0";
            $trItemBeanList = $trItemBean->get_full_list('name', $trItemBeanFilterQuery, false, 0);

            if (isset($trItemBean->tri_technicalrequestitems_tr_technicalrequests)) {
                $distroBean = BeanFactory::getBean('DSBTN_Distribution');
                $distroBeanList = $distroBean->get_full_list('', "dsbtn_distribution_cstm.tr_technicalrequests_id_c = '{$trBean->id}'", false, 0);
                $distroBeanArray = [];

                if (!empty($distroBeanList) && count($distroBeanList) > 0) {
                    foreach ($distroBeanList as $distroBean) {
                        $distroItemBean = BeanFactory::getBean('DSBTN_DistributionItems');
                        $distroItemBeanList = $distroItemBean->get_full_list('dsbtn_distributionitems_cstm.distribution_item_c', "dsbtn_distributionitems_cstm.dsbtn_distribution_id_c = '{$distroBean->id}'", false, 0);

                        if (!empty($distroItemBeanList) && count($distroItemBeanList) > 0) {
                            foreach ($distroItemBeanList as $distroItemkey => $distroItemBean) {
                                $distroBeanArray[$distroItemBean->distribution_item_c]['name'] = $distroItemBean->distribution_item_c;
                                $distroBeanArray[$distroItemBean->distribution_item_c]['product_number'] = $productNumber;
                                $distroBeanArray[$distroItemBean->distribution_item_c]['qty'] += $distroItemBean->qty_c;
                                $distroBeanArray[$distroItemBean->distribution_item_c]['uom'] = $distroItemBean->uom_c;
                                $distroBeanArray[$distroItemBean->distribution_item_c]['due_date'] = $trBean->req_completion_date_c;
                                $distroBeanArray[$distroItemBean->distribution_item_c]['est_completion_date_c'] = $trBean->est_completion_date_c;
                                $distroBeanArray[$distroItemBean->distribution_item_c]['status'] = 'new';
                            }
                        }
                    }
                }

                if (!empty($distroBeanArray) && count($distroBeanArray) > 0) {
                    foreach ($distroBeanArray as $key => $distro) {
                        $skipCreate = false;
                        $completedTrItemBeanFilterQuery = $trItemIdsWhereIn ? "tri_technicalrequestitems.id IN ({$trItemIdsWhereIn}) AND tri_technicalrequestitems.status IN ('complete', 'rejected') AND distro_generated_c = 1 AND tri_technicalrequestitems.name = '{$distro['name']}' AND tri_technicalrequestitems.name NOT LIKE '%_task'" : "1=0";
                        $completedTrItemBeanList = $trItemBean->get_full_list('name', $completedTrItemBeanFilterQuery, false, 0);

                        if (!empty($trItemBeanList) && count($trItemBeanList) > 0) {
                            foreach ($trItemBeanList as $trItemBean) {
                                if ($distro['name'] == $trItemBean->name) {
                                    
                                    $completedQtys = 0;
                                    $cancelUpdate = false;
                                    
                                    if (!empty($completedTrItemBeanList) && count($completedTrItemBeanList) > 0) {
                                        foreach ($completedTrItemBeanList as $completedTrItemBean) {
                                            $completedQtys += $completedTrItemBean->qty;
                                        }
                                    }

                                    // Process to check if distro item is removed and there exists a completed tr item to compare to, remove tr item
                                    if ($distro['qty'] - $completedQtys <= 0) {
                                        self::sendTrItemUpdateEmail($trBean, $trItemBean, 'tr_item_removed');

                                        $trItemBean->mark_deleted($trItemBean->id);
                                        $trItemBean->save();
                                        
                                        $cancelUpdate = true;
                                        
                                        if ((strpos($trItemBean->name, 'chips') !== false) || (strpos($trItemBean->name, 'sample') !== false) && ! in_array($trItemBean->status, ['complete', 'rejected'])) {
                                            self::deleteTRItemTask($trBean, 'colormatch_task');

                                            /* Ontrack #1662: Reverted logic on generating a SDS task; SDS is now separated from the Sample
                                                if (strpos($trItemBean->name, 'sample') !== false) {
                                                    self::deleteTRItemTask($trBean, 'sds_task');
                                                }
                                             */
                                        }
                                    }
                                    
                                    if (!$cancelUpdate) {
                                        // If TR Item Product Master does not match with TR Product Master, remove relationship
                                        if ($trItemBean->product_number && $trItemBean->product_number !== $distro['product_number']) {
                                            $trProductMasterBean = BeanFactory::getBean('AOS_Products')->retrieve_by_string_fields(
                                                ['product_number_c' => $trItemBean->product_number], false, true
                                            );
                                            
                                            if ($trProductMasterBean && $trProductMasterBean->id) {
                                                $trProductMasterBean->load_relationship('aos_products_tri_technicalrequestitems_1');
                                                $trProductMasterBean->aos_products_tri_technicalrequestitems_1->delete($trProductMasterBean->id, $trItemBean->id);
                                            }
                                        }
                                        
                                        $trItemBean->product_number = $distro['product_number'];
                                        $trItemBean->qty = $completedQtys > 0 ? $distro['qty'] - $completedQtys : $distro['qty'];
                                        $trItemBean->uom = $distro['uom'];
                                        $trItemBean->due_date = (! $trItemBean->due_date || $trBean->req_completion_date_c !== $trItemBean->due_date) ? $trBean->req_completion_date_c : $trItemBean->due_date;
                                        $trItemBean->est_completion_date_c = (! $trItemBean->est_completion_date_c || $trBean->est_completion_date_c !== $trItemBean->est_completion_date_c) ? $trBean->est_completion_date_c : $trItemBean->est_completion_date_c;
                                        
                                        $assignedUserBean = self::retrieveTRItemAssignedUser($trBean, $trItemBean->name);

                                        if ($trBean->site != $trBean->fetched_row['site']) {
                                            $trItemBean->assigned_user_id = ($assignedUserBean && $assignedUserBean->id) ? $assignedUserBean->id : '';
                                        } else {
                                            // If assigned user is empty, set assigned user, else check if assignedUserBean is not equal to TR Item assigned to, if true, set new assigned user, else, don't update TR Item assigned user
                                            if (! $trItemBean->assigned_user_id) {
                                                $trItemBean->assigned_user_id = ($assignedUserBean && $assignedUserBean->id) ? $assignedUserBean->id : '';
                                            } else {
                                                // OnTrack #1629 fix: commented out to prevent On Save TR event to override the set Assigned User ID -- Glai Obido
                                                // $trItemBean->assigned_user_id = ($assignedUserBean && $assignedUserBean->id) && $trItemBean->assigned_user_id != $assignedUserBean->id ? $assignedUserBean->id : $trItemBean->assigned_user_id;
                                            }

                                            // If TR Item is under Lab section of Distro Items, assign to ColorMatcher
                                            if (in_array($trItemBean->name, array_column(DistributionHelper::$distro_items['Lab'], 'value'))) {
                                                $workGroupSiteRDManagerList = $trBean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'RDManager' AND trwg_trworkinggroup.parent_type = 'Users'");
                                                $siteRDManagerBean = (!empty($workGroupSiteRDManagerList) && count($workGroupSiteRDManagerList) > 0) ? BeanFactory::getBean('Users', $workGroupSiteRDManagerList[0]->parent_id) : null;

                                                $workGroupColorMatcherList = $trBean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'ColorMatcher' AND trwg_trworkinggroup.parent_type = 'Users'");
                                                $colorMatcherBean = (!empty($workGroupColorMatcherList) && count($workGroupColorMatcherList) > 0) ? BeanFactory::getBean('Users', $workGroupColorMatcherList[0]->parent_id) : null;

                                                //  If assigned user is RD Manager and Colormatcher exists, assign to Colormatcher
                                                if (($siteRDManagerBean && $siteRDManagerBean->id) && ($colorMatcherBean && $colorMatcherBean->id) && $trItemBean->assigned_user_id == $siteRDManagerBean->id) {
                                                    $trItemBean->assigned_user_id = $colorMatcherBean->id;
                                                }

                                                // If new colornmather is assigned, update assigned user to colormatcher
                                                if (($colorMatcherBean && $colorMatcherBean->id) && $trItemBean->assigned_user_id != $colorMatcherBean->id) {
                                                    $trItemBean->assigned_user_id = $colorMatcherBean->id;
                                                }

                                                // If colormatcher is removed and assigned user is not empty, set to RD manager else leave as blank
                                                if (($colorMatcherBean && (! $colorMatcherBean->id) && $trItemBean->assigned_user_id)) {
                                                    $trItemBean->assigned_user_id = ($siteRDManagerBean && $siteRDManagerBean->id) ? $siteRDManagerBean->id : '';
                                                } 
                                            }
                                        }
                                        
                                        $sendNotificationMail = ($trItemBean->fetched_row['assigned_user_id'] != $trItemBean->assigned_user_id) ? true : false;

                                        $trItemBean->save();
                                        $skipCreate = true;

                                        // Link TR Item to PM
                                        $productMasterBean->load_relationship('aos_products_tri_technicalrequestitems_1');
                                        $productMasterBean->aos_products_tri_technicalrequestitems_1->add($trItemBean);

                                        if ((strpos($trItemBean->name, 'chips') !== false) || (strpos($trItemBean->name, 'sample') !== false) && ! in_array($trItemBean->status, ['complete', 'rejected'])) {
                                            self::createOrUpdateTRItemTask($trBean, $productMasterBean, 'colormatch_task');

                                            /* Ontrack #1662: Reverted logic on generating a SDS task; SDS is now separated from the Sample
                                                if (strpos($trItemBean->name, 'sample') !== false) {
                                                    self::createOrUpdateTRItemTask($trBean, $productMasterBean, 'sds_task');
                                                }
                                            */
                                        }
                                        
                                        /* Depracted: Triggered assigned user mail via After Save Hook
                                            if ($sendNotificationMail) {
                                                handleAssignmentNotification($trItemBean);
                                            } 
                                        */
                                    }
                                }
                            }
                        }

                        if (!$skipCreate) {
                            $completedQtys = 0;
                            $cancelCreate = false;

                            if (!empty($completedTrItemBeanList) && count($completedTrItemBeanList) > 0) {
                                foreach ($completedTrItemBeanList as $trItemBean) {
                                    $completedQtys += $trItemBean->qty;
                                }
                            }

                            if ($distro['qty'] - $completedQtys <= 0) {
                                $cancelCreate = true;
                            }

                            if (!$cancelCreate) {
                                $assignedUserBean = self::retrieveTRItemAssignedUser($trBean, $distro['name']);

                                $newTRItemBean = BeanFactory::newBean('TRI_TechnicalRequestItems');
                                $newTRItemBean->name = $distro['name'];
                                $newTRItemBean->product_number = $distro['product_number'];
                                $newTRItemBean->qty = $completedQtys > 0 ? $distro['qty'] - $completedQtys : $distro['qty'];
                                $newTRItemBean->uom = $distro['uom'];
                                $newTRItemBean->due_date = $distro['due_date'];
                                $newTRItemBean->est_completion_date_c = $distro['est_completion_date_c'];
                                $newTRItemBean->status = $distro['status'];
                                $newTRItemBean->assigned_user_id = $assignedUserBean && $assignedUserBean->id ? $assignedUserBean->id : '';
                                $newTRItemBean->distro_generated_c = 1;
                                $newTRItemBean->save();

                                // Link TR Item to TR
                                $newTRItemBean->tri_technicalrequestitems_tr_technicalrequests->add($trBean->id);

                                // Link TR Item to PM
                                $productMasterBean->load_relationship('aos_products_tri_technicalrequestitems_1');
                                $productMasterBean->aos_products_tri_technicalrequestitems_1->add($newTRItemBean);

                                if ((strpos($newTRItemBean->name, 'chips') !== false) || (strpos($newTRItemBean->name, 'sample') !== false) && ! in_array($newTRItemBean->status, ['complete', 'rejected'])) {
                                    self::createOrUpdateTRItemTask($trBean, $productMasterBean, 'colormatch_task');

                                    /* Ontrack #1662: Reverted logic on generating a SDS task; SDS is now separated from the Sample
                                        if (strpos($newTRItemBean->name, 'sample') !== false) {
                                            self::createOrUpdateTRItemTask($trBean, $productMasterBean, 'sds_task');
                                        } 
                                    */
                                }
                                // Depracated: triggered Assigned user mail by way of After Relationship Add event hook
                                // handleAssignmentNotification($newTRItemBean);
                            }
                        }
                    }
                }
                
                // Process to check if distro item is removed and no existing completed tr item to compare to, remove tr item
                if (isset($trItemBeanList) && isset($distroBeanArray)) {
                    $trItemBeanNames = is_array($trItemBeanList) ? array_column($trItemBeanList, 'name') : [];
                    $distroBeanNames = is_array($distroBeanArray) ? array_column($distroBeanArray, 'name') : [];
                    $trItemsToDeleteArray = array_diff($trItemBeanNames, $distroBeanNames);
                    
                    if ($trItemsToDeleteArray) {
                        foreach ($trItemsToDeleteArray as $trItemToDeleteName) {
                            foreach ($trItemBeanList as $trItemBean) {
                                if($trItemToDeleteName == $trItemBean->name) {
                                    self::sendTrItemUpdateEmail($trBean, $trItemBean, 'tr_item_removed');

                                    $trItemBean->mark_deleted($trItemBean->id);
                                    $trItemBean->save();

                                    if ((strpos($trItemBean->name, 'chips') !== false) || (strpos($trItemBean->name, 'sample') !== false) && ! in_array($trItemBean->status, ['complete', 'rejected'])) {
                                        self::deleteTRItemTask($trBean, 'colormatch_task');

                                        
                                        /* Ontrack #1662: Reverted logic on generating a SDS task; SDS is now separated from the Sample
                                            if (strpos($trItemBean->name, 'sample') !== false) {
                                                self::deleteTRItemTask($trBean, 'sds_task');
                                            } 
                                        */
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        public static function GetDistributionDropdown($selected)
        {
            global $log;
            $result = '<select id="name" name="name" class="form-control" style="width: 90%">';
            
            // Filter Distribution items - OnTrack 1696
            $filteredDistroItemsArr = self::filterDistributionDropdown($selected);

            // array_sort_by_column(DistributionHelper::$distro_items['Documentation'], 'name');
            // array_sort_by_column(DistributionHelper::$distro_items['Lab Items'], 'name');

            array_sort_by_column($filteredDistroItemsArr['Documentation'], 'name');
            array_sort_by_column($filteredDistroItemsArr['Lab Items'], 'name');

            $result .= '<option value="" data-description=""></option>';

            foreach ($filteredDistroItemsArr as $distro_item_opt_group_keys => $distro_item_opt_groups) {
                $result .= '<optgroup label="'.$distro_item_opt_group_keys.'">';
                
                foreach ($distro_item_opt_groups as $distro_item) {
                    $result .= '<option value="'. $distro_item['value'] .'" data-description="'. $distro_item['description'] .'"';

                    if(!empty($selected) && $distro_item['value'] == $selected) {
                        $result .= ' selected="selected"';
                    }

                    $result .= '> '. $distro_item['name'] .' </option>';
                }

                $result .= '</optgroup>';
            }

            $result .= '</select>';

            return $result;
        }
         /**
            * @author Glai Obido
            * Ontrack #1696
            * Handle filtering TR Items dropdown list based on parent TR Type
            * 
        */
        public static function filterDistributionDropdown($selected = '')
        {
            global $log;
            
            $filteredItemsArray = [];
            
            // On Create TR Item
            if (!empty($_REQUEST['return_module']) && !empty($_REQUEST['return_id']) && $_REQUEST['return_module'] == 'TR_TechnicalRequests') {
                $parentTrBean = BeanFactory::getBean('TR_TechnicalRequests', $_REQUEST['return_id']);

            } elseif (!empty($selected) && $_REQUEST['module'] == 'TRI_TechnicalRequestItems' && !empty($_REQUEST['record'])) { 
                // On Edit TR Item (not distro generated)
                $trItemBean = BeanFactory::getBean('TRI_TechnicalRequestItems', $_REQUEST['record']);
                $parentTrBean = BeanFactory::getBean('TR_TechnicalRequests', $trItemBean->tri_techni0387equests_ida);
                
            } else {
                // Safety Net
                return DistributionHelper::$distro_items;
            }

            $filteredItemsArray['Documentation'] = array_filter(DistributionHelper::$distro_items['Documentation'], function($itemArray) use ($parentTrBean) {
                switch ($parentTrBean->type) {
                    case 'lab_items':
                        return in_array($itemArray['value'], ['', 'spectral_data']);
                    default:
                        return $itemArray;
                } // end of switch-case

            });  // end of array_filter

            $filteredItemsArray['Lab Items'] = array_filter(DistributionHelper::$distro_items['Lab Items'], function($itemArray) use ($parentTrBean) {
                switch ($parentTrBean->type) {
                    case 'lab_items':
                        return !in_array($itemArray['value'], ['', 'sample_concentrate', 'sample_dry_color']);
                    default:
                        return $itemArray;
                } // end of switch-case

            });  // end of array_filter

            return $filteredItemsArray;
        }

        public function createOrUpdateTRItemTask($trBean, $productMasterBean, $taskName = 'colormatch_task')
        {
            $trItemTaskBeanList = $trBean->get_linked_beans(
                'tri_technicalrequestitems_tr_technicalrequests',
                'TRI_TechnicalRequestItems',
                array(),
                0,
                -1,
                0,
                "tri_technicalrequestitems.name = '{$taskName}' AND tri_technicalrequestitems_cstm.distro_generated_c = 1"
            );

            $trItemTaskBean = (!empty($trItemTaskBeanList) && count($trItemTaskBeanList) > 0) ? $trItemTaskBeanList[0] : BeanFactory::newBean('TRI_TechnicalRequestItems');

            if (in_array($trItemTaskBean->status, ['complete', 'rejected'])) {
                return true;
            }

            $assignedUserBean = self::retrieveTRItemAssignedUser($trBean, $taskName);

            if ($trItemTaskBean && $trItemTaskBean->id) {
                if ($trItemTaskBean->product_number !== $productMasterBean->product_number_c) {
                    $trItemProductMasterBean = BeanFactory::getBean('AOS_Products')->retrieve_by_string_fields(
                        ['product_number_c' => $trItemTaskBean->product_number], false, true
                    );
                    
                    if ($trItemProductMasterBean && $trItemProductMasterBean->id) {
                        $trItemProductMasterBean->load_relationship('aos_products_tri_technicalrequestitems_1');
                        $trItemProductMasterBean->aos_products_tri_technicalrequestitems_1->delete($trItemProductMasterBean->id, $trItemTaskBean->id);
                    }

                    $trItemTaskBean->product_number = $productMasterBean->product_number_c;

                    // Link TR Item to PM
                    $productMasterBean->load_relationship('aos_products_tri_technicalrequestitems_1');
                    $productMasterBean->aos_products_tri_technicalrequestitems_1->add($trItemTaskBean);
                }

                // Only update assigned user if TR Item is not assigned to a user
                if (! $trItemTaskBean->assigned_user_id) {
                    $trItemTaskBean->assigned_user_id = ($assignedUserBean && $assignedUserBean->id) ? $assignedUserBean->id : '';
                }

                $trItemTaskBean->due_date = (! $trItemTaskBean->due_date || $trBean->req_completion_date_c !== $trItemTaskBean->due_date) ? $trBean->req_completion_date_c : $trItemTaskBean->due_date;
                $trItemTaskBean->est_completion_date_c = (! $trItemTaskBean->est_completion_date_c || $trBean->est_completion_date_c !== $trItemTaskBean->est_completion_date_c) ? $trBean->est_completion_date_c : $trItemTaskBean->est_completion_date_c;
                $trItemTaskBean->save();
            } else {
                $trItemTaskBean->name = $taskName;
                $trItemTaskBean->product_number = $productMasterBean->product_number_c;
                $trItemTaskBean->qty = 1;
                $trItemTaskBean->uom = 'ea';
                $trItemTaskBean->due_date = $trBean->req_completion_date_c;
                $trItemTaskBean->est_completion_date_c = $trBean->est_completion_date_c;
                $trItemTaskBean->status = 'new';
                $trItemTaskBean->assigned_user_id = ($assignedUserBean && $assignedUserBean->id) ? $assignedUserBean->id : '';
                $trItemTaskBean->distro_generated_c = 1;
                $trItemTaskBean->save();

                // Link TR Item to TR
                $trItemTaskBean->tri_technicalrequestitems_tr_technicalrequests->add($trBean->id);

                // Link TR Item to PM
                $productMasterBean->load_relationship('aos_products_tri_technicalrequestitems_1');
                $productMasterBean->aos_products_tri_technicalrequestitems_1->add($trItemTaskBean);
            }
        }

        public function deleteTRItemTask($trBean, $taskName = 'colormatch_task')
        {
            $cancelDelete = false;
            
            if ($taskName == 'colormatch_task') {
                $trItemChipsOrSampleBeanList = $trBean->get_linked_beans(
                    'tri_technicalrequestitems_tr_technicalrequests',
                    'TRI_TechnicalRequestItems',
                    array(),
                    0,
                    -1,
                    0,
                    "(tri_technicalrequestitems.name LIKE '%chips%' OR tri_technicalrequestitems.name LIKE '%sample%') AND tri_technicalrequestitems.status NOT IN ('complete', 'rejected') AND tri_technicalrequestitems_cstm.distro_generated_c = 1"
                );

                $cancelDelete = (!empty($trItemChipsOrSampleBeanList) && count($trItemChipsOrSampleBeanList) > 0) ? true : false;
            }

            /*  Ontrack #1662: Reverted logic on generating a SDS task; SDS is now separated from the Sample;
                if ($taskName == 'sds_task') {
                    $trItemSampleBeanList = $trBean->get_linked_beans(
                        'tri_technicalrequestitems_tr_technicalrequests',
                        'TRI_TechnicalRequestItems',
                        array(),
                        0,
                        -1,
                        0,
                        "(tri_technicalrequestitems.name LIKE '%sample%') AND tri_technicalrequestitems.status NOT IN ('complete', 'rejected') AND tri_technicalrequestitems_cstm.distro_generated_c = 1"
                    );

                    $cancelDelete = (!empty($trItemSampleBeanList) && count($trItemSampleBeanList) > 0) ? true : false;
                } 
            */

            if (! $cancelDelete) {
                $trItemTaskBeanList = $trBean->get_linked_beans(
                    'tri_technicalrequestitems_tr_technicalrequests',
                    'TRI_TechnicalRequestItems',
                    array(),
                    0,
                    -1,
                    0,
                    "tri_technicalrequestitems.name = '{$taskName}' AND tri_technicalrequestitems.status NOT IN ('complete', 'rejected') AND tri_technicalrequestitems_cstm.distro_generated_c = 1"
                );
    
                $trItemTaskBean = (!empty($trItemTaskBeanList) && count($trItemTaskBeanList) > 0) ? $trItemTaskBeanList[0] : BeanFactory::newBean('TRI_TechnicalRequestItems');
    
                if ($trItemTaskBean && $trItemTaskBean->id) {
                    self::sendTrItemUpdateEmail($trBean, $trItemTaskBean, 'tr_item_removed');

                    $trItemTaskBean->mark_deleted($trItemTaskBean->id);
                    $trItemTaskBean->save();
                }
            }
        }

        // Retrieve TR Item (Quote) Document by way of document_revisions table using 
        // the filename that has format of <tr_item_id>_<document_c>
        public static function retrieveTriDocument($triBean)
        {
            global $db, $log;
            
            $documentRevisionsQuery = $db->query("
                SELECT 
                        documents.*, documents_cstm.*, document_revisions.filename
                    FROM
                        documents
                            LEFT JOIN
                        documents_cstm ON documents_cstm.id_c = documents.id
                            AND documents.deleted = 0
                            LEFT JOIN
                        document_revisions ON document_revisions.document_id = documents.id
                    WHERE
                        document_revisions.filename = '{$triBean->id}_{$triBean->document_c}'
                                AND documents.deleted = 0;
                ");
            $row = $db->fetchRow($documentRevisionsQuery); // assoc array
            $returnArray = empty($row) ? [] : $row;
            return $returnArray;
        }

        /**
         *  Prepares and processes the email notification body with the module details 
         * in the mail body before triggering the CustomMailNotification class.
         */
        public static function triggerMailNotification($triBean, $recipientsArray = [], $mailSubject = "")
        {
            global $app_list_strings;

            $trBean = BeanFactory::getBean('TR_TechnicalRequests', $triBean->tri_techni0387equests_ida);
            $trNumber = (!empty($trBean->id)) ? $trBean->technicalrequests_number_c: "";
            
            // prepare module field name => value to dispay array
            $bodyDetailsArray = [
                array(
                    'label' => 'Technical Request Item',
                    'value' => $app_list_strings['distro_item_list'][$triBean->name]
                ),
                array(
                    'label' => 'TR #',
                    'value' => $trNumber
                ),
                array(
                    'label' => 'Estimated Completed Date',
                    'value' => Carbon::parse($triBean->est_completion_date_c)->toDateString()
                ),
                array(
                    'label' => 'Status',
                    'value' => $app_list_strings['technical_request_items_status_list'][$triBean->status]
                ),
            ];

            $customMailer = new CustomMailNotification($triBean, $bodyDetailsArray);
            
            if (!empty($recipientsArray)) {
                $customMailer->setDefaultMailRecipient(false); // False if there are other recipients of the Mail other than the assigned user of the $bean
                $customMailer->setMailRecipients($recipientsArray);
            }
            $customMailer->mail_subject = ($mailSubject != "") 
                ? $mailSubject 
                : $customMailer->mail_subject;
            $customMailer->process();
        }   
    }