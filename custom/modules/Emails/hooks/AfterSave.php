<?php

class EmailsAfterSaveHook 
{

    function custom_related_to_audit($bean, $event, $arguments)
    {
        global $db, $timedate, $app_list_strings, $current_user;

        if ($bean->fetched_row['parent_type'] != $bean->parent_type 
            || $bean->fetched_row['parent_id'] != $bean->parent_id ) {
                
            // Manual insert on emails_audit table
            $newId = create_guid();
            $timeDateNow = $timedate->getNow()->asDb();

            $beforeValueBean = BeanFactory::getBean($bean->fetched_row['parent_type'], $bean->fetched_row['parent_id']);
            $beforeValueName = isset($beforeValueBean->first_name) ? "{$beforeValueBean->first_name} {$beforeValueBean->last_name}" : $beforeValueBean->name;
            $beforeValueStr = "{$app_list_strings['parent_type_display'][$bean->fetched_row['parent_type']]} - {$beforeValueName}";
            $afterValueStr = $app_list_strings['parent_type_display'][$bean->parent_type] . " - " . $bean->parent_name;

            $query = "
                INSERT INTO `emails_audit` (
                    `id`,
                    `parent_id`,
                    `date_created`,
                    `created_by`,
                    `field_name`,
                    `data_type`,
                    `before_value_string`,
                    `after_value_string`
                )

                VALUES (
                    '{$newId}',
                    '$bean->id',
                    '{$timeDateNow}',
                    '{$current_user->id}',
                    'Related To',
                    'id',
                    '{$beforeValueStr}',
                    '{$afterValueStr}'
                );
            ";


            $result = $db->query($query);

        }
      
    }
}

?>