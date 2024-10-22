<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
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
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

require_once('include/SugarObjects/templates/issue/Issue.php');

class TR_TechnicalRequests extends Issue
{
    public $new_schema = true;
    public $module_dir = 'TR_TechnicalRequests';
    public $object_name = 'TR_TechnicalRequests';
    public $table_name = 'tr_technicalrequests';
    public $importable = false;

    public $id;
    public $name;
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $modified_by_name;
    public $created_by;
    public $created_by_name;
    public $description;
    public $deleted;
    public $created_by_link;
    public $modified_user_link;
    public $assigned_user_id;
    public $assigned_user_name;
    public $assigned_user_link;
    public $SecurityGroups;
    public $tr_technicalrequests_number;
    public $type;
    public $status;
    public $priority;
    public $resolution;
    public $work_log;
    public $approval_stage;
    public $competitive_sample_submitted;
    public $curing_process;
    public $current_supplier;
    public $cust_disp_equip;
    public $cust_end_product;
    public $customer_specs;
    public $customers_specs_submit;
    public $division;
    public $finished_product_submitted;
    public $lab_results;
    public $lab_work_required;
    public $mix_equipment;
    public $prodmgt_rejection_comments;
    public $rejection_reason;
    public $req_sample_size;
    public $required_selling_price;
    public $salesregion;
    public $site;
    public $stat_and_reg_req;
    public $technical_request_update;
    public $updates;
	
    public function bean_implements($interface)
    {
        switch($interface)
        {
            case 'ACL':
                return true;
        }

        return false;
    }
    
    function create_list_count_query($query)
    {
        $count_query = "select count(*) as c from (" . $query . ") as list_count";

        return $count_query;
    }

