<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

/**

 * Description:  Defines the Account SugarBean Account entity with the necessary
 * methods and variables.
 */

require_once("include/SugarObjects/templates/company/Company.php");
require_once __DIR__ . '/../../include/EmailInterface.php';

// Account is used to store account information.
#[\AllowDynamicProperties]
class Account extends Company implements EmailInterface
{
    public $field_name_map = array();
    // Stored fields
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $assigned_user_id;
    public $annual_revenue;
    public $billing_address_street;
    public $billing_address_city;
    public $billing_address_state;
    public $billing_address_country;
    public $billing_address_postalcode;

    public $billing_address_street_2;
    public $billing_address_street_3;
    public $billing_address_street_4;

    public $description;
    public $email1;
    public $email2;
    public $email_opt_out;
    public $invalid_email;
    public $employees;
    public $id;
    public $industry;
    public $name;
    public $ownership;
    public $parent_id;
    public $phone_alternate;
    public $phone_fax;
    public $phone_office;
    public $rating;
    public $shipping_address_street;
    public $shipping_address_city;
    public $shipping_address_state;
    public $shipping_address_country;
    public $shipping_address_postalcode;

    public $shipping_address_street_2;
    public $shipping_address_street_3;
    public $shipping_address_street_4;

    public $campaign_id;

    public $sic_code;
    public $ticker_symbol;
    public $account_type;
    public $website;
    public $custom_fields;

    public $created_by;
    public $created_by_name;
    public $modified_by_name;

    // These are for related fields
    public $opportunity_id;
    public $case_id;
    public $contact_id;
    public $task_id;
    public $note_id;
    public $meeting_id;
    public $call_id;
    public $email_id;
    public $member_id;
    public $parent_name;
    public $assigned_user_name;
    public $account_id = '';
    public $account_name = '';
    public $bug_id ='';
    public $module_dir = 'Accounts';
    public $emailAddress;


    public $table_name = "accounts";
    public $object_name = "Account";
    public $importable = true;
    public $new_schema = true;
    // This is used to retrieve related fields from form posts.
    public $additional_column_fields = array('assigned_user_name', 'assigned_user_id', 'opportunity_id', 'bug_id', 'case_id', 'contact_id', 'task_id', 'note_id', 'meeting_id', 'call_id', 'email_id', 'parent_name', 'member_id'
    );
    public $relationship_fields = array('opportunity_id'=>'opportunities', 'bug_id' => 'bugs', 'case_id'=>'cases',
                                    'contact_id'=>'contacts', 'task_id'=>'tasks', 'note_id'=>'notes',
                                    'meeting_id'=>'meetings', 'call_id'=>'calls', 'email_id'=>'emails','member_id'=>'members',
                                    'project_id'=>'project',
                                    );

    //Meta-Data Framework fields
    public $push_billing;
    public $push_shipping;

    public function __construct()
    {
        parent::__construct();

        $this->setupCustomFields('Accounts');

        foreach ($this->field_defs as $field) {
            if (isset($field['name'])) {
                $this->field_name_map[$field['name']] = $field;
            }
        }


        //Email logic
        if (!empty($_REQUEST['parent_id']) && !empty($_REQUEST['parent_type']) && $_REQUEST['parent_type'] == 'Emails'
            && !empty($_REQUEST['return_module']) && $_REQUEST['return_module'] == 'Emails') {
            $_REQUEST['parent_name'] = '';
            $_REQUEST['parent_id'] = '';
        }
    }

    public function get_summary_text()
    {
        return $this->name;
    }

    public function get_contacts()
    {
        return $this->get_linked_beans('contacts', 'Contact');
    }



    public function clear_account_case_relationship($account_id = '', $case_id = '')
    {
        $where = '';

        $accountIdQuoted = $this->db->quoted($account_id);

        if (!empty($case_id)) {
            $caseIdQuoted = $this->db->quoted($case_id);
            $where = " and id = " . $caseIdQuoted;
        }

        $query = "UPDATE cases SET account_name = '', account_id = '' WHERE account_id = " . $accountIdQuoted . " AND deleted = 0 " . $where;

        $this->db->query($query, true, "Error clearing account to case relationship: ");
    }

