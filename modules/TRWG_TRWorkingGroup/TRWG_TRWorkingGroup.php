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


class TRWG_TRWorkingGroup extends Basic
{
    public $new_schema = true;
    public $module_dir = 'TRWG_TRWorkingGroup';
    public $object_name = 'TRWG_TRWorkingGroup';
    public $table_name = 'trwg_trworkinggroup';
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
    public $tr_roles;
    public $parent_name;
    public $parent_type;
    public $parent_id;
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
        
        // Need to return core create_new_list_query for other modules tapping into TR Workgroup to prevent query issues
        if ($_REQUEST['module'] !== 'TRWG_TRWorkingGroup') {
            return $result;
        }

        if ($return_array) {
            $result['where'] = str_replace(
                "where", 
                "LEFT JOIN tr_technicalrequests_trwg_trworkinggroup_1_c
                    ON trwg_trworkinggroup.id = tr_technicalrequests_trwg_trworkinggroup_1_c.tr_technic7dfcnggroup_idb
                    AND tr_technicalrequests_trwg_trworkinggroup_1_c.deleted = 0
                LEFT JOIN tr_technicalrequests
                    ON tr_technicalrequests.id = tr_technicalrequests_trwg_trworkinggroup_1_c.tr_technic9742equests_ida
                    AND tr_technicalrequests.deleted = 0
                WHERE",
                $result['where']
            );
    
            $result['where'] = str_replace("technical_request_sales_stage_non_db", "tr_technicalrequests.approval_stage", $result['where']);
            

            $result['where'] = str_replace(
                "full_name_non_db", 
                "(CASE
                    WHEN trwg_trworkinggroup.parent_type = 'Users' THEN (SELECT CONCAT(users.first_name, ' ', users.last_name) FROM users WHERE users.id = trwg_trworkinggroup.parent_id LIMIT 1)
                    WHEN trwg_trworkinggroup.parent_type = 'Contacts' THEN (SELECT CONCAT(contacts.first_name, ' ', contacts.last_name) FROM contacts WHERE contacts.id = trwg_trworkinggroup.parent_id LIMIT 1)
                    ELSE trwg_trworkinggroup.name
                END)", 
                $result['where']
            );
            
            $result['order_by'] = str_replace(
                "full_name_non_db", 
                "(CASE
                    WHEN trwg_trworkinggroup.parent_type = 'Users' THEN (SELECT CONCAT(users.first_name, ' ', users.last_name) FROM users WHERE users.id = trwg_trworkinggroup.parent_id LIMIT 1)
                    WHEN trwg_trworkinggroup.parent_type = 'Contacts' THEN (SELECT CONCAT(contacts.first_name, ' ', contacts.last_name) FROM contacts WHERE contacts.id = trwg_trworkinggroup.parent_id LIMIT 1)
                    ELSE trwg_trworkinggroup.name
                END)", 
                $result['order_by']
            );
        } else {
            $result = str_replace(
                "where", 
                "LEFT JOIN tr_technicalrequests_trwg_trworkinggroup_1_c
                    ON trwg_trworkinggroup.id = tr_technicalrequests_trwg_trworkinggroup_1_c.tr_technic7dfcnggroup_idb
                    AND tr_technicalrequests_trwg_trworkinggroup_1_c.deleted = 0
                LEFT JOIN tr_technicalrequests
                    ON tr_technicalrequests.id = tr_technicalrequests_trwg_trworkinggroup_1_c.tr_technic9742equests_ida
                    AND tr_technicalrequests.deleted = 0
                WHERE",
                $result
            );
    
            $result = str_replace("technical_request_sales_stage_non_db", "tr_technicalrequests.approval_stage", $result);

            $result = str_replace(
                "full_name_non_db", 
                "(CASE
                    WHEN trwg_trworkinggroup.parent_type = 'Users' THEN (SELECT CONCAT(users.first_name, ' ', users.last_name) FROM users WHERE users.id = trwg_trworkinggroup.parent_id LIMIT 1)
                    WHEN trwg_trworkinggroup.parent_type = 'Contacts' THEN (SELECT CONCAT(contacts.first_name, ' ', contacts.last_name) FROM contacts WHERE contacts.id = trwg_trworkinggroup.parent_id LIMIT 1)
                    ELSE trwg_trworkinggroup.name
                END)", 
                $result
            );
        }

        return $result;
    }
}
