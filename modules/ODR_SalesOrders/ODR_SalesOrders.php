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
require_once('modules/ODR_SalesOrders/ODR_SalesOrders_sugar.php');
class ODR_SalesOrders extends ODR_SalesOrders_sugar {

	function __construct(){
		parent::__construct();
	}

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function ODR_SalesOrders(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }


    function save($check_notify = false)
    {
        global $sugar_config, $log;

        if (empty($this->id) || $this->new_with_id
            || (isset($_POST['duplicateSave']) && $_POST['duplicateSave'] == 'true')) {
            if (isset($_POST['group_id'])) {
                unset($_POST['group_id']);
            }
            if (isset($_POST['product_id'])) {
                unset($_POST['product_id']);
            }
            if (isset($_POST['service_id'])) {
                unset($_POST['service_id']);
            }
            
            /*
             * APX Custom Code: Ontrack 1922: Commented out the code below to prevent the system from generating a new order number
             * if($sugar_config['dbconfig']['db_type'] == 'mssql'){
                $this->number = $this->db->getOne("SELECT MAX(CAST(number as INT))+1 FROM ODR_SalesOrders");
            } else {
                $this->number = $this->db->getOne("SELECT MAX(CAST(number as UNSIGNED))+1 FROM ODR_SalesOrders");
            }*/

            if($this->number < $sugar_config['aos']['invoices']['initialNumber']){
                $this->number = $sugar_config['aos']['invoices']['initialNumber'];
            }
        }

        require_once('modules/AOS_Products_Quotes/AOS_Utils.php');

        perform_aos_save($this);

        parent::save($check_notify);

        require_once('modules/AOS_Line_Item_Groups/AOS_Line_Item_Groups.php');
        $productQuoteGroup = new AOS_Line_Item_Groups();
        $productQuoteGroup->save_groups($_POST, $this, 'group_');
    }

    function mark_deleted($id)
    {
        $productQuote = new AOS_Products_Quotes();
        $productQuote->mark_lines_deleted($this);
        parent::mark_deleted($id);
    }

