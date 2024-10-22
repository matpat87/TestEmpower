<?php

function tr_technicalrequests_contacts_1()
{
    //Get the current bean
    $bean = $GLOBALS['app']->controller->bean;

    $return_array = [];
    $return_array['select'] = " SELECT tr_technicalrequests.id ";
    $return_array['from'] = " FROM tr_technicalrequests ";
    $return_array['join'] = "  
        INNER JOIN contacts 
            ON contacts.id = tr_technicalrequests_cstm.contact_id1_c
            AND contacts.deleted = 0
    ";


    $return_array['where'] = " contacts.id = '{$bean->id}' AND tr_technicalrequests.deleted = 0 ";

    return $return_array;
}
function custom_dsbtn_distributioncustom_dsbtn_distribution()
{
    //Get the current bean
    $bean = $GLOBALS['app']->controller->bean;

    $return_array = [];
    $return_array['select'] = " SELECT dsbtn_distribution.id ";
    $return_array['from'] = " FROM dsbtn_distribution ";
    $return_array['join'] = "  
        INNER JOIN contacts 
            ON contacts.id = dsbtn_distribution_cstm.contact_id_c
            AND contacts.deleted = 0
    ";


    $return_array['where'] = " contacts.id = '{$bean->id}' AND dsbtn_distribution.deleted = 0 ";

    return $return_array;
}
