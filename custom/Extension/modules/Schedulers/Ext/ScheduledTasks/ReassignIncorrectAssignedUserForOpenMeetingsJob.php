<?php

handleVerifyBeforeRequire('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');

class ReassignIncorrectAssignedUserForOpenMeetingsJob implements RunnableSchedulerJob
{
    public function run($arguments)
    {
        $db = DBManagerFactory::getInstance();
        $sql = "SELECT 
                    meetings.id AS meeting_id, 
                    accounts.id AS account_id, 
                    meetings.assigned_user_id AS meeting_assigned_user_id, 
                    (SELECT users.user_name FROM users WHERE users.id = meetings.assigned_user_id) as meeting_assigned_user_name, 
                    accounts.assigned_user_id as account_assigned_user_id, 
                    (SELECT users.user_name FROM users WHERE users.id = accounts.assigned_user_id) as account_assigned_user_name, 
                    users_accounts_1_c.users_accounts_1users_ida, 
                    (SELECT users.user_name FROM users WHERE users.id = users_accounts_1_c.users_accounts_1users_ida) as sam_user_name, 
                    users_accounts_2_c.users_accounts_2users_ida,
                    (SELECT users.user_name FROM users WHERE users.id = users_accounts_2_c.users_accounts_2users_ida) as mdm_user_name
                FROM meetings 
                LEFT JOIN meetings_cstm
                    ON meetings.id = meetings_cstm.id_c
                INNER JOIN accounts
                    ON accounts.id = meetings.parent_id
                    AND meetings.parent_type = 'Accounts'
                    AND accounts.deleted = 0
                LEFT JOIN users_accounts_1_c
                    ON accounts.id = users_accounts_1_c.users_accounts_1accounts_idb
                LEFT JOIN users_accounts_2_c
                    ON accounts.id = users_accounts_2_c.users_accounts_2accounts_idb
                WHERE meetings.deleted = 0
                    AND accounts.deleted = 0
                    AND meetings.assigned_user_id <> accounts.assigned_user_id
                    AND meetings.status <> 'Held'
                    AND accounts.assigned_user_id <> (SELECT users.id FROM users WHERE users.user_name IN ('HACCOUNT'))";

        $result = $db->query($sql); 

        $eventLogId = create_guid();

        while ($row = $db->fetchByAssoc($result)) {
            $meetingBean = BeanFactory::getBean('Meetings', $row['meeting_id']);
            $accountBean = BeanFactory::getBean('Accounts', $row['account_id']);

            if ($meetingBean && $meetingBean->id && $accountBean && $accountBean->assigned_user_id) {
                $updateSQL = "UPDATE meetings SET meetings.assigned_user_id = '{$accountBean->assigned_user_id}' WHERE meetings.id = '{$meetingBean->id}'";
                $db->query($updateSQL);

                SecurityGroupHelper::createActivityUserReassignmentLog($meetingBean->module_dir, $meetingBean->id, $accountBean->assigned_user_id, $eventLogId);
            }
        }

        return true;
    }

    public function setJob(SchedulersJob $job)
    {
        $this->job = $job;
    }
}