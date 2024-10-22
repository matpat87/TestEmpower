<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');

// Call function in browser: <url>/index.php?module=Accounts&action=UpdateAccountSecurityGroups
updateAccountSecurityGroups();

function updateAccountSecurityGroups()
{
	global $db;

	$db = DBManagerFactory::getInstance();

	$accountSQL = " SELECT accounts.id, accounts_audit.before_value_string, accounts_audit.after_value_string 
									FROM accounts
									LEFT JOIN accounts_audit 
										ON accounts.id = accounts_audit.parent_id
									WHERE accounts.deleted = 0
										AND accounts_audit.field_name = 'assigned_user_id'
										AND accounts.assigned_user_id = accounts_audit.after_value_string
									GROUP BY accounts.id
									ORDER BY accounts_audit.date_created DESC";
	$accountResult = $db->query($accountSQL);
	
	while($accountRow = $db->fetchByAssoc($accountResult) ) {
		$eventLogId = create_guid();
		$accountBean = BeanFactory::getBean('Accounts', $accountRow['id']);
		
		echo '<pre>';
			print_r("ACCOUNT ID: {$accountBean->id}");
			echo '<br>';
			print_r("ACCOUNT NAME: {$accountBean->name}");
		echo '</pre>';

		if (isset($accountRow['before_value_string']) && $accountRow['before_value_string'] == $accountRow['after_value_string']) {
			$assignedUserAccessSecGroup = SecurityGroupHelper::retrieveSecGroupAcctAccessBean($accountRow['after_value_string'], 'Account Access');

			if (! SecurityGroupHelper::checkIfRecordExistsInSecurityGroup($assignedUserAccessSecGroup->id, $accountBean->id, 'Accounts')) {
				SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('insert', $accountBean->id, $assignedUserAccessSecGroup->id, $eventLogId, true);
			}
		}
		
		if (! $accountRow['before_value_string'] && $accountRow['after_value_string']) {
			$newAssignedUserAccessSecGroup = SecurityGroupHelper::retrieveSecGroupAcctAccessBean($accountRow['after_value_string'], 'Account Access');

			if ($newAssignedUserAccessSecGroup && $newAssignedUserAccessSecGroup->load_relationship('securitygroups_accounts')) {	
				SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('insert', $accountBean->id, $newAssignedUserAccessSecGroup->id, $eventLogId, true);
			}
		}
		
		if (isset($accountRow['before_value_string']) && $accountRow['before_value_string'] != $accountRow['after_value_string']) {
			
			$oldAssignedUserAccessSecGroup = SecurityGroupHelper::retrieveSecGroupAcctAccessBean($accountRow['before_value_string'], 'Account Access');
			$newAssignedUserAccessSecGroup = SecurityGroupHelper::retrieveSecGroupAcctAccessBean($accountRow['after_value_string'], 'Account Access');

			if ($oldAssignedUserAccessSecGroup) SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('delete', $accountBean->id, $oldAssignedUserAccessSecGroup->id, $eventLogId, true);
			if ($newAssignedUserAccessSecGroup) SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('insert', $accountBean->id, $newAssignedUserAccessSecGroup->id, $eventLogId, true);
		}
		
		if (isset($accountRow['before_value_string']) && (! $accountRow['after_value_string'])) {
			$oldAssignedUserAccessSecGroup = SecurityGroupHelper::retrieveSecGroupAcctAccessBean($accountRow['before_value_string'], 'Account Access');

			if ($oldAssignedUserAccessSecGroup && $oldAssignedUserAccessSecGroup->load_relationship('securitygroups_accounts')) {
				SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('delete', $accountBean->id, $oldAssignedUserAccessSecGroup->id, $eventLogId, true);
			}
		}

		echo '<pre>';
		if ($oldAssignedUserAccessSecGroup) {
			print_r("OLD SECURITYGROUP ID: {$oldAssignedUserAccessSecGroup->id}");
			echo '<br>';
			print_r("OLD SECURITYGROUP NAME: {$oldAssignedUserAccessSecGroup->name}");
			echo '<br>';
		}
		
		if ($newAssignedUserAccessSecGroup) {
			print_r("NEW SECURITYGROUP ID: {$newAssignedUserAccessSecGroup->id}");
			echo '<br>';
			print_r("NEW SECURITYGROUP NAME: {$newAssignedUserAccessSecGroup->name}");
		}
		echo '</pre>';
	}
}
