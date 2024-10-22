<?php

    if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    $post = $_POST;
    $queryParams = array(
        'module' => 'Home',
        'action' => 'index',    
    );

    if(isset($post['parent_technical_request_id']))
    {
        $queryParams = array(
            'module' => 'TR_TechnicalRequests',
            'action' => 'EditView',
            'return_module' => 'TR_TechnicalRequests',
            'return_action' => 'DetailView',
            'parent_rematch_id' => $post['parent_technical_request_id'],
        );
    }

    SugarApplication::redirect('index.php?' . http_build_query($queryParams));
?>