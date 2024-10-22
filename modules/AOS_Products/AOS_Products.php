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
require_once('modules/AOS_Products/AOS_Products_sugar.php');
#[\AllowDynamicProperties]
class AOS_Products extends AOS_Products_sugar
{
    public function __construct()
    {
        parent::__construct();
    }



    public function getGUID()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        }
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(mt_rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid, 12, 4).$hyphen
                .substr($charid, 16, 4).$hyphen
                .substr($charid, 20, 12);
        return $uuid;
    }

    public function save($check_notify = false)
    {
        global $sugar_config, $mod_strings;

        if (isset($_POST['deleteAttachment']) && $_POST['deleteAttachment'] == '1') {
            $this->product_image = '';
        }

        require_once('include/upload_file.php');
        $GLOBALS['log']->debug('UPLOADING PRODUCT IMAGE');

        if(!empty($_FILES['uploadimage']['name'])){
            $imageFileName = $_FILES['uploadimage']['name'] ?? '';
            if (!has_valid_image_extension('AOS_Products Uploaded image file: ' . $imageFileName , $imageFileName)) {
                LoggerManager::getLogger()->fatal("AOS_Products save - Invalid image file ext : '$imageFileName'.");
                throw new RuntimeException('Invalid request');
            }
        }

        if (!empty($_FILES['uploadimage']['tmp_name']) && verify_uploaded_image($_FILES['uploadimage']['tmp_name'])) {
            if ($_FILES['uploadimage']['size'] > $sugar_config['upload_maxsize']) {
                die($mod_strings['LBL_IMAGE_UPLOAD_FAIL'] . $sugar_config['upload_maxsize']);
            }
            $prefix_image = $this->getGUID() . '_';
            $this->product_image = $sugar_config['site_url'] . '/' . $sugar_config['upload_dir'] . $prefix_image . $_FILES['uploadimage']['name'];
            move_uploaded_file($_FILES['uploadimage']['tmp_name'], $sugar_config['upload_dir'] . $prefix_image . $_FILES['uploadimage']['name']);
        }

        require_once('modules/AOS_Products_Quotes/AOS_Utils.php');

        perform_aos_save($this);

        return parent::save($check_notify);
    }

    public function getCustomersPurchasedProductsQuery()
    {
        $query = "
 			SELECT * FROM (
 				SELECT
					aos_quotes.*,
					accounts.id AS account_id,
					accounts.name AS billing_account,

					opportunity_id AS opportunity,
					billing_contact_id AS billing_contact,
					'' AS created_by_name,
					'' AS modified_by_name,
					'' AS assigned_user_name
				FROM
					aos_products

				JOIN aos_products_quotes ON aos_products_quotes.product_id = aos_products.id AND aos_products.id = '{$this->id}' AND aos_products_quotes.deleted = 0 AND aos_products.deleted = 0
				JOIN aos_quotes ON aos_quotes.id = aos_products_quotes.parent_id AND aos_quotes.stage = 'Closed Accepted' AND aos_quotes.deleted = 0
				JOIN accounts ON accounts.id = aos_quotes.billing_account_id -- AND accounts.deleted = 0

				GROUP BY aos_quotes.id
			) AS aos_quotes

		";
        return $query;
    }

    public function get_list_view_data()
    {

		$temp_array = parent::get_list_view_data();
		$temp_array["VERSION_C"] = $this->version_c;

		return $temp_array;
	}

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
		global $app_list_strings;

		if(strpos($where, 'related_product_number_non_db_c') !== false) {
			$relatedProductList = BeanFactory::getBean('AOS_Products')->get_full_list(
				'name',
				"system_version_c LIKE '{$_REQUEST['related_product_number_non_db_c_advanced']}%'"
			);

			$relatedBeanIdArray = [];

			foreach ($relatedProductList as $key => $value) {
				array_push($relatedBeanIdArray, "'{$value->id}'");
			}
			
			$relatedBeanIdString = $relatedBeanIdArray ? implode(', ', $relatedBeanIdArray) : "'{$_REQUEST['related_product_number_non_db_c_advanced']}'";
			$where = string_replace_all("related_product_number_non_db_c like '{$_REQUEST['related_product_number_non_db_c_advanced']}%'", "aos_products_id_c IN ({$relatedBeanIdString})", $where);
		}

		$result =  parent::create_new_list_query(
			$order_by, 
			$where, 
			$filter, 
			$params, 
			$show_deleted, 
			$join_type, 
			$return_array, 
			$parentbean, 
			$singleSelect
		);
		global $log;
		// Global Search Customizations  -- OnTrack #1235 Glai Obido
		if ((isset($_REQUEST['module']) && $_REQUEST['module'] == 'Home') && $_REQUEST['action'] == 'UnifiedSearch') {
			$queryString = $_REQUEST['query_string'];
			$result['where'] = str_replace("aos_products.base_resin_nondb", "aos_products_cstm.base_resin_c", $result['where']);
			$result['where'] = str_replace("aos_products.color_c_nondb", "aos_products_cstm.color_c", $result['where']);
			$result['where'] = str_replace("aos_products.resin_type_c_nondb", "aos_products_cstm.resin_type_c", $result['where']);

			// FOR THE color value search (GLOBAL SEARCH)
			$colorList = $this->strtolowerDropdownValues('pi_color_list');
			$baseResinList = $this->strtolowerDropdownValues('resin_type_list');
			

			$colorKeyList = $this->searchEnumArrayByValue($queryString, $colorList);
			$baseResinKeys = $this->searchEnumArrayByValue($queryString, $baseResinList);
			
			
			if (count($colorKeyList) > 0) {
				$colorKeys = array_map('strval', $colorKeyList);
				$implodeColorKeys = implode(",'", $colorKeys);
				
				// if query string (color) is in the list of colors in $app_list_strings['pi_color_list'], replace the query string in WHERE Clause to the KEY of the color value
				$result['where'] = str_replace("aos_products_cstm.color_c like '{$_REQUEST['query_string']}%'", " aos_products_cstm.color_c IN ('{$implodeColorKeys}')", $result['where']);
			}

			if (count($baseResinKeys) > 0) {

				$implodeKeys = implode(",", $baseResinKeys);
				// if query string (color) is in the list of colors in $app_list_strings['pi_color_list'], replace the query string in WHERE Clause to the KEY of the color value
				$result['where'] = str_replace("aos_products_cstm.base_resin_c like '{$_REQUEST['query_string']}%'", "aos_products_cstm.base_resin_c IN ({$implodeKeys})", $result['where']);
				
				$result['where'] = str_replace("aos_products_cstm.resin_type_c like '{$_REQUEST['query_string']}%'", "aos_products_cstm.resin_type_c IN ({$implodeKeys})", $result['where']);
			}

		}
		
		// Popup returns an SQL array instead of string
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'Popup') {
			$result['select'] = str_replace('aos_products.name', 'aos_products_cstm.product_number_c as name', $result['select']);
			
			// Popup returns an SQL array instead of string
            if ((isset($_REQUEST['filter_production_only_results']) && $_REQUEST['filter_production_only_results']) || (strpos($_REQUEST['request_data'], 'product_rematch_id') !== false)) {
                $result['where'] .= " AND aos_products.type = 'production' AND aos_products_cstm.status_c = 'active' ";
            }
		}

        // Autocomplete returns an SQL string instead of array
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'quicksearchQuery') {
            $result = str_replace('aos_products.*', 'aos_products.*, aos_products_cstm.product_number_c as name', $result);
            $result = str_replace('aos_products.name like', 'aos_products_cstm.product_number_c like', $result);
		}
		
		if (isset($result['order_by'])) {
			$result['order_by'] = str_replace('product_name_non_db', 'aos_products.name', $result['order_by']);
		}
        
        /*
         * Ontrack #1705: Custom ListView Status Sorting
         * */
        if (is_array($result) && !empty($_REQUEST['lvso']) && isset($_REQUEST['AOS_Products2_AOS_PRODUCTS_ORDER_BY']) && $_REQUEST['AOS_Products2_AOS_PRODUCTS_ORDER_BY'] == 'status_c') {
            $result = customStatusSorting($result);
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
