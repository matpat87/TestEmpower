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


class SAR_SalesActivityReport extends Basic
{
    public $new_schema = true;
    public $module_dir = 'SAR_SalesActivityReport';
    public $object_name = 'SAR_SalesActivityReport';
    public $table_name = 'sar_salesactivityreport';
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
        global $log;

        $salesActivityReportQuery = new SalesActivityReportQuery();

        $return_array = Array();

        $return_array['select'] = $salesActivityReportQuery->get_select_query();   
        $return_array['from'] = $salesActivityReportQuery->get_from_query();                               
        $return_array['where'] = " order by ";    
        $return_array['order_by'] = ' ';
        $contains = false;

        if(!empty($where))
        {
            if(strpos($where, 'assigned_to_c') !== false)
            {
                $where = str_replace('assigned_to_c', "CONCAT(u.first_name, ' ', u.last_name)", $where);
                $contains = true;
            }

            if(strpos($where, 'assigned_account_c') !== false)
            {
                $where = str_replace('assigned_account_c', "a.name", $where);
                $contains = true;
            }

            if(strpos($where, 'sar_salesactivityreport_cstm.activity_type_c IS NULL') !== false)
            {
                $where = string_replace_all("sar_salesactivityreport_cstm.activity_type_c IS NULL", "sar_salesactivityreport_cstm.activity_type_c IS NULL OR 1=1", $where);
            }

            if(strpos($where, 'sar_salesactivityreport_cstm.activity_type_c') !== false ||
                strpos($where, 'sar_salesactivityreport_cstm.activity_type_c IS NULL') !== false)
            {
                $where = string_replace_all('sar_salesactivityreport_cstm.activity_type_c', "activity.type", $where);
                $contains = true;
            }

            if(strpos($where, 'sar_salesactivityreport_cstm.related_to_c IS NULL') !== false)
            {
                $where = str_replace('sar_salesactivityreport_cstm.related_to_c IS NULL', "sar_salesactivityreport_cstm.related_to_c IS NULL OR 1=1", $where);
                $contains = true;
            }

            if(strpos($where, 'sar_salesactivityreport_cstm.related_to_c') !== false)
            {
                $where = str_replace('sar_salesactivityreport_cstm.related_to_c', "activity.parent_type", $where);
                $contains = true;
            }

            if(strpos($where, 'sar_salesactivityreport_cstm.date_from_c') !== false)
            {
                $where = string_replace_all("sar_salesactivityreport_cstm.date_from_c,'%Y-%m-%d') =", "activity.date,'%Y-%m-%d') >=", $where);
                $contains = true;
            }

            if(strpos($where, 'sar_salesactivityreport_cstm.date_to_c') !== false)
            {
                $where = string_replace_all("sar_salesactivityreport_cstm.date_to_c,'%Y-%m-%d') =", "activity.date,'%Y-%m-%d') <=", $where);
                $contains = true;
            }

            if($contains)
            {
                $return_array['where'] = 'where ' . $where;
                $return_array['where'] .= ' order by ';
            }
        }

        if(!empty($order_by) && strpos($order_by, 'date_entered') !== false)
        {
            $order_by = string_replace_all("date_entered", "date_start_c", $order_by);
        }

        $return_array['order_by'] = $order_by;

        $_SESSION['SalesActivityReportQuery'] = $return_array;

        return $return_array;

    }
	
}
