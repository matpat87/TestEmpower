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

require_once('modules/SecurityGroups/SecurityGroup.php');
require_once('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');

class GlobalBeforeSaveHooks
{
    function setDivisionLevelIISecurityGroup($bean, $event, $arguments)
    {
        global $current_user, $app_list_strings;

        $moduleName = $bean->module_dir;
        $acceptedModules = [
            'Leads', 'Accounts', 'Contacts', 'Opportunities',
            'TR_TechnicalRequests', 'DSBTN_Distribution', 'AOS_Products', 'CI_CustomerItems',
            'Cases', 'Documents', 'EHS_EHS', 'RE_Regulatory', 'Campaigns',
            'Calls', 'Meetings',' Tasks', 'Notes', 'Emails', 'CHL_Challenges',
            'TRWG_TRWorkingGroup', 'TRI_TechnicalRequestItems', 'RRQ_RegulatoryRequests', 'RRWG_RRWorkingGroup'
        ];

        // Skip process if record is not new or not in accepted modules list
        if ($bean->fetched_row['id'] || ! in_array($moduleName, $acceptedModules)) {
            return;
        }

        // Set record division values to logged user's division if value is empty (Ex. division field is hidden on views)
        if (! $bean->division) {
            $bean->division = $current_user->division_c;
        }

        if (! $bean->division_c) {
            $bean->division_c = $current_user->division_c;
        }

        // Set division value based on bean (division, division_c) if exists, or set to logged user's division
        if ($bean->division) {
            $division = $bean->division;
        } else if ($bean->division_c) {
            $division = $bean->division_c;
        } else {
            $division = $current_user->division_c;
        }

        if ($division) {
            $divisionLabel = $app_list_strings['user_division_list'][$division];
            $eventLogId = create_guid();
            
            $securitygroupDivisionBean = BeanFactory::getBean('SecurityGroups')->retrieve_by_string_fields(
                array(
                    "division_c" => $division,
                    "type_c" => "Division Access",
                    "name" => "Level II - {$divisionLabel} Management"
                ), false, true
            );

            if ($securitygroupDivisionBean) {                
                SecurityGroupHelper::insertOrDeleteSecurityGroupRecord('insert', $securitygroupDivisionBean->id, $bean->id, $moduleName, $eventLogId);
            };
        }
    }

    function handleInheritRootAccountSecurityGroup(&$bean, $event, $arguments)
    {
        if (! $bean->fetched_row['id']) {
            $securityGroupModules = SecurityGroup::getSecurityModules();
            
            if (! in_array($bean->module_dir, array_keys($securityGroupModules))) {
                return;
            }

            if ($bean->module_dir !== 'Accounts') {
                foreach ($bean->field_name_map as $name => $def) {
                    if ($def['type'] == 'relate' && isset($def['id_name']) && isset($def['module'])) {
                        if (strtolower($def['module']) == 'accounts') {
                            $idName = $def['id_name'];
                            SecurityGroup::inherit_parentQuery($bean, $def['module'], $bean->$idName, $bean->id, $bean->module_dir);
                        } else {
                            if (isset($bean->parent_type) && isset($bean->parent_id) && (! empty($bean->parent_id))) {
                                $parentBean = BeanFactory::getBean($bean->parent_type, $bean->parent_id);
    
                                if ($parentBean->module_dir !== 'Accounts') {
                                    foreach ($parentBean->field_name_map as $name => $def) {
                                        if ($def['type'] == 'relate' && isset($def['id_name']) && isset($def['module'])) {
                                            if (strtolower($def['module']) == 'accounts') {
                                                $idName = $def['id_name'];
                                                SecurityGroup::inherit_parentQuery($bean, $def['module'], $parentBean->$idName, $bean->id, $bean->module_dir);
                                            }
                                        }
                                    }
                                } else {
                                    SecurityGroup::inherit_parentQuery($bean, $bean->parent_type, $bean->parent_id, $bean->id, $bean->module_dir);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    function setCreatedByAccountAccessSecurityGroup(&$bean, $event, $arguments)
    {
        global $current_user, $app_list_strings;

        $createdByUserBean = BeanFactory::getBean('Users', $bean->created_by);
        $moduleName = $bean->module_dir;
        $acceptedModules = [
            'RRQ_RegulatoryRequests'
        ];

        // Skip process if created by user bean does not exist or current module is not in accepted modules list
        if (! $createdByUserBean->id || ! in_array($moduleName, $acceptedModules)) {
            return;
        }

        // Set record division values to created by user bean's division if value is empty (Ex. division field is hidden on views)
        if (! $bean->division) {
            $bean->division = $createdByUserBean->division_c;
        }

        if (! $bean->division_c) {
            $bean->division_c = $createdByUserBean->division_c;
        }

        // Set division value based on bean (division, division_c) if exists, or set to created by user bean's division
        if ($bean->division) {
            $division = $bean->division;
        } else if ($bean->division_c) {
            $division = $bean->division_c;
        } else {
            $division = $createdByUserBean->division_c;
        }

        if ($division) {
            $divisionLabel = $app_list_strings['user_division_list'][$division];
            $eventLogId = create_guid();
            
            $securitygroupDivisionBean = BeanFactory::getBean('SecurityGroups')->retrieve_by_string_fields(
                array(
                    "division_c" => $division,
                    "type_c" => "Account Access",
                    "name" => "{$createdByUserBean->user_name}"
                ), false, true
            );

            if ($securitygroupDivisionBean) {                
                SecurityGroupHelper::insertOrDeleteSecurityGroupRecord('insert', $securitygroupDivisionBean->id, $bean->id, $moduleName, $eventLogId);
            };
        }
    }

    public function inheritParentSecurityGroup(&$bean, $event, $arguments)
    {
        $acceptedModules = [
            'RD_RegulatoryDocuments'
        ];

        // Skip process if current module is not in accepted modules list
        if (! in_array($bean->module_dir, $acceptedModules)) {
            return;
        }

        // Check if parent_type and parent_id field exists and are not empty before running inherit_parentQuery function
        if ((isset($bean->parent_type) && $bean->parent_type) && (isset($bean->parent_id) && $bean->parent_id)) {
            SecurityGroup::inherit_parentQuery($bean, $bean->parent_type, $bean->parent_id, $bean->id, $bean->module_dir);
        }

    }
}

