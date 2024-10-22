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

// Opportunity is used to store customer information.
#[\AllowDynamicProperties]
class Opportunity extends SugarBean
{
    public $field_name_map;
    // Stored fields
    public $id;
    public $lead_source;
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $assigned_user_id;
    public $created_by;
    public $created_by_name;
    public $modified_by_name;
    public $description;
    public $name;
    public $opportunity_type;
    public $amount;
    public $amount_usdollar;
    public $currency_id;
    public $date_closed;
    public $next_step;
    public $sales_stage;
    public $probability;
    public $campaign_id;

    // These are related
    public $account_name;
    public $account_id;
    public $contact_id;
    public $task_id;
    public $note_id;
    public $meeting_id;
    public $call_id;
    public $email_id;
    public $email1 = '';
    public $assigned_user_name;

    public $table_name = "opportunities";
    public $rel_account_table = "accounts_opportunities";
    public $rel_contact_table = "opportunities_contacts";
    public $module_dir = "Opportunities";

    public $importable = true;
    public $object_name = "Opportunity";

    // This is used to retrieve related fields from form posts.
    public $additional_column_fields = array('assigned_user_name', 'assigned_user_id', 'account_name', 'account_id', 'contact_id', 'task_id', 'note_id', 'meeting_id', 'call_id', 'email_id'
    );

    public $relationship_fields = array('task_id'=>'tasks', 'note_id'=>'notes', 'account_id'=>'accounts',
                                    'meeting_id'=>'meetings', 'call_id'=>'calls', 'email_id'=>'emails', 'project_id'=>'project',
                                    // Bug 38529 & 40938
                                    'currency_id' => 'currencies',
                                    );

    public function __construct()
    {
        parent::__construct();
        global $sugar_config;
        if (!$sugar_config['require_accounts']) {
            unset($this->required_fields['account_name']);
        }
    }



    public $new_schema = true;



    public function get_summary_text()
    {
        return (string)$this->name;
    }

    public function create_list_query($order_by, $where, $show_deleted = 0)
    {
        $custom_join = $this->getCustomJoin();
        $query = "SELECT ";

        $query .= "
                            accounts.id as account_id,
                            accounts.name as account_name,
                            accounts.assigned_user_id account_id_owner,
                            users.user_name as assigned_user_name ";
        $query .= $custom_join['select'];
        $query .= " ,opportunities.*
                            FROM opportunities ";


        $query .= 			"LEFT JOIN users
                            ON opportunities.assigned_user_id=users.id ";
        $query .= "LEFT JOIN $this->rel_account_table
                            ON opportunities.id=$this->rel_account_table.opportunity_id
                            LEFT JOIN accounts
                            ON $this->rel_account_table.account_id=accounts.id ";
        $query .= $custom_join['join'];
        $where_auto = '1=1';
        if ($show_deleted == 0) {
            $where_auto = "
			($this->rel_account_table.deleted is null OR $this->rel_account_table.deleted=0)
			AND (accounts.deleted is null OR accounts.deleted=0)
			AND opportunities.deleted=0";
        } else {
            if ($show_deleted == 1) {
                $where_auto = " opportunities.deleted=1";
            }
        }

        if ($where != "") {
            $query .= "where ($where) AND ".$where_auto;
        } else {
            $query .= "where ".$where_auto;
        }

        if ($order_by != "") {
            $query .= " ORDER BY $order_by";
        } else {
            $query .= " ORDER BY opportunities.name";
        }

        return $query;
    }

    // APX Custom Codes: Modified function to match business requirements
    public function create_export_query($order_by, $where, $relate_link_join='')
    {
        $custom_join = $this->getCustomJoin(true, true, $where);
        $custom_join['join'] .= $relate_link_join;
        $query = "SELECT
                                opportunities.*,
								accounts.id as account_id,
                                accounts.name as account_name,
                                users.user_name as assigned_user_name ";
        $query .= $custom_join['select'];

        // APX Custom Codes -- START
        $query .= ", mkt_markets.id as mkt_markets_opportunities_1mkt_markets_ida, mkt_markets.name as mkt_markets_opportunities_1_name ";
        // APX Custom Codes -- END

        $query .= " FROM opportunities ";
        $query .= 				"LEFT JOIN users
                                ON opportunities.assigned_user_id=users.id";
        $query .= " LEFT JOIN $this->rel_account_table
                                ON opportunities.id=$this->rel_account_table.opportunity_id
                                LEFT JOIN accounts
                                ON $this->rel_account_table.account_id=accounts.id ";
        $query .= $custom_join['join'];

        // APX Custom Codes -- START
        $query .= " LEFT JOIN mkt_markets
			                    ON mkt_markets.id = opportunities_cstm.sub_industry_c ";
        // APX Custom Codes -- END

        $where_auto = "
			($this->rel_account_table.deleted is null OR $this->rel_account_table.deleted=0)
			AND (accounts.deleted is null OR accounts.deleted=0)
			AND opportunities.deleted=0";

        if ($where != "") {
            $query .= "where $where AND ".$where_auto;
        } else {
            $query .= "where ".$where_auto;
        }

        if ($order_by != "") {
            $query .= " ORDER BY opportunities.$order_by";
        } else {
            $query .= " ORDER BY opportunities.name";
        }
        return $query;
    }