    /**
    * This method is used to provide backward compatibility with old data that was prefixed with http://
    * We now automatically prefix http://
    * @deprecated.
    */
    public function remove_redundant_http()
    {	/*
        if(preg_match("@http://@", $this->website))
        {
            $this->website = substr($this->website, 7);
        }
        */
    }

    public function fill_in_additional_list_fields()
    {
        parent::fill_in_additional_list_fields();
        // Fill in the assigned_user_name
    //	$this->assigned_user_name = get_assigned_user_name($this->assigned_user_id);
    }

    public function fill_in_additional_detail_fields()
    {
        parent::fill_in_additional_detail_fields();

        //rrs bug: 28184 - instead of removing this code altogether just adding this check to ensure that if the parent_name
        //is empty then go ahead and fill it.
        if (empty($this->parent_name) && !empty($this->id)) {

            $idQuoted = $this->db->quoted($this->id);

            $query = "SELECT a1.name FROM accounts a1, accounts a2 WHERE a1.id = a2.parent_id AND a2.id = " . $idQuoted . " and a1.deleted=0";
            $result = $this->db->query($query, true, " Error filling in additional detail fields: ");

            // Get the id and the name.
            $row = $this->db->fetchByAssoc($result);

            if ($row != null) {
                $this->parent_name = $row['name'];
            } else {
                $this->parent_name = '';
            }
        }

        // Set campaign name if there is a campaign id
        if (!empty($this->campaign_id)) {
            $camp = BeanFactory::newBean('Campaigns');

            $campaignIdQuoted = $this->db->quoted($this->campaign_id);

            $where = "campaigns.id = " . $campaignIdQuoted;
            $campaign_list = $camp->get_full_list("campaigns.name", $where, true);
            $this->campaign_name = $campaign_list[0]->name;
        }
    }

    public function get_list_view_data()
    {
        $temp_array = parent::get_list_view_data();

        $temp_array["ENCODED_NAME"] = $this->name;

        if (!empty($this->billing_address_state)) {
            $temp_array["CITY"] = $this->billing_address_city . ', '. $this->billing_address_state;
        } else {
            $temp_array["CITY"] = $this->billing_address_city;
        }
        $temp_array["BILLING_ADDRESS_STREET"]  = $this->billing_address_street;
        $temp_array["SHIPPING_ADDRESS_STREET"] = $this->shipping_address_street;

        return $temp_array;
    }
    /**
    	builds a generic search based on the query string using or
    	do not include any $this-> because this is called on without having the class instantiated
    */
    public function build_generic_where_clause($the_query_string)
    {
        $where_clauses = array();
        $the_query_string = $this->db->quote($the_query_string);
        array_push($where_clauses, "accounts.name like '$the_query_string%'");
        if (is_numeric($the_query_string)) {
            array_push($where_clauses, "accounts.phone_alternate like '%$the_query_string%'");
            array_push($where_clauses, "accounts.phone_fax like '%$the_query_string%'");
            array_push($where_clauses, "accounts.phone_office like '%$the_query_string%'");
        }

        $the_where = "";
        foreach ($where_clauses as $clause) {
            if (!empty($the_where)) {
                $the_where .= " or ";
            }
            $the_where .= $clause;
        }

        return $the_where;
    }


