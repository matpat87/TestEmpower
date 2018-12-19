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

require_once('include/SugarObjects/templates/issue/Issue.php');

class OTR_OnTrack extends Issue
{
    public $new_schema = true;
    public $module_dir = 'OTR_OnTrack';
    public $object_name = 'OTR_OnTrack';
    public $table_name = 'otr_ontrack';
    public $importable = true;

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
    public $otr_ontrack_number;
    public $type;
    public $status;
    public $priority;
    public $resolution;
    public $work_log;
   
    function set_notification_body($xtpl, $otr_ontrack)
    {
        global $mod_strings, $app_list_strings, $sugar_config; 

        $work_log = string_replace_all("\n", "<br/>", $otr_ontrack->work_log); //replace all \n with <br> so that Work Log will be readable            

        $xtpl->assign("OTR_ISSUE_URL", $sugar_config['site_url'] . '/index.php?module=OTR_OnTrack&action=DetailView&record=' . $otr_ontrack->id);
        $xtpl->assign("OTR_ISSUE_NUMBER", $otr_ontrack->otr_ontrack_number);
        $xtpl->assign("OTR_APPLICATION", $app_list_strings['application_list'][$otr_ontrack->application_c]);
        $xtpl->assign("OTR_MODULE", "On Track");
        $xtpl->assign("OBJECT", "On Track");
        $xtpl->assign("OTR_PHASE", $app_list_strings['phase_list'][$otr_ontrack->application_c]);
        $xtpl->assign("OTR_STATUS", $app_list_strings['bug_status_dom'][$otr_ontrack->status]); // dont change this, it will refer to bug status dom
        $xtpl->assign("OTR_TYPE", $app_list_strings['bug_type_dom'][$otr_ontrack->type]); // dont change this, it will refer to bug type dom
        $xtpl->assign("OTR_SEVERITY", $app_list_strings['severity_list'][$otr_ontrack->severity_c]);
        $xtpl->assign("OTR_PRIORITY", $app_list_strings['priority_c_list'][$otr_ontrack->priority_c]);
        $xtpl->assign("OTR_SUBJECT", $otr_ontrack->name);
        $xtpl->assign("OTR_DESCRIPTION", $otr_ontrack->description);
        $xtpl->assign("OTR_WORK_LOG", $work_log);

        return $xtpl;
    }
    
    public function bean_implements($interface)
    {
        switch($interface)
        {
            case 'ACL':
                return true;
        }

        return false;
    }
    
}
