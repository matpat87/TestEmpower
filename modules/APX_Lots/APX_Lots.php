<?php
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


class APX_Lots extends Basic
{
    public $new_schema = true;
    public $module_dir = 'APX_Lots';
    public $object_name = 'APX_Lots';
    public $table_name = 'apx_lots';
    public $importable = true;

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
	
    public function bean_implements($interface)
    {
        switch($interface)
        {
            case 'ACL':
                return true;
        }

        return false;
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
    )
    {
        global $log;

        $where = str_replace('apx_lots.account_name_non_db', 'accounts.name', $where);
        $where = str_replace('account_name_non_db', 'accounts.name', $where);

        $result = parent::create_new_list_query($order_by, $where, $filter, $params, $show_deleted, $join_type, $return_array, $parentbean, $singleSelect);

        if ($_REQUEST['action'] == 'quicksearchQuery') {
            // SQS Auto complete when triggered via Cases Lot # Line Item field
            if (strpos($_REQUEST['data'], 'product_lot_name') !== false) {
                $customWhere = "
                    INNER JOIN apx_lots_aos_products_c
                        ON apx_lots.id = apx_lots_aos_products_c.apx_lots_aos_productsapx_lots_idb
                        AND apx_lots_aos_products_c.deleted = 0
                    INNER JOIN aos_products
                        ON aos_products.id = apx_lots_aos_products_c.apx_lots_aos_productsaos_products_ida
                        AND aos_products.deleted = 0
                    LEFT JOIN aos_products_cstm
                        ON aos_products.id = aos_products_cstm.id_c
                    INNER JOIN apx_lots_ci_customeritems_c
                        ON apx_lots.id = apx_lots_ci_customeritems_c.apx_lots_ci_customeritemsapx_lots_ida
                        AND apx_lots_ci_customeritems_c.deleted = 0
                    INNER JOIN ci_customeritems
                        ON ci_customeritems.id = apx_lots_ci_customeritems_c.apx_lots_ci_customeritemsci_customeritems_idb
                        AND ci_customeritems.deleted = 0
                    LEFT JOIN ci_customeritems_cstm
                        ON ci_customeritems.id = ci_customeritems_cstm.id_c
                    INNER JOIN ci_customeritems_accounts_c
                        ON ci_customeritems.id = ci_customeritems_accounts_c.ci_customeritems_accountsci_customeritems_idb
                        AND ci_customeritems_accounts_c.deleted = 0
                    INNER JOIN accounts
                        ON accounts.id = ci_customeritems_accounts_c.ci_customeritems_accountsaccounts_ida
                        AND accounts.deleted = 0
                    WHERE 
                ";

                $result = str_replace('where', $customWhere, $result);

                // Need to allow N/A as selectable option as Lot Line Item is mandatory
                $result = str_replace($where, "{$where} OR (apx_lots.name like 'n/a%')", $result);
            }
        }

        if ($_REQUEST['action'] == 'Popup') {
            $result['select'] = str_replace('apx_lots.id', 'DISTINCT(apx_lots.id)', $result['select']);
            $result['select'] .= ", ci_customeritems_cstm.product_number_c AS customer_product_number_non_db
                                  , aos_products.name AS product_master_non_db";

            $result['from'] .= "
                    INNER JOIN apx_lots_aos_products_c
                        ON apx_lots.id = apx_lots_aos_products_c.apx_lots_aos_productsapx_lots_idb
                        AND apx_lots_aos_products_c.deleted = 0
                    INNER JOIN aos_products
                        ON aos_products.id = apx_lots_aos_products_c.apx_lots_aos_productsaos_products_ida
                        AND aos_products.deleted = 0
                    LEFT JOIN aos_products_cstm
                        ON aos_products.id = aos_products_cstm.id_c
                    INNER JOIN apx_lots_ci_customeritems_c
                        ON apx_lots.id = apx_lots_ci_customeritems_c.apx_lots_ci_customeritemsapx_lots_ida
                        AND apx_lots_ci_customeritems_c.deleted = 0
                    INNER JOIN ci_customeritems
                        ON ci_customeritems.id = apx_lots_ci_customeritems_c.apx_lots_ci_customeritemsci_customeritems_idb
                        AND ci_customeritems.deleted = 0
                    LEFT JOIN ci_customeritems_cstm
                        ON ci_customeritems.id = ci_customeritems_cstm.id_c
                    ";

            // Only join if Account field is populated to improve query performance as field is not on Pop up list view
            if (isset($_REQUEST['account_name_non_db_advanced']) && $_REQUEST['account_name_non_db_advanced']
            ) {
                $result['select'] = str_replace('jt0.name account_name_non_db ,', '', $result['select']);

                $result['from'] .= "
                    INNER JOIN ci_customeritems_accounts_c
                        ON ci_customeritems.id = ci_customeritems_accounts_c.ci_customeritems_accountsci_customeritems_idb
                        AND ci_customeritems_accounts_c.deleted = 0
                    INNER JOIN accounts
                        ON accounts.id = ci_customeritems_accounts_c.ci_customeritems_accountsaccounts_ida
                        AND accounts.deleted = 0
                    ";

                $result['where'] = str_replace('account_name_non_db', 'accounts.name', $result['where']);
            }

            // Only join if Invoice PO # field, Invoice #, or Invoice Shipped Date is populated to improve query performance as field is not on Pop up list view
            if (
                (isset($_REQUEST['invoice_po_number_non_db_advanced']) && $_REQUEST['invoice_po_number_non_db_advanced']) ||
                (isset($_REQUEST['invoice_number_non_db_advanced']) && $_REQUEST['invoice_number_non_db_advanced']) ||
                (isset($_REQUEST['invoice_line_item_shipped_date_non_db_advanced']) && $_REQUEST['invoice_line_item_shipped_date_non_db_advanced'])) {
                $result['from'] .= "
                    INNER JOIN apx_lots_aos_invoices_c
                        ON apx_lots.id = apx_lots_aos_invoices_c.apx_lots_aos_invoicesapx_lots_ida
                        AND apx_lots_aos_invoices_c.deleted = 0
                    INNER JOIN aos_invoices
                        ON aos_invoices.id = apx_lots_aos_invoices_c.apx_lots_aos_invoicesaos_invoices_idb
                        AND aos_invoices.deleted = 0
                    LEFT JOIN aos_invoices_cstm
                        ON aos_invoices.id = aos_invoices_cstm.id_c
                    ";

                if (isset($_REQUEST['invoice_po_number_non_db_advanced']) && $_REQUEST['invoice_po_number_non_db_advanced']) {
                    $result['where'] = str_replace('invoice_po_number_non_db', 'aos_invoices_cstm.po_number_c', $result['where']);
                }

                if (isset($_REQUEST['invoice_number_non_db_advanced']) && $_REQUEST['invoice_number_non_db_advanced']) {
                    $result['where'] = str_replace('invoice_number_non_db', 'aos_invoices.number', $result['where']);
                }

                if (isset($_REQUEST['invoice_line_item_shipped_date_non_db_advanced']) && $_REQUEST['invoice_line_item_shipped_date_non_db_advanced']) {
                    $result['from'] .= " 
                        LEFT JOIN aos_products_quotes 
                            ON aos_products_quotes.parent_id = aos_invoices.id 
                            AND aos_products_quotes.parent_type = 'AOS_Invoices' 
                            AND aos_products_quotes.deleted = 0 
                    ";

                    $result['where'] = str_replace('invoice_line_item_shipped_date_non_db', 'aos_products_quotes.shipped_date_c', $result['where']);
                }
            }

            $result['where'] = str_replace('customer_product_number_non_db', 'ci_customeritems_cstm.product_number_c', $result['where']);

            // Need to allow N/A as selectable option as Lot Line Item is mandatory
            $result['where'] = str_replace($where, "{$where} OR (apx_lots.name like 'n/a%')", $result['where']);

            $result['order_by'] = str_replace('customer_product_number_non_db', 'ci_customeritems_cstm.product_number_c', $result['order_by']);
            $result['order_by'] = str_replace('product_master_non_db', 'aos_products.name', $result['order_by']);
        }

        return $result;
    }
}