    public function create_export_query($order_by, $where, $relate_link_join='')
    {
        $relatedJoins = [];
        $relatedSelects = [];
        foreach (explode('AND', $where) as $whereClause) {
            $newWhereClause = str_replace('( ', '(', $whereClause);
            foreach ($this->field_defs as $field_def) {
                $needle = '(' . $field_def['name'] . ' LIKE';
                if (strpos($newWhereClause, $needle) !== false) {
                    $joinAlias = 'rjt' . count($relatedJoins);
                    
                    // APX Custom Codes: Fixed core issue where on export it returns a Query Error due incorrect relate field generated queries -- START
                    if ($field_def['table'] == 'users') {
                        // $relatedSelects[] = " , {$joinAlias}.id ,CONCAT({$joinAlias}.first_name, ' ', {$joinAlias}.last_name) ";
                        $explodedFieldDefIdName = explode('users_ida', $field_def['id_name']);
                        $relatedTableName = $explodedFieldDefIdName ? "{$explodedFieldDefIdName[0]}_c" : 'accounts';
                        $relatedJoins[] = " 
                            LEFT JOIN {$explodedFieldDefIdName[0]}_c on accounts.id = {$explodedFieldDefIdName[0]}_c.{$explodedFieldDefIdName[0]}accounts_idb
                            LEFT JOIN {$field_def['table']} as {$joinAlias} on {$joinAlias}.id = {$relatedTableName}.{$field_def['id_name']} 
                        ";
                    } else {
                        $relatedSelects[] = ' ,' . $joinAlias . '.id ,' . $joinAlias . '.' . $field_def['rname'] . ' ';
                        $relatedJoins[] = ' LEFT JOIN ' . $field_def['table'] . ' as ' . $joinAlias . ' ON ' . $joinAlias . '.id ' . ' = accounts.' . $field_def['id_name'] . ' ';
                    }
                    // APX Custom Codes: Fixed core issue where on export it returns a Query Error due incorrect relate field generated queries -- END

                    $newWhereClause = str_replace(
                        $field_def['name'],
                        $joinAlias . '.' . $field_def['rname'],
                        $newWhereClause
                    );

                    // APX Custom Codes: Fixed core issue where on export it returns a Query Error due incorrect relate field generated queries -- START
                    if ($field_def['table'] == 'users') {
                        $newWhereClause = str_replace(
                            $joinAlias . '.' . $field_def['rname'],
                            "CONCAT({$joinAlias}.first_name, ' ', {$joinAlias}.last_name)",
                            $newWhereClause
                        );
                    }
                    // APX Custom Codes: Fixed core issue where on export it returns a Query Error due incorrect relate field generated queries -- END

                    $where = str_replace($whereClause, $newWhereClause, (string) $where);
                }
            }

            // APX Custom Codes: Ontrack #1810 - Replace with subquery that returns full user name to fix unknown column issue and filter by way of joined relate field tables -- START
            if (strpos($newWhereClause, "users_accounts_1_name") !== false) {
                $where = str_replace("users_accounts_1_name", "(SELECT CONCAT(users.first_name, ' ', users.last_name) FROM users WHERE users.id = users_accounts_1_c.users_accounts_1users_ida AND users.deleted = 0)", $where);
            }

            if (strpos($newWhereClause, "users_accounts_2_name") !== false) {
                $where = str_replace("users_accounts_2_name", "(SELECT CONCAT(users.first_name, ' ', users.last_name) FROM users WHERE users.id = users_accounts_2_c.users_accounts_2users_ida AND users.deleted = 0)", $where);
            }

            if (strpos($newWhereClause, "users_accounts_3_name") !== false) {
                $where = str_replace("users_accounts_3_name", "(SELECT CONCAT(users.first_name, ' ', users.last_name) FROM users WHERE users.id = users_accounts_3_c.users_accounts_3users_ida AND users.deleted = 0)", $where);
            }
            // APX Custom Codes: Ontrack #1810 - Replace with subquery that returns full user name to fix unknown column issue and filter by way of joined relate field tables -- END

            // APX Custom Codes: Ontrack #1054 - Remove country and state on where clause when no value is selected -- START
            if (strpos($newWhereClause, "accounts.shipping_address_country IS NULL OR accounts.shipping_address_country = ''") !== false) {
                $where = str_replace("((accounts.shipping_address_country IS NULL OR accounts.shipping_address_country = '') ) AND", "", $where);
                $where = str_replace("( (accounts.shipping_address_country IS NULL OR accounts.shipping_address_country = '') ) AND", "", $where);
                
            }
            
            if (strpos($newWhereClause, "accounts.shipping_address_state IS NULL OR accounts.shipping_address_state = ''") !== false) {
                $where = str_replace("( (accounts.shipping_address_state IS NULL OR accounts.shipping_address_state = '') ) AND", "", $where);
                $where = str_replace("(accounts.shipping_address_state IS NULL OR accounts.shipping_address_state = '')", "(accounts.id IS NOT NULL)", $where);
                
            }
            // APX Custom Codes: Ontrack #1054 - Remove country and state on where clause when no value is selected -- END
        }

        $custom_join = $this->getCustomJoin(true, true, $where);
        $custom_join['join'] .= $relate_link_join;
        $query = "SELECT
                    accounts.*,
                    email_addresses.email_address email_address,
                    '' email_addresses_non_primary, " . // email_addresses_non_primary needed for get_field_order_mapping()
                    "accounts.name as account_name,
                    users.user_name as assigned_user_name ";

        // APX Custom Codes: Add markets id and name for custom export -- START
        $query .= ", mkt_markets.id as mkt_markets_accounts_1mkt_markets_ida, mkt_markets.name as mkt_markets_accounts_1_name ";
        // APX Custom Codes: Add markets id and name for custom export -- END

        // APX Custom Codes: Ontrack #1810 - Include SAM/MDM/CS Relate Field on export -- START
        $query .= ", users_accounts_1_c.users_accounts_1users_ida, (SELECT CONCAT(users.first_name, ' ', users.last_name) FROM users WHERE users.id = users_accounts_1_c.users_accounts_1users_ida AND users.deleted = 0) AS users_accounts_1_name";
        $query .= ", users_accounts_2_c.users_accounts_2users_ida, (SELECT CONCAT(users.first_name, ' ', users.last_name) FROM users WHERE users.id = users_accounts_2_c.users_accounts_2users_ida AND users.deleted = 0) AS users_accounts_2_name";
        $query .= ", users_accounts_3_c.users_accounts_3users_ida,  (SELECT CONCAT(users.first_name, ' ', users.last_name) FROM users WHERE users.id = users_accounts_3_c.users_accounts_3users_ida AND users.deleted = 0) AS users_accounts_3_name";
        // APX Custom Codes: Ontrack #1810 - Include SAM/MDM/CS Relate Field on export -- END

        $query .= $custom_join['select'];

        $query .= implode('', $relatedSelects);

        $query .= " FROM accounts ";
        $query .= "LEFT JOIN users
	                ON accounts.assigned_user_id = users.id ";

        // APX Custom Codes: Join markets table for custom export -- START
        $query .= " LEFT JOIN mkt_markets_accounts_1_c
                        ON accounts.id = mkt_markets_accounts_1accounts_idb
                    LEFT JOIN mkt_markets
                        ON mkt_markets_accounts_1mkt_markets_ida = mkt_markets.id ";
        // APX Custom Codes: Join markets table for custom export -- END

        // APX Custom Codes: Ontrack #1810 - Join SAM/MDM/CS Relate Field tables to resolve DB Failure issue on export -- START
        $query .= " LEFT JOIN users_accounts_1_c
                        ON accounts.id = users_accounts_1_c.users_accounts_1accounts_idb
                        AND users_accounts_1_c.deleted = 0
                    LEFT JOIN users_accounts_2_c
                        ON accounts.id = users_accounts_2_c.users_accounts_2accounts_idb
                        AND users_accounts_2_c.deleted = 0
                    LEFT JOIN users_accounts_3_c
                        ON accounts.id = users_accounts_3_c.users_accounts_3accounts_idb
                        AND users_accounts_3_c.deleted = 0 ";
        // APX Custom Codes: Ontrack #1810 - Join SAM/MDM/CS Relate Field tables to resolve DB Failure issue on export -- END

        //join email address table too.
        $query .=  ' LEFT JOIN email_addr_bean_rel ON accounts.id = email_addr_bean_rel.bean_id
                     AND email_addr_bean_rel.bean_module=\'Accounts\'
                     AND email_addr_bean_rel.deleted = 0
                     AND email_addr_bean_rel.primary_address = 1 ';
        $query .=  ' LEFT JOIN email_addresses on email_addresses.id = email_addr_bean_rel.email_address_id ' ;

        $query .= implode('', $relatedJoins);

        $query .= $custom_join['join'];

        $where_auto = "( accounts.deleted IS NULL OR accounts.deleted=0 )";

        if ($where != "") {
            $query .= "where ($where) AND ".$where_auto;
        } else {
            $query .= "where ".$where_auto;
        }

        $order_by = $this->process_order_by($order_by);
        if (!empty($order_by)) {
            $query .= ' ORDER BY ' . $order_by;
        }

        return $query;
    }

