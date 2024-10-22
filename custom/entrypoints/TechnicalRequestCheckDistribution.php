<?php

    if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    global $log;

    $post = $_POST;
    $technical_request_id = $post['technical_request_id']; // change it to post later
    $result = array('result' => false,);

    $distroBean = BeanFactory::getBean('DSBTN_Distribution');
    $distroBeanList = $distroBean->get_full_list("", "dsbtn_distribution_cstm.tr_technicalrequests_id_c = '{$technical_request_id->id}'", false, 0);

    if($distroBeanList != null && count($distroBeanList) > 0)
    {
        $result['result'] = true;
    }

    echo json_encode($result);
?>