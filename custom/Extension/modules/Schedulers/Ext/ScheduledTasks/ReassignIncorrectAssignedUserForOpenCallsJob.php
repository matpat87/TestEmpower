<?php

handleVerifyBeforeRequire('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');

class ReassignIncorrectAssignedUserForOpenCallsJob implements RunnableSchedulerJob
{
    public function run($arguments)
    {
        $db = DBManagerFactory::getInstance();
        $sql = "SELECT 
                    calls.id AS call_id, 
                    accounts.id AS account_id, 
                    calls.assigned_user_id AS call_assigned_user_id, 
                    (SELECT users.user_name FROM users WHERE users.id = calls.assigned_user_id) as call_assigned_user_name, 
                    accounts.assigned_user_id as account_assigned_user_id, 
                    (SELECT users.user_name FROM users WHERE users.id = accounts.assigned_user_id) as account_assigned_user_name, 
                    users_accounts_1_c.users_accounts_1users_ida, 
                    (SELECT users.user_name FROM users WHERE users.id = users_accounts_1_c.users_accounts_1users_ida) as sam_user_name, 
                    users_accounts_2_c.users_accounts_2users_ida,
                    (SELECT users.user_name FROM users WHERE users.id = users_accounts_2_c.users_accounts_2users_ida) as mdm_user_name
                FROM calls 
                LEFT JOIN calls_cstm
                    ON calls.id = calls_cstm.id_c
                INNER JOIN accounts
                    ON accounts.id = calls.parent_id
                    AND calls.parent_type = 'Accounts'
                    AND accounts.deleted = 0
                LEFT JOIN users_accounts_1_c
                    ON accounts.id = users_accounts_1_c.users_accounts_1accounts_idb
                LEFT JOIN users_accounts_2_c
                    ON accounts.id = users_accounts_2_c.users_accounts_2accounts_idb
                WHERE calls.deleted = 0
                    AND accounts.deleted = 0
                    AND calls.assigned_user_id <> accounts.assigned_user_id
                    AND calls.status <> 'Held'
                    AND accounts.assigned_user_id <> (SELECT users.id FROM users WHERE users.user_name IN ('HACCOUNT'))";

        $result = $db->query($sql); 

        $eventLogId = create_guid();

        while ($row = $db->fetchByAssoc($result)) {
            $callBean = BeanFactory::getBean('Calls', $row['call_id']);
            $accountBean = BeanFactory::getBean('Accounts', $row['account_id']);

            if ($callBean && $callBean->id && $accountBean && $accountBean->assigned_user_id) {
                $updateSQL = "UPDATE calls SET calls.assigned_user_id = '{$accountBean->assigned_user_id}' WHERE calls.id = '{$callBean->id}'";
                $db->query($updateSQL);

                SecurityGroupHelper::createActivityUserReassignmentLog($callBean->module_dir, $callBean->id, $accountBean->assigned_user_id, $eventLogId);
            }
        }

        return true;
    }

    public function setJob(SchedulersJob $job)
    {
        $this->job = $job;
    }
}