    public function set_notification_body($xtpl, $account)
    {
        $xtpl->assign("ACCOUNT_NAME", $account->name);
        $xtpl->assign("ACCOUNT_TYPE", $account->account_type);
        $xtpl->assign("ACCOUNT_DESCRIPTION", nl2br($account->description));

        return $xtpl;
    }

    public function bean_implements($interface)
    {
        switch ($interface) {
            case 'ACL':return true;
        }
        return false;
    }
    public function get_unlinked_email_query($type=array())
    {
        return get_unlinked_email_query($type, $this);
    }

    /**
     * Create a query string for select Products/Services Purchased list from database.
     * @return string final query
     */
    public function getProductsServicesPurchasedQuery()
    {
        $idQuoted = $this->db->quoted($this->id);

        $query = "
			SELECT
				aos_products_quotes.*
			FROM
				aos_products_quotes
			JOIN aos_quotes ON aos_quotes.id = aos_products_quotes.parent_id AND aos_quotes.stage LIKE 'Closed Accepted' AND aos_quotes.deleted = 0 AND aos_products_quotes.deleted = 0
			JOIN accounts ON accounts.id = aos_quotes.billing_account_id AND accounts.id = $idQuoted

			";
        return $query;
    }

    // APX Custom Codes -- START
    public function retrieveCustomerItems()
    {
		$query = "SELECT ci_customeritems.*, ci_customeritems_cstm.*,
							CASE
								WHEN (
									ci_customeritems_accountsaccounts_ida = '".$this->id."'
								) THEN 'Account'
								WHEN (
									(ci_customeritems_accountsaccounts_ida IS NULL OR ci_customeritems_accountsaccounts_ida != '".$this->id."') 
								) THEN 'OEM Account'
								WHEN (
									ci_customeritems_accountsaccounts_ida = '".$this->id."'
								) THEN 'Account & OEM Account'
							ELSE 
								NULL
							END 'account_relate_type'
							FROM ci_customeritems
							LEFT JOIN ci_customeritems_cstm
								ON ci_customeritems.id = ci_customeritems_cstm.id_c
							LEFT JOIN ci_customeritems_accounts_c 
								ON ci_customeritems.id = ci_customeritems_accounts_c.ci_customeritems_accountsci_customeritems_idb
								AND ci_customeritems_accounts_c.deleted = 0
							WHERE ci_customeritems_accountsaccounts_ida = '".$this->id."'
								AND ci_customeritems.deleted = 0
								AND ci_customeritems_accounts_c.deleted = 0";
		return $query;
	}
    // APX Custom Codes -- END