    public function fill_in_additional_list_fields()
    {
        if ($this->force_load_details == true) {
            $this->fill_in_additional_detail_fields();
        }
    }

    public function fill_in_additional_detail_fields()
    {
        parent::fill_in_additional_detail_fields();

        if (!empty($this->currency_id)) {
            $currency = BeanFactory::newBean('Currencies');
            $currency->retrieve($this->currency_id);
            if ($currency->id != $this->currency_id || $currency->deleted == 1) {
                $this->amount = $this->amount_usdollar;
                $this->currency_id = $currency->id;
            }
        }
        //get campaign name
        if (!empty($this->campaign_id)) {
            $camp = BeanFactory::newBean('Campaigns');
            $camp->retrieve($this->campaign_id);
            $this->campaign_name = $camp->name;
        }
        $this->account_name = '';
        $this->account_id = '';
        if (!empty($this->id)) {
            $ret_values=(new Opportunity())->get_account_detail($this->id);
            if (!empty($ret_values)) {
                $this->account_name=$ret_values['name'];
                $this->account_id=$ret_values['id'];
                $this->account_id_owner =$ret_values['assigned_user_id'];
            }
        }
    }

    /** Returns a list of the associated contacts
     * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
     * All Rights Reserved..
     * Contributor(s): ______________________________________..
    */
    public function get_contacts()
    {
        $this->load_relationship('contacts');
        $query_array=$this->contacts->getQuery(true);

        if (is_string($query_array)) {
            LoggerManager::getLogger()->warn("Illegal string offset 'select' (\$query_array) value id: $query_array");
        } else {
            //update the select clause in the retruned query.
            $query_array['select']="SELECT contacts.id, contacts.first_name, contacts.last_name, contacts.title, contacts.email1, contacts.phone_work, opportunities_contacts.contact_role as opportunity_role, opportunities_contacts.id as opportunity_rel_id ";
        }

        $query='';
        foreach ((array)$query_array as $qstring) {
            $query.=' '.$qstring;
        }
        $temp = array('id', 'first_name', 'last_name', 'title', 'email1', 'phone_work', 'opportunity_role', 'opportunity_rel_id');
        $contact = BeanFactory::newBean('Contacts');
        return $this->build_related_list2($query, $contact, $temp);
    }



    public function update_currency_id($fromid, $toid)
    {
        $idequals = '';

        $currency = BeanFactory::newBean('Currencies');
        $currency->retrieve($toid);
        foreach ($fromid as $f) {
            if (!empty($idequals)) {
                $idequals .= ' or ';
            }
            $fQuoted = $this->db->quote($f);
            $idequals .= "currency_id='$fQuoted'";
        }

        if (!empty($idequals)) {
            $query = "select amount, id from opportunities where (" . $idequals . ") and deleted=0 and opportunities.sales_stage <> 'Closed Won' AND opportunities.sales_stage <> 'Closed Lost';";
            $result = $this->db->query($query);
            while ($row = $this->db->fetchByAssoc($result)) {
                $currencyIdQuoted = $this->db->quote($currency->id);
                $currencyConvertToDollarRowAmountQuoted = $this->db->quote($currency->convertToDollar($row['amount']));
                $rowIdQuoted = $this->db->quote($row['id']);
                $query = "update opportunities set currency_id='" . $currencyIdQuoted . "', amount_usdollar='" . $currencyConvertToDollarRowAmountQuoted . "' where id='" . $rowIdQuoted . "';";
                $this->db->query($query);
            }
        }
    }

    public function get_list_view_data()
    {
        global $locale, $current_language, $current_user, $mod_strings, $app_list_strings, $sugar_config;
        $app_strings = return_application_language($current_language);
        $params = array();

        $temp_array = $this->get_list_view_array();
        $temp_array['SALES_STAGE'] = empty($temp_array['SALES_STAGE']) ? '' : $temp_array['SALES_STAGE'];
        $temp_array["ENCODED_NAME"]=$this->name;
        return $temp_array;
    }

