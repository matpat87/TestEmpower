<?php
    function get_distributions()
    {
        global $app;
        $id = $app->controller->bean->id;

        $result = "SELECT dsbtn_distributionitems_cstm.id_c AS id, 
                            dsbtn_distribution.id AS dsbtn_distribution_id_c,
                            dsbtn_distribution_cstm.account_id_c AS custom_account_id_c,
                            dsbtn_distribution_cstm.distribution_number_c AS custom_distribution_number_c,
                            accounts.name AS custom_account_c,
                            CONCAT(COALESCE(contacts.first_name, ''), ' ', COALESCE(contacts.lASt_name, '')) AS distribution_c,
                            dsbtn_distributionitems_cstm.distribution_item_c,
                            dsbtn_distributionitems_cstm.qty_c,
                            dsbtn_distributionitems_cstm.row_order_c,
                            dsbtn_distributionitems_cstm.shipping_method_c,
                            dsbtn_distribution_cstm.city_c AS custom_city_c,
                            dsbtn_distribution_cstm.state_c AS custom_state_c,
                            dsbtn_distributionitems_cstm.uom_c,
                            dsbtn_distributionitems_cstm.status_c,
                            dsbtn_distributionitems_cstm.account_information_c,
                            dsbtn_distributionitems_cstm.date_completed_c,
                            u.id as assigned_user_id
                    FROM dsbtn_distribution
                    LEFT JOIN dsbtn_distribution_cstm
                    ON dsbtn_distribution_cstm.id_c = dsbtn_distribution.id
                    INNER JOIN dsbtn_distributionitems_cstm
                    ON dsbtn_distributionitems_cstm.dsbtn_distribution_id_c = dsbtn_distribution.id
                    INNER JOIN dsbtn_distributionitems 
                    ON dsbtn_distributionitems.id = dsbtn_distributionitems_cstm.id_c
                        AND dsbtn_distributionitems.deleted = 0
                    LEFT JOIN contacts
                    ON contacts.id = dsbtn_distribution_cstm.contact_id_c 
                        AND contacts.deleted = 0
                    LEFT JOIN accounts
                    ON accounts.id = dsbtn_distribution_cstm.account_id_c
                        AND accounts.deleted = 0
                    LEFT JOIN users as u
	                    ON u.id = dsbtn_distributionitems.assigned_user_id
                            and u.deleted = 0
                    WHERE dsbtn_distribution.deleted = 0
                    AND dsbtn_distribution_cstm.tr_technicalrequests_id_c = '{$id}'
                    GROUP BY dsbtn_distributionitems_cstm.id_c";
        return $result;
    }
?>