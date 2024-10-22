<?php
    function get_assigned_tri_technicalrequestitems()
    {
        global $app, $log;
        $id = $app->controller->bean->id; // $app->controller->bean is User Bean
        
        $result = "SELECT 
                tri_technicalrequestitems.name AS name,
                tri_technicalrequestitems.id AS id,
                tri_technicalrequestitems.date_entered AS date_entered,
                tri_technicalrequestitems.date_modified AS date_modified,
                CONCAT(COALESCE(users.first_name, ''), ' ', COALESCE(users.last_name, '')) AS assigned_user_name,
                tri_technicalrequestitems.date_modified AS date_modified,
                tri_technicalrequestitems.uom AS uom,
                tri_technicalrequestitems.qty as qty,
                tri_technicalrequestitems.due_date as due_date,
                tri_technicalrequestitems_cstm.est_completion_date_c AS est_completion_date_c,
                tri_technicalrequestitems_cstm.completed_date_c AS completed_date_c,
                tr_technicalrequests_cstm.technicalrequests_number_c as users_tri_technicalrequestsitems_tr_number_non_db,
                tr_technicalrequests.id as tri_techni0387equests_ida,
                tri_technicalrequestitems.assigned_user_id as assigned_user_id
            FROM
                tri_technicalrequestitems
                    LEFT JOIN
                tri_technicalrequestitems_cstm ON tri_technicalrequestitems_cstm.id_c = tri_technicalrequestitems.id
                    LEFT JOIN
                tri_technicalrequestitems_tr_technicalrequests_c ON tri_technicalrequestitems_tr_technicalrequests_c.tri_technif81bstitems_idb = tri_technicalrequestitems.id
                    AND tri_technicalrequestitems_tr_technicalrequests_c.deleted = 0
                    LEFT JOIN
                tr_technicalrequests ON tr_technicalrequests.id = tri_technicalrequestitems_tr_technicalrequests_c.tri_techni0387equests_ida
                    AND tr_technicalrequests.deleted = 0
                    LEFT JOIN
                tr_technicalrequests_cstm ON tr_technicalrequests.id = tr_technicalrequests_cstm.id_c
                    LEFT JOIN
                users ON users.id = tri_technicalrequestitems.assigned_user_id
            WHERE
                tri_technicalrequestitems.deleted = 0 and
                tri_technicalrequestitems.assigned_user_id = '{$id}'";

        return $result;
    }
?>