    function create_new_list_query(
		$order_by, $where, $filter = array(), $params = array(),
		$show_deleted = 0, $join_type = '', $return_array = false, $parentbean = null,
        $singleSelect = false, $ifListForExport = false)
    {
		global $log;

		$result = parent::create_new_list_query($order_by, $where, $filter, $params, 
			$show_deleted, $join_type, $return_array, $parentbean, 
            $singleSelect, $ifListForExport);

        $is_export = isset($_REQUEST['entryPoint']) && $_REQUEST['entryPoint'] == 'export' ? true : false;
        $is_export_to_excel = (isset($_REQUEST['entryPoint']) && $_REQUEST['entryPoint'] == 'TR_TechnicalRequestsExportXLSRegistry');
        
        if(is_array($result) && !$is_export_to_excel && !$is_export && isset($_REQUEST['module']) && $_REQUEST['module'] == 'TR_TechnicalRequests'
            && isset($_REQUEST['action']) && ($_REQUEST['action'] == 'index' || $_REQUEST['action'] == 'Popup')) {
            $result['select'] .= ' , jt1_c.oppid_c as custom_opportunity_id, aos_products_cstm.product_number_c as product_master_non_db, aos_products.id as product_master_id_non_db ';
            $result['from'] .= ' LEFT JOIN opportunities_cstm jt1_c ON jt1_c.id_c = jt1.id ';

            $result['where'] = str_replace('custom_opportunity_id', 'oppid_c', $result['where']);
            $result['order_by'] = str_replace('custom_opportunity_id', 'oppid_c', $result['order_by']);

            $result['from'] .= ' 
                LEFT JOIN tr_technicalrequests_aos_products_2_c ON tr_technicalrequests.id = tr_technicalrequests_aos_products_2_c.tr_technicalrequests_aos_products_2tr_technicalrequests_ida AND tr_technicalrequests_aos_products_2_c.deleted = 0 

                LEFT JOIN aos_products ON aos_products.id = tr_technicalrequests_aos_products_2_c.tr_technicalrequests_aos_products_2aos_products_idb AND aos_products.deleted = 0
                LEFT JOIN aos_products_cstm ON aos_products.id = aos_products_cstm.id_c
            ';
            $result['order_by'] = str_replace('product_master_non_db', 'aos_products_cstm.product_number_c', $result['order_by']);
        }
        
        //#Colormatch #314 - if from Dashlet - TR_TechnicalRequestsUpdateDashlet
        if(isset($_SESSION['dashlet']) && $_SESSION['dashlet'] == 'TR_TechnicalRequestsUpdateDashlet')
        {
            unset($_SESSION['dashlet']);
            $result['where'] .= " AND tr_technicalrequests.technical_request_update <> ''";
        }

        // Global Search Customizations  -- OnTrack #1235 Glai Obido
		if ((isset($_REQUEST['module']) && $_REQUEST['module'] == 'Home') && $_REQUEST['action'] == 'UnifiedSearch') {
			$queryString = $_REQUEST['query_string'];
			$result['where'] = str_replace("tr_technicalrequests.resin_compound_type_c_nondb", "tr_technicalrequests_cstm.resin_compound_type_c", $result['where']);
			// FOR THE color value search (GLOBAL SEARCH)
			$baseResinList = $this->strtolowerDropdownValues('resin_type_list');
			
			
			$baseResinKeys = $this->searchEnumArrayByValue($queryString, $baseResinList);
            
			if (count($baseResinKeys) > 0) {

				$implodeKeys = implode(",", $baseResinKeys);
				// if query string (color) is in the list of colors in $app_list_strings['pi_color_list'], replace the query string in WHERE Clause to the KEY of the color value
				$result['where'] = str_replace("tr_technicalrequests_cstm.resin_compound_type_c like '{$_REQUEST['query_string']}%'", "tr_technicalrequests_cstm.resin_compound_type_c IN ({$implodeKeys})", $result['where']);
				$result['where'] = str_replace("LTRIM(RTRIM(CONCAT(IFNULL(tr_technicalrequests_cstm.resin_compound_type_c,'')))) LIKE '{$_REQUEST['query_string']}%'", "tr_technicalrequests_cstm.resin_compound_type_c IN ({$implodeKeys})", $result['where']);
		
			}

            // OnTrack 1565: Include Product # and Product Name associated with Product Master - Glai Obido
            if (is_array($result)) {
                $result['from'] .= "
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
                    OR aos_products_cstm.product_number_c = '{$queryString}'
                    OR aos_products.name LIKE '{$queryString}%'
                ";
            }
		}

        if(!empty($_REQUEST['module']) && $_REQUEST['module'] == 'TR_TechnicalRequests'
            && !empty($_REQUEST['entryPoint']) && $_REQUEST['entryPoint'] == 'export' /*|| $is_export_to_excel)*/){
            //OnTrack #1399 - Include Opportunity (related Opportunity ID) in Export
            $opp_alias = $this->get_opp_alias($result);
            $result = str_replace('FROM', ", opportunities_cstm.oppid_c as opportunity_id_c FROM ", $result);
            $result = str_replace("where", " LEFT JOIN opportunities_cstm ON opportunities_cstm.id_c = {$opp_alias}.tr_technicalrequests_opportunitiesopportunities_ida where ", $result);
        }

        //OnTrack #1451 - need to include Prod Master
        if($is_export_to_excel){
            $result = str_replace('FROM', ", opp.name tr_technicalrequests_opportunities_name, acc.name tr_technicalrequests_accounts_name, opportunities_cstm.oppid_c as custom_opportunity_id, aos_products_cstm.product_number_c as product_master_non_db FROM ", $result);
            $result = str_replace("where", " LEFT JOIN tr_technicalrequests_aos_products_2_c ON tr_technicalrequests.id = tr_technicalrequests_aos_products_2_c.tr_technicalrequests_aos_products_2tr_technicalrequests_ida AND tr_technicalrequests_aos_products_2_c.deleted = 0 
            LEFT JOIN aos_products ON aos_products.id = tr_technicalrequests_aos_products_2_c.tr_technicalrequests_aos_products_2aos_products_idb AND aos_products.deleted = 0
            LEFT JOIN aos_products_cstm ON aos_products.id = aos_products_cstm.id_c 
            LEFT JOIN tr_technicalrequests_opportunities_c tto ON tto.tr_technicalrequests_opportunitiestr_technicalrequests_idb = tr_technicalrequests.id and tto.deleted = 0
            LEFT JOIN opportunities opp ON opp.id = tto.tr_technicalrequests_opportunitiesopportunities_ida and opp.deleted = 0
            LEFT JOIN opportunities_cstm ON opportunities_cstm.id_c = tto.tr_technicalrequests_opportunitiesopportunities_ida
            LEFT JOIN tr_technicalrequests_accounts_c tta ON tta.tr_technicalrequests_accountstr_technicalrequests_idb = tr_technicalrequests.id and tta.deleted = 0
            LEFT JOIN accounts as acc ON acc.id = tta.tr_technicalrequests_accountsaccounts_ida and acc.deleted = 0 where ", $result);
        }
        
        /*
         * Ontrack #1705: Custom ListView Status Sorting
         * */
        if (is_array($result) && !empty($_REQUEST['lvso']) && isset($_REQUEST['TR_TechnicalRequests2_TR_TECHNICALREQUESTS_ORDER_BY']) && $_REQUEST['TR_TechnicalRequests2_TR_TECHNICALREQUESTS_ORDER_BY'] == 'status') {
            $result = customStatusSorting($result);
        }
        
        $_SESSION['TR_TechnicalRequestsExportXLSQuery'] = str_replace('where', '', $result['where']); // For Ontrack #1986 Fix on export to excel in Bulk Actions; add a filter to exported list if List view is filtered and Select All is clicked
        
        return $result;
	}

    private function get_opp_alias($query){
        global $log;

        $result = "";

        if(!empty($query)){
            $relate_pos = strpos($query, "tr_technicalrequests_opportunities_c ");
            $relate_substr = substr($query, $relate_pos + 37); //36 bec tr_technicalrequests_opportunities_c # of chars + space
            $alias_pos = strpos($relate_substr, " ");
            $result = substr($relate_substr, 0, $alias_pos);
        }

        return $result;
    }

    protected function strtolowerDropdownValues($dropdownList = null)
	{
		global $app_list_strings;

		if (isset($dropdownList)) {
				$returnArray = array_map(function($value) {
					return strtolower($value);
				}, $app_list_strings[$dropdownList]);

			return $returnArray;
		}

		return [];
	}

    // @desc: Searches thru the Array if searchValue is within the string
	// @param: String $searchValue, Array $searchArray
	// @return: Array of keys if there are matches and an EMPTY Array if otherwise
	protected function searchEnumArrayByValue($searchValue = null, $searchArray = [])
	{
		$returnKeys = [];

		if (isset($searchValue) && count($searchArray) > 0) {
			foreach ($searchArray as $key => $value) {
				$checkString = strpos($value, strtolower($searchValue));
				
				if ($checkString !== false) {
					$returnKeys[] = $key;
				}
			}
		}

		return $returnKeys;
	}
}