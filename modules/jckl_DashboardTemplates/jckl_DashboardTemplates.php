<?php
/**
 * @noinspection PhpUndefinedClassInspection
 * phpcs:disable Generic.ControlStructures.InlineControlStructure.NotAllowed
 * phpcs:disable PSR1.Files.SideEffects
 * phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
 * phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps
 * phpcs:disable PSR2.Files.ClosingTag.NotAllowed
 */
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 ********************************************************************************/

/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/jckl_DashboardTemplates/jckl_DashboardTemplates_sugar.php');

class jckl_DashboardTemplates extends jckl_DashboardTemplates_sugar
{

    public $encoded_pages;
    public $encoded_content;
    public $deployed_to_users;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Process list of users, roles, or groups
     *
     * @param $deploy_ids
     *
     * @return bool|int
     */
    public function deploy($deploy_ids)
    {
        // Get Users List
        $users = $this->getUsersArray($deploy_ids);

        $has_users = $this->checkUsers($users);

        if ($has_users) {
            $result = $this->deployToUsers($users);
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * @param $users
     *
     * @return int
     */
    protected function deployToUsers($users)
    {
        $template = new jckl_DashboardTemplates();
        $template->retrieve($_REQUEST['template']);

        $this->backupUsersDashboard($users, $template);
        $this->encoded_pages = $template->encoded_pages;
        $this->encoded_content = $template->encoded_content;

        $unencoded_pages = unserialize(base64_decode($this->encoded_pages));
        $unencoded_content = unserialize(base64_decode($this->encoded_content));
        $i = 0;
        foreach ($users as $user_id) {
            $user = new User();
            $user->retrieve($user_id);

            $contents = array_merge(
                ['dashlets' => $unencoded_content],
                ['pages' => $unencoded_pages]
            );
            require_once('modules/UserPreferences/UserPreference.php');

            //Update 2017-05-08 fix global settings override.
            $focus = new UserPreference($user);
            $result = $focus->retrieve_by_string_fields([
                'assigned_user_id' => $user->id,
                'category'         => 'Home',
            ]);
            $focus->assigned_user_id = $user->id; // MFH Bug #13862
            $focus->deleted = 0;
            $focus->contents = base64_encode(serialize($contents));
            $focus->category = 'Home';
            unset($_SESSION[$user->user_name."_PREFERENCES"]['Home']);

            $focus->save();

//                $user->setPreference('pages', $unencoded_pages, 0, 'Home');
//                $user->setPreference('dashlets', $unencoded_content,0,'Home');
//                $user->savePreferencesToDB();
            $this->saveDeployment($user, $template, $focus->contents);
            $i++;
        }

        return $i;
    }

    /**
     * Backup each user dashboard before deploying
     *
     * @param $users
     * @param $template
     */
    protected function backupUsersDashboard($users, $template)
    {
        global $current_user;
        foreach ($users as $user_id) {
            require_once('modules/Users/User.php');

            //Load User bean
            $user = new User();
            $user->retrieve($user_id);

            //Encode the user preferences for database storage.

            $encoded_pages
                = base64_encode(
                    serialize($user->getPreference('pages', 'Home'))
                );
            $encoded_content
                = base64_encode(
                    serialize($user->getPreference('dashlets', 'Home'))
                );

            require_once('modules/jckl_DashboardDeployments/jckl_DashboardDeployments.php');

            $deployment = new jckl_DashboardDeployments();
            $deployment->name = 'Backup: '.$template->name.' - '
                .$user->user_name;
            $deployment->assigned_user_id = $user->id;
            $deployment->encoded_pages = $encoded_pages;
            $deployment->encoded_content = $encoded_content;
            $deployment->user_id_c = $current_user->id;
            $deployment->save();

            $relationship = 'jckl_dashboarddeployments_jckl_dashboardtemplates';
            $deployment->load_relationship($relationship);
            $deployment->$relationship->add($template->id);
            $deployment->save();
        }
    }

    /**
     * Save deployment record
     * @param $user
     * @param $template
     * @param $contents
     */
    protected function saveDeployment($user, $template, $contents)
    {
        global $current_user;
        require_once('modules/jckl_DashboardDeployments/jckl_DashboardDeployments.php');

        $deployment = new jckl_DashboardDeployments();
        $deployment->name = $template->name.' - '.$user->user_name;
        $deployment->assigned_user_id = $user->id;
        $deployment->encoded_pages = $template->encoded_pages;
        $deployment->encoded_content = $contents;
        $deployment->user_id_c = $current_user->id;
        $deployment->save();

        $relationship = 'jckl_dashboarddeployments_jckl_dashboardtemplates';
        $deployment->load_relationship($relationship);
        $deployment->$relationship->add($template->id);
        $deployment->save();
    }

    /**
     * Check if there are any users selected
     *
     * @param $users
     *
     * @return bool
     */
    protected function checkUsers($users)
    {
        $count = count($users);

        $valid = false;

        if ($count > 0) {
            $valid = true;
        }

        return $valid;
    }


    /**
     * Return array of users depending on whether we
     * are deploying to users, roles, or groups
     *
     * @param $deploy_ids
     *
     * @return array
     */
    protected function getUsersArray($deploy_ids)
    {

        $deploy_to = $_REQUEST['deploy_type'];
        $users = [];

        if ($deploy_to == 'role') {
            $users = $this->getUsersFromRoles($deploy_ids);
        } elseif ($deploy_to == 'group') {
            $users = $this->getUsersFromGroups($deploy_ids);
        } else {
            $users = $deploy_ids;
        }


        return $users;
    }


    /**
     * Query to get arrar of users if deploying to groups
     *
     * @param $deploy_ids
     *
     * @return array
     */
    protected function getUsersFromGroups($deploy_ids)
    {
        global $db;

        $temp_data = [];
        foreach ($deploy_ids as $deploy_id) {
            $temp_data[] = "'".$deploy_id."'";
        }

        $in_string = implode(',', $temp_data);

        $sql = "SELECT su.user_id
                    FROM securitygroups_users su
                    LEFT JOIN users u ON su.user_id = u.id 
                    WHERE su.securitygroup_id IN ($in_string)
                    AND su.deleted = 0
                    AND u.deleted = 0";

        $GLOBALS['log']->debug("jckl_DashboardTemplates::getUsersFromGroups Query: $sql");

        $results = $db->query($sql);

        $users = [];

        while ($row = $db->fetchByAssoc($results)) {
            $users[] = $row['user_id'];
        }

        return $users;
    }

    /**
     * Query to get array of users if deploying to roles
     *
     * @param $deploy_ids
     *
     * @return array
     */
    protected function getUsersFromRoles($deploy_ids)
    {
        global $db;

        $temp_data = [];
        foreach ($deploy_ids as $deploy_id) {
            $temp_data[] = "'".$deploy_id."'";
        }

        $in_string = implode(',', $temp_data);

        $sql = "SELECT aru.user_id 
                    FROM acl_roles_users aru
                    LEFT JOIN users u ON aru.user_id = u.id 
                    WHERE aru.role_id IN ($in_string)
                    AND aru.deleted = 0
                    AND u.deleted = 0";

        $GLOBALS['log']->debug("jckl_DashboardTemplates::getUsersFromRoles Query: $sql");

        $results = $db->query($sql);

        $users = [];

        while ($row = $db->fetchByAssoc($results)) {
            $users[] = $row['user_id'];
        }

        return $users;
    }


    /**
     * Update template content from the assigned to user settings.
     *
     * @param $user_id
     *
     * @throws Exception
     */
    public function updateEncodedData($user_id)
    {
        global $current_user;
        //DB Datetimestamp
        $date = new SugarDateTime();
        $now = $date->asDb(true);

        require_once('modules/Users/User.php');

        //Load User bean
        $user = new User();
        $user->retrieve($user_id);

        //Encode the user preferences for database storage.
        $encoded_pages = base64_encode(
            serialize($user->getPreference('pages', 'Home'))
        );
        $encoded_content
            = base64_encode(
                serialize($user->getPreference('dashlets', 'Home'))
            );

        $this->encoded_content = $encoded_content;
        $this->encoded_pages = $encoded_pages;
        $this->data_last_refreshed = $now;
    }


    /**
     * Append dashboards to selected users
     *
     * @param $deploy_ids
     *
     * @return bool|int
     */
    public function appendDashboard($deploy_ids)
    {
        // Get list of users
        $users = $this->getUsersArray($deploy_ids);
        $has_users = $this->checkUsers($users);

        $template = new jacka_DashboardAppend();
        $template->retrieve($_REQUEST['template']);
        if ($has_users) {
            $result = $this->appendToUsers($users, $template);
        } else {
            $result = false;
        }

        return $result;
    }


    public function appendToUsers($users, $template)
    {
        // Get data from dashboards
        // Selected dashboards will be an array of dashboards identified by
        // <user_id>_<place_of_dashboard_tab_for_user>
        $selected_dashboards
            = unencodeMultienum($template->dashboards_to_deploy);

        $i = 0;
        foreach ($selected_dashboards as $key) {
            $extraction_array = explode('_', $key);
            $source_user_id = $extraction_array[0];
            $dashboard_tab = $extraction_array[1];

            $info = $this->getDasbhoardInfoFromUserTab(
                $source_user_id,
                $dashboard_tab
            );

            foreach ($users as $user_id) {
                $user = new User();
                $user->retrieve($user_id);

                require_once('modules/UserPreferences/UserPreference.php');

                //Update 2017-05-08 fix global settings override.
                $focus = new UserPreference($user);
                $dashboards = $focus->getPreference('dashlets', 'Home');
                $pages = $focus->getPreference('pages', 'Home');

                $pages[] = $info['pages'];
                $dashboards = array_merge($dashboards, $info['dashboards']);

                $contents = array_merge(
                    ['dashlets' => $dashboards],
                    ['pages' => $pages]
                );

                $result = $focus->retrieve_by_string_fields([
                    'assigned_user_id' => $user->id,
                    'category'         => 'Home',
                ]);
                $focus->assigned_user_id = $user->id; // MFH Bug #13862
                $focus->deleted = 0;
                $focus->contents = base64_encode(serialize($contents));
                $focus->category = 'Home';

                unset($_SESSION[$user->user_name."_PREFERENCES"]['Home']);
                unset($_SESSION[$user->user_name."_PREFERENCES"]['dashboards']);
                unset($_SESSION[$user->user_name."_PREFERENCES"]['pages']);

                $focus->save();
                $this->addAlertForUser($user_id);

                $i++;
            }
        }

        return $i;
    }


    /**
     * Retrieve Dashboards and Pages for specific user for a specific tab #
     *
     * @param $user_id
     * @param $tab_number
     *
     * @return array|null
     */
    public function getDasbhoardInfoFromUserTab($user_id, $tab_number)
    {
        require_once('modules/UserPreferences/UserPreference.php');

        $user = new User();
        $user->retrieve($user_id);
        $focus = new UserPreference($user);
        $dashboards = $focus->getPreference('dashlets', 'Home');
        $pages = $focus->getPreference('pages', 'Home');

        if (is_array($pages[$tab_number])) {
            // Retrieve Dashboards to copy
            $dashlets = [];
            foreach ($pages[$tab_number]['columns'] as $column) {
                $dashlets = array_merge($dashlets, $column['dashlets']);
            }

            $return_dashboards = [];
            foreach ($dashlets as $key => $value) {
                if (array_key_exists($value, $dashboards)) {
                    $return_dashboards[$value] = $dashboards[$value];
                }
            }

            return [
                'pages' => $pages[$tab_number],
                'dashboards' => $return_dashboards,
            ];
        } else {
            return null;
        }
    }

    /**
     * Creates a new Alert Record
     *
     * @param $user_id
     */
    public function addAlertForUser($user_id)
    {
        global $suitecrm_version;
        /**
         * Alerts were introduced in Suite 7.3
         */
        if (version_compare($suitecrm_version, '7.3') < 0) {
            return;
        } else {
            if (!in_array($this->deployed_to_users, $user_id)) {
                $alert = BeanFactory::newBean('Alerts');
                $alert->name = 'New Dashboards';
                $alert->description = 'You have been assigned new Dashboards. 
                Logout and back in to see them';
                $alert->url_redirect = 'index.php';
                $alert->target_module = 'Home';
                $alert->assigned_user_id = $user_id;
                $alert->type = 'info';
                $alert->is_read = 0;
                $alert->save();

                $this->deployed_to_users[] = $user_id;
            }
        }
    }
}

?>

