<?php

function get_user_times($args){
    global $app, $log;
    $id = $app->controller->bean->id; // $app->controller->bean is User Bean

    $return_array = "
        SELECT 
            times.id,
            times.name,
            times.time,
            times.date_entered,
            times.date_modified,
            times.date_worked,
            times.parent_id,
            times.parent_type,
            times.assigned_user_id,
            CONCAT(users.first_name, ' ', users.last_name) AS assigned_user_name
        FROM
            times
                LEFT JOIN
            users ON users.id = times.assigned_user_id
                AND users.deleted = 0
                LEFT JOIN
            users_cstm ON users_cstm.id_c = users.id
        WHERE
            times.deleted = 0
                AND times.assigned_user_id = '{$id}' ";

    return $return_array;
}

function getParentJoin()
{
    $joinQuery = "";

    
}

?>