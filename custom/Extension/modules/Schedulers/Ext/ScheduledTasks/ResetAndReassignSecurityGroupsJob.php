<?php
require_once('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');

class ResetAndReassignSecurityGroupsJob implements RunnableSchedulerJob
{
  public function run($arguments)
  {
    global $db, $log;

    $decodedArguments = json_decode(html_entity_decode($arguments),1);
    $ctr = $decodedArguments['counter'];
    $limit = $decodedArguments['limit'];
    $offset = $decodedArguments['offset'];

    $db = DBManagerFactory::getInstance();

    if (isset($ctr) && $ctr == 1) {
      $deleteSecurityGroupRecordsSQL = "DELETE securitygroups_records FROM securitygroups_records
        LEFT JOIN securitygroups
          ON securitygroups.id = securitygroups_records.securitygroup_id
        LEFT JOIN securitygroups_cstm
          ON securitygroups.id = securitygroups_cstm.id_c
        WHERE securitygroups_cstm.type_c IN ('Account Access',  'SAMAccountAccess', 'MDMAccountAccess')
      ";

      $db->query($deleteSecurityGroupRecordsSQL);
    }

    $accountSQL = "SELECT accounts.id FROM accounts 
      WHERE accounts.deleted = 0 
      ORDER BY accounts.date_entered DESC 
      LIMIT {$limit} 
      OFFSET {$offset}
    ";
    
    $accountResult = $db->query($accountSQL);

    while ($accountRow = $db->fetchByAssoc($accountResult)) {
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
					SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('insert', $bean->id, $assignedUserAccessSecGroup->id, $eventLogId, false);
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