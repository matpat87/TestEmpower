<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2016 Salesagility Ltd.
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


class GlobalAfterSaveHooks{

    static $hookTriggered = false;

    function updateLastActivityDate($bean, $event, $arguments){

        // Added to prevent infinite loop issue
        if(self::$hookTriggered == true) return;
        self::$hookTriggered = true;

        $module = $_REQUEST['module'] ?? '';
        $parentModules = ['Accounts']; // Add other modules as needed. Make sure they have the same last_activity_date_c field to prevent issues
        $relatedModules = ['Calls', 'Tasks', 'Meetings', 'Notes', 'Project', 'Documents'];
        $action = $_REQUEST['action'] ?? '';
        $recordID = $_REQUEST['record'] ?? '';

        if($action == 'Save') {
            if(in_array($module, $parentModules)) {
                // Triggers when updating an existing parent module record
                $recordID ? $this->parentBeanUpdateLastActivityDate($module, $recordID) : '';
            } else if(in_array($module, $relatedModules)) {
                // Triggers when updating related modules that are assigned to any of the parent modules
                $parentType = $_REQUEST['parent_type'] ?? '';
                if($parentType) {
                    if(in_array($parentType, $parentModules)) {
                        $parentID = $_REQUEST['parent_id'] ?? '';
                        $this->parentBeanUpdateLastActivityDate($parentType, $parentID);
                    }
                } else {
                    // Triggers when updating related modules that have the parent modules as subpanels
                    if(in_array($module, $relatedModules)) {
                        $newBean = BeanFactory::getBean($module, $recordID);

                        foreach ($parentModules as $parentKey => $parentValue) {
                            $lowerCaseParentModule = strtolower($parentValue); // Convert to lowercase to cater bean load relationship function

                            //If check if relationship is existing
                            if ($newBean->load_relationship($lowerCaseParentModule)) {

                                $relatedBeans = $newBean->$lowerCaseParentModule->getBeans();

                                // Loop through subpanel data and update last activity date
                                foreach ($relatedBeans as $relatedBean) {
                                    $relatedBean->last_activity_date_c = date('Y-m-d H:i:s');
                                    $relatedBean->save();
                                }

                            }

                        }
                    }
                }
            }
        } else if($action == 'Save2') {
            // This action is for when a user selects a record in the parent module's subpanel
            $subpanelModule = ucwords($_REQUEST['subpanel_module_name']);

            if(in_array($subpanelModule, $parentModules)) {
                $subpanelID = $_REQUEST['subpanel_id'];
                $this->parentBeanUpdateLastActivityDate($subpanelModule, $subpanelID);
            }
        }
    }

    function parentBeanUpdateLastActivityDate($module, $id) {
        if(!empty($module) && !empty($id)) {
            $parentBean = BeanFactory::getBean($module, $id);
            $parentBean->last_activity_date_c = date('Y-m-d H:i:s');
            $parentBean->save();
        }
    }
}