    public function get_currency_symbol()
    {
        if (isset($this->currency_id)) {
            $cur_qry = "select * from currencies where id ='".$this->currency_id."'";
            $cur_res = $this->db->query($cur_qry);
            if (!empty($cur_res)) {
                $cur_row = $this->db->fetchByAssoc($cur_res);
                if (isset($cur_row['symbol'])) {
                    return $cur_row['symbol'];
                }
            }
        }
        return '';
    }


    /**
    	builds a generic search based on the query string using or
    	do not include any $this-> because this is called on without having the class instantiated
    */
    public function build_generic_where_clause($the_query_string)
    {
        $where_clauses = array();
        $the_query_string = DBManagerFactory::getInstance()->quote($the_query_string);
        array_push($where_clauses, "opportunities.name like '$the_query_string%'");
        array_push($where_clauses, "accounts.name like '$the_query_string%'");

        $the_where = "";
        foreach ($where_clauses as $clause) {
            if ($the_where != "") {
                $the_where .= " or ";
            }
            $the_where .= $clause;
        }


        return $the_where;
    }

    public function save($check_notify = false)
    {
        // Bug 32581 - Make sure the currency_id is set to something
        global $current_user, $app_list_strings;

        if (empty($this->currency_id)) {
            $this->currency_id = $current_user->getPreference('currency');
        }
        if (empty($this->currency_id)) {
            $this->currency_id = -99;
        }

        //if probablity isn't set, set it based on the sales stage
        if (!isset($this->probability) && !empty($this->sales_stage)) {
            $prob_arr = $app_list_strings['sales_probability_dom'];
            if (isset($prob_arr[$this->sales_stage])) {
                $this->probability = $prob_arr[$this->sales_stage];
            }
        }

        require_once('modules/Opportunities/SaveOverload.php');

        perform_save($this);
        return parent::save($check_notify);
    }

    public function save_relationship_changes($is_update, $exclude = array())
    {
        //if account_id was replaced unlink the previous account_id.
        //this rel_fields_before_value is populated by sugarbean during the retrieve call.
        if (!empty($this->account_id) && !empty($this->rel_fields_before_value['account_id']) && trim($this->account_id) !== trim($this->rel_fields_before_value['account_id'])) {
            //unlink the old record.
            $this->load_relationship('accounts');
            $this->accounts->delete($this->id, $this->rel_fields_before_value['account_id']);
        }
        // Bug 38529 & 40938 - exclude currency_id
        parent::save_relationship_changes($is_update, array('currency_id'));

        if (!empty($this->contact_id)) {
            $this->set_opportunity_contact_relationship($this->contact_id);
        }
    }

    public function set_opportunity_contact_relationship($contact_id)
    {
        global $app_list_strings;
        $default = $app_list_strings['opportunity_relationship_type_default_key'];
        $this->load_relationship('contacts');
        $this->contacts->add($contact_id, array('contact_role'=>$default));
    }

    public function set_notification_body($xtpl, $oppty)
    {
        global $app_list_strings;

        $xtpl->assign("OPPORTUNITY_NAME", $oppty->name);
        $xtpl->assign("OPPORTUNITY_AMOUNT", $oppty->amount);
        $xtpl->assign("OPPORTUNITY_CLOSEDATE", $oppty->date_closed);
        $xtpl->assign("OPPORTUNITY_STAGE", (isset($oppty->sales_stage)?$app_list_strings['sales_stage_dom'][$oppty->sales_stage]:""));
        $xtpl->assign("OPPORTUNITY_DESCRIPTION", nl2br($oppty->description));

        return $xtpl;
    }

    public function bean_implements($interface)
    {
        switch ($interface) {
            case 'ACL':return true;
        }
        return false;
    }
    public function listviewACLHelper()
    {
        $array_assign = parent::listviewACLHelper();
        $is_owner = false;
        $in_group = false; //SECURITY GROUPS
        if (!empty($this->account_id)) {
            if (!empty($this->account_id_owner)) {
                global $current_user;
                $is_owner = $current_user->id == $this->account_id_owner;
            }
            /* BEGIN - SECURITY GROUPS */
            else {
                global $current_user;
                $parent_bean = BeanFactory::getBean('Accounts', $this->account_id);
                if ($parent_bean !== false) {
                    $is_owner = $current_user->id == $parent_bean->assigned_user_id;
                }
            }
            require_once("modules/SecurityGroups/SecurityGroup.php");
            $in_group = SecurityGroup::groupHasAccess('Accounts', $this->account_id, 'view');
            /* END - SECURITY GROUPS */
        }
        /* BEGIN - SECURITY GROUPS */
        /**
        if(!ACLController::moduleSupportsACL('Accounts') || ACLController::checkAccess('Accounts', 'view', $is_owner)){
        */
        if (!ACLController::moduleSupportsACL('Accounts') || ACLController::checkAccess('Accounts', 'view', $is_owner, 'module', $in_group)) {
            /* END - SECURITY GROUPS */
            $array_assign['ACCOUNT'] = 'a';
        } else {
            $array_assign['ACCOUNT'] = 'span';
        }

        return $array_assign;
    }

