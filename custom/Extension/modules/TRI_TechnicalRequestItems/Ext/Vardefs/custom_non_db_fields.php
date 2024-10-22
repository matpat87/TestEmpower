<?php

    $dictionary['TRI_TechnicalRequestItems']['fields']['technical_request_number_non_db']= array(
        'name' => 'technical_request_number_non_db',
        'vname' => 'LBL_TECHNICAL_REQUEST_NUMBER_NON_DB',
        'type' => 'varchar',
        'len' => '150',
        'inline_edit' => false,
        'source' => 'non-db',
    );
    
    $dictionary['TRI_TechnicalRequestItems']['fields']['technical_request_version_non_db']= array(
        'name' => 'technical_request_version_non_db',
        'vname' => 'LBL_TECHNICAL_REQUEST_VERSION_NON_DB',
        'type' => 'varchar',
        'len' => '150',
        'inline_edit' => false,
        'source' => 'non-db',
    );

    $dictionary['TRI_TechnicalRequestItems']['fields']['technical_request_product_name_non_db']= array(
        'name' => 'technical_request_product_name_non_db',
        'vname' => 'LBL_TECHNICAL_REQUEST_PRODUCT_NAME_NON_DB',
        'type' => 'varchar',
        'len' => '150',
        'inline_edit' => false,
        'source' => 'non-db',
    );

    $dictionary['TRI_TechnicalRequestItems']['fields']['technical_request_account_name_non_db']= array(
        'name' => 'technical_request_account_name_non_db',
        'vname' => 'LBL_TECHNICAL_REQUEST_ACCOUNT_NAME_NON_DB',
        'type' => 'varchar',
        'len' => '150',
        'inline_edit' => false,
        'source' => 'non-db',
    );

    $dictionary['TRI_TechnicalRequestItems']['fields']['technical_request_site_non_db']= array(
        'name' => 'technical_request_site_non_db',
        'vname' => 'LBL_TECHNICAL_REQUEST_SITE_NON_DB',
        'type' => 'enum',
        'len' => '150',
        'inline_edit' => false,
        'source' => 'non-db',
        'options' => 'lab_site_list',
        'massupdate' => 0
    );

    $dictionary['TRI_TechnicalRequestItems']['fields']['technical_request_opportunity_number_non_db']= array(
        'name' => 'technical_request_opportunity_number_non_db',
        'vname' => 'LBL_TECHNICAL_REQUEST_OPPORTUNITY_NUMBER_NON_DB',
        'type' => 'varchar',
        'len' => '150',
        'inline_edit' => false,
        'source' => 'non-db',
    );

    $dictionary['TRI_TechnicalRequestItems']['fields']['users_tri_technicalrequestsitems_tr_number_non_db']= array(
        'name' => 'users_tri_technicalrequestsitems_tr_number_non_db',
        'vname' => 'LBL_TRI_TECHNICALREQUESTSITEMS_TR_NUMBER',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );
?>