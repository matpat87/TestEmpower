<?php

    class RRWorkingGroupHelper
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

        public static function createOrUpdateRRRole($rrBean = null, $rrRole)
        {
            global $log, $current_user;

            $relatedToObj = self::queryRelatedTo($rrBean, $rrRole);
            $hasRole = self::hasRRRole($rrBean, $rrRole);
            
            if (! $hasRole) {
                // If Regulatory Request does not have this RR Role, Create the RR Role
                $workGroupBean = BeanFactory::newBean('RRWG_RRWorkingGroup');
                $workGroupBean->rr_roles = $rrRole;
                $workGroupBean->assigned_user_id = $current_user->id;
                $workGroupBean->created_by = $current_user->id;
                $workGroupBean->parent_type = $relatedToObj->parent_type ?? '';
                $workGroupBean->parent_id = $relatedToObj->parent_id ?? '';

                if ($relatedToObj->relatedToCheck) {
                    $workGroupBean->save();
    
                    $rrBean->load_relationship('rrq_regulatoryrequests_rrwg_rrworkinggroup_1');
                    $rrBean->rrq_regulatoryrequests_rrwg_rrworkinggroup_1->add($workGroupBean);
                }

            } else {
                // Else update the RR Role Details??
                if ($relatedToObj->relatedToCheck) {
                    $workgroupBeanArr = $rrBean->get_linked_beans(
                        'rrq_regulatoryrequests_rrwg_rrworkinggroup_1',
                        'RRWG_RRWorkingGroup',
                        array(),
                        0,
                        -1,
                        0,
                        "rrwg_rrworkinggroup.rr_roles = '".$rrRole."'");
                    
                    $workGroupBean = $workgroupBeanArr[0];
                    $workGroupBean->parent_type = $relatedToObj->parent_id ? $relatedToObj->parent_type : '';
                    $workGroupBean->parent_id = $relatedToObj->parent_id ? $relatedToObj->parent_id : '';
                    $workGroupBean->save();
                }
            }
         
        }   

        private function hasRRRole($rrBean, $rrRole)
        {
            $rrBean->load_relationship('rrq_regulatoryrequests_rrwg_rrworkinggroup_1');
            $rrWorkingGroupRolesBeans = $rrBean->rrq_regulatoryrequests_rrwg_rrworkinggroup_1->getBeans();

            // Retrieve the RR Roles under this Regulatory Request
            $RRWorkGroupRoles = array_column($rrWorkingGroupRolesBeans, 'rr_roles');

            return in_array($rrRole, $RRWorkGroupRoles);
        }

        private function queryRelatedTo($rrBean, $rrRole)
        {
            global $log, $current_user;
            
            $relatedAccountId = is_string($rrBean->accounts_rrq_regulatoryrequests_1accounts_ida) 
                ? $rrBean->accounts_rrq_regulatoryrequests_1accounts_ida
                : $_REQUEST['accounts_rrq_regulatoryrequests_1accounts_ida']; // Scenario: Accounts > RRQ subpanel create then save

            $account = BeanFactory::getBean('Accounts', $relatedAccountId);
            
            $relatedTo = new stdClass();
            $relatedTo->relatedToCheck = true;
            
            // Query parent data on CREATE Regulatory Request Only
            switch ($rrRole) {
                case 'Creator':
                    // User who created the Regulatory Request
                    $workgroupBeanArr = $rrBean->get_linked_beans(
                        'rrq_regulatoryrequests_rrwg_rrworkinggroup_1',
                        'RRWG_RRWorkingGroup',
                        array(),
                        0,
                        -1,
                        0,
                        "rrwg_rrworkinggroup.rr_roles = 'Creator' 
                        AND rrwg_rrworkinggroup.parent_id = '{$rrBean->created_by}'
                        AND rrwg_rrworkinggroup.parent_type = 'Users'");

                    $relatedTo->relatedToCheck = false;

                    if (count($workgroupBeanArr) === 0) {
                        $relatedTo->parent_type = 'Users';
                        $relatedTo->parent_id = $rrBean->created_by;
                        $relatedTo->relatedToCheck = true;
                    }

                    break;
                case 'Requestor':
                    // User who is set as the "Requested By" to the Regulatory Request
                    $workgroupBeanArr = $rrBean->get_linked_beans(
                        'rrq_regulatoryrequests_rrwg_rrworkinggroup_1',
                        'RRWG_RRWorkingGroup',
                        array(),
                        0,
                        -1,
                        0,
                        "rrwg_rrworkinggroup.rr_roles = 'Requestor' 
                        AND rrwg_rrworkinggroup.parent_id = '{$rrBean->user_id_c}'
                        AND rrwg_rrworkinggroup.parent_type = 'Users'");

                    $relatedTo->relatedToCheck = false;

                    if (count($workgroupBeanArr) === 0) {
                        $relatedTo->parent_type = 'Users';
                        $relatedTo->parent_id = $rrBean->user_id_c;
                        $relatedTo->relatedToCheck = true;
                    }

                    break;
                case 'SalesPerson':
                    // Person assigned to the related account of a Regulatory request
                    $relatedTo->parent_type = 'Users';
                    $relatedTo->parent_id = ($account->assigned_user_id) ? $account->assigned_user_id : '';
                    break;
                case 'RegulatoryManager':
                    // Retrieve Regulatory Manager by way of Security Group with Type = RRWorkingGroup
                    $userBean = retrieveUserBySecurityGroupTypeDivision('Regulatory Manager', 'RRWorkingGroup', NULL, $rrBean->division_c);

                    if ($userBean && $userBean->id) {
                        $relatedTo->parent_type = 'Users';
                        $relatedTo->parent_id = $userBean->id;
                    } else {
                        $relatedTo->parent_id = '';
                    }
                    break;
                case 'RegulatoryAnalyst':
                    // User who is assigned to the Regulatory Request when status was set to Assigned
                    $workgroupBeanArr = $rrBean->get_linked_beans(
                        'rrq_regulatoryrequests_rrwg_rrworkinggroup_1',
                        'RRWG_RRWorkingGroup',
                        array(),
                        0,
                        -1,
                        0,
                        "rrwg_rrworkinggroup.rr_roles = 'RegulatoryAnalyst' 
                        AND rrwg_rrworkinggroup.parent_id = '{$rrBean->assigned_user_id}'
                        AND rrwg_rrworkinggroup.parent_type = 'Users'");

                    $relatedTo->relatedToCheck = false;

                    if (count($workgroupBeanArr) === 0) {

                        // $_REQUEST['custom_regulatory_analyst_id'] is from PopulateRRWorkingGroupSchedulerJob.php which is the Regulatory Manager ID
                        $regulatoryAnalystId = (isset($_REQUEST['custom_regulatory_analyst_id']) && $_REQUEST['custom_regulatory_analyst_id']) 
                            ? $_REQUEST['custom_regulatory_analyst_id']
                            : $rrBean->assigned_user_id;

                        $relatedTo->parent_type = 'Users';
                        $relatedTo->parent_id = $regulatoryAnalystId ;
                        $relatedTo->relatedToCheck = true;
                    }
                    
                    break;
                default:
                    # code...
                    break;
                
            }

            return isset($relatedTo->parent_id) ? $relatedTo : null;
        }

        public static function handleRetrieveWorkgroupUserBean($rrBean, $rrRole)
        {
            $workGroupBeanList = $rrBean->get_linked_beans(
                'rrq_regulatoryrequests_rrwg_rrworkinggroup_1', 'RRWG_RRWorkingGroup', array(), 0, -1, 0, "rrwg_rrworkinggroup.rr_roles = '{$rrRole}' AND rrwg_rrworkinggroup.parent_type = 'Users'"
            );

            $userBean = (!empty($workGroupBeanList) && count($workGroupBeanList) > 0)
                ? BeanFactory::getBean('Users', $workGroupBeanList[0]->parent_id)
                : null;

            return $userBean;
        }
    }
?>