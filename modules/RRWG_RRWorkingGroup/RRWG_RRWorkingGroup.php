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


class RRWG_RRWorkingGroup extends Basic
{
    public $new_schema = true;
    public $module_dir = 'RRWG_RRWorkingGroup';
    public $object_name = 'RRWG_RRWorkingGroup';
    public $table_name = 'rrwg_rrworkinggroup';
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
    public $rr_roles;
    public $parent_name;
    public $parent_type;
    public $parent_id;
    public $division;
    public $notification_type;
	
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
        global $log;

        $result = parent::create_new_list_query($order_by, $where, $filter, $params, $show_deleted, $join_type, $return_array, $parentbean, $singleSelect, $ifListForExport);
        
        // Need to return core create_new_list_query for other modules tapping into RR Workgroup to prevent query issues
        if ($_REQUEST['module'] !== 'RRWG_RRWorkingGroup') {
            return $result;
        }

        if ($return_array) {
            $result['where'] = str_replace(
                "where", 
                "LEFT JOIN rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c
                    ON rrwg_rrworkinggroup.id = rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c.rrq_regulaffdanggroup_idb
                    AND rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c.deleted = 0
                LEFT JOIN rrq_regulatoryrequests
                    ON rrq_regulatoryrequests.id = rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c.rrq_regula2443equests_ida
                    AND rrq_regulatoryrequests.deleted = 0
                LEFT JOIN rrq_regulatoryrequests_cstm
                    ON rrq_regulatoryrequests.id = rrq_regulatoryrequests_cstm.id_c
                WHERE",
                $result['where']
            );
    
            $result['where'] = str_replace("regulatory_request_status_non_db", "rrq_regulatoryrequests_cstm.status_c", $result['where']);
            

            $result['where'] = str_replace(
                "full_name_non_db", 
                "(CASE
                    WHEN rrwg_rrworkinggroup.parent_type = 'Users' THEN (SELECT CONCAT(users.first_name, ' ', users.last_name) FROM users WHERE users.id = rrwg_rrworkinggroup.parent_id LIMIT 1)
                    WHEN rrwg_rrworkinggroup.parent_type = 'Contacts' THEN (SELECT CONCAT(contacts.first_name, ' ', contacts.last_name) FROM contacts WHERE contacts.id = rrwg_rrworkinggroup.parent_id LIMIT 1)
                    ELSE rrwg_rrworkinggroup.name
                END)", 
                $result['where']
            );
            
            $result['order_by'] = str_replace(
                "full_name_non_db", 
                "(CASE
                    WHEN rrwg_rrworkinggroup.parent_type = 'Users' THEN (SELECT CONCAT(users.first_name, ' ', users.last_name) FROM users WHERE users.id = rrwg_rrworkinggroup.parent_id LIMIT 1)
                    WHEN rrwg_rrworkinggroup.parent_type = 'Contacts' THEN (SELECT CONCAT(contacts.first_name, ' ', contacts.last_name) FROM contacts WHERE contacts.id = rrwg_rrworkinggroup.parent_id LIMIT 1)
                    ELSE rrwg_rrworkinggroup.name
                END)", 
                $result['order_by']
            );
        } else {
            $result = str_replace(
                "where", 
                "LEFT JOIN rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c
                    ON rrwg_rrworkinggroup.id = rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c.rrq_regulaffdanggroup_idb
                    AND rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c.deleted = 0
                LEFT JOIN rrq_regulatoryrequests
                    ON rrq_regulatoryrequests.id = rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c.rrq_regula2443equests_ida
                    AND rrq_regulatoryrequests.deleted = 0
                LEFT JOIN rrq_regulatoryrequests_cstm
                    ON rrq_regulatoryrequests.id = rrq_regulatoryrequests_cstm.id_c
                WHERE",
                $result
            );
    
            $result = str_replace("regulatory_request_status_non_db", "rrq_regulatoryrequests_cstm.status_c", $result);

            $result = str_replace(
                "full_name_non_db", 
                "(CASE
                    WHEN rrwg_rrworkinggroup.parent_type = 'Users' THEN (SELECT CONCAT(users.first_name, ' ', users.last_name) FROM users WHERE users.id = rrwg_rrworkinggroup.parent_id LIMIT 1)
                    WHEN rrwg_rrworkinggroup.parent_type = 'Contacts' THEN (SELECT CONCAT(contacts.first_name, ' ', contacts.last_name) FROM contacts WHERE contacts.id = rrwg_rrworkinggroup.parent_id LIMIT 1)
                    ELSE rrwg_rrworkinggroup.name
                END)", 
                $result
            );
        }

        return $result;
    }
}