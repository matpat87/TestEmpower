<?php
    // Workflow Section
    $dictionary['AOS_Products']['fields']['workflow_section_non_db']= array(
        'name' => 'workflow_section_non_db',
        'vname' => 'LBL_WORKFLOW_SECTION_NON_DB',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );

    // Overview Section
    $dictionary['AOS_Products']['fields']['overview_section_non_db']= array(
        'name' => 'overview_section_non_db',
        'vname' => 'LBL_OVERVIEW_SECTION_NON_DB',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );

    //  Non-db TR Relate field
    //  Set naming convention as tr_technicalrequests_aos_products_2 to trick subpanel "create" to populate the non-db tr field automatically
    $dictionary['AOS_Products']['fields']['tr_technicalrequests_aos_products_2'] = array (
        'name' => 'tr_technicalrequests_aos_products_2',
        'type' => 'link',
        'relationship' => 'tr_technicalrequests_aos_products_2',
        'source' => 'non-db',
        'module' => 'TR_TechnicalRequests',
        'bean_name' => 'TR_TechnicalRequests',
        'vname' => 'LBL_TR_TECHNICALREQUESTS_AOS_PRODUCTS_2_FROM_TR_TECHNICALREQUESTS_TITLE',
        'id_name' => 'tr_technicalrequests_aos_products_2tr_technicalrequests_ida',
    );

    $dictionary['AOS_Products']['fields']['tr_technicalrequests_aos_products_2_name'] = array (
        'name' => 'tr_technicalrequests_aos_products_2_name',
        'type' => 'relate',
        'source' => 'non-db',
        'vname' => 'LBL_TR_TECHNICALREQUESTS_AOS_PRODUCTS_2_FROM_TR_TECHNICALREQUESTS_TITLE',
        'save' => true,
        'id_name' => 'tr_technicalrequests_aos_products_2tr_technicalrequests_ida',
        'link' => 'tr_technicalrequests_aos_products_2',
        'table' => 'tr_technicalrequests',
        'module' => 'TR_TechnicalRequests',
        'rname' => 'name',
        'inline_edit' => '',
        'required' => true,
    );

    $dictionary['AOS_Products']['fields']['tr_technicalrequests_aos_products_2tr_technicalrequests_ida'] = array (
        'name' => 'tr_technicalrequests_aos_products_2tr_technicalrequests_ida',
        'type' => 'link',
        'relationship' => 'tr_technicalrequests_aos_products_2',
        'source' => 'non-db',
        'reportable' => false,
        'side' => 'right',
        'vname' => 'LBL_TR_TECHNICALREQUESTS_AOS_PRODUCTS_2_FROM_AOS_PRODUCTS_TITLE',
    );
?>