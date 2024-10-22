<?php

handleVerifyBeforeRequire('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');

class ReassignIncorrectAssignedUserForOpenOpportunitiesJob implements RunnableSchedulerJob
{
    public function run($arguments)
    {
        $db = DBManagerFactory::getInstance();
        $sql = "SELECT 
                    opportunities.id AS opportunity_id, 
                    accounts.id AS account_id, 
                    opportunities_cstm.oppid_c,
                    opportunities.sales_stage,
                    opportunities.assigned_user_id AS opp_assigned_user_id, 
                    (SELECT users.user_name FROM users WHERE users.id = opportunities.assigned_user_id) as opp_assigned_user_name, 
                    accounts.assigned_user_id as account_assigned_user_id, 
                    (SELECT users.user_name FROM users WHERE users.id = accounts.assigned_user_id) as account_assigned_user_name, 
                    users_accounts_1_c.users_accounts_1users_ida, 
                    (SELECT users.user_name FROM users WHERE users.id = users_accounts_1_c.users_accounts_1users_ida) as sam_user_name, 
                    users_accounts_2_c.users_accounts_2users_ida,
                    (SELECT users.user_name FROM users WHERE users.id = users_accounts_2_c.users_accounts_2users_ida) as mdm_user_name
                FROM opportunities 
                LEFT JOIN opportunities_cstm
                    ON opportunities.id = opportunities_cstm.id_c
                INNER JOIN accounts_opportunities
                    ON opportunities.id = accounts_opportunities.opportunity_id
                    AND accounts_opportunities.deleted = 0
                INNER JOIN accounts
                    ON accounts.id = accounts_opportunities.account_id
                    AND accounts.deleted = 0
                LEFT JOIN users_accounts_1_c
                    ON accounts.id = users_accounts_1_c.users_accounts_1accounts_idb
                LEFT JOIN users_accounts_2_c
                    ON accounts.id = users_accounts_2_c.users_accounts_2accounts_idb
                WHERE opportunities.deleted = 0
                    AND accounts.deleted = 0
                    AND opportunities.assigned_user_id <> accounts.assigned_user_id
                    AND opportunities.sales_stage NOT IN ('Closed', 'ClosedLost', 'ClosedWon', 'ClosedRejected')
                    AND accounts.assigned_user_id <> (SELECT users.id FROM users WHERE users.user_name IN ('HACCOUNT'))";

        $result = $db->query($sql); 

        $eventLogId = create_guid();

        while ($row = $db->fetchByAssoc($result)) {
            $opportunityBean = BeanFactory::getBean('Opportunities', $row['opportunity_id']);
            $accountBean = BeanFactory::getBean('Accounts', $row['account_id']);

            if ($opportunityBean && $opportunityBean->id && $accountBean && $accountBean->assigned_user_id) {
                $updateSQL = "UPDATE opportunities SET opportunities.assigned_user_id = '{$accountBean->assigned_user_id}' WHERE opportunities.id = '{$opportunityBean->id}'";
                $db->query($updateSQL);

                SecurityGroupHelper::createActivityUserReassignmentLog($opportunityBean->module_dir, $opportunityBean->id, $accountBean->assigned_user_id, $eventLogId);
            }
        }

        return true;
    }

    public function setJob(SchedulersJob $job)
    {
        $this->job = $job;
    }
}