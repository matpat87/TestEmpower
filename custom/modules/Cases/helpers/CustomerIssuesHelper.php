<?php

    class CustomerIssuesHelper
    {
        // Get the user assigned for closing an Issue
        public static function getUserForClosingIssue($customerIssueID)
        {
            global $log, $db;

            $query = "
                SELECT cases_audit.created_by
                FROM cases_audit
                LEFT JOIN cases ON cases.id = cases_audit.parent_id
                WHERE
                    cases.deleted = 0
                AND cases_audit.field_name = 'status'
                AND cases_audit.before_value_string != 'Closed'
                AND cases_audit.after_value_string = 'Closed'
                AND cases.id = '".$customerIssueID."'
                ORDER BY cases_audit.date_created DESC LIMIT 1
            ";

            $result = $db->query($query);
            $row = $db->fetchByAssoc($result);

			if (! empty($row)) {
                // get the user Bean
                $user = BeanFactory::getBean('Users', $row['created_by']);
                return $user;
            }
           
			return false;
        }

        // Manual Insert to _audit table when Un/Verify button is clicked - Glai Obido
        public static function handleVerificationAudit($customerIssueBean)
        {
            global $db, $timedate, $current_user, $log;

            // inserts to cases_audit table
            $newId = create_guid();
            $timeDateNow = $timedate->getNow()->asDb();
            $beforeValueStr = !$customerIssueBean->verified_status_c ? 'Verified' : 'Unverified';
            $afterValueStr = $customerIssueBean->verified_status_c == 1 ? 'Verified' : 'Unverified';

                $query = "
                INSERT INTO cases_audit (
                    `id`,
                    `parent_id`,
                    `date_created`,
                    `created_by`,
                    `field_name`,
                    `data_type`,
                    `before_value_string`,
                    `after_value_string`) 
                    
                    VALUES (
                        '{$newId}',
                        '{$customerIssueBean->id}',
                        '{$timeDateNow}',
                        '{$current_user->id}',
                        'verified_status_c',
                        'varchar',
                        '{$beforeValueStr}',
                        '{$afterValueStr}' );
            ";

            $result = $db->query($query);
        }

        // Checks if all Preventive actions in this Issue are all closed (Status - Closed) - Glai Obido
        public static function checkPreventiveActions($customerIssueBean)
        {
            global $log;

            $preventiveActions = $customerIssueBean->get_linked_beans(
                'cases_pa_preventiveactions_1',
                'PA_PreventiveActions',
                array(), 0, -1, 0,
                "pa_preventiveactions.status != 'Closed'");

            // if query has result, means there are still PA's that are not closed yet
            $all_closed = (count($preventiveActions) > 0)
                ? false
                : true;
            
            return $all_closed;
        }

        // Retrieve User whole verified the issue
        public static function getRecentVerificationAuditDetails($customerIssueBean)
        {
            global $log, $db;

            $returnArr = array(
                'audit_details' => null,
                'user_details' => null
            );

            $query = "
                SELECT cases_audit.*
                FROM cases_audit
                LEFT JOIN cases ON cases.id = cases_audit.parent_id
                WHERE
                    cases.deleted = 0
                AND cases_audit.field_name = 'verified_status_c'
                AND cases.id = '".$customerIssueBean->id."'
                ORDER BY cases_audit.date_created DESC LIMIT 1
            ";

            $result = $db->query($query);
            $row = $db->fetchByAssoc($result);

			if (! empty($row)) {
                // get the user Bean
                $user = BeanFactory::getBean('Users', $row['created_by']);
                $returnArr['user_details'] = $user;
                $returnArr['audit_details'] = $row;
                
                return $returnArr;
            }
           
			return false;
        }

        public static function getWorkgroupUsers($customerIssueBean, $capaRole)
        {
            global $log;
            $workgroupBeanArr = $customerIssueBean->get_linked_beans(
                'cases_cwg_capaworkinggroup_1',
                'CWG_CAPAWorkingGroup',
                array(),
                0,
                -1,
                0,
                "cwg_capaworkinggroup.capa_roles = '".$capaRole."'");
            
            $users = array_map(function($value) {
                $userBean = BeanFactory::getBean('Users', $value->parent_id);
                return $userBean;
            }, $workgroupBeanArr);
           
            return $users;
        }

        public static function filterStatusOptions($status = '')
        {
            global $log, $app_list_strings, $current_user;

            if (! $current_user->is_admin) {

                $statusArr = array_filter($app_list_strings['status_list'], function($key) use ($status, $log) {
                    switch ($status) {
                        case 'Draft':
                            return in_array($key, ['New', 'Draft', 'Cancelled', 'CreatedInError']);
                            break;
                        case 'New':
                            return in_array($key, ['New', 'Approved', 'AwaitingInformation', 'Cancelled', 'Rejected']);
                            break;
                        case 'Approved':
                            return in_array($key, ['Approved', 'InProcess', 'AwaitingInformation', 'Rejected', 'Cancelled']);
                            break;
                        case 'InProcess':
                            return in_array($key, ['InProcess', 'CAPAReview', 'AwaitingInformation', 'Cancelled']);
                            break;
                        case 'CAPAReview':
                            return in_array($key, ['CAPAReview', 'CAPAApproved', 'Rejected', 'Cancelled']);
                            break;
                        case 'CAPAApproved':
                            return in_array($key, ['CAPAApproved', 'CAPAComplete']);
                            break;
                        case 'CAPAComplete':
                            return in_array($key, ['CAPAComplete', 'Closed']);
                            break;
                        case 'Closed':
                            return in_array($key, ['Closed']);
                            break;
                        case 'AwaitingInformation':
                            return in_array($key, ['AwaitingInformation', 'New', 'Approved', 'InProcess']);
                        case 'Rejected':
                            return in_array($key, ['Rejected', 'Draft']);
                            break;
                        case 'CreatedInError':
                            return in_array($key, ['New', 'Draft', 'Cancelled', 'CreatedInError']);
                            break;
                        case 'Cancelled':
                            return in_array($key, ['Cancelled']);; // Cancelled
                            break;
                        
                        default:
                            return $key != '';
                            break;
                    }
                }, ARRAY_FILTER_USE_KEY);

            } else {
                return $app_list_strings['status_list'];
            }

            return $statusArr;
        }
    }


?>