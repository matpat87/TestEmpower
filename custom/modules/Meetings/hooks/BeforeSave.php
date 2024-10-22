<?php
require_once('custom/include/Carbon/src/Carbon/Carbon.php');
require_once('custom/include/Carbon/src/Carbon/CarbonInterval.php');

use Carbon\Carbon;

class MeetingsBeforeSaveHook 
{

    function custom_duration_audit(&$bean, $event, $arguments)
    {
        global $db, $timedate, $current_user, $app_list_strings;

        if ($bean->fetched_row['duration_minutes'] != $bean->duration_minutes || $bean->fetched_row['duration_hours'] != $bean->duration_hours) {
            
            $oldDateStart = Carbon::parse($bean->fetched_row['date_start']);
            $oldDateEnd = Carbon::parse($bean->fetched_row['date_end']);
            $oldDiffInSeconds = $oldDateEnd->diffInSeconds($oldDateStart);

            // Manual insert on calls_audit table
            $newId = create_guid();
            $timeDateNow = $timedate->getNow()->asDb();
            $beforeValueStr = $app_list_strings['duration_dom'][$oldDiffInSeconds];
            $afterValueStr = $app_list_strings['duration_dom'][$bean->duration];
            
            if (array_key_exists($oldDiffInSeconds, $app_list_strings['duration_dom']) && array_key_exists($bean->duration, $app_list_strings['duration_dom'])) {
                $query = "
                    INSERT INTO meetings_audit (
                        `id`,
                        `parent_id`,
                        `date_created`,
                        `created_by`,
                        `field_name`,    
                        `data_type`,
                        `before_value_string`,
                        `after_value_string`) 
                        
                        VALUES (
                            '{$newId}',
                            '{$bean->id}',
                            '{$timeDateNow}',
                            '{$current_user->id}',
                            'duration',
                            'enum',
                            '{$beforeValueStr}',
                            '{$afterValueStr}' );
                ";

    

                $result = $db->query($query);
            }
        }
      
    }

   
}

?>