    //OnTrack #921 - Order Advanced Searcched Query
    function create_new_list_query(
		$order_by, $where, $filter = array(), $params = array(),
		$show_deleted = 0, $join_type = '', $return_array = false, $parentbean = null,
        $singleSelect = false, $ifListForExport = false)
    {
		global $log;
        $module = !empty($_REQUEST['module']) ? $_REQUEST['module'] : '';
        $action = !empty($_REQUEST['action']) ? $_REQUEST['action'] : '';
        $entryPoint = !empty($_REQUEST['entryPoint']) ? $_REQUEST['entryPoint'] : ''; //OnTrack #1024
        $custom_fields = array('custom_item_name');

		$result = parent::create_new_list_query($order_by, $where, $filter, $params, 
			$show_deleted, $join_type, $return_array, $parentbean, 
            $singleSelect, $ifListForExport);
        
        // IF list rendered is on LIST VIEW, Subpanel or My Orders dashlet(OnTrack 943)
        if ( ($module == 'ODR_SalesOrders' && $action = 'index' && empty($entryPoint) ) 
                || ( isset($_REQUEST['customRequestDashletName']) && $_REQUEST['customRequestDashletName'] == 'MyRecentOrders' ) ) {

            $result['select'] .= ", aos_products_quotes.id as aos_products_quotes_id
                                    , aos_products_quotes.part_number as custom_item_number
                                    , aos_products_quotes.name as custom_item_name
                                    , aos_products_quotes.product_qty as custom_product_qty
                                    , aos_products_quotes.required_ship_date_c as custom_req_ship_date
                                    , aos_products_quotes.product_unit_price as custom_unit_price 
                                    , aos_products_quotes.promised_date as custom_promised_date
                                    , aos_products_quotes.req_ship_date_reason_code as custom_req_ship_date_reason_code
                                    , aos_products_quotes.req_ship_date_orig as custom_req_ship_date_orig
                                    , aos_products_quotes.order_line_status as custom_order_line_status ";
            
            $result['from'] .= " inner join aos_products_quotes
                                    on aos_products_quotes.parent_id = odr_salesorders.id
                                        and aos_products_quotes.parent_type = 'ODR_SalesOrders'
                                        and aos_products_quotes.deleted = 0";

            //OnTrack #1410 - Add Order Requested Date
            $result['select'] .= ", aos_products_quotes.requested_date_c as custom_requested_date ";

            $result['where'] = $this->manage_where($result['where']);
        }

        if($entryPoint == 'ODR_SalesOrdersExportCSV'){
            //$log->fatal(print_r($result, true));

            $result = str_replace('FROM', ", aos_products_quotes.part_number as custom_item_number
            , aos_products_quotes.part_number as custom_item_number
            , aos_products_quotes.name as custom_item_name
            , aos_products_quotes.product_qty as custom_product_qty
            , aos_products_quotes.required_ship_date_c as custom_req_ship_date
            , aos_products_quotes.product_unit_price as custom_unit_price 
            , aos_products_quotes.promised_date as custom_promised_date
            , aos_products_quotes.requested_date_c as custom_requested_date 
            , aos_products_quotes.req_ship_date_reason_code as custom_req_ship_date_reason_code
            , aos_products_quotes.req_ship_date_orig as custom_req_ship_date_orig
            , aos_products_quotes.order_line_status as custom_order_line_status FROM ", $result);

            $result = str_replace("where", "inner join aos_products_quotes
            on aos_products_quotes.parent_id = odr_salesorders.id
                and aos_products_quotes.parent_type = 'ODR_SalesOrders'
                and aos_products_quotes.deleted = 0 where ", $result);
        }

        //OnTrack #1262 - Required Ship Date 365 days
        if(!empty($_REQUEST['custom_req_ship_date_advanced_range_choice'])
            && $_REQUEST['custom_req_ship_date_advanced_range_choice'] == 'last_365_days'){
            $result['where'] .= ' and aos_products_quotes.required_ship_date_c BETWEEN NOW() - INTERVAL 365 DAY AND NOW() ';
        }

        //OnTrack #1288 - Add New Fields to List View
        if(isset($_GET['module']) && $_GET['module'] == 'ODR_SalesOrders' 
            && $_GET['action'] == 'index'){
            $result['from'] .= " LEFT JOIN accounts_cstm ON accounts_cstm.id_c = jt0.id ";
            $result['select'] .= ", accounts_cstm.cust_num_c as custom_cust_num ";
        }

        //OnTrack #1309 
        if(isset($_REQUEST['entryPoint']) && $_REQUEST['entryPoint'] == 'export'){
            $result = str_replace('FROM', ", aos_products_quotes.id as aos_products_quotes_id
            ,aos_products_quotes.part_number as custom_item_number
            , aos_products_quotes.date_entered as aos_products_quotes_date_entered
            , aos_products_quotes.name as custom_item_name
            , aos_products_quotes.product_qty as custom_product_qty
            , aos_products_quotes.required_ship_date_c as custom_req_ship_date
            , aos_products_quotes.product_unit_price as custom_unit_price 
            , aos_products_quotes.promised_date as custom_promised_date
            , aos_products_quotes.requested_date_c as custom_requested_date 
            , aos_products_quotes.req_ship_date_reason_code as custom_req_ship_date_reason_code
            , aos_products_quotes.req_ship_date_orig as custom_req_ship_date_orig
            , aos_products_quotes.order_line_status as custom_order_line_status FROM ", $result);

            $result = str_replace("where", "inner join aos_products_quotes
                        on aos_products_quotes.parent_id = odr_salesorders.id
                            and aos_products_quotes.parent_type = 'ODR_SalesOrders'
                            and aos_products_quotes.deleted = 0 where ", $result);
        }

        //OnTrack #1386 - Order - Account integration
        if(isset($_REQUEST['module']) && $_REQUEST['module'] == 'Accounts' 
            && isset($_REQUEST['action']) && ($_REQUEST['action'] == 'DetailView' || $_REQUEST['action'] == 'SubPanelViewer')){

            $result = str_replace('FROM', ",aos_products_quotes.part_number as custom_item_number
                , aos_products_quotes.date_entered as aos_products_quotes_date_entered
                , aos_products_quotes.name as custom_item_name
                , aos_products_quotes.product_qty as custom_product_qty
                , aos_products_quotes.required_ship_date_c as custom_req_ship_date
                , aos_products_quotes.product_unit_price as custom_unit_price 
                , aos_products_quotes.promised_date as custom_promised_date
                , aos_products_quotes.req_ship_date_reason_code as custom_req_ship_date_reason_code
                , aos_products_quotes.req_ship_date_orig as custom_req_ship_date_orig
                , aos_products_quotes.order_line_status as custom_order_line_status FROM ", $result);

            $result = str_replace("where", "left join aos_products_quotes
                on aos_products_quotes.parent_id = odr_salesorders.id
                    and aos_products_quotes.parent_type = 'ODR_SalesOrders'
                    and aos_products_quotes.deleted = 0 where ", $result);

            // $result['select'] = str_replace('odr_salesorders.id', 'aos_products_quotes.id as id', $result['select']); -- Ontrack 1619: commented out so $bean in hooks will render the correct ODR_SalesOrders ID and not the AOS_Products_Quotes ID
        }
        return $result;
	}

    // function create_list_count_query($query)
    // {        
    //     $count_query = "select count(*) as c from ( select distinct tblOrder.id, tblOrder.aos_products_quotes_id from (" . $query . ") as tblOrder ) as list_count";

    //     return $count_query;
    // }

    //OnTrack #921 - Order Advanced Searcched Query
    private function manage_where($where){
        global $log;

        $result = $where;
        $custom_fields = array(
            array(
                'field_name' => 'custom_item_name',
                'sql' => "aos_products_quotes.name",
            ),
            array(
                'field_name' => 'custom_item_number',
                'sql' => 'aos_products_quotes.part_number',
            ),
            array(
                'field_name' => 'custom_req_ship_date',
                'sql' => 'aos_products_quotes.required_ship_date_c',
            ),
            array(
                'field_name' => 'custom_promised_date',
                'sql' => 'aos_products_quotes.promised_date',
            ),
            array(
                'field_name' => 'custom_requested_date',
                'sql' => 'aos_products_quotes.requested_date_c',
            ),
        );

        foreach($custom_fields as $custom_field){

            if(strpos($where, $custom_field['field_name']) !== false){
                $result = str_replace($custom_field['field_name'], $custom_field['sql'], $result);
            }
        }

        return $result;
    }
}
