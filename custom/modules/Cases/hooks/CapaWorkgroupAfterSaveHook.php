<?php

    require_once('custom/modules/CWG_CAPAWorkingGroup/helpers/CapaWorkingGroupHelper.php');
    
    class CapaWorkgroupAfterSaveHook
    {
        public function generate_workgroup($bean, $event, $arguments)
        {
            global $app_list_strings, $log;
            
            if ($_REQUEST['massupdate']) {
                return true;
            }

            $sortedList = $this->filterRolesOnSave($bean);

            // Purpose: To put creator at hte bottom of the list
            // sort CAPA Role array, transfer CREATOR role to end of Arrays
            if (array_key_exists("Creator", $sortedList)) {
                unset($sortedList['Creator']);
                $sortedList['Creator'] = 'Creator';

            }
            // should trigger when: it's a new issue and when site is changed
            foreach ($sortedList as $capa_role_key => $capa_role) {
                
                if ($capa_role != '') {
                    $cwgBean = CapaWorkingGroupHelper::createOrUpdateCapaRole($bean, $capa_role_key);
                }
            }
        }

        private function filterRolesOnSave($bean)
        {
            global $app_list_strings, $log;

            $isNewIssue = (isset($bean->fetched_row['id'])) ? false : true;
            
            $roles = array_filter($app_list_strings['capa_roles_list'], function($key) use ($isNewIssue, $bean, $log) {
                
                if ($isNewIssue || $bean->status == 'Draft') {
                    return in_array($key, ['SalesPerson', 'SalesManager', 'Creator']); // Ontrack 1971: Removed SAM and MDM Capa Role creation

                } elseif (!$isNewIssue && $bean->status == 'Approved') { 
                    return $key != ''; // create other capa working groups including site-related roles
                } elseif(!$isNewIssue && !in_array($bean->status, ['Cancelled', 'CreatedInError', 'Rejected', 'New'])) {
                    return $key != ''; // should not create or update any of the workgroups
                } else {
                    return $key  == '';
                }
            }, ARRAY_FILTER_USE_KEY);
            
            return $roles;
        }
    }


?>