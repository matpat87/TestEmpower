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

require_once('modules/Accounts/Account.php'); // APX Custom Codes
require_once('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php'); // APX Custom Codes

class APR_AccountProfileReport extends Account
{
    public $new_schema = true;
    public $module_dir = 'APR_AccountProfileReport';
    public $object_name = 'APR_AccountProfileReport';
    public $table_name = 'accounts'; // Original table name: `apr_accountprofilereport`
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
    public $customer_number;
    public $account_type;
    public $account_status;
	
    public function bean_implements($interface)
    {
        switch($interface)
        {
            case 'ACL':
                return true;
        }

        return false;
    }

    function create_new_list_query($order_by,
        $where,
        $filter = array(),
        $params = array(),
        $show_deleted = 0,
        $join_type = '',
        $return_array = false,
        $parentbean = null,
        $singleSelect = false,
        $ifListForExport = false)
    {
        global $current_user, $log;

        $result =  parent::create_new_list_query($order_by, $where, $filter, $params, $show_deleted, $join_type, $return_array, $parentbean, $singleSelect, $ifListForExport);

        // Rename account_status
        $result['select'] = str_replace("accounts.account_status", " accounts_cstm.status_c AS account_status", $result['select']);
        $result['select'] = str_replace("accounts.customer_number", " accounts_cstm.cust_num_c AS customer_number ", $result['select']);
        $result['from'] = str_replace("apr_accountprofilereport.assigned_user_id", " accounts.assigned_user_id", $result['from']);
        $result['from'] .= " LEFT JOIN accounts_cstm ON accounts_cstm.id_c = accounts.id AND accounts.deleted=0 ";

        if (! $current_user->is_admin) {
            if (SecurityGroupHelper::checkIfUserExistsInAccountOrDivisionAccessSecurityGroup()) {
                $result['select'] = str_replace("accounts.id", "DISTINCT(accounts.id)", $result['select']);
                
                $result['from'] = "{$result['from']} 
                        LEFT JOIN securitygroups_records
                                ON securitygroups_records.record_id = accounts.id
                                AND securitygroups_records.module = 'Accounts'
                                AND securitygroups_records.deleted = 0
                        LEFT JOIN securitygroups
                                ON securitygroups.id = securitygroups_records.securitygroup_id
                                AND securitygroups.deleted = 0
                        LEFT JOIN securitygroups_cstm
                                ON securitygroups.id = securitygroups_cstm.id_c
                        LEFT JOIN securitygroups_users
                            ON securitygroups.id = securitygroups_users.securitygroup_id
                                AND securitygroups_users.deleted = 0
                    ";

                $result['where'] = "{$result['where']}
                        AND securitygroups_cstm.type_c IN ('Account Access', 'Division Access')
                        AND securitygroups_users.user_id = '{$current_user->id}'
                    ";
            }
        }
       
        $result['where'] .= " AND accounts.account_type IN ('CustomerParent', 'Customer') AND accounts_cstm.status_c='Active' ";
        $result['order_by'] = str_replace("accounts.customer_number", " accounts_cstm.cust_num_c ", $result['order_by']);
        $result['select'] = str_replace(" SELECT  DISTINCT(DISTINCT(accounts.id)) ", " SELECT  DISTINCT(accounts.id) ", $result['select']);
        $result = $this->handleAdvancedSearch($result); // Handle Advanced Search query customizations
        $result = $this->handleOrderList($result); // handle string replace for ORDER BY clause if necessary
        
        return $result;
    }

    /* OnTrack 1821: Fix Sort issue: renames sorted columns that are originally from the APR_AccountProfileReport fields
       replaced them with corresponding `account` field names to fix custom query - Glai Obido */
    private function handleOrderList($queryArray)
    {
        global $log;
        
        if (empty($queryArray)) {
            return;
        }
        
        // lvso
        if (! empty($_REQUEST['APR_AccountProfileReport2_APR_ACCOUNTPROFILEREPORT_ORDER_BY'])) {
            $column = $_REQUEST['APR_AccountProfileReport2_APR_ACCOUNTPROFILEREPORT_ORDER_BY'];

            switch ($column) {
                case 'customer_number':
                    $queryArray['order_by'] = str_replace("accounts.customer_number", " accounts_cstm.cust_num_c ", $queryArray['order_by']);
                    break;
                case 'account_status':
                    $queryArray['order_by'] = str_replace("accounts.account_status", " accounts_cstm.status_c ", $queryArray['order_by']);
                    break;
                
                default:
                   // do nothing
                    break;
            }
        }

        return $queryArray;
    }

    /* OnTrack 1821: Advance filter query customistions
        triggers an str_replace to unknown column names in custom query to accounts table.
        NOTE: For Type and Status: disregards the default filter for reports and replaces filter with the search value
     */
    private function handleAdvancedSearch($queryArray)
    {
        global $log;
        
        if (empty($queryArray)) {
            return;
        }
        
        if (!empty($_REQUEST['apr_account_name_nondb_advanced'])) {

            $queryArray['from'] = str_replace("accounts.account_id_c", " accounts.id", $queryArray['from']);
            $queryArray['where'] = str_replace("apr_account_name_nondb", " accounts.name", $queryArray['where']);
        }

        if (!empty($_REQUEST['customer_number_advanced'])) {

            // $queryArray['from'] = str_replace("accounts.account_id_c", " accounts.id", $queryArray['from']);
            $queryArray['where'] = str_replace("accounts.customer_number", " accounts_cstm.cust_num_c ", $queryArray['where']);
        }

        if (!empty($_REQUEST['account_status_advanced'])) {
            $queryArray['where'] = str_replace("accounts.account_status", " accounts_cstm.status_c ", $queryArray['where']);
            $queryArray['where'] = str_replace("AND accounts_cstm.status_c='Active'", "", $queryArray['where']);
        }
        
        if (!empty($_REQUEST['account_type_advanced'])) {
            $queryArray['where'] = str_replace("AND accounts.account_type IN ('CustomerParent', 'Customer')", "", $queryArray['where']);
        }

        return $queryArray;
    }
	
}