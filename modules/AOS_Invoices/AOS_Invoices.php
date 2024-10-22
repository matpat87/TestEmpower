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
 * @author SalesAgility Ltd <support@salesagility.com>
 */

/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/AOS_Invoices/AOS_Invoices_sugar.php');
#[\AllowDynamicProperties]
class AOS_Invoices extends AOS_Invoices_sugar
{
    public function __construct()
    {
        parent::__construct();
    }




    public function save($check_notify = false)
    {
        global $sugar_config;

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

            if ($sugar_config['dbconfig']['db_type'] == 'mssql') {
                $this->number = $this->db->getOne("SELECT MAX(CAST(number as INT))+1 FROM aos_invoices");
            } else {
                $this->number = $this->db->getOne("SELECT MAX(CAST(number as UNSIGNED))+1 FROM aos_invoices");
            }

            if ($this->number < $sugar_config['aos']['invoices']['initialNumber']) {
                $this->number = $sugar_config['aos']['invoices']['initialNumber'];
            }
        }

        require_once('modules/AOS_Products_Quotes/AOS_Utils.php');

        perform_aos_save($this);

        $return_id = parent::save($check_notify);

        require_once('modules/AOS_Line_Item_Groups/AOS_Line_Item_Groups.php');
        $productQuoteGroup = BeanFactory::newBean('AOS_Line_Item_Groups');
        $productQuoteGroup->save_groups($_POST, $this, 'group_');

