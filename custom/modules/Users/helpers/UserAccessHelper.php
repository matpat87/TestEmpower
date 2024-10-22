<?php

class UserAccessHelper
{
    /**
     * Checks if @param userBean has a role(s) that has access to the $module
     * @param $userBean, String $module [Module Name]
     * @return Boolean
     */
    public static function checkModuleAccessByRole($userBean, $module)
    {
        global $db, $log;

        if (!isset($module) || empty($module)) {
            return true;
        }
        
        require_once 'modules/ACLRoles/ACLRole.php';
        $aclRoles = new ACLRole();
        $userRoleBeans = $aclRoles->getUserRoles($userBean->id, false); // retrieves all ACLRoles of a user (array)
        
        // if user is admin, default to TRUE
        if ($userBean->is_admin) {
            return true;
        }

        if (is_array($userRoleBeans) && count($userRoleBeans) > 0) {

            $userRoleActions = array_map(function($role) use ($aclRoles, $module) {
                $roleActions = $aclRoles->getRoleActions($role->id); // get the role actions
                return $roleActions[$module]['module']['access']['aclaccess']; // return only the "access" action for 'jjwg_Maps' module
            }, $userRoleBeans);

           $result = in_array(89, $userRoleActions) || in_array(0, $userRoleActions); // if there is a value 89 or 0, it means user has access to 'jjwg_Maps'
           return $result;
        }



        return true;
    }
}
