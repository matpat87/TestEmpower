<?php
require_once('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');

class ResetAndReassignSecurityGroupsAndAssignmentsJob implements RunnableSchedulerJob
{
  public function run($arguments)
  {
    global $db;

    $db = DBManagerFactory::getInstance();

    $deleteSecurityGroupRecordsSQL = "DELETE securitygroups_records FROM securitygroups_records
    LEFT JOIN securitygroups
      ON securitygroups.id = securitygroups_records.securitygroup_id
    LEFT JOIN securitygroups_cstm
      ON securitygroups.id = securitygroups_cstm.id_c
    WHERE securitygroups_cstm.type_c IN ('Account Access',  'SAMAccountAccess', 'MDMAccountAccess')";

    $resetContactAssignments = "UPDATE contacts SET assigned_user_id = created_by";
    $resetOpportunityAssignments = "UPDATE opportunities SET assigned_user_id = created_by";
    $resetCaseAssignments = "UPDATE cases SET assigned_user_id = created_by";
    $resetMeetingAssignments = "UPDATE meetings SET assigned_user_id = created_by";
    $resetCallAssignments = "UPDATE calls SET assigned_user_id = created_by";
    $resetTaskAssignments = "UPDATE tasks SET assigned_user_id = created_by";

    $db->query($deleteSecurityGroupRecordsSQL);
    $db->query($resetContactAssignments);
    $db->query($resetOpportunityAssignments);
    $db->query($resetCaseAssignments);
    $db->query($resetMeetingAssignments);
    $db->query($resetCallAssignments);
    $db->query($resetTaskAssignments);

    $accountSQL = "SELECT accounts.id FROM accounts WHERE accounts.deleted = 0 ORDER BY accounts.name ASC";
    $accountResult = $db->query($accountSQL);

    while($accountRow = $db->fetchByAssoc($accountResult) ) {
      $eventLogId = create_guid();
      
      // Account Bean
      $bean = BeanFactory::getBean('Accounts', $accountRow['id']);

      // SAM
      if (is_object($bean->users_accounts_1users_ida)) {
				$query = "SELECT id FROM users WHERE CONCAT(first_name, ' ', last_name) = '{$bean->users_accounts_1_name}'";
				$strategicAccountManagerId = $db->getOne($query);
			} else {
				$strategicAccountManagerId = $bean->users_accounts_1users_ida;
      }
      
      if ($strategicAccountManagerId) {
				$stratAcctMgrAccessSecGroup = SecurityGroupHelper::retrieveSecGroupAcctAccessBean($strategicAccountManagerId, 'SAMAccountAccess');

				if ($stratAcctMgrAccessSecGroup && ! SecurityGroupHelper::checkIfRecordExistsInSecurityGroup($stratAcctMgrAccessSecGroup->id, $bean->id, 'Accounts')) {
					SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('insert', $bean->id, $stratAcctMgrAccessSecGroup->id, $eventLogId, false);
				}
      }
      
      // MDM
      if (is_object($bean->users_accounts_2users_ida)) {
				$query = "SELECT id FROM users WHERE CONCAT(first_name, ' ', last_name) = '{$bean->users_accounts_2_name}'";
				$marketDevelopmentManagerId = $db->getOne($query);
			} else {
				$marketDevelopmentManagerId = $bean->users_accounts_2users_ida;
      }
      
      if ($marketDevelopmentManagerId) {
				$mktDevMgrAccessSecGroup = SecurityGroupHelper::retrieveSecGroupAcctAccessBean($marketDevelopmentManagerId, 'MDMAccountAccess');

				if ($mktDevMgrAccessSecGroup && ! SecurityGroupHelper::checkIfRecordExistsInSecurityGroup($mktDevMgrAccessSecGroup->id, $bean->id, 'Accounts')) {
					SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('insert', $bean->id, $mktDevMgrAccessSecGroup->id, $eventLogId, false);
				}
      }
      
      // Sales Rep
      if ($bean->assigned_user_name) {
				$assignedUserAccessSecGroup = SecurityGroupHelper::retrieveSecGroupAcctAccessBean($bean->assigned_user_id, 'Account Access');

				if ($assignedUserAccessSecGroup && ! SecurityGroupHelper::checkIfRecordExistsInSecurityGroup($assignedUserAccessSecGroup->id, $bean->id, 'Accounts')) {
					SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('insert', $bean->id, $assignedUserAccessSecGroup->id, $eventLogId, true);
				}
      }
    }

    return true;
  }

  public function setJob(SchedulersJob $job)
  {
    $this->job = $job;
  }
}