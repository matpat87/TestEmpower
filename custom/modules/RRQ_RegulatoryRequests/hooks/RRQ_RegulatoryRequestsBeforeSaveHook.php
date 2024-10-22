<?php
    require_once('custom/modules/RRQ_RegulatoryRequests/helpers/RRQ_RegulatoryRequestsHelper.php');
    require_once('custom/modules/RRQ_RegulatoryRequests/ManageTimelyNotif.php');

    class RRQ_RegulatoryRequestsBeforeSaveHook{
        
        public function assign_id(&$bean, $event, $arguments){
            //assign id for Regulatory Requests
            if(isset($bean->fetched_row) && !$bean->fetched_row['id']){
                $id_num = $this->get_id();
                $id_num = !empty($id_num) ? ((int) $id_num) + 1 : 1;
                $bean->id_num_c = $id_num;
            }
        }

        public function before_save(&$bean, $event, $arguments){
            global $current_user;

            //set only during first save
            if(isset($bean->fetched_row) && !$bean->fetched_row['id']){
                $bean->name = $bean->id_num_c;
                $bean->user_id1_c = $current_user->id;
            }

            // echo 'fetched_row id: ' . $bean->fetched_row['id'] . '<br/>';;
            // echo 'id: ' . $bean->id . '<br/>';
            // echo 'assigned_user_id: ' . $bean->assigned_user_id . '<br/>';
            // echo 'status_c: ' . $bean->status_c . '<br/>';
            // echo '<br/>';

            // $this->manage_workflow($bean);        
        }

        private function manage_workflow(&$bean){
            $db_record = RRQ_RegulatoryRequestsHelper::get_record($bean->fetched_row['id']);

             //Workflow Process and record is already in db
             if(isset($bean->fetched_row) && !empty($bean->fetched_row['id'])){

                //change status to assigned if Manager done choosing
                if($bean->status_c == 'new'){
                    //$bean->status_c = 'assigned';
                    $regulatory_manager_details = RRQ_RegulatoryRequestsHelper::get_regulatory_manager();

                    //means Reg Manager has assigned someone
                    if($bean->assigned_user_id != $regulatory_manager_details['id']){
                        $bean->status_c = 'assigned';
                    }
                    else{ //assign to Reg Manager
                        $bean->assigned_user_id = $regulatory_manager_details['id'];
                    }
                }

                //Complete / Rejected - assign to Requestor
                if($bean->status_c == 'complete' || $bean->status_c == 'rejected'){
                    $bean->assigned_user_id = $bean->user_id_c;
                    $bean->assigned_user_id = $regulatory_manager_details['id'];
                }


            }

            if($bean->custom_action == 'SubmitForReview'){
                $regulatory_manager_details = RRQ_RegulatoryRequestsHelper::get_regulatory_manager();
                $bean->status_c = 'new';
                $bean->assigned_user_id = $regulatory_manager_details['id'];
            }
        }

        private function get_id(){
            global $db;
            $result = '';
            $query = "select rc.id_num_c
                        from rrq_regulatoryrequests r
                        left join rrq_regulatoryrequests_cstm rc
                            on rc.id_c = r.id
                        where r.deleted = 0
                        order by CAST(id_num_c AS SIGNED) desc
                        limit 1";
            $data = $db->query($query);
            $rowData = $db->fetchByAssoc($data);

            if($rowData != null)
            {
                $result = $rowData['id_num_c'];
            }

            return $result;
        }

        public function handleStatusUpdateFormat(&$bean, $event, $arguments)
        {
            global $current_user;

            $status = "";
            $time_and_date = new TimeAndDateCustom();
            $current_datetime_timestamp = $time_and_date->customeDateFormatter($time_and_date->new_york_format, "D m/d/Y g:iA");
    
            if ($bean->status_update_c != "") {
                $conjunction = "<br/>";
               
    
                $status = '<div style="font-size: 8pt;">('. $current_user->user_name . ' - '.  $current_datetime_timestamp .')</div>';
                $status .= '<div style="font-size: 12pt; line-height: 1">'. nl2br($bean->status_update_c) .'</div>';
    
                if($bean->status_update_log_c != "") {
                    $status .= "$conjunction " . $bean->status_update_log_c;
                }
    
                $bean->status_update_log_c = $status;
                $bean->status_update_c = "";
            } else {
                // On edit, the field becomes blank by default and triggers an audit change when saved as empty if it previously had a value
                // Need to set it on the backend to set value based on fetched_row to prevent incorrect audit log
                // $bean->status_update_c = $bean->fetched_row['status_update_c'];
                // $bean->status_update_c = "";
            }
        }

    }

?>