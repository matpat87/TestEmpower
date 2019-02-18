<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004 - 2008 SugarCRM Inc.
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
 */




require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/Project/Project.php');

class ProjectUpdatesDashlet extends DashletGeneric {
    function __construct($id, $def = null) {
        global $current_user, $app_strings;
		require('modules/Project/Dashlets/ProjectUpdatesDashlet/ProjectUpdatesDashlet.data.php');

        parent::__construct($id, $def);

        if(empty($def['title'])) $this->title = translate('LBL_UPDATES', 'Project');

        $this->searchFields = $dashletData['ProjectUpdatesDashlet']['searchFields'];
        $this->columns = $dashletData['ProjectUpdatesDashlet']['columns'];
        $this->myItemsOnly = false;
        $this->showMyItemsOnly = false;
        $this->seedBean = new Project();
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function ProjectUpdatesDashlet($id, $def = null){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct($id, $def);
    }

    function process($lvsParams = array(), $id = null) {
        
        global $current_user;
        
        // Accounts is jt0 in system generated query
        $lvsParams['custom_from'] = "  LEFT JOIN accounts_cstm
                                        ON jt0.id = accounts_cstm.id_c ";
        
        // If admin, show all project updates, else show only projects whose accounts are assigned to the logged user                                       
        $lvsParams['custom_where'] = !$current_user->is_admin ? " OR (jt0.assigned_user_id = '".$current_user->id."')" : " ";
        
        // Filter data to show only records of projects that have active accounts and the project update field is not empty
        $lvsParams['custom_where'] .= " AND (project_cstm.project_update_c IS NOT NULL AND project_cstm.project_update_c != '') 
                                       AND accounts_cstm.status_c = 'Active'";

        

        // By default, sort data of project updates by last modified DESC
        if(empty($lvsParams['orderBy']) && empty($lvsParams['sortOrder'])) {
            $lvsParams['overrideOrder'] = true;
            $lvsParams['orderBy'] = 'date_modified';
            $lvsParams['sortOrder'] = 'DESC';
        }
        
        parent::process($lvsParams);
    } 
}
