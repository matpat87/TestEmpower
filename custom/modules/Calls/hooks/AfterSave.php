<?php

class CallsAfterSaveHook 
{

    function custom_status_audit($bean, $event, $arguments)
    {
        global $db, $timedate, $current_user;

        if ($bean->fetched_row['direction'] != $bean->direction 
            || $bean->fetched_row['status'] != $bean->status ) {

            // Manual insert on calls_audit table
            $newId = create_guid();
            $timeDateNow = $timedate->getNow()->asDb();
            $beforeValueStr = $bean->fetched_row['direction'] . " " . $bean->fetched_row['status'];
            $afterValueStr = $bean->direction . " " . $bean->status;

            $query = "
                INSERT INTO calls_audit (
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
                        'status',
                        'enum',
                        '{$beforeValueStr}',
                        '{$afterValueStr}' );
            ";

            $result = $db->query($query);

        }
      
    }
}

?>