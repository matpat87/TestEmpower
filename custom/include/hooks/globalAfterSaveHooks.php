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


class GlobalAfterSaveHooks
{

    static $hookTriggered = false;

    function updateLastActivityDate($bean, $event, $arguments)
    {
        // Added to prevent infinite loop issue
        if(self::$hookTriggered == true) return;
        self::$hookTriggered = true;

        $module = $_REQUEST['module'] ?? '';
        $parentModule = ['Accounts']; // Add other modules as needed. Make sure they have the same last_activity_date_c field to prevent issues
        $relatedModules = ['Contacts', 'Opportunities', 'Cases'];
        $activityModules = ['Calls', 'Tasks', 'Meetings', 'Emails'];
        $action = $_REQUEST['action'] ?? '';
        $recordID = $_REQUEST['record'] ?? '';

        if(!$bean->fetched_row['id']) {
            if($action == 'Save') {
                if(in_array($module, $activityModules)) {
                    // When an account activity is created/updated
                    $parentType = $_REQUEST['parent_type'] ?? '';
                    $parentID = $_REQUEST['parent_id'] ?? '';
                    
                    if($parentType) {
                        if(in_array($parentType, $parentModule)) {
                            $this->updateAccountActivityDate($parentType, $parentID);
                        } else {
                            $newBean = BeanFactory::getBean($parentType, $parentID);
                            $this->relatedBeanUpdateAccountLastActivityDate($newBean, $parentModule);
                        }
                    } else {
                        // Triggers when updating related modules that have the parent modules as subpanels
                        if(in_array($module, $activityModules)) {
                            $newBean = BeanFactory::getBean($module, $recordID);
                            $this->relatedBeanUpdateAccountLastActivityDate($newBean, $parentModule);
                        }
                    }
                }

                else if(in_array($module, $relatedModules)) {
                    // When an account related module is created/updated
                    $recordID = $recordID ? $recordID : $bean->id;
                    $newBean = BeanFactory::getBean($module, $recordID);
                    $this->relatedBeanUpdateAccountLastActivityDate($newBean, $parentModule);
                    
                } 
            } else if($action == 'Save2') {
                
                // Retrieve Parent Module and ID
                $module = $_REQUEST['module'];
                $moduleID = $_REQUEST['record'];

                // This action is for when a user selects a record in the parent module's subpanel
                $subpanelModule = ucwords($_REQUEST['subpanel_module_name']);
                $subpanelID = $_REQUEST['subpanel_id'];
            }
        }
    }

    function updateAccountActivityDate($module, $id)
    {
        if(!empty($module) && !empty($id)) {
            $parentBean = BeanFactory::getBean($module, $id);
            $parentBean->last_activity_date_c = date('Y-m-d H:i:s');
            $parentBean->save();
        }
    }
    
    function relatedBeanUpdateAccountLastActivityDate($newBean, $parentModule, $relatedBeanName = null, $relatedBean = null)
    {
        foreach ($parentModule as $parentKey => $parentValue) {
            $lowerCaseParentModule = strtolower($parentValue); // Convert to lowercase to cater bean load relationship function
            
            if(!$relatedBeanName && !$relatedBean) {
                //If check if relationship is existing
                if ($newBean->load_relationship($lowerCaseParentModule)) {

                    $childBeans = $newBean->$lowerCaseParentModule->getBeans();

                    // Loop through subpanel data and update last activity date
                    foreach ($childBeans as $bean) {
                        $bean->last_activity_date_c = date('Y-m-d H:i:s');
                        $bean->save();
                    }

                }
            } else {
                $lowerCaseRelatedBeanName = strtolower($relatedBeanName);

                if($newBean->load_relationship($lowerCaseRelatedBeanName)) {
                    if($relatedBean->load_relationship($lowerCaseParentModule)) {
                        $childBeans = $relatedBean->$lowerCaseParentModule->getBeans();

                        // Loop through subpanel data and update last activity date
                        foreach ($childBeans as $bean) {
                            $bean->last_activity_date_c = date('Y-m-d H:i:s');
                            $bean->save();
                        }
                    } else {
                        // On Accounts Module, a related module is selected
                        $childBeans = $newBean->$lowerCaseParentModule->getBeans();

                        // Loop through subpanel data and update last activity date
                        foreach ($childBeans as $bean) {
                            $bean->last_activity_date_c = date('Y-m-d H:i:s');
                            $bean->save();
                        }
                    }
                }
            }
        }
    }

    /**
     * AfterSaveHook for Activity Modules whose parent module is PA_Preventive Actions
     * Triggered if Module created is in $activityModules
     * Manually creates the Module relationship to Preventive Actions
     * Logic Hook file: custom/modules/logic_hooks.php
     */
    public function handleActivityParentIdUpdates(&$bean, $event, $arguments)
    {
        global $log;

        $activityModules = [
            'Meetings' => 'pa_preventiveactions_meetings_1', 
            'Calls' => 'pa_preventiveactions_calls_1'];
            
            
        if (in_array($_REQUEST['module'], array_keys($activityModules)) && $_REQUEST['parent_type'] == 'PA_PreventiveActions') {
            $moduleBean = BeanFactory::getBean($_REQUEST['module'], $_REQUEST['record']);
            
            // check if parent_id is updated
            if ($moduleBean->fetched_row['parent_id'] != $moduleBean->parent_id) {
                $preventiveActionBean = BeanFactory::getBean('PA_PreventiveActions', $moduleBean->parent_id);
                $moduleBean->load_relationship($activityModules[$_REQUEST['module']]);
                $moduleBean->{$activityModules[$_REQUEST['module']]}->add($preventiveActionBean);
                
            }
        } // end of if
    }
}

