<?php

    class TRWorkingGroupHelper
    {
        
        public static function getParentData($type, $id)
        {
            global $log;
            
            $return = array(
                'first_name' => null,
                'last_name' => null,
                'company' => null,
                'phone_work' => null,
                'phone_mobile' => null,
                'email' => null,
            );


            $bean = BeanFactory::getBean($type, $id);

                switch ($type) {
                    case 'Contacts':
                        $return['first_name'] = $bean->first_name;
                        $return['last_name'] = $bean->last_name;
                        $return['company'] = '';
                        $return['phone_work'] = $bean->phone_work;
                        $return['phone_mobile'] = $bean->phone_mobile;
                        $return['email'] = $bean->email1;
                        break;
                        
                    default:
                        $return['first_name'] = $bean->first_name;
                        $return['last_name'] = $bean->last_name;
                        $return['company'] = '';
                        $return['phone_work'] = $bean->phone_work;
                        $return['phone_mobile'] = $bean->phone_mobile;
                        $return['email'] = null;
                        $return['email'] = $bean->email1;
                    
                        break;
                }
            
            return $return;
           
        }

        public static function createOrUpdateTRRole($trBean = null, $trRole)
        {
            global $log, $current_user;

            $relatedToObj = self::queryRelatedTo($trBean, $trRole);
            $hasRole = self::hasTRRole($trBean, $trRole);
            
            if (! $hasRole) {
                // If Technical Request does not have this TR Role, Create the TR Role
                $workGroupBean = BeanFactory::newBean('TRWG_TRWorkingGroup');
                $workGroupBean->tr_roles = $trRole;
                $workGroupBean->assigned_user_id = $current_user->id;
                $workGroupBean->created_by = $current_user->id;
                $workGroupBean->parent_type = $relatedToObj->parent_type ?? '';
                $workGroupBean->parent_id = $relatedToObj->parent_id ?? '';

                if ($relatedToObj->relatedToCheck) {
                    $workGroupBean->save();
    
                    $trBean->load_relationship('tr_technicalrequests_trwg_trworkinggroup_1');
                    $trBean->tr_technicalrequests_trwg_trworkinggroup_1->add($workGroupBean);
                }

            } else {
                // Else update the TR Role Details??
                if ($relatedToObj->relatedToCheck) {
                    $workgroupBeanArr = $trBean->get_linked_beans(
                        'tr_technicalrequests_trwg_trworkinggroup_1',
                        'TRWG_TRWorkingGroup',
                        array(),
                        0,
                        -1,
                        0,
                        "trwg_trworkinggroup.tr_roles = '".$trRole."'");
                    
                    $workGroupBean = $workgroupBeanArr[0];
                    $workGroupBean->parent_type = $relatedToObj->parent_id ? $relatedToObj->parent_type : '';
                    $workGroupBean->parent_id = $relatedToObj->parent_id ? $relatedToObj->parent_id : '';
                    $workGroupBean->save();
                }
            }
         
        }   

        private function hasTRRole($trBean, $trRole)
        {
            $trBean->load_relationship('tr_technicalrequests_trwg_trworkinggroup_1');
            $trWorkingGroupRolesBeans = $trBean->tr_technicalrequests_trwg_trworkinggroup_1->getBeans();

            // Retrieve the TR Roles under this Technical Request
            $TRWorkGroupRoles = array_column($trWorkingGroupRolesBeans, 'tr_roles');

            return in_array($trRole, $TRWorkGroupRoles);
        }

        private function queryRelatedTo($trBean, $trRole)
        {
            global $log, $current_user;

            $account = BeanFactory::getBean('Accounts', $trBean->tr_technicalrequests_accountsaccounts_ida);
            
            $relatedTo = new stdClass();
            $relatedTo->relatedToCheck = true;
            
            // Query parent data on CREATE Technical Request Only
            switch ($trRole) {
                case 'Creator':
                    // User who created the Technical Request
                    $workgroupBeanArr = $trBean->get_linked_beans(
                        'tr_technicalrequests_trwg_trworkinggroup_1',
                        'TRWG_TRWorkingGroup',
                        array(),
                        0,
                        -1,
                        0,
                        "trwg_trworkinggroup.tr_roles != 'Creator' 
                        AND trwg_trworkinggroup.parent_id = '{$trBean->created_by}'
                        AND trwg_trworkinggroup.parent_type = 'Users'");

                    $relatedTo->relatedToCheck = false;

                    if (count($workgroupBeanArr) === 0) {
                        $relatedTo->parent_type = 'Users';
                        $relatedTo->parent_id = $trBean->created_by;
                        $relatedTo->relatedToCheck = true;
                    }

                    break;
                case 'SalesPerson':
                    // Person assigned to the related account of a technical request
                    $relatedTo->parent_type = 'Users';
                    $relatedTo->parent_id = ($account->assigned_user_id) ? $account->assigned_user_id : '';
                    break;
                case 'SalesManager':
                    //  Person that the Sales Person reports to
                    $salesMgr = BeanFactory::getBean('Users', $account->assigned_user_id);
                    $relatedTo->parent_type = 'Users';
                    $relatedTo->parent_id = ($salesMgr->reports_to_id) ? $salesMgr->reports_to_id : '';
                    break;
                /*case 'MarketDevelopmentManager':
                    // Ontrack 1971: Removed SAM and MDM role creation
                    if (! $account->users_accounts_2users_ida) {
                        break;
                    }

                    $relatedTo->parent_type = 'Users';
                    $relatedTo->parent_id = $account->users_accounts_2users_ida;
                    break;*/
                /*case 'StrategicAccountManager':
                    // Ontrack 1971: Removed SAM and MDM role creation
                    if (! $account->users_accounts_1users_ida) {
                        break;
                    }

                    $relatedTo->parent_type = 'Users';
                    $relatedTo->parent_id = $account->users_accounts_1users_ida;
                    break;*/
                case 'QuoteManager':
                    // Retrieve Quote Manager
                    $userBean = retrieveUserBySecurityGroupTypeDivision('Quote Manager', 'TRWorkingGroup', $trBean->site, $trBean->division);

                    if ($userBean && $userBean->id) {
                        $relatedTo->parent_type = 'Users';
                        $relatedTo->parent_id = $userBean->id;
                    } else {
                        $relatedTo->parent_id = '';
                    }
                    break;
                case 'RDManager':
                    // Retrieve R&D Manager
                    $userBean = retrieveUserBySecurityGroupTypeDivision('R&D Manager', 'TRWorkingGroup', $trBean->site, $trBean->division);

                    if ($userBean && $userBean->id) {
                        $relatedTo->parent_type = 'Users';
                        $relatedTo->parent_id = $userBean->id;
                    } else {
                        $relatedTo->parent_id = '';
                    }
                    break;
                case 'ColorMatchCoordinator':
                    // Retrieve Colormatch Coordinator
                    $userBean = retrieveUserBySecurityGroupTypeDivision('Color Match Coordinator', 'TRWorkingGroup', $trBean->site, $trBean->division);

                    if ($userBean && $userBean->id) {
                        $relatedTo->parent_type = 'Users';
                        $relatedTo->parent_id = $userBean->id;
                    } else {
                        $relatedTo->parent_id = '';
                    }
                    break;
                case 'ColorMatcher':
                    $workGroupColorMatcherList = $trBean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'ColorMatcher' AND trwg_trworkinggroup.parent_type = 'Users'");
                    $colorMatcherBean = (!empty($workGroupColorMatcherList) && count($workGroupColorMatcherList) > 0) ? BeanFactory::getBean('Users', $workGroupColorMatcherList[0]->parent_id) : null;

                    if (! $colorMatcherBean || $trBean->site != $trBean->fetched_row['site']) {
                        $relatedTo->parent_type = '';
                        $relatedTo->parent_id = '';
                        $relatedTo->relatedToCheck = true;
                    }
                    break;
                case 'RegulatoryManager':
                    // Retrieve Regulatory Manager
                    $userBean = retrieveUserBySecurityGroupTypeDivision('Regulatory', 'TRWorkingGroup', $trBean->site, $trBean->division);

                    if ($userBean && $userBean->id) {
                        $relatedTo->parent_type = 'Users';
                        $relatedTo->parent_id = $userBean->id;
                    } else {
                        $relatedTo->parent_id = '';
                    }
                    break;
                default:
                    # code...
                    break;
                
            }

            return isset($relatedTo->parent_id) ? $relatedTo : null;
        }

        public static function getWorkgroupUser($trBean, $trRole)
        {
            global $log;

            $workgroupBeanArr = $trBean->get_linked_beans(
                'tr_technicalrequests_trwg_trworkinggroup_1',
                'TRWG_TRWorkingGroup',
                array(),
                0,
                -1,
                0,
                "trwg_trworkinggroup.tr_roles = '".$trRole."'");

                
            if (!empty($workgroupBeanArr)) {
                $userId = $workgroupBeanArr[0]->parent_id;
                $userBean = BeanFactory::getBean('Users', $userId);

                return $userBean;
            }

            return false;
        }
        
        public static function getWorkgroupUsers($trBean, $trRoles = [])
        {
            global $log;

            if (empty($trRoles)) {
                return false;
            }

            $implodeRolesString = implode("','", $trRoles);

            $workgroupBeanArr = $trBean->get_linked_beans(
                'tr_technicalrequests_trwg_trworkinggroup_1',
                'TRWG_TRWorkingGroup',
                array(),
                0,
                -1,
                0,
                "trwg_trworkinggroup.tr_roles IN ('{$implodeRolesString}')");

           
            if (!empty($workgroupBeanArr)) {
                $userBeans = array_map(function($workGroupBean) {
                    $userId = $workGroupBean->parent_id;
                    $userBean = BeanFactory::getBean('Users', $userId);

                    return $userBean;
                }, $workgroupBeanArr);

                return $userBeans;
            }

            return false;
        }
    }
?>