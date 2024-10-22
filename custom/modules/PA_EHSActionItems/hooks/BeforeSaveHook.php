<?php

    class PA_EHSActionItemsBeforeSave
    {
        function formatStatusUpdateLog(&$bean, $event, $arguments)
        {
            global $current_user, $log;
            $status = "";
            $time_and_date = new TimeAndDateCustom();
            $current_datetime_timestamp = $time_and_date->customeDateFormatter($time_and_date->new_york_format, "D m/d/Y g:iA");

            if($bean->status_update != ""){
                $conjunction = "<br/>";
            

                $status = '<div style="font-size: 8pt;">('. $current_user->user_name . ' - '.  $current_datetime_timestamp .')</div>';
                $status .= '<div style="font-size: 12pt;">'. nl2br($bean->status_update) .'</div>';

                if($bean->status_update_log_c != "") {
                    $status .= "$conjunction " . $bean->status_update_log_c;
                }

                $bean->status_update_log_c = $status;
                $bean->status_update = "";
            }
        }
    }
?>