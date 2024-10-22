<?php

handleVerifyBeforeRequire('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');

class ReassignIncorrectAssignedUserForOpenTasksJob implements RunnableSchedulerJob
{
    public function run($arguments)
    {
        $db = DBManagerFactory::getInstance();
        $sql = "SELECT 
                    tasks.id AS task_id, 
                    accounts.id AS account_id, 
                    tasks.assigned_user_id AS task_assigned_user_id, 
                    (SELECT users.user_name FROM users WHERE users.id = tasks.assigned_user_id) as task_assigned_user_name, 
                    accounts.assigned_user_id as account_assigned_user_id, 
                    (SELECT users.user_name FROM users WHERE users.id = accounts.assigned_user_id) as account_assigned_user_name, 
                    users_accounts_1_c.users_accounts_1users_ida, 
                    (SELECT users.user_name FROM users WHERE users.id = users_accounts_1_c.users_accounts_1users_ida) as sam_user_name, 
                    users_accounts_2_c.users_accounts_2users_ida,
                    (SELECT users.user_name FROM users WHERE users.id = users_accounts_2_c.users_accounts_2users_ida) as mdm_user_name
                FROM tasks 
                LEFT JOIN tasks_cstm
                    ON tasks.id = tasks_cstm.id_c
                INNER JOIN accounts
                    ON accounts.id = tasks.parent_id
                    AND tasks.parent_type = 'Accounts'
                    AND accounts.deleted = 0
                LEFT JOIN users_accounts_1_c
                    ON accounts.id = users_accounts_1_c.users_accounts_1accounts_idb
                LEFT JOIN users_accounts_2_c
                    ON accounts.id = users_accounts_2_c.users_accounts_2accounts_idb
                WHERE tasks.deleted = 0
                    AND accounts.deleted = 0
                    AND tasks.assigned_user_id <> accounts.assigned_user_id
                    AND tasks.status <> 'Completed'
                    AND accounts.assigned_user_id <> (SELECT users.id FROM users WHERE users.user_name IN ('HACCOUNT'))";

        $result = $db->query($sql); 

        $eventLogId = create_guid();

        while ($row = $db->fetchByAssoc($result)) {
            $taskBean = BeanFactory::getBean('Tasks', $row['task_id']);
            $accountBean = BeanFactory::getBean('Accounts', $row['account_id']);

            if ($taskBean && $taskBean->id && $accountBean && $accountBean->assigned_user_id) {
                $updateSQL = "UPDATE tasks SET tasks.assigned_user_id = '{$accountBean->assigned_user_id}' WHERE tasks.id = '{$taskBean->id}'";
                $db->query($updateSQL);

                SecurityGroupHelper::createActivityUserReassignmentLog($taskBean->module_dir, $taskBean->id, $accountBean->assigned_user_id, $eventLogId);
            }
        }

        return true;
    }

    public function setJob(SchedulersJob $job)
    {
        $this->job = $job;
    }
}