<?php
    function get_parent_user_trwg_tr_workinggroup()
    {
        global $app, $log;
        $id = $app->controller->bean->id; // $app->controller->bean is User Bean
        
        $result = "SELECT 
                        CONCAT(COALESCE(users.first_name, ''),
                                ' ',
                                COALESCE(users.last_name, '')) AS name,
                        trwg_trworkinggroup.tr_roles AS tr_roles,
                        trwg_trworkinggroup.id AS id,
                        trwg_trworkinggroup.date_entered as date_entered,
                        trwg_trworkinggroup.date_modified as date_modified,
                        tr_technicalrequests_cstm.technicalrequests_number_c as tr_number_c_nondb,
                        tr_technicalrequests_trwg_trworkinggroup_1_c.tr_technic9742equests_ida as tr_technic9742equests_ida
                    FROM
                        trwg_trworkinggroup
                            LEFT JOIN
                        trwg_trworkinggroup_cstm ON trwg_trworkinggroup.id = trwg_trworkinggroup_cstm.id_c
                            INNER JOIN
                        tr_technicalrequests_trwg_trworkinggroup_1_c ON tr_technicalrequests_trwg_trworkinggroup_1_c.tr_technic7dfcnggroup_idb = trwg_trworkinggroup.id
                            INNER JOIN
                        tr_technicalrequests ON tr_technicalrequests.id = tr_technicalrequests_trwg_trworkinggroup_1_c.tr_technic9742equests_ida
                            LEFT JOIN
                        tr_technicalrequests_cstm ON tr_technicalrequests_cstm.id_c = tr_technicalrequests.id
                            LEFT JOIN
                        users ON users.id = trwg_trworkinggroup.parent_id
                            AND trwg_trworkinggroup.parent_type = 'Users'
                    WHERE
                        trwg_trworkinggroup.deleted = 0
                            AND tr_technicalrequests_trwg_trworkinggroup_1_c.deleted = 0
                            AND tr_technicalrequests.deleted = 0
                            AND trwg_trworkinggroup.parent_id = '{$id}'";

        return $result;
    }
?>