    /**
     * Static helper function for getting releated account info.
     */
    public function get_account_detail($opp_id)
    {
        $ret_array = array();
        $db = DBManagerFactory::getInstance();
        $query = "SELECT acc.id, acc.name, acc.assigned_user_id "
            . "FROM accounts acc, accounts_opportunities a_o "
            . "WHERE acc.id=a_o.account_id"
            . " AND a_o.opportunity_id='$opp_id'"
            . " AND a_o.deleted=0"
            . " AND acc.deleted=0";
        $result = $db->query($query, true, "Error filling in opportunity account details: ");
        $row = $db->fetchByAssoc($result);
        if ($row != null) {
            $ret_array['name'] = $row['name'];
            $ret_array['id'] = $row['id'];
            $ret_array['assigned_user_id'] = $row['assigned_user_id'];
        }
        return $ret_array;
    }

    // APX Custom Codes: Modified function to match business requirements
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
	)
	{
		
		global $current_user, $app_list_strings, $log;
		
		if (isset($_REQUEST['module']) && $_REQUEST['module'] == 'Home') {
			$ret_array = parent::create_new_list_query($order_by, $where, $filter, $params, $show_deleted, $join_type, true, $parentbean, $singleSelect, $ifListForExport);
			$ret_array = str_replace('opportunities.contact_id_c', 'opportunities_cstm.contact_id_c', $ret_array);
			$returnCustomRetArray = false;

			if ($_REQUEST['customRequestDashletName'] == 'MyTeamsTopOpportunitiesDashlet') {
				$ret_array['select'] = str_replace('opportunities.id', 'DISTINCT(opportunities.id)', $ret_array['select']);
			
				$ret_array['from'] = "{$ret_array['from']}
															LEFT JOIN securitygroups_records
																	ON securitygroups_records.record_id = opportunities.id
																	AND securitygroups_records.module = 'Opportunities'
																	AND securitygroups_records.deleted = 0
															LEFT JOIN securitygroups
																	ON securitygroups.id = securitygroups_records.securitygroup_id
																	AND securitygroups.deleted = 0
															LEFT JOIN securitygroups_cstm
																	ON securitygroups.id = securitygroups_cstm.id_c
															LEFT JOIN securitygroups_users
																ON securitygroups.id = securitygroups_users.securitygroup_id
																	AND securitygroups_users.deleted = 0";

				if (! $current_user->is_admin) {
					$ret_array['where'] = "{$ret_array['where']}
																AND securitygroups_cstm.type_c = 'Sales Group'
																AND securitygroups_users.user_id = '{$current_user->id}'";
				}

				$returnCustomRetArray = true;
			}

			if ($_REQUEST['customRequestDashletName'] == 'OpportunityUpdatesDashlet') {
				$ret_array['select'] = str_replace('opportunities.next_step', 'REPLACE(SUBSTRING_INDEX(opportunities.next_step,\'</div>\',1), \'<div>\', \'\') AS next_step', $ret_array['select']);
				$ret_array['where'] .= " AND opportunities.next_step != '' AND opportunities.next_step IS NOT NULL";
				$returnCustomRetArray = true;
			}

			if (in_array($_REQUEST['customRequestDashletName'], ['MyOpportunitiesDashlet', 'MyTeamsTopOpportunitiesDashlet'])) {
				$ret_array = str_replace('open_sales_stages_non_db', 'sales_stage', $ret_array);
				
				if (strpos($ret_array['where'], 'opportunities.sales_stage IN') === false) {
					$openSalesStageWhereIn = handleArrayToWhereInFormatAll($app_list_strings['open_sales_stage_dom']);
					$ret_array['where'] .= " AND opportunities.sales_stage IN ({$openSalesStageWhereIn}) ";
				}

				$returnCustomRetArray = true;
			}
		}
		
		$result = parent::create_new_list_query($order_by, $where, $filter, $params, $show_deleted, $join_type, $return_array, $parentbean, $singleSelect);
		$result = str_replace('opportunities.contact_id_c', 'opportunities_cstm.contact_id_c', $result);

		if ((isset($result) && is_array($result))) {
			$result['select'] = "{$result['select']} , opportunities_cstm.oppid_c AS opp_id_non_db ";
		}

		if (!empty($_REQUEST['sub_industry_c_advanced'])) {
			$customWhere = $this->customIndustryWhereClause();
			
			$subIndustryImplodeStr = implode("','", $_REQUEST['sub_industry_c_advanced']);
			$result['where']  = ($customWhere != '') ? str_replace("opportunities_cstm.sub_industry_c in ('{$subIndustryImplodeStr}')", $customWhere, $result['where']) : $result['where'];	

			if (!empty($_REQUEST['industry_c_advanced'])) {
				$implodeIndustry = implode("','", $_REQUEST['industry_c_advanced']);
				$result['where']  = str_replace("(opportunities_cstm.industry_c in ('{$implodeIndustry}') ) AND", "(opportunities_cstm.industry_c in ('{$implodeIndustry}') ) OR", $result['where']);	
			}

		}

		// OnTrack 1565: Return Opportunities by way of Product # from it's Child TR(s) that is associated to Product Master -- Glai Obido
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'UnifiedSearch') {
            if (is_array($result)) {
                $result['from'] .= "
                    LEFT JOIN
                        tr_technicalrequests_opportunities_c tto ON tto.tr_technicalrequests_opportunitiesopportunities_ida = opportunities.id
                    LEFT JOIN
                        tr_technicalrequests ON tr_technicalrequests.id = tto.tr_technicalrequests_opportunitiestr_technicalrequests_idb
                            AND tto.deleted = 0
                    LEFT JOIN
                        tr_technicalrequests_aos_products_2_c ON tr_technicalrequests.id = tr_technicalrequests_aos_products_2_c.tr_technicalrequests_aos_products_2tr_technicalrequests_ida
                            AND tr_technicalrequests_aos_products_2_c.deleted = 0
                    LEFT JOIN
                        aos_products ON aos_products.id = tr_technicalrequests_aos_products_2_c.tr_technicalrequests_aos_products_2aos_products_idb
                            AND aos_products.deleted = 0
                    LEFT JOIN
                        aos_products_cstm ON aos_products.id = aos_products_cstm.id_c
                ";
                
                $result['where'] .= "
                    OR aos_products_cstm.product_number_c = '{$_REQUEST['query_string']}'
                    OR aos_products.name LIKE '{$_REQUEST['query_string']}%'
                ";
            }
		}
		
		// Used to store WHERE query to be used in Export to Excel feature (OppExpCSVEntryPoint.php)
		if ((isset($_REQUEST['action']) && $_REQUEST['action'] == 'index') && isset($_REQUEST['query']) && $_REQUEST['query']) {
			$_SESSION['OpportunityQueryWhere'] = str_replace('where', '', $result['where']);
			$_SESSION['OpportunityQueryOrderBy'] = str_replace('ORDER BY', '', $result['order_by']);
		}

		return (isset($returnCustomRetArray) && $returnCustomRetArray) ? $ret_array : $result;
	}

	protected function customIndustryWhereClause()
	{
		global $log;
		
		$implodeSubIndustry = implode("','", $_REQUEST['sub_industry_c_advanced']);
		$implodeIndustry = implode("','", $_REQUEST['industry_c_advanced']);
		
		$filterSubIndustryString = !empty( $_REQUEST['sub_industry_c_advanced']) && $implodeSubIndustry != '' ? "AND mkt_markets_cstm.sub_industry_c IN ('{$implodeSubIndustry}') " : '';
		

		$filterSubIndustryString .=  !empty( $_REQUEST['industry_c_advanced']) && $implodeIndustry != '' ? " OR mkt_markets.name IN ('{$implodeIndustry}')" : "";
		
		$whereStr = "";
		$industryBean = BeanFactory::getBean('MKT_Markets');
		$industryBeanList =  $industryBean->get_full_list(
            'name',
            "mkt_markets.id IS NOT NULL $filterSubIndustryString"
            );
		
		if (!empty($industryBeanList)) {
			$implodeSubIndustry = implode("','", array_column($industryBeanList, 'id'));
			$whereStr .= " opportunities_cstm.sub_industry_c IN ('{$implodeSubIndustry}')";
		}

		return $whereStr;
	}
}
function getCurrencyType()
{
}
