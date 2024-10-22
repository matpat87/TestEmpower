<?php

    require_once('include/SugarPHPMailer.php');
    require_once('custom/modules/RRQ_RegulatoryRequests/helpers/RRQ_RegulatoryRequestsHelper.php');
    require_once('custom/modules/RRQ_RegulatoryRequests/ManageTimelyNotif.php');
    require_once('custom/modules/RRWG_RRWorkingGroup/helpers/RRWorkingGroupHelper.php');

    class RRQ_RegulatoryRequestsAfterSaveHook{

        public function save_cust_products(&$bean, $event, $arguments){
            global $log;

            $customer_product_ids = $_REQUEST['customer_product_id'];
            if(!empty($customer_product_ids) && count($customer_product_ids) > 0){
                /* Ontrack 1742: Depracated relationship as this is an incorrect link: RR and Customer Products needs to be a 'many-to-many' link -- Glai Obido
                    $bean->load_relationship('rrq_regulatoryrequests_ci_customeritems_1'); 
                */
                
                $bean->load_relationship('rrq_regulatoryrequests_ci_customeritems_2');
                $db_cust_prod_bean_list = $bean->rrq_regulatoryrequests_ci_customeritems_2->getBeans();

                //delete all
                foreach($db_cust_prod_bean_list as $db_cust_prod_bean){
                    $bean->rrq_regulatoryrequests_ci_customeritems_2->delete($bean->id, $db_cust_prod_bean);
                }

                //then, save all
                foreach($customer_product_ids as $index => $customer_product_id){
                    if($index == 0){ //skip 0 because of UI issues
                        continue;
                    }
                    else{
                        //echo 'customer_product_id : ' . $customer_product_id . '<br/>';
                        $cust_prod_bean = BeanFactory::getBean('CI_CustomerItems', $customer_product_id);
                        $bean->rrq_regulatoryrequests_ci_customeritems_2->add($cust_prod_bean);

                        //echo 'name : ' . $cust_prod_bean->name . '<br/>';
                        
                    }
                }
            }

        }

        public function email_notif(&$bean, $event, $arguments){

            global $sugar_config, $app_list_strings, $current_user, $log;

            if ($bean->fetched_row['assigned_user_id'] != $bean->assigned_user_id) {
                // Make use of the ManageTimelyNotif class to get the Regulatory Manager
                $customNotifObj = new ManageTimelyNotif($bean->id);
                $regulatoryManagerUserBean = $customNotifObj->getRegulatoryManager();

                $creatorUserBean = BeanFactory::getBean('Users', $bean->user_id1_c);
                // handleAssignmentNotification($bean, [$creatorUserBean]); // trigger Email Notification to the assigned user and cc the Creator of the Regulatory Request
            }

            if( !$bean->fetched_row //first save
                || (is_array($bean->fetched_row) && $bean->status_c != $bean->fetched_row['status_c'])){
                $content = RRQ_RegulatoryRequestsHelper::get_content($bean);
                $address_arr = array();
                $regulatory_manager_details = RRQ_RegulatoryRequestsHelper::get_regulatory_manager();

                if($bean->status_c == 'new'){
                    $address_arr[] = array(
                        'email' => $regulatory_manager_details['email'],
                        'name' => $regulatory_manager_details['name']
                    );
                    // RRQ_RegulatoryRequestsHelper::send_email($subject, $content, $address_arr);
                }
                else if($bean->status_c == 'assigned'){

                    if(!empty($bean->assigned_user_id)){
                        $user_bean = BeanFactory::getBean('Users', $bean->assigned_user_id);
                        $address_arr[] = array(
                            'email' => $user_bean->emailAddress->getPrimaryAddress($user_bean),
                            'name' => $user_bean->name
                        );
                    }

                    if(!empty($bean->user_id1_c)){
                        $user_bean = BeanFactory::getBean('Users', $bean->user_id1_c);
                        $address_arr[] = array(
                            'email' => $user_bean->emailAddress->getPrimaryAddress($user_bean),
                            'name' => $user_bean->name
                        );
                    }

                    // RRQ_RegulatoryRequestsHelper::send_email($subject, $content, $address_arr);
                }
                else if($bean->status_c == 'complete'){
                    if(!empty($bean->assigned_user_id)){
                        $user_bean = BeanFactory::getBean('Users', $bean->assigned_user_id);
                        $address_arr[] = array(
                            'email' => $user_bean->emailAddress->getPrimaryAddress($user_bean),
                            'name' => $user_bean->name
                        );
                    }
                }
                else if($bean->status_c == 'awaiting_more_info'){
                    
                    if(!empty($bean->user_id1_c)){
                        $user_bean = BeanFactory::getBean('Users', $bean->user_id1_c);
                        $address_arr[] = array(
                            'email' => $user_bean->emailAddress->getPrimaryAddress($user_bean),
                            'name' => $user_bean->name
                        );
                    }

                    // RRQ_RegulatoryRequestsHelper::send_email($subject, $content, $address_arr);
                }
            }

            //die();
        }

        public function handleUserAssignment(&$bean, $event, $arguments)
        {
            global $current_user, $db, $log;

            if (!empty($bean->fetched_row['id'])) {
                // Regulatory Manager Bean
                $regulatoryManagerUserBean = RRWorkingGroupHelper::handleRetrieveWorkgroupUserBean($bean, 'RegulatoryManager');
                
                // Regulatory Analyst Bean
                $regulatoryAnalystUserBean = RRWorkingGroupHelper::handleRetrieveWorkgroupUserBean($bean, 'RegulatoryAnalyst');

                // Requestor Bean
                $requestorUserBean = RRWorkingGroupHelper::handleRetrieveWorkgroupUserBean($bean, 'Requestor');
                
                // Creator User Bean
                $creatorUserBean = RRWorkingGroupHelper::handleRetrieveWorkgroupUserBean($bean, 'Creator');
                $creatorUserBean = ($creatorUserBean && $creatorUserBean->id) ? $creatorUserBean : $current_user;

                switch ($bean->status_c) {
                    case 'new':
                        if ($bean->fetched_row['status_c'] != $bean->status_c) {
                            // if status has been updated to NEW: set assigned user to Regulatory Manager
                            $bean->assigned_user_id = ($regulatoryManagerUserBean && $regulatoryManagerUserBean->id) 
                                ? $regulatoryManagerUserBean->id 
                                : $bean->assigned_user_id;
                            break;
                        }
                        
                        // if status is still new (AND unchanged) AND assigned user is updated: set status only to 'Assigned' and do nothing with the new assigned user
                        if ($bean->fetched_row['status_c'] == $bean->status_c && ($bean->fetched_row['assigned_user_id'] != $bean->assigned_user_id && ($regulatoryManagerUserBean && $regulatoryManagerUserBean->id) && $bean->assigned_user_id != $regulatoryManagerUserBean->id)) {
                            $bean->status_c = 'assigned';
                            
                            $updateStatusQuery = "UPDATE rrq_regulatoryrequests_cstm SET status_c = '{$bean->status_c}' WHERE id_c = '{$bean->id}'";
                            $db->query($updateStatusQuery);

                            RRWorkingGroupHelper::createOrUpdateRRRole($bean, 'RegulatoryAnalyst');
                            break;
                        }

                        break;
                    case 'assigned':
                    case 'in_process':
                        $bean->assigned_user_id = ($regulatoryAnalystUserBean && $regulatoryAnalystUserBean->id)
                            ? $regulatoryAnalystUserBean->id
                            : $bean->assigned_user_id;
                        break;
                    case 'complete':
                    case 'rejected':
                        // If status changed to Complete, System Assigns to Requested By
                        $bean->assigned_user_id = ($requestorUserBean && $requestorUserBean->id)
                            ? $requestorUserBean->id
                            : $bean->assigned_user_id;
                        break;
                    case 'waiting_on_supplier':
                        // If status changed to Complete, System Assigns to Requested By
                        $bean->assigned_user_id = $bean->assigned_user_id;
                        break;
                    default:
                        $bean->assigned_user_id = ($creatorUserBean && $creatorUserBean->id)
                            ? $creatorUserBean->id
                            : $bean->assigned_user_id;
                        break;
                } // end of switch

                if ($bean->assigned_user_id != $bean->fetched_row['assigned_user_id']) {
                    $updateQuery = "UPDATE rrq_regulatoryrequests SET assigned_user_id = '{$bean->assigned_user_id}' WHERE id = '{$bean->id}'";
                    $db->query($updateQuery);
                }
            }
        }

        public function handleAssignedEmailNotifications(&$bean, $event, $arguments)
        {
            global $currentUser, $sugar_config;
            
            if ($bean->fetched_row['assigned_user_id'] != $bean->assigned_user_id) {
                // Regulatory Manager Bean
                $regulatoryManagerUserBean = RRWorkingGroupHelper::handleRetrieveWorkgroupUserBean($bean, 'RegulatoryManager');

                // Creator User Bean
                $creatorUserBean = RRWorkingGroupHelper::handleRetrieveWorkgroupUserBean($bean, 'Creator');
                
                $recordUrl = "{$sugar_config['site_url']}/index.php?module=RRQ_RegulatoryRequests&action=DetailView&record={$bean->id}";

                $customMailObj = new ManageTimelyNotif($bean->id);

                switch($bean->status_c) {
                    case 'assigned':
                        // (Assigned User & Creator )
                        $customMailObj->processAssignedUserEmailNotifications([$creatorUserBean]); // trigger Email Notification to the assigned user and cc the Creator of the Regulatory Request
                        break;
                    case 'rejected':
                        //Should be Requestor based on Workflow & Regulatory Manager
                        $customMailObj->processAssignedUserEmailNotifications([$regulatoryManagerUserBean]); // trigger Email Notification to the assigned user and cc the Creator of the Regulatory Request
                        break;
                    case 'created_in_error':
                    case 'in_process':
                        // no email notification
                        break;
                    default;
                    $customMailObj->processAssignedUserEmailNotifications([$regulatoryManagerUserBean]);
                        
                } // end of Switch-Case
            }
        }

        public function generate_workgroup(&$bean, $event, $arguments)
        {
            if ($_REQUEST['massupdate']) {
                return true;
            }
            
            $sortedList = [];
            $sortedList['Creator'] = 'Creator';
            $sortedList['RegulatoryManager'] = 'Regulatory Manager';
            $sortedList['SalesPerson'] = 'Sales Person';

            // Only generate Requestor if Requested By is not empty
            if ($bean->user_id_c) {
                $sortedList['Requestor'] = 'Requestor';
            }
            
            // If status is Assigned onwards, add Regulatory Analyst in array
            if (in_array($bean->status_c, ['assigned', 'in_process'])) {
                $sortedList['RegulatoryAnalyst'] = 'Regulatory Analyst';
            }

            if (count($sortedList) > 0) {
                foreach ($sortedList as $rr_role_key => $rr_role) {
                    if ($rr_role != '') {
                        RRWorkingGroupHelper::createOrUpdateRRRole($bean, $rr_role_key);
                    }
                }
            }
        }
    }

?>