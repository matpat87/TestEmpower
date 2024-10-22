<?php
    // Activities - Tasks
    $layout_defs["Accounts"]["subpanel_setup"]["activities"]['collection_list']['tasks']["get_subpanel_data"] = 'function:tasks';
    $layout_defs["Accounts"]["subpanel_setup"]["activities"]['collection_list']['tasks']["override_subpanel_name"] = 'ForAccountActivities';
	$layout_defs["Accounts"]["subpanel_setup"]["activities"]['collection_list']['tasks']["generate_select"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["activities"]['collection_list']['tasks']["get_distinct_data"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["activities"]['collection_list']['tasks']["function_parameters"] = array(
        'import_function_file' => 'custom/modules/Accounts/RetrieveRollupData.php',
        'return_as_array' => true,
        'link' => 'tasks',
        'subpanel_name' => 'ForActivities',
    );

    // Activities - Meetings
    $layout_defs["Accounts"]["subpanel_setup"]["activities"]['collection_list']['meetings']["get_subpanel_data"] = 'function:meetings';
    $layout_defs["Accounts"]["subpanel_setup"]["activities"]['collection_list']['meetings']["override_subpanel_name"] = 'ForAccountActivities';
	$layout_defs["Accounts"]["subpanel_setup"]["activities"]['collection_list']['meetings']["generate_select"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["activities"]['collection_list']['meetings']["get_distinct_data"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["activities"]['collection_list']['meetings']["function_parameters"] = array(
        'import_function_file' => 'custom/modules/Accounts/RetrieveRollupData.php',
        'return_as_array' => true,
        'link' => 'meetings',
        'subpanel_name' => 'ForActivities',
    );

    // Activities - Calls
    $layout_defs["Accounts"]["subpanel_setup"]["activities"]['collection_list']['calls']["get_subpanel_data"] = 'function:calls';
    $layout_defs["Accounts"]["subpanel_setup"]["activities"]['collection_list']['calls']["override_subpanel_name"] = 'ForAccountActivities';
	$layout_defs["Accounts"]["subpanel_setup"]["activities"]['collection_list']['calls']["generate_select"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["activities"]['collection_list']['calls']["get_distinct_data"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["activities"]['collection_list']['calls']["function_parameters"] = array(
        'import_function_file' => 'custom/modules/Accounts/RetrieveRollupData.php',
        'return_as_array' => true,
        'link' => 'calls',
        'subpanel_name' => 'ForActivities',
    );

    // History - Tasks
    $layout_defs["Accounts"]["subpanel_setup"]["history"]['collection_list']['tasks']["get_subpanel_data"] = 'function:tasks';
    $layout_defs["Accounts"]["subpanel_setup"]["history"]['collection_list']['tasks']["override_subpanel_name"] = 'ForAccountHistory';
	$layout_defs["Accounts"]["subpanel_setup"]["history"]['collection_list']['tasks']["generate_select"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["history"]['collection_list']['tasks']["get_distinct_data"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["history"]['collection_list']['tasks']["function_parameters"] = array(
        'import_function_file' => 'custom/modules/Accounts/RetrieveRollupData.php',
        'return_as_array' => true,
        'link' => 'tasks',
        'subpanel_name' => 'ForHistory',
    );

    // History - Meetings
    $layout_defs["Accounts"]["subpanel_setup"]["history"]['collection_list']['meetings']["get_subpanel_data"] = 'function:meetings';
    $layout_defs["Accounts"]["subpanel_setup"]["history"]['collection_list']['meetings']["override_subpanel_name"] = 'ForAccountHistory';
	$layout_defs["Accounts"]["subpanel_setup"]["history"]['collection_list']['meetings']["generate_select"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["history"]['collection_list']['meetings']["get_distinct_data"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["history"]['collection_list']['meetings']["function_parameters"] = array(
        'import_function_file' => 'custom/modules/Accounts/RetrieveRollupData.php',
        'return_as_array' => true,
        'link' => 'meetings',
        'subpanel_name' => 'ForHistory',
    );

    // History - Calls
    $layout_defs["Accounts"]["subpanel_setup"]["history"]['collection_list']['calls']["get_subpanel_data"] = 'function:calls';
    $layout_defs["Accounts"]["subpanel_setup"]["history"]['collection_list']['calls']["override_subpanel_name"] = 'ForAccountHistory';
	$layout_defs["Accounts"]["subpanel_setup"]["history"]['collection_list']['calls']["generate_select"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["history"]['collection_list']['calls']["get_distinct_data"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["history"]['collection_list']['calls']["function_parameters"] = array(
        'import_function_file' => 'custom/modules/Accounts/RetrieveRollupData.php',
        'return_as_array' => true,
        'link' => 'calls',
        'subpanel_name' => 'ForHistory',
    );

    // History - Notes
    $layout_defs["Accounts"]["subpanel_setup"]["history"]['collection_list']['notes']["get_subpanel_data"] = 'function:notes';
    $layout_defs["Accounts"]["subpanel_setup"]["history"]['collection_list']['notes']["override_subpanel_name"] = 'ForAccountHistory';
	$layout_defs["Accounts"]["subpanel_setup"]["history"]['collection_list']['notes']["generate_select"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["history"]['collection_list']['notes']["get_distinct_data"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["history"]['collection_list']['notes']["function_parameters"] = array(
        'import_function_file' => 'custom/modules/Accounts/RetrieveRollupData.php',
        'return_as_array' => true,
        'link' => 'notes',
        'subpanel_name' => 'ForHistory',
    );

    // Contacts
    $layout_defs["Accounts"]["subpanel_setup"]["contacts"]["get_subpanel_data"] = 'function:contacts';
	$layout_defs["Accounts"]["subpanel_setup"]["contacts"]["generate_select"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["contacts"]["get_distinct_data"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["contacts"]["function_parameters"] = array(
        'import_function_file' => 'custom/modules/Accounts/RetrieveRollupData.php',
        'return_as_array' => true,
        'link' => 'contacts'
    );

    // Opportunities
    $layout_defs["Accounts"]["subpanel_setup"]["opportunities"]["get_subpanel_data"] = 'function:opportunities';
	$layout_defs["Accounts"]["subpanel_setup"]["opportunities"]["generate_select"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["opportunities"]["get_distinct_data"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["opportunities"]["function_parameters"] = array(
        'import_function_file' => 'custom/modules/Accounts/RetrieveRollupData.php',
        'return_as_array' => true,
        'link' => 'opportunities'
    );
    
    // Competitors
    $layout_defs["Accounts"]["subpanel_setup"]["accounts_comp_competition_1"]["get_subpanel_data"] = 'function:accounts_comp_competition_1';
	$layout_defs["Accounts"]["subpanel_setup"]["accounts_comp_competition_1"]["generate_select"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["accounts_comp_competition_1"]["get_distinct_data"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["accounts_comp_competition_1"]["function_parameters"] = array(
        'import_function_file' => 'custom/modules/Accounts/RetrieveRollupData.php',
        'return_as_array' => true,
        'link' => 'accounts_comp_competition_1'
    );

    //Challenges
    $layout_defs["Accounts"]["subpanel_setup"]["accounts_chl_challenges_1"]["get_subpanel_data"] = 'function:accounts_chl_challenges_1';
    $layout_defs["Accounts"]["subpanel_setup"]["accounts_chl_challenges_1"]["generate_select"] = true;
    $layout_defs["Accounts"]["subpanel_setup"]["accounts_chl_challenges_1"]["get_distinct_data"] = true;
    $layout_defs["Accounts"]["subpanel_setup"]["accounts_chl_challenges_1"]["function_parameters"] = array(
        'import_function_file' => 'custom/modules/Accounts/RetrieveRollupData.php',
        'return_as_array' => true,
        'link' => 'accounts_chl_challenges_1'
    );

    // Invoices
    $layout_defs["Accounts"]["subpanel_setup"]["account_aos_invoices"]["get_subpanel_data"] = 'function:account_aos_invoices';
	$layout_defs["Accounts"]["subpanel_setup"]["account_aos_invoices"]["generate_select"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["account_aos_invoices"]["get_distinct_data"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["account_aos_invoices"]["function_parameters"] = array(
        'import_function_file' => 'custom/modules/Accounts/RetrieveRollupData.php',
        'return_as_array' => true,
        'link' => 'account_aos_invoices'
    );

    // Orders
    $layout_defs["Accounts"]["subpanel_setup"]["accounts_odr_salesorders_1"]["get_subpanel_data"] = 'function:accounts_odr_salesorders_1';
	$layout_defs["Accounts"]["subpanel_setup"]["accounts_odr_salesorders_1"]["generate_select"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["accounts_odr_salesorders_1"]["get_distinct_data"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["accounts_odr_salesorders_1"]["function_parameters"] = array(
        'import_function_file' => 'custom/modules/Accounts/RetrieveRollupData.php',
        'return_as_array' => true,
        'link' => 'accounts_odr_salesorders_1'
    );
    
    // Customer Products
    $layout_defs["Accounts"]["subpanel_setup"]["ci_customeritems_accounts"]["get_subpanel_data"] = 'function:ci_customeritems_accounts';
	$layout_defs["Accounts"]["subpanel_setup"]["ci_customeritems_accounts"]["generate_select"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["ci_customeritems_accounts"]["get_distinct_data"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["ci_customeritems_accounts"]["function_parameters"] = array(
        'import_function_file' => 'custom/modules/Accounts/RetrieveRollupData.php',
        'return_as_array' => true,
        'link' => 'ci_customeritems_accounts'
    );

    // Cases (Customer Issues)
    $layout_defs["Accounts"]["subpanel_setup"]["cases"]["get_subpanel_data"] = 'function:cases';
	$layout_defs["Accounts"]["subpanel_setup"]["cases"]["generate_select"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["cases"]["get_distinct_data"] = true;
	$layout_defs["Accounts"]["subpanel_setup"]["cases"]["function_parameters"] = array(
        'import_function_file' => 'custom/modules/Accounts/RetrieveRollupData.php',
        'return_as_array' => true,
        'link' => 'cases'
    );
?>