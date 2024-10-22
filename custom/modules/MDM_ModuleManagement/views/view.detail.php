<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/*********************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2010 SugarCRM Inc.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

require_once('include/MVC/View/views/view.detail.php');
require_once('modules/ACLActions/ACLAction.php');
require_once('modules/ACLRoles/ACLRole.php');

class MDM_ModuleManagementViewDetail extends ViewDetail {

    public $access_options = array(
        89 => 'Enabled',
        0 => 'Not Set',
        -98 => 'Disabled'
    );

    public $other_options = array(
        '90' => 'All',
        '80' => 'Group',
        '75' => 'Owner',
        '0' => 'Not Set',
        '-99' => 'None'
    );

    private $sortedNames = array(
        'access' => array(
            'label' => 'Access',
            'options' => array(),
        ),
        'list' => array(
            'label' => 'List View',
            'options' => array(),
        ),
        'view' => array(
            'label' => 'Detail View',
            'options' => array(),
        ),
        'edit' => array(
            'label' => 'Edit',
            'options' => array(),
        ),
        'massupdate' => array(
            'label' => 'Mass Update',
            'options' => array(),
        ),
        'import' => array(
            'label' => 'Import',
            'options' => array(),
        ),
        'export' => array(
            'label' => 'Export',
            'options' => array(),
        ),
        'delete' => array(
            'label' => 'Delete',
            'options' => array(),
        ),
    );

 	function __construct(){
 		parent::__construct();
 	}

 	function display(){
        if(empty($this->bean->id)){
            sugar_die($GLOBALS['app_strings']['ERROR_NO_RECORD']);
        }

		$this->dv->process();

        $this->include_css();
        echo $this->dv->display();

        $sugar_smarty = new Sugar_Smarty();

        $module_list = $GLOBALS['moduleList'];
        $roleList = $this->get_all_roles();


        $acl_role_actions = $this->get_acl_role_actions($this->bean->module_c);
        $data = $this->assign_actions_db($roleList, $acl_role_actions);
        
        $sugar_smarty->assign('ROLE_LIST', $roleList);
        $sugar_smarty->assign('ACTION_NAMES', $this->sortedNames);
        $sugar_smarty->assign('ACL_ROLE_ACTION_LIST', $data);

        echo $sugar_smarty->fetch('custom/modules/MDM_ModuleManagement/tpl/DetailView.tpl');
	}

    private function include_css(){
        echo '<link rel="stylesheet" href="custom/modules/MDM_ModuleManagement/css/detail.css" />';
    }

    private function get_acl_role_actions($module_name){
        global $db;
        $result = array();

        $query = "select ara.id as ara_id, ara.access_override,
                    ar.id as role_id, ar.name as role_name,
                    aa.id as action_id, aa.name as action_name
                  from acl_actions aa
                  left join acl_roles_actions ara
                    on ara.action_id = aa.id
                        and ara.deleted = 0
                  left join acl_roles ar
                    on ar.id = ara.role_id
                        and ar.deleted = 0
                  where aa.deleted = 0
                    and aa.category = '{$module_name}' ";
        $data = $db->query($query);

        while($rowData = $db->fetchByAssoc($data)){
            $result[$rowData['ara_id']] = $rowData;
        }

        return $result;
    }

    private function get_all_roles()
    {
        global $db;
        $result = array();

        $data = $db->query("select id, name, description, division
            from acl_roles 
            where deleted = 0
            order by name asc");

        while($rowData = $db->fetchByAssoc($data)){
            $result[$rowData['id']] = $rowData;
        }

        return $result;
    }

    private function assign_actions_db($roleList, $acl_role_actions){
        global $log;

        $result = array();

        $default_role_actions = ACLRole::getRoleActions('');

        $names = ACLAction::setupCategoriesMatrix($default_role_actions);

        if(!empty($acl_role_actions)){
            $i = 0;
            foreach($roleList as $role){
                $result[$role['id']]['role_id'] = $role['id'];
                $result[$role['id']]['role_name'] = $role['name'];
                $result[$role['id']]['access_list'] = array();

                $role_actions = ACLRole::getRoleActions($role['id']);

                foreach($this->sortedNames as $name => &$sortedName){
                    if($i == 0){
                        $sortedName['options'] = $default_role_actions[$this->bean->module_c]['module'][$name]['accessOptions'];
                    }
                    
                    $result[$role['id']]['access_list'][$name] = $this->assign_action($acl_role_actions, $role['id'], 
                        $role['name'], $name, $role_actions, $default_role_actions);
                }
                
                $i++;
            }
        }

        return $result;
    }

    private function assign_action($acl_role_actions, $role_id, $role_name, $action_name, $role_actions, $default_role_actions){
        $options = $default_role_actions[$this->bean->module_c]['module'][$action_name]['accessOptions'];

        $result = array(
            'id' => create_guid(),
            'aclaccess' => 0,
            'accessColor' => ACLAction::AccessColor(0),
            'accessName' => 'Not Set',
            'accessLabel' => $options[0],
            'role_name' => $role_name,
            'action_name' => $action_name,
            'action_id' => $role_actions[$this->bean->module_c]['module'][$action_name]['id'],
            'module_name' => $this->bean->module_c,
            'accessOptions' => $options
        );

        if(!empty($acl_role_actions)){
            foreach($acl_role_actions as $acl_role_action){
                if($role_id == $acl_role_action['role_id'] 
                    && strtolower($action_name) == strtolower($acl_role_action['action_name']) ){
                        $acl_role_action_id = (!empty($acl_role_action['ara_id'])) ? $acl_role_action['ara_id'] : create_guid();
                        $aclAccess = ACLAction::AccessLabel($role_actions[$this->bean->module_c]['module'][$action_name]['aclaccess']);

                        $result = array(
                            'id' => $acl_role_action_id,
                            'aclaccess' => $role_actions[$this->bean->module_c]['module'][$action_name]['aclaccess'],
                            'accessColor' => ACLAction::AccessColor($role_actions[$this->bean->module_c]['module'][$action_name]['aclaccess']),
                            'accessName' => ACLAction::AccessName($role_actions[$this->bean->module_c]['module'][$action_name]['aclaccess']),
                            'accessLabel' => $aclAccess == 'default' ? 'Not Set' : $aclAccess,
                            'action_name' => $action_name,
                            'action_id' => $role_actions[$this->bean->module_c]['module'][$action_name]['id'],
                            'module_name' => $this->bean->module_c,
                            'accessOptions' => $options 
                        );
                        
                        break;
                }
            }
        }

        return $result;
    }

    private function get_all_actions($module_name){
        global $db;
        $result = array();

        $query = "select id, name, category,
                        acltype, aclaccess
                  from acl_actions 
                  where category = '{$module_name}'
                    and deleted = 0 ";
        $data = $db->query($query);

        while($rowData = $db->fetchByAssoc($data)){
            $result[$rowData['id']] = $rowData;
        }

        return $result;
    }
}

