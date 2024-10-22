<?php

    class SalesActivityProcessRecordHook
    {
        public function processStatusColumn($bean, $event, $arguments)
        {
            global $log, $app_list_strings;

            if ($bean->activity_name_c == 'Meetings') {
                $bean->status_c = ($bean->type_c_nondb != "N/A" && $bean->type_c_nondb != "") 
                    ? "Meeting - {$app_list_strings['meeting_type_list'][$bean->type_c_nondb]} ({$bean->activity_status_nondb})"
                    : $bean->status_c;
            }
            
        }
    }

?>