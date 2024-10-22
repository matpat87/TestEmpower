<?php


class OTR_OnTrackBeforeSaveHook 
{


    function status_update_append_before_save(&$bean, $event, $arguments)
    {
        global $current_user, $log;
        $status = "";
        $time_and_date = new TimeAndDateCustom();
        $current_datetime_timestamp = $time_and_date->customeDateFormatter($time_and_date->new_york_format, "D m/d/Y g:iA");

        if($bean->status_update_c != ""){
            $conjunction = "<br/>";
           

            $status = '<div style="font-size: 8pt;">('. $current_user->user_name . ' - '.  $current_datetime_timestamp .')</div>';
            $status .= '<div style="font-size: 12pt;">'. nl2br($bean->status_update_c) .'</div>';

            if($bean->work_log != "") {
                $status .= "$conjunction " . $bean->work_log;
            }

            $bean->work_log = $status;
            $bean->status_update_c = "";
        }
    }

    
  
}

?>