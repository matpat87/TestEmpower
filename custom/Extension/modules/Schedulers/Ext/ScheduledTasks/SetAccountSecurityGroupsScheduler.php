<?php
  require_once('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');
  $job_strings[] = 'setAccountSecurityGroupsScheduler';

  function setAccountSecurityGroupsScheduler()
  {
    global $db;
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
        SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('insert', $bean->id, $stratAcctMgrAccessSecGroup->id, $eventLogId, false);
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
        SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('insert', $bean->id, $mktDevMgrAccessSecGroup->id, $eventLogId, false);
      }
      
      // Sales Rep
      if ($bean->assigned_user_name) {
				$assignedUserAccessSecGroup = SecurityGroupHelper::retrieveSecGroupAcctAccessBean($bean->assigned_user_id, 'Account Access');
        SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('insert', $bean->id, $assignedUserAccessSecGroup->id, $eventLogId, true);
      }
    }

    return true;
  }