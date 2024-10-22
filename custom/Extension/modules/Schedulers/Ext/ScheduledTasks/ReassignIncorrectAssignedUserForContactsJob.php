<?php

handleVerifyBeforeRequire('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');

class ReassignIncorrectAssignedUserForContactsJob implements RunnableSchedulerJob
{
    public function run($arguments)
    {
        $db = DBManagerFactory::getInstance();
        $sql = "SELECT 
                    contacts.id AS contact_id, 
                    accounts.id AS account_id, 
                    contacts.assigned_user_id AS contact_assigned_user_id, 
                    (SELECT users.user_name FROM users WHERE users.id = contacts.assigned_user_id) as contact_assigned_user_name, 
                    accounts.assigned_user_id as account_assigned_user_id, 
                    (SELECT users.user_name FROM users WHERE users.id = accounts.assigned_user_id) as account_assigned_user_name, 
                    users_accounts_1_c.users_accounts_1users_ida, 
                    (SELECT users.user_name FROM users WHERE users.id = users_accounts_1_c.users_accounts_1users_ida) as sam_user_name, 
                    users_accounts_2_c.users_accounts_2users_ida,
                    (SELECT users.user_name FROM users WHERE users.id = users_accounts_2_c.users_accounts_2users_ida) as mdm_user_name
                FROM contacts 
                LEFT JOIN contacts_cstm
                    ON contacts.id = contacts_cstm.id_c
                INNER JOIN accounts_contacts
                    ON contacts.id = accounts_contacts.contact_id
                    AND accounts_contacts.deleted = 0
                INNER JOIN accounts
                    ON accounts.id = accounts_contacts.account_id
                    AND accounts.deleted = 0
                LEFT JOIN users_accounts_1_c
                    ON accounts.id = users_accounts_1_c.users_accounts_1accounts_idb
                LEFT JOIN users_accounts_2_c
                    ON accounts.id = users_accounts_2_c.users_accounts_2accounts_idb
                WHERE contacts.deleted = 0
                    AND accounts.deleted = 0
                    AND contacts.assigned_user_id <> accounts.assigned_user_id
                    AND accounts.assigned_user_id <> (SELECT users.id FROM users WHERE users.user_name IN ('HACCOUNT'))";

        $result = $db->query($sql); 

        $eventLogId = create_guid();

        while ($row = $db->fetchByAssoc($result)) {
            $contactBean = BeanFactory::getBean('Contacts', $row['contact_id']);
            $accountBean = BeanFactory::getBean('Accounts', $row['account_id']);

            if ($contactBean && $contactBean->id && $accountBean && $accountBean->assigned_user_id) {
                $updateSQL = "UPDATE contacts SET contacts.assigned_user_id = '{$accountBean->assigned_user_id}' WHERE contacts.id = '{$contactBean->id}'";
                $db->query($updateSQL);

                SecurityGroupHelper::createActivityUserReassignmentLog($contactBean->module_dir, $contactBean->id, $accountBean->assigned_user_id, $eventLogId);
            }
        }

        return true;
    }

    public function setJob(SchedulersJob $job)
    {
        $this->job = $job;
    }
}