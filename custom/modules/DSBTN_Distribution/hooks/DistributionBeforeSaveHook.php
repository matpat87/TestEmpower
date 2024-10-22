<?php
    require_once('custom/modules/DSBTN_DistributionItems/helpers/EmailNotificationHelper.php');
    require_once('custom/modules/DSBTN_Distribution/helper/DistributionHelper.php');
    require_once('custom/include/Carbon/src/Carbon/Carbon.php');
	use Carbon\Carbon;

    class DistributionBeforeSaveHook{
        public $dbDistroItemBeans;
        public $checkedItems = array();

        public function before_save($bean, $event, $arguments){
            global $log;

            $bean->distribution_number_c = DistributionHelper::assign_distribution_number($bean->id);
            
            if(!empty($bean->contact_id_c)) {
                $contactBean = BeanFactory::getBean('Contacts', $bean->contact_id_c);
                $bean->name = "{$bean->distribution_number_c} - {$contactBean->first_name} {$contactBean->last_name}";
            }

            //Save Line Items
            if(isset($_POST['qty']))
            {
                $count = count($_POST['qty']);
                $qty_list = $_POST['qty'];
                $uom_list =  $_POST['uom'];
                $distribution_item_list =  $_POST['distribution_item'];
                $shipping_method_list =  $_POST['shipping_method'];
                $account_information_list =  $_POST['account_information'];
                $status_list =  $_POST['status'];
                $assigned_to_list = array_values($_POST['distro_item_assigned_user_id']);
                $date_entered = date("Y-m-d H:i:s");

                $this->dbDistroItemBeans = $this->retrieve_current_distribution_items($bean->id);

                $this->remove_distributions('DSBTN_Distribution', $bean->id);

                if($_POST['sync_to_contact_distribution_items']) {
                    $this->remove_distributions('Contacts', $bean->contact_id_c);
                }

                $this->checkedItems = array();
                $currentOpenDistroItemCount = 0;
                $newOpenDistroItemCount = 0;

                if (isset($this->dbDistroItemBeans) && is_array($this->dbDistroItemBeans) && count($this->dbDistroItemBeans) > 0) {
                    $currentOpenDistroItems = array_filter($this->dbDistroItemBeans, function($itemObj) {
                        return (! in_array($itemObj->status_c, ['complete', 'rejected']));
                    });
                }

                if (isset($currentOpenDistroItems) && is_array($currentOpenDistroItems) && count($currentOpenDistroItems) > 0) {
                    $currentOpenDistroItemsQtyArray = array_column($currentOpenDistroItems, 'qty_c');
                }
                
                if (isset($currentOpenDistroItemsQtyArray) && is_array($currentOpenDistroItemsQtyArray) && count($currentOpenDistroItemsQtyArray) > 0) {
                    $currentOpenDistroItemCount = array_sum($currentOpenDistroItemsQtyArray);
                }

                for($i = 0; $i < $count; $i++)
                {
                    if (! in_array($status_list[$i], ['complete', 'rejected'])) {
                        $newOpenDistroItemCount += $qty_list[$i];
                    }
                    
                    $this->insert_distribution_line_item('DSBTN_Distribution', $bean->id, $qty_list[$i], $distribution_item_list[$i], $shipping_method_list[$i], $account_information_list[$i], $status_list[$i], $assigned_to_list[$i], ($i +1), $bean->created_by, $bean->custom_technical_request_id_non_db, $uom_list[$i]);
                    
                    if($_POST['sync_to_contact_distribution_items']) {
                        $this->insert_distribution_line_item('Contacts', $bean->contact_id_c, $qty_list[$i], $distribution_item_list[$i], $shipping_method_list[$i], $account_information_list[$i], $status_list[$i], $assigned_to_list[$i], ($i +1), $bean->created_by, $bean->custom_technical_request_id_non_db, $uom_list[$i]);
                    }
                }

                $trBean = BeanFactory::getBean('TR_TechnicalRequests', $bean->tr_technicalrequests_id_c);
                
                // If current distro items count is no longer equal to new distro item count or quantity of any of the existing distro items are modified, trigger reset TR to Development - New logic
                if ($currentOpenDistroItemCount <> $newOpenDistroItemCount && $newOpenDistroItemCount > $currentOpenDistroItemCount) {
                    if (! in_array($trBean->approval_stage, ['understanding_requirements', 'development', 'closed', 'closed_won', 'closed_lost', 'closed_rejected'])) {
                        $trBean->approval_stage = 'development';
                        $trBean->status = 'new';

                        // Color Matcher
                        $workGroupColorMatcherList = $trBean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'ColorMatcher' AND trwg_trworkinggroup.parent_type = 'Users'");
                        
                        if (!empty($workGroupColorMatcherList) && count($workGroupColorMatcherList) > 0) {
                            // Used to fix issue where it skips TR After Save Hooks and cause issues like incorrect assigned user despite Stage and Status changes
                            $_REQUEST['skip_hook'] = true;
                            
                            $workGroupColorMatcherList[0]->parent_id = '';
                            $workGroupColorMatcherList[0]->save();
                        }
                    }
                }

                // Only trigger TR bean save after removing and re-inserting distro items
                // Needs to be outside distro quantity changed condition as this still needs to run the needed logic hooks from other related modules
                if (isset($trBean) && $trBean->id) {
                    // Used to fix issue where it skips TR After Save Hooks and cause issues like incorrect assigned user despite Stage and Status changes
                    $_REQUEST['skip_hook'] = true;
                    
                    $trBean->save();
                }
            }
        }

        private function insert_distribution_line_item($module, $id, $qty, $distribution_item, $shipping_method, $account_information, $status, $assigned_to, $row_order, $created_by, $technical_request_id, $uom)
        {
            if(!empty($distribution_item) && !empty($qty) && !empty($shipping_method))
            {
                $distribution_items_bean = BeanFactory::newBean('DSBTN_DistributionItems');
                $distribution_items_bean->qty_c = $qty;
                $distribution_items_bean->distribution_item_c = $distribution_item;
                $distribution_items_bean->shipping_method_c = $shipping_method;
                $distribution_items_bean->account_information_c = $account_information;
                $distribution_items_bean->uom_c = $uom;
                $distribution_items_bean->row_order_c = $row_order;
                $distribution_items_bean->created_by = $created_by;
                
                


                if ($module == 'DSBTN_Distribution') {
                    $distribution_items_bean->status_c = $status;
                    $distribution_items_bean->assigned_user_id = $assigned_to;
                    $distribution_items_bean->dsbtn_distribution_id_c = $id;
                }
                
                if ($module == 'Contacts') {
                    $distribution_items_bean->contact_id_c = $id;
                }

                $distribution_items_bean->save();
                $this->handle_completed_date_value($distribution_items_bean);

                // Disabled feature as per OnTrack #1512
                // $this->triggerDistributionItemCompleted($distribution_items_bean);
            }
        }

        private function remove_distributions($module, $id)
        {
            global $db;
            
            $query = "DELETE  a, b 
                FROM    dsbtn_distributionitems a
                INNER JOIN dsbtn_distributionitems_cstm b
                    ON b.id_c = a.id ";

            if ($module == 'DSBTN_Distribution') {
                $query .= " WHERE  b.dsbtn_distribution_id_c = '{$id}'";
            }
            
            if ($module == 'Contacts') {
                $query .= " WHERE  b.contact_id_c = '{$id}'";
            }

            $db->query($query);
        }

        private function retrieve_current_distribution_items($distroId)
        {
            $distroItemBean = BeanFactory::getBean('DSBTN_DistributionItems');
            $distroItemBeanList = $distroItemBean->get_full_list("row_order_c ASC", "dsbtn_distributionitems_cstm.dsbtn_distribution_id_c = '{$distroId}'", false, 0);

            return $distroItemBeanList;
        }

        // Triggers an email notification for Distribution Items that's been updated to Complete
        // Only for items that are Sample/Chips - OnTrack #1358
        private function triggerDistributionItemCompleted($newDistroItemBean)
        {
            global $log;
            
            if ((strpos($newDistroItemBean->distribution_item_c, 'chips') !== false) || (strpos($newDistroItemBean->distribution_item_c, 'sample') !== false)) {
                
                $previousItems = array_filter($this->dbDistroItemBeans, function($itemObj) {
                    return $itemObj->status_c !== 'complete' && $itemObj->status_c !== 'rejected';
                });
                
                // Sort Previous Distribution Items ASC order
                usort($previousItems, function($a, $b) {
                    return strcmp($a->distribution_item_c, $b->distribution_item_c);
                });

                $distroBean = BeanFactory::getBean('DSBTN_Distribution', $newDistroItemBean->dsbtn_distribution_id_c);
                $trBean = BeanFactory::getBean('TR_TechnicalRequests', $distroBean->tr_technicalrequests_id_c);

                if ((! $distroBean->id) && (! $trBean->id)) { 
                    return true;
                }
                
                // Created By
                $workGroupCreatedByList = $trBean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'Creator' AND trwg_trworkinggroup.parent_type = 'Users'");
                $createdByUserBean = (!empty($workGroupCreatedByList) && count($workGroupCreatedByList) > 0) ? BeanFactory::getBean('Users', $workGroupCreatedByList[0]->parent_id) : null;
                
                // Sales Rep
                $workGroupSalesRepList = $trBean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'SalesPerson' AND trwg_trworkinggroup.parent_type = 'Users'");
                $salesRepBean = (!empty($workGroupSalesRepList) && count($workGroupSalesRepList) > 0) ? BeanFactory::getBean('Users', $workGroupSalesRepList[0]->parent_id) : null;

                // If $createdByUserBean is empty, then Creator workgroup does not exist since it is equal to Sales Rep, therefore assign $createdByUserBean to $salesRepBean
                if ((! $createdByUserBean) || ($createdByUserBean && ! $createdByUserBean->id)) {
                    $createdByUserBean = $salesRepBean;
                }
                
                foreach ($previousItems as $prevItem) {
                    if (in_array($prevItem->distribution_item_c, $this->checkedItems) === false && $prevItem->distribution_item_c == $newDistroItemBean->distribution_item_c && $newDistroItemBean->status_c == 'complete' && $newDistroItemBean->status_c != $prevItem->status_c) {
                        if ($createdByUserBean && $createdByUserBean->id) {
                            EmailNotificationHelper::notifyOnItemComplete($newDistroItemBean, [$createdByUserBean],[], ['trBean' => $trBean]);
                            array_push($this->checkedItems, $prevItem->distribution_item_c);
                        }
                    }
                }
            }
        
        }

        private function handle_completed_date_value($newDistroItemBean)
        {
            global $log, $db;

            $checkedItems = array();
            $previousItems = $this->dbDistroItemBeans;

            if ($newDistroItemBean->status_c == 'complete') {
                if (in_array($newDistroItemBean->distribution_item_c, array_column($previousItems, 'distribution_item_c'))) {
                    foreach ($previousItems as $prevItem) {
                        if (in_array($prevItem->distribution_item_c, $checkedItems) === false && $prevItem->distribution_item_c == $newDistroItemBean->distribution_item_c) {
                            array_push($checkedItems, $prevItem->distribution_item_c);

                            $date_completed = ($newDistroItemBean->status_c != $prevItem->status_c) ? Carbon::now() : $prevItem->date_completed_c;
                        }
                    }
                } else {
                    $date_completed = Carbon::now();
                }

                if ($date_completed) {
                    $sql = "
                        UPDATE dsbtn_distributionitems_cstm
                        SET date_completed_c = '{$date_completed}'
                        WHERE id_c = '{$newDistroItemBean->id}'
                    ";
                    
                    $db->query($sql);
                }
            }
        }
    }

?>