<?php
    // Workflow Section
    $dictionary['TR_TechnicalRequests']['fields']['workflow_section_non_db']= array(
        'name' => 'workflow_section_non_db',
        'vname' => 'LBL_WORKFLOW_SECTION_NON_DB',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );

    // Overview Section
    $dictionary['TR_TechnicalRequests']['fields']['overview_section_non_db']= array(
        'name' => 'overview_section_non_db',
        'vname' => 'LBL_OVERVIEW_SECTION_NON_DB',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );

    // Product Master Non-DB (Used in listview)
    $dictionary['TR_TechnicalRequests']['fields']['product_master_non_db']= array(
        'name' => 'product_master_non_db',
        'vname' => 'LBL_PRODUCT_MASTER_NON_DB',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );
    // Product Master Non-DB (Used in listview)
    $dictionary['TR_TechnicalRequests']['fields']['product_master_id_non_db']= array(
        'name' => 'product_master_id_non_db',
        'vname' => 'LBL_PRODUCT_MASTER_NON_DB',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );

    //  Non-db TR Relate field
    //  Set naming convention as tr_technicalrequests_aos_products_2 to trick subpanel "create" to populate the non-db tr field automatically
    $dictionary['TR_TechnicalRequests']['fields']['tr_technicalrequests_aos_products_2'] = array (
        'name' => 'tr_technicalrequests_aos_products_2',
        'type' => 'link',
        'relationship' => 'tr_technicalrequests_aos_products_2',
        'source' => 'non-db',
        'module' => 'AOS_Products',
        'bean_name' => 'AOS_Products',
        'vname' => 'LBL_PRODUCT_NUMBER',
        'id_name' => 'tr_technicalrequests_aos_products_2aos_products_idb',
    );

    $dictionary['TR_TechnicalRequests']['fields']['tr_technicalrequests_aos_products_2_name'] = array (
        'name' => 'tr_technicalrequests_aos_products_2_name',
        'type' => 'relate',
        'source' => 'non-db',
        'vname' => 'LBL_PRODUCT_NUMBER',
        'save' => true,
        'id_name' => 'tr_technicalrequests_aos_products_2aos_products_idb',
        'link' => 'tr_technicalrequests_aos_products_2',
        'table' => 'aos_products',
        'module' => 'AOS_Products',
        'rname' => 'name',
        'inline_edit' => '',
        'required' => true,
    );

    $dictionary['TR_TechnicalRequests']['fields']['tr_technicalrequests_aos_products_2aos_products_idb'] = array (
        'name' => 'tr_technicalrequests_aos_products_2aos_products_idb',
        'type' => 'link',
        'relationship' => 'tr_technicalrequests_aos_products_2',
        'source' => 'non-db',
        'reportable' => false,
        'side' => 'right',
        'vname' => 'LBL_PRODUCT_NUMBER',
    );

    // REGULATORY TAB CUSTOM PANELS

    // Product Information (Not Documentation)
    $dictionary['TR_TechnicalRequests']['fields']['product_information_panel_non_db']= array(
        'name' => 'product_information_panel_non_db',
        'vname' => 'LBL_PRODUCT_INFORMATION_PANEL_NON_DB',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );

    // Physical Material Properties 
    $dictionary['TR_TechnicalRequests']['fields']['physical_material_properties_panel_non_db']= array(
        'name' => 'physical_material_properties_panel_non_db',
        'vname' => 'LBL_PHYSICAL_MATERIAL_PROPERTIES_PANEL_NON_DB',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );
    
    // Customer Certifications
    $dictionary['TR_TechnicalRequests']['fields']['customer_certifications_panel_non_db']= array(
        'name' => 'customer_certifications_panel_non_db',
        'vname' => 'LBL_CUSTOMER_CERTIFICATIONS_PANEL_NON_DB',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );
?>