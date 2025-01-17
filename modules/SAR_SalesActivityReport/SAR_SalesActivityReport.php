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
        global $log, $current_user;

        $salesActivityReportQuery = new SalesActivityReportQuery();

        $return_array = Array();

        $return_array['select'] = $salesActivityReportQuery->get_select_query();   
        $from_query = $salesActivityReportQuery->get_from_query();                               
        $return_array['where'] = " ";    
        $contains = false;
        
        $securityGroupBean = BeanFactory::getBean('SecurityGroups');
        $security_groups_assiged = $securityGroupBean->retrieve_by_string_fields(array('assigned_user_id' => $current_user->id, 'type_c' => 'Sales Group'), false, false);

        if(!$current_user->is_admin)
        {
            $from_query .= " INNER JOIN users AS u 
                ON u.id = activity.assigned_user_id";

            if(!empty($security_groups_assiged)){
                $from_query .= " AND (u.id in (SELECT u.id
                                    FROM securitygroups AS s
                                    INNER JOIN securitygroups_cstm AS sc
                                        ON sc.id_c = s.id
                                    INNER JOIN securitygroups_users AS su
                                        ON su.securitygroup_id = s.id
                                        AND su.deleted = 0
                                    INNER JOIN users AS u
                                        ON u.id = su.user_id
                                        AND u.deleted = 0
                                    WHERE s.deleted = 0
                                        AND sc.type_c = 'Sales Group'
                                        AND s.assigned_user_id = '{$current_user->id}')

                                        OR u.id = '{$current_user->id}') ";
            }
            else{
                $from_query .= " AND u.id = '{$current_user->id}' ";
            }
        }
        else
        {
            $from_query .= " LEFT JOIN users AS u 
                ON u.id = activity.assigned_user_id ";
        }

        $from_query .= " LEFT JOIN users_cstm AS uc
                            ON u.id = uc.id_c
                         LEFT JOIN accounts as a
                            ON (a.id = activity.parent_id AND activity.parent_type = 'Accounts')
                                OR a.id = (
                                    SELECT account_id
                                    FROM accounts_opportunities
                                    WHERE deleted = 0
                                        and opportunity_id = o.id
                                    LIMIT 1
                                )
                                OR a.id = (
                                    SELECT bean_id
                                    from emails_beans
                                    where deleted = 0 
                                        and email_id = activity.id
                                        and bean_module = 'Accounts'
                                        and activity.type = 'Email'
                                    LIMIT 1
                                ) ";

        $return_array['from'] = $from_query;
        
        if(!empty($where))
        {

            if(strpos($where, 'sar_salesactivityreport_cstm.assigned_to_c') !== false)
            {
                $where = string_replace_all('sar_salesactivityreport_cstm.assigned_to_c', "u.id", $where);
                $contains = true;
            }

            if(strpos($where, 'sar_salesactivityreport_cstm.assigned_account_c') !== false)
            {
                $where = string_replace_all('sar_salesactivityreport_cstm.assigned_account_c', "a.id", $where);
                $contains = true;
            }

            if(strpos($where, 'sar_salesactivityreport_cstm.activity_type_c IS NULL') !== false)
            {
                $where = string_replace_all("sar_salesactivityreport_cstm.activity_type_c IS NULL", "sar_salesactivityreport_cstm.activity_type_c IS NULL OR 1=1", $where);
            }

            if(strpos($where, "sar_salesactivityreport_cstm.activity_type_c in ") !== false && $_REQUEST['activity_type_c_advanced'] != NULL)
            {
                $activityTypeRequest = array();
                $previousInFormatArr = array();
                $activityTypeNonDBArr = array();
                $noActivityTypeModuleArr = array();

                // format Activity and Activity Type (if any) into an assoc array
                foreach ($_REQUEST['activity_type_c_advanced'] as $index => $value) {
                    $splitStr = explode("_", $value); // for formats: <ActivityName_ActivityType> ex. "Meeting_InPerson"

                    $activityName = "'{$splitStr[0]}'";
                    $activityType = $splitStr[1] ?? null;

                    if (!array_key_exists($splitStr[0], $activityTypeRequest)) {
                        $activityTypeRequest[$splitStr[0]] = array();
                    }

                    if ($activityType) {
                        array_push($activityTypeRequest[$splitStr[0]], "'{$activityType}'");
                    }

                    array_push($previousInFormatArr, "'{$value}'");

                }

                $previousInFormatArr = implode(",", $previousInFormatArr);
                $activityTypeStr = " AND ";
                $hasActivityType = false;

                // format query string
                foreach ($activityTypeRequest as $activity => $activityTypeArr) {
                    if (count($activityTypeArr) > 0) {
                        $hasActivityType = true;
                        $implodedStr = implode(',', $activityTypeArr);
                        $activityTypeStr .= " ( activity.type = '{$activity}' AND activity.type_c_nondb IN ({$implodedStr})  )";

                        unset($activityTypeRequest[$activity]);
                    } else {
                        if (count($noActivityTypeModuleArr) < 1) {
                            $noActivityTypeModuleArr = array_keys($activityTypeRequest);
                        } else {
                            continue;
                        }
                    }
                }

                if (count($noActivityTypeModuleArr) > 0) {
                    $typeWhereInParameter = formatDataArrayForWhereInQuery(implode(',', $noActivityTypeModuleArr));
                    $appendOr = $hasActivityType ? ' OR ' : '';
                    $activityTypeStr .= " {$appendOr} (activity.type IN ({$typeWhereInParameter})) ";
                }

                $where = string_replace_all("AND ( sar_salesactivityreport_cstm.activity_type_c in ($previousInFormatArr))", " {$activityTypeStr} ", $where);

            }


            if(strpos($where, 'sar_salesactivityreport_cstm.activity_type_c') !== false ||
                strpos($where, 'sar_salesactivityreport_cstm.activity_type_c IS NULL') !== false)
            {
                $where = string_replace_all('sar_salesactivityreport_cstm.activity_type_c', "activity.type", $where);
                $contains = true;
            }

            if(strpos($where, 'sar_salesactivityreport_cstm.status_c') !== false)
            {
                $where = string_replace_all('sar_salesactivityreport_cstm.status_c', "activity.status", $where);
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

            if(strpos($where, 'highlights_c') !== false)
            {
                $contains = true;
            }

            if(strpos($where, 'sales_group_c') !== false)
            {
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
                    $where = str_replace("sales_group_c in ('All'", "sales_group_c in (".$stringSalesGroups, $where);
                }

                // Sales Group - End
                $contains = true;
            }

            if($contains)
            {
                $return_array['where'] = 'WHERE ' . $where . ' ';
            }
        }
        else{
            $return_array['where'] = 'WHERE 1=0 ';
        }

        if(!empty($order_by) && strpos($order_by, 'date_entered') !== false)
        {
            $order_by = string_replace_all("date_entered", "date_start_c", $order_by);
        }

        $return_array['order_by'] = ' ORDER BY ' . $order_by;

        $_SESSION['SalesActivityReportQuery'] = $return_array;

        // var_dump(parent::create_new_list_query($order_by, $where, $filter,
        //     $params, $show_deleted, $join_type,
        //     $return_array, $parentbean, $singleSelect,
        //     $ifListForExport));

        return $return_array;

    }

    function create_list_count_query($query)
    {
        $count_query = "select count(*) as c from (" . $query . ") as report_count";

        return $count_query;
    }
}
