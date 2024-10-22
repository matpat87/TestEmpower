<?php
/**
 * Products, Quotations & Invoices modules.
 * Extensions to SugarCRM
 * @package Advanced OpenSales for SugarCRM
 * @subpackage Products
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author Salesagility Ltd <support@salesagility.com>
 */

/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/CI_CustomerItems/CI_CustomerItems_sugar.php');
class CI_CustomerItems extends CI_CustomerItems_sugar {
    public $importable = true;
    
	function __construct(){
		parent::__construct();
	}

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function CI_CustomerItems(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }


	function save($check_notify=false){
		global $sugar_config,$mod_strings;

		if (isset($_POST['deleteAttachment']) && $_POST['deleteAttachment']=='1') {
			$this->product_image = '';
		}

		require_once('include/upload_file.php');
		$GLOBALS['log']->debug('UPLOADING PRODUCT IMAGE');
		$upload_file = new UploadFile('uploadfile');

		if (isset($_FILES['uploadimage']['tmp_name'])&&$_FILES['uploadimage']['tmp_name']!=""){

            if($_FILES['uploadimage']['size'] > $sugar_config['upload_maxsize']) {
                die($mod_strings['LBL_IMAGE_UPLOAD_FAIL'].$sugar_config['upload_maxsize']);

            }
            else {
                $this->product_image=$sugar_config['site_url'].'/'.$sugar_config['upload_dir'].$_FILES['uploadimage']['name'];
                move_uploaded_file($_FILES['uploadimage']['tmp_name'], $sugar_config['upload_dir'].$_FILES['uploadimage']['name']);

            }
	    }

        require_once('modules/AOS_Products_Quotes/AOS_Utils.php');

        perform_aos_save($this);

	    parent::save($check_notify);
    }

    public function create_export_query($order_by, $where)
    {
        global $log;
        
        $query = parent::create_export_query($order_by, $where);

        $query = str_replace(
            'where', 
            'LEFT JOIN mkt_markets ON mkt_markets.id = ci_customeritems_cstm.sub_industry_c
            LEFT JOIN mkt_markets_cstm ON mkt_markets.id = mkt_markets_cstm.id_c where',
            $query
        );

        return $query;
    }
    
    //OnTrack #1309 - remove this because of error in Prod
    /*
    function create_list_count_query($query)
    {        
        $count_query = "select count(*) as c from ( select distinct id from (" . $query . ") as tblCustomerProduct ) as list_count";

        return $count_query;
    }
    */

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
        global $log, $module;
       
        $result = parent::create_new_list_query($order_by, $where, $filter, $params, $show_deleted, $join_type, $return_array, $parentbean, $singleSelect);
        
        if (! $return_array) {
            $result = str_replace('ci_customeritems.mkt_markets_id_c', 'ci_customeritems_cstm.mkt_markets_id_c', $result);
            
        } else {
            $result['from'] = str_replace('ci_customeritems.mkt_markets_id_c', 'ci_customeritems_cstm.mkt_markets_id_c', $result['from']);
        }
        
        if (isset($_REQUEST['mkt_markets_ci_customeritems_1_name_advanced']) && strtolower($_REQUEST['mkt_markets_ci_customeritems_1_name_advanced']) == 'null') {
            $result['where'] = str_replace("jt2.name like", "ci_customeritems_cstm.mkt_markets_id_c IS NULL OR ci_customeritems_cstm.mkt_markets_id_c = ''", $result['where']);
        }

        if (isset($_REQUEST['mkt_newmarkets_ci_customeritems_1_name_advanced']) && strtolower($_REQUEST['mkt_newmarkets_ci_customeritems_1_name_advanced']) == 'null') {
            $result['where'] = str_replace("jt2.name like", "ci_customeritems_cstm.new_market_c IS NULL OR ci_customeritems_cstm.new_market_c = ''", $result['where']);
        }
        
        $from_module = !empty($_REQUEST['from_module']) ? $_REQUEST['from_module'] : '';
        
