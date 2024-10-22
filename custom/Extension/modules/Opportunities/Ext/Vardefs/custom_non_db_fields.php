<?php
    // Workflow Section
    $dictionary['Opportunity']['fields']['workflow_section_non_db']= array(
        'name' => 'workflow_section_non_db',
        'vname' => 'LBL_WORKFLOW_SECTION_NON_DB',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );

    // Overview Section
    $dictionary['Opportunity']['fields']['overview_section_non_db']= array(
        'name' => 'overview_section_non_db',
        'vname' => 'LBL_OVERVIEW_SECTION_NON_DB',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );

    $dictionary['Opportunity']['fields']['opp_id_non_db']= array(
        'name' => 'opp_id_non_db',
        'vname' => 'LBL_OPPID',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );

    $dictionary['Opportunity']['fields']['marketing_information_non_db']= array(
        'name' => 'marketing_information_non_db',
        'vname' => 'LBL_MARKETING_INFORMATION_NON_DB',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );

    $dictionary['Opportunity']['fields']['open_sales_stages_non_db']= array(
        'name' => 'open_sales_stages_non_db',
        'vname' => 'LBL_SALES_STAGE',
        'type' => 'enum',
        'source' => 'non-db',
        'options' => 'open_sales_stage_dom',
    );
?>