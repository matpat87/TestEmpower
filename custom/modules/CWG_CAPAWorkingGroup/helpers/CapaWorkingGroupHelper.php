<?php

    class CapaWorkingGroupHelper
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

        public static function createOrUpdateCapaRole($customerIssueBean = null, $capaRole)
        {
            global $log, $current_user;
            $isNewIssue = (isset($customerIssueBean->fetched_row['id'])) ? false : true;

            $relatedToObj = self::queryRelatedTo($customerIssueBean->id, $capaRole, $isNewIssue);
            $hasRole = self::hasCapaRole($customerIssueBean, $capaRole);

            if (!$hasRole) {
                // If Customer Issue does not have this CAPA Role, Create the CAPA Role

                    $workGroupBean = BeanFactory::newBean('CWG_CAPAWorkingGroup');
                    $workGroupBean->capa_roles = $capaRole;
                    $workGroupBean->assigned_user_id = $current_user->id;
                    $workGroupBean->created_by = $current_user->id;
                    $workGroupBean->parent_type = $relatedToObj->parent_type ?? '';
                    $workGroupBean->parent_id = $relatedToObj->parent_id ?? '';

                    if ($relatedToObj->relatedToCheck) {
                        $workGroupBean->save();
        
                        $customerIssueBean->load_relationship('cases_cwg_capaworkinggroup_1');
                        $customerIssueBean->cases_cwg_capaworkinggroup_1->add($workGroupBean);

                    }

            } else {
                
                // Else update the CAPA Role Details??
                if ($relatedToObj->relatedToCheck) {
                    $workgroupBeanArr = $customerIssueBean->get_linked_beans(
                        'cases_cwg_capaworkinggroup_1',
                        'CWG_CAPAWorkingGroup',
                        array(),
                        0,
                        -1,
                        0,
                        "cwg_capaworkinggroup.capa_roles = '".$capaRole."'");
                    
                    $workGroupBean = $workgroupBeanArr[0];
                    $workGroupBean->parent_type = $relatedToObj->parent_id ? $relatedToObj->parent_type : '';
                    $workGroupBean->parent_id = $relatedToObj->parent_id ? $relatedToObj->parent_id : '';
                    $workGroupBean->save();
                }
            }
         
        }   

        private function hasCapaRole($customerIssueBean, $capaRole)
        {
            $customerIssueBean->load_relationship('cases_cwg_capaworkinggroup_1');
            $customerIssueCapaRolesBeans = $customerIssueBean->cases_cwg_capaworkinggroup_1->getBeans();

            // Retrieve the CAPA Roles under this Customer issue
            $customerIssueCapaRoles = array_column($customerIssueCapaRolesBeans, 'capa_roles');

            return in_array($capaRole, $customerIssueCapaRoles);
            
        }

        private function queryRelatedTo($customerIssueID, $capaRole, $isNewIssue = false)
        {
            global $log, $current_user;

            $customerIssueBean = BeanFactory::getBean('Cases', $customerIssueID);
            $account = BeanFactory::getBean('Accounts', $customerIssueBean->account_id);
    
            $relatedTo = new stdClass();
            $relatedTo->relatedToCheck = true;
                
                
                switch ($capaRole) {
                    
                    case 'CAPACoordinator':
                        // Retrieve CAPA Coordinator
                        $userBean = retrieveUserBySecurityGroupTypeDivision('CAPA Coordinator', 'CAPAWorkingGroup', $customerIssueBean->site_c, $customerIssueBean->division_c);

                        if ($userBean && $userBean->id) {
                            $relatedTo->parent_type = 'Users';
                            $relatedTo->parent_id = $userBean->id;
                        } else {
                            $relatedTo->parent_id = '';
                        }
                        break;
                    case 'Creator':
                        // User who created the Customer Issue
                        $workgroupBeanArr = $customerIssueBean->get_linked_beans(
                            'cases_cwg_capaworkinggroup_1',
                            'CWG_CAPAWorkingGroup',
                            array(),
                            0,
                            -1,
                            0,
                            "cwg_capaworkinggroup.capa_roles != 'Creator' 
                            AND cwg_capaworkinggroup.parent_id = '{$current_user->id}'
                            AND cwg_capaworkinggroup.parent_type = 'Users'");

                        $relatedTo->relatedToCheck = false;

                        if (count($workgroupBeanArr) === 0) {
                            $relatedTo->parent_type = 'Users';
                            $relatedTo->parent_id = $customerIssueBean->created_by;
                            $relatedTo->relatedToCheck = true;
                        }

                        break;
                    case 'CSR':
                        // $relatedTo->parent_type = '';
                        // $relatedTo->parent_id = '';
                        // $relatedTo->relatedToCheck = true;
                        
                        break;
                    case 'CustomerServiceManager':
                        // Retrieve Customer Service Manager
                        $userBean = retrieveUserBySecurityGroupTypeDivision('Customer Service Manager', 'CAPAWorkingGroup', $customerIssueBean->site_c, $customerIssueBean->division_c);

                        if ($userBean && $userBean->id) {
                            $relatedTo->parent_type = 'Users';
                            $relatedTo->parent_id = $userBean->id;
                        } else {
                            $relatedTo->parent_id = '';
                        }
                        break;
                    case 'InternalAuditor':
                        // Retrieve Internal Auditor
                        $userBean = retrieveUserBySecurityGroupTypeDivision('Internal Auditor', 'CAPAWorkingGroup', $customerIssueBean->site_c, $customerIssueBean->division_c);

                        if ($userBean && $userBean->id) {
                            $relatedTo->parent_type = 'Users';
                            $relatedTo->parent_id = $userBean->id;
                        } else {
                            $relatedTo->parent_id = '';
                        }
                        break;
                    /*case 'MarketDevelopmentManager':
                        // OnTrack 1971: MDM & SAM Roles are deprecated
                        if ($account->users_accounts_2users_ida) {
                            $relatedTo->parent_type = 'Users';
                            $relatedTo->parent_id = $account->users_accounts_2users_ida;

                        }
                        break;*/
                    
                    case 'QualityManager':
    
                        break;
                        
                    case 'QualityControlManager':
                        // Retrieve Quality Control Manager
                        $userBean = retrieveUserBySecurityGroupTypeDivision('Quality Control Manager', 'CAPAWorkingGroup', $customerIssueBean->site_c, $customerIssueBean->division_c);

                        if ($userBean && $userBean->id) {
                            $relatedTo->parent_type = 'Users';
                            $relatedTo->parent_id = $userBean->id;
                        } else {
                            $relatedTo->parent_id = '';
                        }
                        break;
                    case 'SalesManager':
                        //  Person that the Sales Person reports to
                        $salesMgr = BeanFactory::getBean('Users', $account->assigned_user_id);
                        $relatedTo->parent_type = 'Users';
                        $relatedTo->parent_id = ($salesMgr->reports_to_id) ? $salesMgr->reports_to_id : '';
                        break;
                    case 'SalesPerson':
                        // Person assigned to the related account of a customer issue
                        $relatedTo->parent_type = 'Users';
                        $relatedTo->parent_id = ($account->assigned_user_id) ? $account->assigned_user_id : '';
                        break;
                    /*case 'StrategicAccountManager':
                        // OnTrack 1971: MDM & SAM Roles are deprecated
                        if ($account->users_accounts_1users_ida != null) {
                            $relatedTo->parent_type = 'Users';
                            $relatedTo->parent_id = $account->users_accounts_1users_ida;
                        }
                        break;*/
                    case 'DepartmentManager':
                        // IF ON EDIT, department field has a value
                        if ($customerIssueBean->ci_department_c != null) {
                            $departmentManager = self::retrieveDepartmentManagerUser($customerIssueBean);
                            $relatedTo->relatedToCheck = true;
                            $relatedTo->parent_type = $departmentManager ? 'Users' : '';
                            $relatedTo->parent_id = ($departmentManager && $departmentManager->id) ? $departmentManager->id : null;
                        }
                    break;
                    case 'TechnicalServices':
                        // Retrieve Technical Services
                        $userBean = retrieveUserBySecurityGroupTypeDivision('Technical Services', 'CAPAWorkingGroup', NULL, $customerIssueBean->division_c);

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

        public static function retrieveDepartmentManagerUser($customerIssueBean)
        {
            global $log;
            $isSiteSpecific = true;

            switch ($customerIssueBean->ci_department_c) {
                case 'CustomerService':
                    $roleName = 'Customer Service Manager';
                    break;
                case 'QualityControl':
                    $roleName = 'Quality Control Manager';
                    break;
                case 'RDLab':
                    $roleName = 'R&D Manager';
                    break;
                case 'Shipping':
                    $roleName = 'Shipping Manager';
                    break;
                case 'Accounting': // deprecated
                    $roleName = 'Accounting';
                    break;
                case 'Operations':
                    $roleName = 'Plant Manager';
                    break;
                case 'Production':
                    $roleName = 'Production Manager';
                    break;
                case 'Billing':
                    $roleName = 'Billing Manager';
                    break;
                case 'Purchasing':
                    $roleName = 'Purchasing Manager';
                    $isSiteSpecific = false; // OnTrack 1588: Set to False to query from Roles that have one user set
                    break;
            }

            if (isset($roleName)) {
                $siteParam = ($isSiteSpecific) ? $customerIssueBean->site_c : NULL;
                $departmentManagerBean = retrieveUserBySecurityGroupTypeDivision($roleName, 'CAPAWorkingGroup', $siteParam, $customerIssueBean->division_c);
                return ($departmentManagerBean && $departmentManagerBean->id) ? $departmentManagerBean : false;
            }

            return false;
        }

        // Retrieves the Capa Role Assigned user
        // @return Array of User bean or Boolean FALSE
        public static function getCapaUsers($customerIssueBean, $capaRolesArray)
        {
            global $log;

            $userBeans = array();

            if (count($capaRolesArray) > 0) {
                $capaRoles = implode("','", $capaRolesArray);
                
                $workgroupBeanArr = $customerIssueBean->get_linked_beans(
                    'cases_cwg_capaworkinggroup_1',
                    'CWG_CAPAWorkingGroup',
                    array(),
                    0,
                    -1,
                    0,
                    "cwg_capaworkinggroup.capa_roles IN ('{$capaRoles}')");
                    
                    
                if (count($workgroupBeanArr) > 0) {
                    $userBeans = array();

                    // filter out CAPA Worgroup beans that have no parent_id set
                    foreach ($workgroupBeanArr as $bean) {
                       if (isset($bean->parent_id)) {
                           array_push($userBeans, $bean);
                       }
                    }
                    
                    // Map thru filtered CAPA Workgroup beans and retrieve its User Bean data
                    $userBeans = (count($userBeans) > 0) 
                        ? array_map(function($bean) {
                                $userBean = BeanFactory::getBean($bean->parent_type, $bean->parent_id); // retrieve its User Beans
                                $userBean->capa_role = $bean->capa_roles;
                                return $userBean;
                            }, $userBeans)
                        : false;
                        
                    return $userBeans;
                }

                return false;

            }

            return false;
            
        }

        // Check if the current logged user is the site user ROLE (param) specified
        // @params: customer issue $bean, String capa role
        // @return Boolean 
        public static function checkLoggedUserWorkgroupRole($customerIssueBean, $capaRole, $systemRoleName)
        {
            global $current_user, $log;

            $workgroupUser = self::getCapaUsers($customerIssueBean, [$capaRole]);
            $capaUserBean = ($workgroupUser)
                ? $workgroupUser
                : retrieveUserBySecurityGroupTypeDivision($systemRoleName, 'CAPAWorkingGroup', $customerIssueBean->site_c, $customerIssueBean->division_c);
            
            if ($capaUserBean != null) {
        
                $workgroupUser = (is_array($capaUserBean)) ? $capaUserBean[0]->id : $capaUserBean->id;
                
                return ($workgroupUser == $current_user->id);
                
            }
            
            
            return false;
        }

    }

?>