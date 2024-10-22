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


class RRQ_RegulatoryRequests extends Basic
{
    public $new_schema = true;
    public $module_dir = 'RRQ_RegulatoryRequests';
    public $object_name = 'RRQ_RegulatoryRequests';
    public $table_name = 'rrq_regulatoryrequests';
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


    function save($check_notify = false)
    {
        // $GLOBALS['log']->fatal("extendend SugarBean save");
        parent::save(false);
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
        
        
        /**
         * Ontrack #1721 & 1691:[Custom Code] Custom Sort for Status: should be sorted numerically
         * Special Case (a): for status with no numeric equivalent, order is based on the list display from dropdown
         * Special Case (b): for regulatory request #, it should be casted to an INT for it to be sorted correctly 
         * */
        if (is_array($result) && (isset($_REQUEST['RRQ_RegulatoryRequests2_RRQ_REGULATORYREQUESTS_ORDER_BY']) || isset($_REQUEST['orderBy']))) {

            $sortByColumn = (array_key_exists('RRQ_RegulatoryRequests2_RRQ_REGULATORYREQUESTS_ORDER_BY', $_REQUEST))
                ? $_REQUEST['RRQ_RegulatoryRequests2_RRQ_REGULATORYREQUESTS_ORDER_BY'] // Clicked from list view column
                : $_REQUEST['orderBy']; // Filter set from Advanced Search ORDER BY
                
            
            $sortOrder = (array_key_exists('RRQ_RegulatoryRequests2_RRQ_REGULATORYREQUESTS_ORDER_BY', $_REQUEST))
                ? $_REQUEST['lvso']
                : $_REQUEST['sortOrder'];
                
            switch (strtolower($sortByColumn)) {
                case 'status_c':
                    /*
                     * Ontrack #1705: Custom ListView Status Sorting
                     * */
                    $result = customStatusSorting($result);
                    break;
                
                case 'id_num_c':
                    // Ontrack #1691: Cast the id_num_c db values to UNSIGNED to properly sort the data as numbers and not as varchar
                    $result['select'] .= " ,CAST(rrq_regulatoryrequests_cstm.id_num_c AS UNSIGNED) AS regulatory_request_number";
                    $result['order_by'] = " ORDER BY regulatory_request_number {$sortOrder}";
                    break;
            }
            
        } // End of Ontrack #1721 customization

        $_SESSION['create_new_list_query'] = $result; // Ontrack 1859: to be used in Generate Report functionality in RegulatoryRequestReport::class

        return $result;
    }
    
    public function mark_deleted($id)
    {
        // Override core mark_deleted function
        // custom_mark_deleted can be found on custom_utils.php
        custom_mark_deleted($this->module_dir, $id);
    }
    // APX Custom Codes -- END
	
}
