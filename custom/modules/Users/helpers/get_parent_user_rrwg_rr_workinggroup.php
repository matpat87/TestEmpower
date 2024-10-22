<?php
    function get_parent_user_rrwg_rr_workinggroup()
    {
        global $app, $log;
        $id = $app->controller->bean->id; // $app->controller->bean is User Bean
        
        $result = "SELECT 
                        CONCAT(COALESCE(users.first_name, ''),
                                ' ',
                                COALESCE(users.last_name, '')) AS name,
                        rrwg_rrworkinggroup.rr_roles AS rr_roles,
                        rrwg_rrworkinggroup.id AS id,
                        rrwg_rrworkinggroup.date_entered as date_entered,
                        rrwg_rrworkinggroup.date_modified as date_modified,
                        rrq_regulatoryrequests_cstm.id_num_c as rr_number_non_db,
                        rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c.rrq_regula2443equests_ida as rrq_regula2443equests_ida
                    FROM
                        rrwg_rrworkinggroup
                            INNER JOIN
                        rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c ON rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c.rrq_regulaffdanggroup_idb = rrwg_rrworkinggroup.id
                            INNER JOIN
                        rrq_regulatoryrequests ON rrq_regulatoryrequests.id = rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c.rrq_regula2443equests_ida
                            LEFT JOIN
                        rrq_regulatoryrequests_cstm ON rrq_regulatoryrequests_cstm.id_c = rrq_regulatoryrequests.id
                            LEFT JOIN
                        users ON users.id = rrwg_rrworkinggroup.parent_id
                            AND rrwg_rrworkinggroup.parent_type = 'Users'
                    WHERE
                        rrwg_rrworkinggroup.deleted = 0
                            AND rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c.deleted = 0
                            AND rrq_regulatoryrequests.deleted = 0
                            AND rrwg_rrworkinggroup.parent_id = '{$id}'";

        return $result;
    }
?>