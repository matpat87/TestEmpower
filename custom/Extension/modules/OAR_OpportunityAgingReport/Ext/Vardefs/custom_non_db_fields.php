<?php
    // Filters -- START

    $dictionary['OAR_OpportunityAgingReport']['fields']['custom_account_non_db']= array(
        'name' => 'custom_account_non_db',
        'vname' => 'LBL_ACCOUNT',
        'type' => 'enum',
        'source' => 'non-db',
        'options' => '',
        'function' => 'getAccountsForReports'
    );

    $dictionary['OAR_OpportunityAgingReport']['fields']['custom_assigned_to_non_db']= array(
        'name' => 'custom_assigned_to_non_db',
        'vname' => 'LBL_ASSIGNED_USER',
        'type' => 'enum',
        'source' => 'non-db',
        'options' => '',
        'function' => 'getUserRepresentativesForReports'
    );

    $dictionary['OAR_OpportunityAgingReport']['fields']['custom_division_non_db']= array(
        'name' => 'custom_division_non_db',
        'vname' => 'LBL_DIVISION',
        'type' => 'enum',
        'source' => 'non-db',
        'options' => '',
        'function' => 'getDivisionsForReports'
    );
    
    $dictionary['OAR_OpportunityAgingReport']['fields']['custom_sales_group_non_db']= array(
        'name' => 'custom_sales_group_non_db',
        'vname' => 'LBL_SALES_GROUP',
        'type' => 'enum',
        'source' => 'non-db',
        'options' => '',
        'function' => 'getSalesGroupForReports'
    );

    $dictionary['OAR_OpportunityAgingReport']['fields']['custom_sales_stage_non_db']= array(
        'name' => 'custom_sales_stage_non_db',
        'vname' => 'LBL_SALES_STAGE',
        'type' => 'enum',
        'source' => 'non-db',
        'options' => '',
        'function' => 'getOpenSalesStagesForReports'
    );

    $dictionary['OAR_OpportunityAgingReport']['fields']['custom_type_non_db']= array(
        'name' => 'custom_type_non_db',
        'vname' => 'LBL_TYPE',
        'type' => 'enum',
        'source' => 'non-db',
        'options' => 'opportunity_type_dom',
    );

    // Filters -- END

    // Columns -- START

    $dictionary['OAR_OpportunityAgingReport']['fields']['sales_rep']= array(
        'name' => 'sales_rep',
        'vname' => 'LBL_SALES_REP',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );

    $dictionary['OAR_OpportunityAgingReport']['fields']['opportunity_id']= array(
        'name' => 'opportunity_id',
        'vname' => 'LBL_OPPORTUNITY_ID',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );

    $dictionary['OAR_OpportunityAgingReport']['fields']['opportunity_id_number']= array(
        'name' => 'opportunity_id_number',
        'vname' => 'LBL_OPPORTUNITY_ID_NUMBER',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );

    $dictionary['OAR_OpportunityAgingReport']['fields']['opportunity_link']= array(
        'name' => 'opportunity_link',
        'vname' => 'LBL_OPPORTUNITY_LINK',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );
    
    $dictionary['OAR_OpportunityAgingReport']['fields']['opportunity_name']= array(
        'name' => 'opportunity_name',
        'vname' => 'LBL_OPPORTUNITY_NAME',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );

    $dictionary['OAR_OpportunityAgingReport']['fields']['account_name']= array(
        'name' => 'account_name',
        'vname' => 'LBL_ACCOUNT_NAME',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );

    $dictionary['OAR_OpportunityAgingReport']['fields']['opportunity_type']= array(
        'name' => 'opportunity_type',
        'vname' => 'LBL_OPPORTUNITY_TYPE',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );

    $dictionary['OAR_OpportunityAgingReport']['fields']['opportunity_value']= array(
        'name' => 'opportunity_value',
        'vname' => 'LBL_OPPORTUNITY_VALUE',
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );

    // Columns -- END

    // Dynamic Sales Stage Non-DB Columns -- START

    $ctr = 1;

    foreach ($GLOBALS['app_list_strings']['sales_stage_dom'] as $key => $value) {
        if (! in_array($key, ['Closed', 'ClosedWon', 'ClosedLost', 'ClosedRejected'])) {
            $dictionary['OAR_OpportunityAgingReport']['fields']["sales_stage_{$ctr}"]= array(
                'name' => "sales_stage_{$ctr}",
                'vname' => "LBL_SALES_STAGE_{$ctr}",
                'type' => 'varchar',
                'len' => '255',
                'source' => 'non-db',
            );

            $ctr++;
        }
    }

    $dictionary['OAR_OpportunityAgingReport']['fields']["sales_stage_total"]= array(
        'name' => "sales_stage_total",
        'vname' => "LBL_SALES_STAGE_TOTAL",
        'type' => 'varchar',
        'len' => '255',
        'source' => 'non-db',
    );
    
    // Dynamic Sales Stage Non-DB Columns -- END
?>