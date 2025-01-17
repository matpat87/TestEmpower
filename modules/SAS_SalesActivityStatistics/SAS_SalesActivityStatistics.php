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


class SAS_SalesActivityStatistics extends Basic
{
    public $new_schema = true;
    public $module_dir = 'SAS_SalesActivityStatistics';
    public $object_name = 'SAS_SalesActivityStatistics';
    public $table_name = 'sas_salesactivitystatistics';
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
        global $log, $current_user;

        $salesActivityStatisticQuery = new SalesActivityStatisticsQuery();

        $return_array = Array();

        $return_array['select'] = $salesActivityStatisticQuery->get_select_query();

        $from_query = $salesActivityStatisticQuery->get_from_query();                               

        $return_array['from'] = $from_query;
        
        if($where) {
            $where = ' AND ' . $where;    
            $where = str_replace('sas_salesactivitystatistics_cstm.assigned_to', 'users.id', $where);
            $where = str_replace('department', 'users.department', $where);
            $where = str_replace('sales_group_c', 'users_cstm.sales_group_c', $where);
            $where = str_replace('division_c', 'users_cstm.division_c', $where);
            $where = str_replace('status', 'users.status', $where);
            
            // Division - Start
            $arrayDivisions = array();
            $dropdownDivisionList = getDivisionsForReports();
          
            foreach ($dropdownDivisionList as $key => $value) {
                if($value != 'All') {
                    array_push($arrayDivisions, "'" . $key . "'");
                }
            }
            $stringDivisions = implode(', ', $arrayDivisions);

            if($stringDivisions) {
                $where = str_replace("users_cstm.division_c in ('All')", "users_cstm.division_c in (".$stringDivisions.")", $where);
            }
            // Division - End

            // Department - Start
            $arrayDepartments = array();
            $dropdownDepartmentList = getDepartmentsForReports();
          
            foreach ($dropdownDepartmentList as $key => $value) {
                if($value != 'All') {
                    array_push($arrayDepartments, "'" . $key . "'");
                }
            }
            $stringDepartments = implode(', ', $arrayDepartments);

            if($stringDepartments) {
                $where = str_replace("users.department in ('All')", "users.department in (".$stringDepartments.")", $where);
            }
            // Department - End

            // Sales Group - Start
            $arraySalesGroups = array();
            $dropdownSalesGroupList = getSalesGroupForReports();

            foreach ($dropdownSalesGroupList as $key => $value) {
                if($value != 'All') {
                    array_push($arraySalesGroups, "'" . $key . "'");
                }
            }
            $stringSalesGroups = implode(', ', $arraySalesGroups);
            
            if($stringSalesGroups) {
                $where = str_replace("users_cstm.sales_group_c in ('All')", "users_cstm.sales_group_c in (".$stringSalesGroups.")", $where);
            }
            // Sales Group - End
            
            $explodeWhere = explode("AND ", $where);
            $dateRangeArray = array();

            // Loop through $explodedWhere and remove date_from and date_to from $where 
            // This is to better handle the date filters on SalesActivityStatisticsQuery.php by appending condition if it exists on $_REQUEST
            foreach ($explodeWhere as $key => $value) {
                if (strpos($value, 'date_from') !== false || strpos($value, 'date_to') !== false) {
                    $where = str_replace("AND {$value}", "", $where);
                }
            }

            $return_array['where'] = $where;
        } else {
            $return_array['where'] = " AND 1=0 ";
        }
        
        if(!empty($order_by) && strpos($order_by, 'date_entered') !== false) {
            $order_by = string_replace_all("date_entered DESC", "user_non_db ASC", $order_by);
        }
        
        $return_array['order_by'] = " GROUP BY users.id ORDER BY {$order_by}";

        $_SESSION['SalesActivityStatisticQuery'] = $return_array;
        return $return_array;

    }
}