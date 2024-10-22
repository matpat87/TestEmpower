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


class jacka_DashboardAppend extends Basic
{
    public $new_schema = true;
    public $module_dir = 'jacka_DashboardAppend';
    public $object_name = 'jacka_DashboardAppend';
    public $table_name = 'jacka_dashboardappend';
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
    public $dashboards_to_deploy;
    public $current_dashboard_enum;

    public function bean_implements($interface)
    {
        switch ($interface) {
            case 'ACL':
                return true;
        }

        return false;
    }


    /**
     * @return array|mixed|void
     */
    public function retrieveDashboardsEnum()
    {
       global $db;

      if ($_REQUEST['action'] != 'DetailView' && $_REQUEST['action'] != 'EditView' ) {
            return;
        }

//      if (!empty($this->current_dashboard_enum)) {
//          return $this->current_dashboard_enum;
//      }


        $sql = "SELECT uf.id, uf.assigned_user_id, uf.contents, u.first_name, u.last_name
         FROM user_preferences uf
         JOIN users u
             ON uf.assigned_user_id = u.id
            AND uf.deleted = 0
            AND u.deleted = 0
            AND u.status = 'Active'
            AND uf.category = 'Home'
            ORDER BY u.first_name ASC";

        $result = $db->query($sql);

        $this->current_dashboard_enum = [];

        while ($row = $db->fetchByAssoc($result)) {
            $this->current_dashboard_enum = $this->parseUserContents($row, $this->current_dashboard_enum);
        }

        return $this->current_dashboard_enum;
    }

    /**
     * @param $contents
     * @param $enum
     *
     * @return mixed
     */
    public function parseUserContents($user_pref, $enum)
    {
        global $local;
        $count = 0;

        $dashboards = $this->getDashboardArray($user_pref['contents']);
        $user_name = $this->getName($user_pref);

        if (!$dashboards['pages']) {
            return $enum;
        }
        foreach ($dashboards['pages'] as $dashboard) {
            $GLOBALS['log']->fatal('Dash Name= ' . $dashboard['pageTitle']);
            $key = $user_pref['assigned_user_id'].'_'.$count;


            $title = $this->getDashboardName($dashboard) . ' (' . $count . ')';

            $enum[$key] = $user_name . ' - ' . $title;
            $count++;
        }


        return $enum;
    }


    /**
     * Unserializes and returns formatted dashboards
     * @param $contents
     *
     * @return mixed
     */
    public function getDashboardArray($contents)
    {
        $data_array = unserialize(base64_decode($contents));

        return $data_array;
    }

    public function getName($row)
    {
        global $locale;
        $full_name = $locale->getLocaleFormattedName($row['first_name'], $row['last_name'], '');

        return $full_name;
    }


    public function getDashboardName($dashboard)
    {
        // Get the dashboard name. First dashboard is always named SUITE DASHBOARD
        $title = ($dashboard['pageTitle']) ? $dashboard['pageTitle'] : $GLOBALS['app_strings']['LBL_SUITE_DASHBOARD'];
        return $title;
    }

}