    // APX Custom Codes -- START
	public function create_new_list_query(
		$order_by,
		$where,
		$filter = array(),
		$params = array(),
		$show_deleted = 0,
		$join_type = '',
		$return_array = false,
		$parentbean = null,
		$singleSelect = false,
		$ifListForExport = false
	) {
		global $current_user, $log;
		$result = array();

		if ((isset($_REQUEST['searchFormTab']) && $_REQUEST['searchFormTab'] == 'advanced_search') || (isset($_REQUEST['massupdate']) && $_REQUEST['massupdate'] == true)) {
			if ($_REQUEST['shipping_address_country_advanced'][0] == '' || $_REQUEST['shipping_address_country'] == '') {
				$where = str_replace("accounts.shipping_address_country IS NULL OR accounts.shipping_address_country = ''", "accounts.shipping_address_country IS NULL OR accounts.shipping_address_country = '' OR accounts.shipping_address_country IS NOT NULL", $where);
			}
			if ($_REQUEST['shipping_address_state_advanced'][0] == '' || $_REQUEST['shipping_address_state'] == '') {
				$where = str_replace("accounts.shipping_address_state IS NULL OR accounts.shipping_address_state = ''", "accounts.shipping_address_state IS NULL OR accounts.shipping_address_state = '' OR accounts.shipping_address_state IS NOT NULL", $where);
			}
		}

		if ((isset($_REQUEST['action']) && $_REQUEST['action'] != 'quicksearchQuery') && $where != "" && (strpos($where, "accounts.name") > 0)) {
			// $where = str_replace("accounts.name like '", "accounts.name like '%", $where); // removed so the default name search can be used: "<keyword>%" #1125
			$where = str_replace("((LTRIM(RTRIM(CONCAT(IFNULL(accounts.name,'')))) LIKE '", "((LTRIM(RTRIM(CONCAT(IFNULL(accounts.name,'')))) LIKE '%", $where);
		}

        //OnTrack #1242 - Multiple Company Type
        $where = $this->set_multiple_company_type($where);

		//Update query for Quick Search Query
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'quicksearchQuery' && $where != "")
		{
			if(strpos($where, "accounts.oem_c") > 0)
				$where = str_replace("accounts.oem_c", "accounts_cstm.oem_c", $where);

			if(strpos($where, "accounts.status_c") > 0)
				$where = str_replace("accounts.status_c", "accounts_cstm.status_c", $where);
		}

