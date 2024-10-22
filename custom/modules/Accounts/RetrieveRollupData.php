<?php
    /**
     * The following function names below are the relationship names between account and their corresponding modules
     * This is done so that we no longer have to create custom "Create" and "Select" subpanel buttons
     * Exception would be for the "Remove" button which we have to control access if the actual record is under the account or rolled up from child accounts (If under account - Show, else - Hide)
     * Refer to file: SugarWidgetSubPanelRollupRemoveButton.php for Show/Hide remove button behavior
     */

    // Called via get_subpanel_data - function:tasks on _override_custom_rollup_data
    function tasks($params) {
        //Get the current bean
        $bean = $GLOBALS['app']->controller->bean;

        //Create the SQL array
        $return_array = array();
        $return_array['select']  = " SELECT tasks.id ";
        $return_array['from']    = " FROM tasks ";
        $return_array['join']    = " 
                                    INNER JOIN accounts
                                        ON accounts.id = tasks.parent_id
                                        AND accounts.deleted = 0
                                ";

        $where = ($bean->account_type !== 'CustomerParent') ? " WHERE accounts.id = '{$bean->id}' " : " WHERE (accounts.id = '{$bean->id}' OR accounts.parent_id = '{$bean->id}') ";
        $where .= ($params['subpanel_name'] == 'ForActivities') ? "AND (tasks.status != 'Completed' AND tasks.status != 'Deferred')" : "AND (tasks.status='Completed' OR tasks.status='Deferred')";

        $return_array['where']   = $where;

        return $return_array;
    }

    // Called via get_subpanel_data - function:meetings on _override_custom_rollup_data
    function meetings($params) {
        //Get the current bean
        $bean = $GLOBALS['app']->controller->bean;

        //Create the SQL array
        $return_array = array();
        $return_array['select']  = " SELECT meetings.id ";
        $return_array['from']    = " FROM meetings ";
        $return_array['join']    = " 
                                    INNER JOIN accounts
                                        ON accounts.id = meetings.parent_id
                                        AND accounts.deleted = 0
                                ";

        $where = ($bean->account_type !== 'CustomerParent') ? " WHERE accounts.id = '{$bean->id}' " : " WHERE (accounts.id = '{$bean->id}' OR accounts.parent_id = '{$bean->id}') ";
        $where .= ($params['subpanel_name'] == 'ForActivities') ? "AND (meetings.status !='Held' AND meetings.status !='Not Held')" : "AND (meetings.status='Held' OR meetings.status='Not Held')";

        $return_array['where']   = $where;

        return $return_array;
    }

    // Called via get_subpanel_data - function:calls on _override_custom_rollup_data
    function calls($params) {
        //Get the current bean
        $bean = $GLOBALS['app']->controller->bean;

        //Create the SQL array
        $return_array = array();
        $return_array['select']  = " SELECT calls.id ";
        $return_array['from']    = " FROM calls ";
        $return_array['join']    = " 
                                    INNER JOIN accounts
                                        ON accounts.id = calls.parent_id
                                        AND accounts.deleted = 0
                                ";

        $where = ($bean->account_type !== 'CustomerParent') ? " WHERE accounts.id = '{$bean->id}' " : " WHERE (accounts.id = '{$bean->id}' OR accounts.parent_id = '{$bean->id}') ";
        $where .= ($params['subpanel_name'] == 'ForActivities') ? "AND (calls.status != 'Held' AND calls.status != 'Not Held')" : "AND (calls.status='Held' OR calls.status='Not Held')";

        $return_array['where']   = $where;

        return $return_array;
    }

    // Called via get_subpanel_data - function:notes on _override_custom_rollup_data
    function notes() {
        //Get the current bean
        $bean = $GLOBALS['app']->controller->bean;

        //Create the SQL array
        $return_array = array();
        $return_array['select']  = " SELECT notes.id ";
        $return_array['from']    = " FROM notes ";
        $return_array['join']    = " 
                                    INNER JOIN accounts
                                        ON accounts.id = notes.parent_id
                                        AND accounts.deleted = 0
                                ";

        $where = ($bean->account_type !== 'CustomerParent') ? " WHERE accounts.id = '{$bean->id}' " : " WHERE (accounts.id = '{$bean->id}' OR accounts.parent_id = '{$bean->id}') ";

        $return_array['where']   = $where;

        return $return_array;
    }

    // Called via get_subpanel_data - function:contacts on custom_contacts_rollup.php
    function contacts() {
        //Get the current bean
        $bean = $GLOBALS['app']->controller->bean;

        //Create the SQL array
        $return_array = array();
        $return_array['select']  = " SELECT contacts.id ";
        $return_array['from']    = " FROM contacts ";
        $return_array['join']    = " 
                                    INNER JOIN accounts_contacts
                                        ON contacts.id = accounts_contacts.contact_id
                                        AND accounts_contacts.deleted = 0
                                    INNER JOIN accounts
                                        ON accounts.id = accounts_contacts.account_id
                                        AND accounts.deleted = 0
                                ";

        $where = ($bean->account_type !== 'CustomerParent') ? " WHERE accounts.id = '{$bean->id}' " : " WHERE accounts.id = '{$bean->id}' OR accounts.parent_id = '{$bean->id}' ";

        $return_array['where']   = $where;

        return $return_array;
    }

    // Called via get_subpanel_data - function:opportunities on custom_opportunities_rollup.php
    function opportunities() {
        //Get the current bean
        $bean = $GLOBALS['app']->controller->bean;

        //Create the SQL array
        $return_array = array();
        $return_array['select']  = " SELECT opportunities.id ";
        $return_array['from']    = " FROM opportunities ";
        $return_array['join']    = " 
                                    INNER JOIN accounts_opportunities
                                        ON opportunities.id = accounts_opportunities.opportunity_id
                                        AND accounts_opportunities.deleted = 0
                                    INNER JOIN accounts
                                        ON accounts.id = accounts_opportunities.account_id
                                        AND accounts.deleted = 0
                                ";

        $where = ($bean->account_type !== 'CustomerParent') ? " WHERE accounts.id = '{$bean->id}' " : " WHERE accounts.id = '{$bean->id}' OR accounts.parent_id = '{$bean->id}' ";

        $return_array['where']   = $where;

        return $return_array;
    }

    // Called via get_subpanel_data - function:accounts_comp_competition_1 on custom_competitors_rollup.php
    function accounts_comp_competition_1() {
        //Get the current bean
        $bean = $GLOBALS['app']->controller->bean;

        //Create the SQL array
        $return_array = array();
        $return_array['select']  = " SELECT comp_competition.id ";
        $return_array['from']    = " FROM comp_competition ";
        $return_array['join']    = " 
                                    INNER JOIN accounts_comp_competition_1_c
                                        ON comp_competition.id = accounts_comp_competition_1_c.accounts_comp_competition_1comp_competition_idb
                                        AND accounts_comp_competition_1_c.deleted = 0
                                    INNER JOIN accounts
                                        ON accounts.id = accounts_comp_competition_1_c.accounts_comp_competition_1accounts_ida
                                        AND accounts.deleted = 0
                                ";

        $where = ($bean->account_type !== 'CustomerParent') ? " WHERE accounts.id = '{$bean->id}' " : " WHERE accounts.id = '{$bean->id}' OR accounts.parent_id = '{$bean->id}' ";

        $return_array['where']   = $where;

        return $return_array;
    }

    // Called via get_subpanel_data - function:accounts_comp_competition_1 on custom_competitors_rollup.php
    function accounts_chl_challenges_1() {
        //Get the current bean
        $bean = $GLOBALS['app']->controller->bean;

        //Create the SQL array
        $return_array = array();
        $return_array['select']  = " SELECT chl_challenges.id ";
        $return_array['from']    = " FROM chl_challenges ";
        $return_array['join']    = " 
                                    INNER JOIN accounts_chl_challenges_1_c
                                        ON chl_challenges.id = accounts_chl_challenges_1_c.accounts_chl_challenges_1chl_challenges_idb
                                        AND accounts_chl_challenges_1_c.deleted = 0
                                    INNER JOIN accounts
                                        ON accounts.id = accounts_chl_challenges_1_c.accounts_chl_challenges_1accounts_ida
                                        AND accounts.deleted = 0
                                ";

        $where = ($bean->account_type !== 'CustomerParent') ? " WHERE accounts.id = '{$bean->id}' " : " WHERE accounts.id = '{$bean->id}' OR accounts.parent_id = '{$bean->id}' ";

        $return_array['where']   = $where;

        return $return_array;
    }

    // Called via get_subpanel_data - function:account_aos_invoices on _override_custom_rollup_data
    function account_aos_invoices() {
        //Get the current bean
        $bean = $GLOBALS['app']->controller->bean;

        //Create the SQL array
        $return_array = array();
        $return_array['select']  = " SELECT aos_invoices.id ";
        $return_array['from']    = " FROM aos_invoices ";
        $return_array['join']    = " 
                                    INNER JOIN accounts
                                        ON accounts.id = aos_invoices.billing_account_id
                                        AND accounts.deleted = 0
                                ";

        $where = ($bean->account_type !== 'CustomerParent') 
            ? " WHERE accounts.id = '{$bean->id}' " 
            : " WHERE (accounts.id = '{$bean->id}' OR accounts.parent_id = '{$bean->id}') ";

        $return_array['where']   = $where;

        return $return_array;
    }

    // Called via get_subpanel_data - function:accounts_odr_salesorders_1 on _override_custom_rollup_data
    function accounts_odr_salesorders_1() {
        //Get the current bean
        $bean = $GLOBALS['app']->controller->bean;

        //Create the SQL array
        $return_array = array();
        $return_array['select']  = " SELECT odr_salesorders.id ";
        $return_array['from']    = " FROM odr_salesorders ";
        $return_array['join']    = " 
                                    INNER JOIN accounts_odr_salesorders_1_c
                                        ON odr_salesorders.id = accounts_odr_salesorders_1_c.accounts_odr_salesorders_1odr_salesorders_idb
                                        AND accounts_odr_salesorders_1_c.deleted = 0
                                    INNER JOIN accounts
                                        ON accounts.id = accounts_odr_salesorders_1_c.accounts_odr_salesorders_1accounts_ida
                                        AND accounts.deleted = 0
                                ";

        $where = ($bean->account_type !== 'CustomerParent') ? " WHERE accounts.id = '{$bean->id}' " : " WHERE accounts.id = '{$bean->id}' OR accounts.parent_id = '{$bean->id}' ";

        $return_array['where']   = $where;

        return $return_array;
    }

    // Called via get_subpanel_data - function:ci_customeritems_accounts on _override_custom_rollup_data
    function ci_customeritems_accounts() {
        //Get the current bean
        $bean = $GLOBALS['app']->controller->bean;

        //Create the SQL array
        $return_array = array();
        $return_array['select']  = " SELECT ci_customeritems.id ";
        $return_array['from']    = " FROM ci_customeritems ";
        $return_array['join']    = " 
                                    INNER JOIN ci_customeritems_accounts_c
                                        ON ci_customeritems.id = ci_customeritems_accounts_c.ci_customeritems_accountsci_customeritems_idb
                                        AND ci_customeritems_accounts_c.deleted = 0
                                    INNER JOIN accounts
                                        ON accounts.id = ci_customeritems_accounts_c.ci_customeritems_accountsaccounts_ida
                                        AND accounts.deleted = 0
                                ";

        $where = ($bean->account_type !== 'CustomerParent') ? " WHERE accounts.id = '{$bean->id}' " : " WHERE accounts.id = '{$bean->id}' OR accounts.parent_id = '{$bean->id}' ";

        $return_array['where']   = $where;

        return $return_array;
    }

    // Called via get_subpanel_data - function:cases on _override_custom_rollup_data
    function cases() {
        //Get the current bean
        $bean = $GLOBALS['app']->controller->bean;

        //Create the SQL array
        $return_array = array();
        $return_array['select']  = " SELECT cases.id ";
        $return_array['from']    = " FROM cases ";
        $return_array['join']    = " 
                                    INNER JOIN accounts
                                        ON accounts.id = cases.account_id
                                        AND accounts.deleted = 0
                                ";

        $where = ($bean->account_type !== 'CustomerParent') ? " WHERE accounts.id = '{$bean->id}' " : " WHERE (accounts.id = '{$bean->id}' OR accounts.parent_id = '{$bean->id}') ";

        $return_array['where']   = $where;

        return $return_array;
    }
?>