        // Popup returns an SQL array instead of string
        if ((isset($_REQUEST['action']) && $_REQUEST['action'] == 'Popup') && $from_module != 'RRQ_RegulatoryRequests') {

            /*
             * Ontrack 1930 Fix: On (cases editview) Product # Popup and a search is triggered, it should set the $from_module to 'Cases' to trigger the select 'product_number_c as `name` in query customisation
             * */
            $popUpRequestData = json_decode(html_entity_decode($_REQUEST['request_data']), true) ?? null;

            if ($popUpRequestData && (!empty($popUpRequestData['field_to_name_array']) && $popUpRequestData['field_to_name_array']['id'] == 'ci_customeritems_cases_1ci_customeritems_ida')) {
                $from_module = 'Cases';
            }
            /* End of OnTrack 1930 Fix */

            if (in_array($from_module, ['Cases', 'TR_TechnicalRequests'])) {

                $result['select'] = str_replace('ci_customeritems.name', 'ci_customeritems_cstm.product_number_c as name', $result['select']);

            }
            if ($return_array) {
                if (isset($_REQUEST['account_id'])) {
                    $result['where'] = str_replace("account_name_nondb", "jt0.id='{$_REQUEST['account_id']}' AND jt0.name", $result['where']);
                } else {
                    $result['where'] = str_replace("account_name_nondb", "jt0.name", $result['where']);
                }

                // Added condition to only trigger if via Customer Issues - Customer Products Subpanel "Select" Action
                if($_REQUEST['return_module'] == 'Cases') {
                    if ($_REQUEST['account_id']) {
                        $result['where'] .= " AND jt0.id = '{$_REQUEST['account_id']}' ";
                    } else {
                        if (! $_REQUEST['account_name_nondb_advanced']) {
                            $result['where'] .= " AND 1=0 ";
                        }
                    }
                }
            }
        }
        
        // Autocomplete returns an SQL string instead of array
        if ((isset($_REQUEST['action']) && $_REQUEST['action'] == 'quicksearchQuery') && $from_module != 'RRQ_RegulatoryRequests') {
            
            $result = str_replace('ci_customeritems.*', 'ci_customeritems.*, ci_customeritems_cstm.product_number_c as name', $result);
            
            $params = json_decode(html_entity_decode($_REQUEST['data']), true);
            
            // Custom query string replace for autocomplete from customer issues module: Product # Field
            if (strpos($_REQUEST['data'], 'ci_customeritems_cases_1ci_customeritems_ida') !== false || in_array('ci_customeritems_accounts_c.ci_customeritems_accountsaccounts_ida', array_column($params['conditions'], 'name'))) {

                $data = json_decode(html_entity_decode($_REQUEST['data']), true);
                $accountID = $data['conditions'][1]['value'];
                
                $result = str_replace(
                    'where',
                    'LEFT JOIN  ci_customeritems_accounts_c ON ci_customeritems.id = ci_customeritems_accounts_c.ci_customeritems_accountsci_customeritems_idb AND ci_customeritems_accounts_c.deleted=0 
                   INNER JOIN accounts cases_acct ON cases_acct.id = ci_customeritems_accounts_c.ci_customeritems_accountsaccounts_ida 
                    where ',
                    $result
                );

                $result = str_replace(
                    '((ci_customeritems.name like ',
                    '((ci_customeritems_cstm.product_number_c LIKE ',
                    $result
                );
                
                /*
                 * Ontrack #1930 fix: commented out to improve query performance; may not need to query accounts that have $accountID as its parent_id
                 * $result = str_replace(
                    "ci_customeritems_accounts_c.ci_customeritems_accountsaccounts_ida = '{$accountID}'",
                    "ci_customeritems_accounts_c.ci_customeritems_accountsaccounts_ida = '{$accountID}' OR cases_acct.parent_id = '{$accountID}' ",
                    $result
                );*/
              
                
            }
                
        }
            

        if (isset($result['order_by'])) {
            $result['order_by'] = str_replace('ci_name_non_db', 'ci_customeritems.name', $result['order_by']);

            /*
             * Ontract 1930 Fix: When pop-up is triggered from Cases: Product # field and current user is not admin, order by query is set to 'product_master_non_db' by default. It should str_replace into ci_customeritems.name to avoid any syntax error(s)
             * */
            $result['order_by'] = str_replace('product_master_non_db', 'ci_customeritems.name', $result['order_by']);
            /* End of Ontrack 1930 fix block */
        }


		return $result;
	}
}