		// Account Dashlet Custom Query
		if ((isset($_REQUEST['module']) && $_REQUEST['module'] == 'Home') && $_REQUEST['customRequestDashletName'] == 'MyAccounts') {
			$ret_array = parent::create_new_list_query($order_by, $where, $filter, $params, $show_deleted, $join_type, true, $parentbean, $singleSelect, $ifListForExport);
			$ret_array['select'] = str_replace('accounts.id', 'DISTINCT(accounts.id)', $ret_array['select']);
			return $ret_array;
		}

		$result = parent::create_new_list_query($order_by, $where, $filter, $params, $show_deleted, $join_type,
			$return_array, $parentbean, $singleSelect);

		if(isset($_GET['from_module']) && $_GET['from_module'] == 'AOS_Products' && isset($_GET['parent_tr_id']))
		{
			$parent_tr_id = $_GET['parent_tr_id'];
			$result['where'] .= " and accounts.id in (select oc.account_id_c
			from tr_technicalrequests_opportunities_c as t_o
			inner join opportunities_cstm oc
				on oc.id_c = t_o.tr_technicalrequests_opportunitiesopportunities_ida
			where t_o.deleted = 0
				and t_o.tr_technicalrequests_opportunitiestr_technicalrequests_idb = '$parent_tr_id') ";
		}
		
		if (isset($_REQUEST['disable_security_groups_filter']) && $_REQUEST['disable_security_groups_filter']) {
			// Popup returns an SQL array instead of string
			if ($_REQUEST['action'] == 'Popup') {
				// On Popup Search Initial Load
				if (isset($_REQUEST['oem_c_advanced'])) {
					$result['where'] = str_replace(
						"accounts_cstm.oem_c like 'Yes%'", 
						"accounts_cstm.status_c LIKE 'Active%' AND (accounts.account_type IN ('OEMBrandOwner') OR (accounts.account_type IN ('CustomerParent') AND accounts_cstm.oem_c LIKE 'Yes%'))",
						$result['where']
					);
				}

				// On Popup Search Submit
				if (strpos($_REQUEST['request_data'], 'oem_account_c') !== false) {
					$result['where'] .= " AND accounts_cstm.status_c LIKE 'Active%' AND (accounts.account_type IN ('OEMBrandOwner') OR (accounts.account_type IN ('CustomerParent') AND accounts_cstm.oem_c LIKE 'Yes%'))";
				}
			}
			
			// Autocomplete returns an SQL string instead of array
			if ($_REQUEST['action'] == 'quicksearchQuery') {
				// Custom autocomplete query conditions for oem_account_c
				if (strpos($_REQUEST['data'], 'oem_account_c') !== false) {
					$result = str_replace(
						"AND accounts.deleted=0",
						"AND accounts_cstm.status_c LIKE 'Active%' AND (accounts.account_type IN ('OEMBrandOwner') OR (accounts.account_type IN ('CustomerParent') AND accounts_cstm.oem_c LIKE 'Yes%')) AND accounts.deleted=0",
						$result
					);
				}
            }
        }
        
        // APX Custom Codes: OnTrack #1755 -- START
        // Filter Popup and Autocomplete Results to show only Active Parent Accounts filtered by way of Security Groups based on Regular Account's Parent Accounts
        if ($_REQUEST['action'] == 'Popup' && (isset($_REQUEST['filter_regulatory_request_accounts_data']) || (strpos($_REQUEST['request_data'], 'accounts_rrq_regulatoryrequests_1_name') !== false)) || 
            $_REQUEST['action'] == 'quicksearchQuery' && (strpos($_REQUEST['data'], 'accounts_rrq_regulatoryrequests_1_name') !== false)
        ) {
            if (! $current_user->is_admin) {
                $_REQUEST['disable_security_groups_filter'] = true;
            }
            
            $result = parent::create_new_list_query($order_by, $where, $filter, $params, $show_deleted, $join_type, $return_array, $parentbean, $singleSelect);
            $result = $this->handleRegulatoryRequestAccountsPopUpAndAutoComplete($result);
        }
        // APX Custom Codes: OnTrack #1755 -- END

		// Display account name as <NAME> (<SHIPPING_ADDRESS_STREET>) in Popup to fix the issue where on click, it only shows the Account Name on the Account Relate field
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'Popup') {

			$result['select'] = str_replace("accounts.name", "IF(accounts.shipping_address_street IS NULL OR accounts.shipping_address_street = '', accounts.name, CONCAT(accounts.name, ' ', '(', accounts.shipping_address_street, ')' )) AS name", $result['select']);

			//OnTrack #1475 - filter Customer Parent
			$from_module = (isset($_GET['from_module']) && !empty($_GET['from_module'])) ? $_GET['from_module'] : '';
			$account_type_param = (isset($_REQUEST['account_type_param']) && !empty($_REQUEST['account_type_param'])) ? $_REQUEST['account_type_param'] : '';

			if (isset($_SESSION['popup_account_type']) && $_SESSION['popup_account_type'] == 'CustomerParent') {
                $result['where'] .= " AND accounts.account_type = 'CustomerParent' ";
			}
		}

		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'UnifiedSearch') {
			// Ontrack #1565: Include filter for Accounts that have children Customer Products with Item #/Product # of <query_string>
			$result = $this->globalSearchCustomFilter($result);

		}

        // APX Custom Codes: OnTrack #1883 -- START
        // Filter distinct accounts.id in select as it causes duplicate results issue when fields like Customer Service is added where it needs to join with bridge tables resulting to repeating account id's in result
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'index') {
            $result['select'] = str_replace('accounts.id', 'DISTINCT(accounts.id)', $result['select']);
        }
        // APX Custom Codes: OnTrack #1883 -- END

		return $result;
	}
    // APX Custom Codes -- END

    // APX Custom Codes -- START
	// Ontrack #1565: Include filter for Accounts that have children Customer Products with Item #/Product # of <query_string> -GLAI OBIDO
	private function globalSearchCustomFilter($queryArray)
	{
        if (is_array($queryArray)) {
            $queryArray['from'] .= " 
                LEFT JOIN
                ci_customeritems_accounts_c ON accounts.id = ci_customeritems_accounts_c.ci_customeritems_accountsaccounts_ida
                    AND ci_customeritems_accounts_c.deleted = 0
                    LEFT JOIN
                ci_customeritems ON ci_customeritems.id = ci_customeritems_accounts_c.ci_customeritems_accountsci_customeritems_idb
                    AND ci_customeritems.deleted = 0
                    LEFT JOIN
                ci_customeritems_cstm ON ci_customeritems_cstm.id_c = ci_customeritems.id
            ";

            $queryArray['where'] .= "
                OR (ci_customeritems_cstm.product_number_c = '{$_REQUEST['query_string']}'
                OR ci_customeritems.name LIKE'{$_REQUEST['query_string']}%')
            ";

            $queryArray['order_by'] = " GROUP BY accounts.id {$queryArray['order_by']}";
        }
		

		return $queryArray;
	}
    // APX Custom Codes -- END

    // APX Custom Codes -- START
    //OnTrack #1242 - Multiple Company Type
    private function set_multiple_company_type($where){
        $result = $where; //OnTrack #1388 - fix Account Filter

        $manufact_index = strpos($where, 'accounts_cstm.manufacturing_type_c');
        $where_str = substr($where, $manufact_index);
        $manufact_close_index = strpos($where_str, ')') + 1;
        $manufact_str = substr($where, $manufact_index, $manufact_close_index);

        if($manufact_index > 0){
            $manufact_str_start_index = strpos($manufact_str, '(') + 1;
            $manufact_str_last_index = strpos($manufact_str, ')');
            $manufact_values = substr($manufact_str, $manufact_str_start_index, $manufact_str_last_index - $manufact_str_start_index);

            $manufact_values_arr = explode(',', $manufact_values);

            $where_manufact = '';
            foreach($manufact_values_arr as $manufact){
                $manufact = str_replace("'", '', $manufact);
                $where_manufact .= " accounts_cstm.manufacturing_type_c like '%^{$manufact}^%' OR ";
            }

            $where_manufact = substr($where_manufact, 0, strlen($where_manufact) - 3);
            $where_manufact = ' ( ' . $where_manufact . ' ) ';
            $result = str_replace($manufact_str, $where_manufact, $where);
        }

        return $result;
    }
    // APX Custom Codes -- END


    // APX Custom Codes: OnTrack #1755 -- START
    // Filter Popup and Autocomplete Results to show only Active Parent Accounts filtered by way of Security Groups based on Regular Account's Parent Accounts
    private function handleRegulatoryRequestAccountsPopUpAndAutoComplete($result)
    {
        global $log, $current_user;

        $filterBySecurityGroupAccessQuery = '';

        if (! $current_user->is_admin) {
            $filterBySecurityGroupAccessQuery = "AND accounts.id IN (
                SELECT accounts.id FROM accounts 
                INNER JOIN securitygroups_records secr 
                    ON secr.record_id = accounts.id
                    AND secr.module = 'Accounts'
                    AND secr.deleted = 0
                INNER JOIN securitygroups secg 
                    ON secg.id = secr.securitygroup_id
                    AND secg.deleted = 0
                INNER JOIN securitygroups_users secu 
                    ON secg.id = secu.securitygroup_id
                    AND secu.deleted = 0
                    AND secu.user_id = '{$current_user->id}'
                WHERE accounts.deleted = 0 
                    AND accounts.account_type = 'CustomerParent'
                    AND accounts_cstm.status_c LIKE 'Active%'
                UNION ALL
                SELECT accounts.parent_id FROM accounts 
                INNER JOIN securitygroups_records secr 
                    ON secr.record_id = accounts.id
                    AND secr.module = 'Accounts'
                    AND secr.deleted = 0
                INNER JOIN securitygroups secg 
                    ON secg.id = secr.securitygroup_id
                    AND secg.deleted = 0
                INNER JOIN securitygroups_users secu 
                    ON secg.id = secu.securitygroup_id
                    AND secu.deleted = 0
                    AND secu.user_id = '{$current_user->id}'
                WHERE accounts.deleted = 0 
                    AND accounts.account_type <> 'CustomerParent'
                    AND accounts_cstm.status_c LIKE 'Active%'
            )";
        }

        $filterByParentAccountsQuery = " {$filterBySecurityGroupAccessQuery}
            AND accounts.account_type = 'CustomerParent'
            AND accounts_cstm.status_c LIKE 'Active%' ";

        if (! is_array($result)) {
            $result = str_replace(
            "ORDER BY", 
            "{$filterByParentAccountsQuery} ORDER BY",
            $result);
        } else {
            $result['where'] .= $filterByParentAccountsQuery;
        }

        return $result;
    }
    // APX Custom Codes: OnTrack #1755 -- END
}