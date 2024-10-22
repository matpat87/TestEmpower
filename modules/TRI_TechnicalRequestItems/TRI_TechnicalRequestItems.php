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

require_once('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');

class TRI_TechnicalRequestItems extends Basic
{
    public $new_schema = true;
    public $module_dir = 'TRI_TechnicalRequestItems';
    public $object_name = 'TRI_TechnicalRequestItems';
    public $table_name = 'tri_technicalrequestitems';
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
    public $product_number;
    public $qty;
    public $uom;
    public $status;
    public $due_date;
	
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
    ) {
        global $current_user;

        // Disable out-of-the-box security groups filter as TR Item data will be retrieved by way of TR - TR Item access rights
        if (! $current_user->is_admin) {
            $_REQUEST['disable_security_groups_filter'] = true;
        }

        $result = parent::create_new_list_query($order_by, $where, $filter, $params, $show_deleted, $join_type, $return_array, $parentbean, $singleSelect, $ifListForExport);
        
        if($_REQUEST['module'] == 'Home' && $_REQUEST['customRequestDashletName'] == 'TechnicalRequestItemsDashlet' || ((! isset($_REQUEST['entryPoint'])) && isset($_REQUEST['action']) && $_REQUEST['action'] == 'index') || $_REQUEST['action'] == 'Popup') {
            $result['from'] .= "
                LEFT JOIN tri_technicalrequestitems_tr_technicalrequests_c 
                    ON tri_technicalrequestitems.id = tri_technicalrequestitems_tr_technicalrequests_c.tri_technif81bstitems_idb
                    AND tri_technicalrequestitems_tr_technicalrequests_c.deleted = 0
                LEFT JOIN tr_technicalrequests
                    ON tr_technicalrequests.id = tri_technicalrequestitems_tr_technicalrequests_c.tri_techni0387equests_ida
                    AND tr_technicalrequests.deleted = 0
                LEFT JOIN tr_technicalrequests_cstm
                    ON tr_technicalrequests.id = tr_technicalrequests_cstm.id_c
                LEFT JOIN tr_technicalrequests_accounts_c
                    ON tr_technicalrequests.id = tr_technicalrequests_accounts_c.tr_technicalrequests_accountstr_technicalrequests_idb
                    AND tr_technicalrequests_accounts_c.deleted = 0
                LEFT JOIN accounts
                    ON accounts.id = tr_technicalrequests_accounts_c.tr_technicalrequests_accountsaccounts_ida
                    AND accounts.deleted = 0
                LEFT JOIN aos_products_tri_technicalrequestitems_1_c
                    ON tri_technicalrequestitems.id = aos_products_tri_technicalrequestitems_1_c.aos_produc39c3stitems_idb
                    AND aos_products_tri_technicalrequestitems_1_c.deleted = 0
                LEFT JOIN aos_products
                    ON aos_products.id = aos_products_tri_technicalrequestitems_1_c.aos_products_tri_technicalrequestitems_1aos_products_ida
                    AND aos_products.deleted = 0
                LEFT JOIN aos_products_cstm
                    ON aos_products.id = aos_products_cstm.id_c
                LEFT JOIN tr_technicalrequests_opportunities_c
                    ON tr_technicalrequests.id = tr_technicalrequests_opportunities_c.tr_technicalrequests_opportunitiestr_technicalrequests_idb
                    AND tr_technicalrequests_opportunities_c.deleted = 0
                LEFT JOIN opportunities
                    ON tr_technicalrequests_opportunities_c.tr_technicalrequests_opportunitiesopportunities_ida = opportunities.id 
                    AND opportunities.deleted = 0
                LEFT JOIN opportunities_cstm
                    ON opportunities.id = opportunities_cstm.id_c
            ";

            // TR #
            $result['where'] = str_replace('technical_request_number_non_db', 'tr_technicalrequests_cstm.technicalrequests_number_c', $result['where']);
            $result['where'] = str_replace('technical_request_site_non_db', 'tr_technicalrequests.site', $result['where']);
            $result['where'] = str_replace("tr_technicalrequests_cstm.technicalrequests_number_c like '{$_REQUEST['technical_request_number_non_db_advanced']}%'", "tr_technicalrequests_cstm.technicalrequests_number_c IN ({$_REQUEST['technical_request_number_non_db_advanced']})", $result['where']);
            $result['order_by'] = str_replace('technical_request_number_non_db', 'tr_technicalrequests_cstm.technicalrequests_number_c', $result['order_by']);

            // TR Version #
            $result['order_by'] = str_replace('technical_request_version_non_db', 'tr_technicalrequests_cstm.version_c', $result['order_by']);

            // Product Name
            $result['order_by'] = str_replace('technical_request_product_name_non_db', 'aos_products.name', $result['order_by']);

            // Account Name
            $result['order_by'] = str_replace('technical_request_account_name_non_db', 'accounts.name', $result['order_by']);

            // Opp ID #
            $result['where'] = str_replace('technical_request_opportunity_number_non_db', 'opportunities_cstm.oppid_c', $result['where']);
            $result['order_by'] = str_replace('technical_request_opportunity_number_non_db', 'opportunities_cstm.oppid_c', $result['order_by']);

            // Filter query results based on logged user's TR Item - TR Security Group Account Access
            if (! $current_user->is_admin) {
                if (SecurityGroupHelper::checkIfUserExistsInAccountOrDivisionAccessSecurityGroup()) {
                    $result['from'] = "{$result['from']} 
                        LEFT JOIN securitygroups_records
                                ON securitygroups_records.record_id = tr_technicalrequests.id
                                AND securitygroups_records.module = 'TR_TechnicalRequests'
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
        } else {
            if (! $return_array && isset($_REQUEST['entryPoint']) && $_REQUEST['entryPoint'] == 'export') {
                $result = str_replace(
                    'where', 
                    'LEFT JOIN tr_technicalrequests_cstm
                        ON jt4.id = tr_technicalrequests_cstm.id_c
                    LEFT JOIN tr_technicalrequests_opportunities_c
                        ON jt4.id = tr_technicalrequests_opportunities_c.tr_technicalrequests_opportunitiestr_technicalrequests_idb
                        AND tr_technicalrequests_opportunities_c.deleted = 0
                    LEFT JOIN opportunities
                        ON tr_technicalrequests_opportunities_c.tr_technicalrequests_opportunitiesopportunities_ida = opportunities.id 
                        AND opportunities.deleted = 0
                    LEFT JOIN opportunities_cstm
                        ON opportunities.id = opportunities_cstm.id_c where',
                     $result
                );
                $result = str_replace('technical_request_number_non_db', 'tr_technicalrequests_cstm.technicalrequests_number_c', $result);
                $result = str_replace('technical_request_site_non_db', 'jt4.site', $result);
                $result = str_replace('technical_request_version_non_db', 'tr_technicalrequests_cstm.version_c', $result);
                $result = str_replace('technical_request_product_name_non_db', 'aos_products.name', $result);
                $result = str_replace('technical_request_account_name_non_db', 'accounts.name', $result);
                $result = str_replace('technical_request_opportunity_number_non_db', 'opportunities_cstm.oppid_c', $result);
            }
        }
        
        return $result;
    }
	
    public function save($check_notify = false)
    {
        $check_notify = false; // Disable out of the box notifications for this module
        return parent::save($check_notify);
    }
}