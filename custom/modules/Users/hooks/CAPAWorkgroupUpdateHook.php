<?php

// Deprecated as feature is now handled via Security Group (OnTrack #1611)
/*
    require_once('custom/modules/CWG_CAPAWorkingGroup/helpers/CapaWorkingGroupHelper.php');
    
    class CAPAWorkgroupUpdateHook
    {
        public function updateCapaUsers($bean, $event, $arguments)
        {
            global $app_list_strings, $log, $db;
            
            // To make sure User has a site_c value before updating Customer Issue Workgroups
            if ($bean->site_c && $bean->site_c != "") {
                
                $userSitesArr = array_map(function($site) {
                    return str_replace("^", "", $site);
                }, explode(",", $bean->site_c));
                
                $userSites = implode("','", $userSitesArr);

                $whereIn = (count($userSitesArr) > 0) 
                ? " AND cases_cstm.site_c IN ('{$userSites}')"
                : "";
                
                $capaRole = $this->getCapaRoleValue($arguments['related_bean']->name);

                if ($arguments['related_module'] == 'ACLRoles' && $arguments['relationship'] == 'acl_roles_users' && $capaRole) {
                    // get all capa workgroup where role is the current added aclrole
                   
                    
                    $casesSql = "
                        UPDATE cwg_capaworkinggroup capa
                                INNER JOIN
                            cases_cwg_capaworkinggroup_1_c ON cases_cwg_capaworkinggroup_1_c.cases_cwg_capaworkinggroup_1cwg_capaworkinggroup_idb = capa.id
                                INNER JOIN
                            cases ON cases.id = cases_cwg_capaworkinggroup_1_c.cases_cwg_capaworkinggroup_1cases_ida
                                AND cases.deleted = 0
                                LEFT JOIN
                            cases_cstm ON cases_cstm.id_c = cases.id 
                        SET 
                            capa.parent_id = '{$bean->id}'
                        WHERE
                            capa.deleted = 0 AND capa_roles = '{$capaRole}'
                            AND cases.status NOT IN ('Closed', 'Rejected', 'Cancelled', 'CreatedInError')
                            {$whereIn}
                        ";

                    $casesResult = $db->query($casesSql);
                   
                    
                    
                }
            }

        }


        private function getCapaRoleValue($roleName)
        {
            global $app_list_strings;

            switch ($roleName) {
                case 'Internal Auditor':
                    $capaRoleName = 'InternalAuditor';
                    break;
                // case 'Quality Control Manager':
                //     $capaRoleName = 'QualityControlManager';
                //     break;
                default:
                   $capaRoleName = false;
                    
            }

            return $capaRoleName;
        }

        
    } // end of class
*/
?>