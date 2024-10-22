<?php


class ProjectTaskBeforeSaveHook 
{


    function status_update_append_before_save(&$bean, $event, $arguments)
    {
        global $current_user, $log;
        $status = "";
        $time_and_date = new TimeAndDateCustom();
        $current_datetime_timestamp = $time_and_date->customeDateFormatter($time_and_date->new_york_format, "D m/d/Y g:iA");

        if(empty($bean->prj_number_c)){
            $bean->prj_number_c = $this->retrieveNewPrjTask();
        }

        if($bean->status_update_c != ""){
            $conjunction = "<br/>";
           

            $status = '<div style="font-size: 8pt;">('. $current_user->user_name . ' - '.  $current_datetime_timestamp .')</div>';
            $status .= '<div style="font-size: 12pt;">'. nl2br($bean->status_update_c) .'</div>';

            if($bean->work_log_c != "") {
                $status .= "$conjunction " . $bean->work_log_c;
            }

            $bean->work_log_c = $status;
            $bean->status_update_c = "";
        }
    }

    function check_project_number(&$bean, $event, $arguments) 
    {
        global $current_user, $log, $db;
        
        if (! $bean->fetched_row['id']) {
            // Retrieve or increment lates project number
            $db = DBManagerFactory::getInstance();

            $sql= "SELECT task_number FROM project_task WHERE deleted = 0 ORDER BY date_entered DESC LIMIT 1";
            $result = $db->query($sql);
            $row = $db->fetchByAssoc($result);
            $bean->task_number = $row['task_number'] + 1;
        
        }
        
    }

    private function retrieveNewPrjTask() {
        global $db;

        $db = DBManagerFactory::getInstance();

        $sql= "SELECT prj_number_c 
            FROM project_task_cstm 
            ORDER BY prj_number_c DESC LIMIT 1";
        $result = $db->query($sql);
        $row = $db->fetchByAssoc($result);
        $prj_number_c = !empty($row['prj_number_c']) ? $row['prj_number_c'] : 0;
        
        return $prj_number_c + 1;
    }
  
}

?>