        return $return_id;
    }

    public function mark_deleted($id)
    {
        $productQuote = BeanFactory::newBean('AOS_Products_Quotes');
        $productQuote->mark_lines_deleted($this);
        parent::mark_deleted($id);
    }

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

        global $log;
        $result = parent::create_new_list_query($order_by, $where, $filter, $params, $show_deleted, $join_type, $return_array, $parentbean, $singleSelect);
        $module = !empty($_REQUEST['module']) ? $_REQUEST['module'] : '';
        $entryPoint = !empty($_REQUEST['entryPoint']) ? $_REQUEST['entryPoint'] : '';
        
        
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'Popup') {
            $result['from'] = "{$result['from']} LEFT JOIN aos_products_quotes ON aos_products_quotes.parent_id = aos_invoices.id AND aos_products_quotes.parent_type = 'AOS_Invoices' AND aos_products_quotes.deleted = 0";

            $result['where'] = str_replace("account_name_nondb", "jt1.name", $result['where']);
            $result['where'] = str_replace("customer_product_number_nondb", "aos_products_quotes.item_number_c", $result['where']);
            $result['where'] = str_replace("and jt1.name", "AND jt1.name", $result['where']);
            $result['where'] = str_replace("and aos_products_quotes.item_number_c", "AND aos_products_quotes.item_number_c", $result['where']);
        }

        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'quicksearchQuery') {

            $result = str_replace('aos_invoices.*', 'aos_invoices.*, aos_invoices.number as name', $result);
            
            if (strpos($_REQUEST['data'], 'aos_products_quotes.item_number_c') !== false) {
                $result = str_replace(
                    'where',
                    "LEFT JOIN aos_products_quotes ON aos_products_quotes.parent_id = aos_invoices.id AND aos_products_quotes.parent_type = 'AOS_Invoices' AND aos_products_quotes.deleted = 0 LEFT JOIN ci_customeritems_aos_products_quotes_c ON ci_customeritems_aos_products_quotes_c.ci_customeritems_aos_products_quotesaos_products_quotes_idb = aos_products_quotes.id AND ci_customeritems_aos_products_quotes_c.deleted = 0 WHERE ",
                    $result
                );
                
            

                $result = str_replace(
                    'aos_invoices.name like',
                    'aos_invoices.number like',
                    $result
                );

                $result = str_replace(
                    "aos_products_quotes.item_number_c =",
                    "ci_customeritems_aos_products_quotes_c.ci_customeritems_aos_products_quotesci_customeritems_ida =",
                    $result
                );


            }

        }

        //OnTrack #1347 - Add Ship Date from Line Item
        if($module == 'AOS_Invoices' && $action = 'index' && empty($entryPoint)){
            $result['from'] .= " LEFT JOIN aos_products_quotes
                                    ON aos_products_quotes.parent_id = aos_invoices.id
                                        AND aos_products_quotes.parent_type = 'AOS_Invoices'
                                        AND aos_products_quotes.deleted = 0 ";
            $result['select'] .= " , aos_products_quotes.shipped_date_c as custom_shipped_date
                                   , aos_products_quotes.item_number_c as custom_item_number ";

            $result['where'] = $this->manage_where($result['where']);

            //OnTrack #1334 - include Customer #
            $result['from'] .= " LEFT JOIN accounts_cstm 
                                    ON accounts_cstm.id_c = jt1.id ";
            $result['select'] .= " , accounts_cstm.cust_num_c as custom_customer_number ";
        }
        
        //OnTrack #1309 
        if(isset($entryPoint) && $entryPoint == 'export'){
            $result = str_replace('where', " LEFT JOIN aos_products_quotes
                                                ON aos_products_quotes.parent_id = aos_invoices.id
                                                    AND aos_products_quotes.parent_type = 'AOS_Invoices'
                                                    AND aos_products_quotes.deleted = 0 where ", $result);

            $result = str_replace("FROM", ", aos_products_quotes.shipped_date_c as custom_shipped_date
            , aos_products_quotes.item_number_c as custom_item_number FROM ", $result);

            //OnTrack #1334 - include Customer #
            $result = str_replace('where', " LEFT JOIN accounts_cstm
                                            ON accounts_cstm.id_c = jt3.id where ", $result);
            $result = str_replace("FROM", ", accounts_cstm.cust_num_c as custom_customer_number FROM ", $result);
        }

        //OnTrack #1385 - Invoice under Account
        if(isset($_REQUEST['module']) && $_REQUEST['module'] == 'Accounts' 
            && isset($_REQUEST['action']) && ($_REQUEST['action'] == 'DetailView' || $_REQUEST['action'] == 'SubPanelViewer')){

            $result['from'] .= " LEFT JOIN aos_products_quotes
                            ON aos_products_quotes.parent_id = aos_invoices.id
                                AND aos_products_quotes.parent_type = 'AOS_Invoices'
                                AND aos_products_quotes.deleted = 0 ";
            $result['select'] .= " , aos_products_quotes.shipped_date_c as custom_shipped_date
                        , aos_products_quotes.item_number_c as custom_item_number ";

            $result['where'] = $this->manage_where($result['where']);
        }

        //OnTrack #1471 - Invoice Duplicates
        if(is_array($result)){
            $result['select'] = str_replace('SELECT', 'SELECT DISTINCT', $result['select']);
        }
        else{
            $result = str_replace('SELECT', 'SELECT DISTINCT', $result);
        }

        // OnTrack 1565: filter by Line Item -- Glai Obido
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'UnifiedSearch') {
            // Get All invoices who have Line Item(s) with product # or item # of <query_string>
            $result = $this->globalSearchCustomFilter($result);
            

		}


        return $result;
    }

    // Ontrack #1565: Include filter for invoices who have Line Item(s) with product # or item # of <query_string> -- Glai Obido
	private function globalSearchCustomFilter($queryArray)
	{
        if (is_array($queryArray)) {
            $queryArray['from'] .= " 
                LEFT JOIN
                aos_products_quotes ON aos_products_quotes.parent_id = aos_invoices.id
                    AND aos_products_quotes.parent_type = 'AOS_Invoices'
                    AND aos_products_quotes.deleted = 0
                    LEFT JOIN
                ci_customeritems_aos_products_quotes_c ON ci_customeritems_aos_products_quotes_c.ci_customeritems_aos_products_quotesaos_products_quotes_idb = aos_products_quotes.id
                    AND ci_customeritems_aos_products_quotes_c.deleted = 0
                    LEFT JOIN
                ci_customeritems ON ci_customeritems.id = ci_customeritems_aos_products_quotes_c.ci_customeritems_aos_products_quotesci_customeritems_ida
                    AND ci_customeritems.deleted = 0
                    LEFT JOIN
                ci_customeritems_cstm ON ci_customeritems_cstm.id_c = ci_customeritems.id
            ";

            $queryArray['where'] .= "
                OR ci_customeritems_cstm.product_number_c = '{$_REQUEST['query_string']}'
                OR ci_customeritems.name LIKE'{$_REQUEST['query_string']}%'
            ";
        }

		return $queryArray;
	}

    private function manage_where($where){
        global $log;

        $result = $where;
        $custom_fields = array(
            array(
                'field_name' => 'custom_shipped_date',
                'sql' => "aos_products_quotes.shipped_date_c",
            ),
            array(
                'field_name' => 'custom_item_number',
                'sql' => "aos_products_quotes.item_number_c",
            ),
        );

        foreach($custom_fields as $custom_field){

            if(strpos($where, $custom_field['field_name']) !== false){
                $result = str_replace($custom_field['field_name'], $custom_field['sql'], $result);
            }
        }

        return $result;
    }
    // APX Custom Codes -- END
}
