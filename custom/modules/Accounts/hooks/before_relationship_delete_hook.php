<?php
	require_once('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');
	
	class AccountsBeforeRelationshipDeleteHook 
	{
		public function removeAccountAccessSecurityGroupFromChildRecords($bean, $event, $arguments)
		{
			$eventLogId = create_guid();
			$action = 'delete';
			$moduleName = $_REQUEST['module'];
			
			if ($moduleName == 'Accounts') {
				$securityGroupId = $_REQUEST['linked_id'];
				$accountId = $_REQUEST['record'];
			} else if ($moduleName == 'SecurityGroups') {
				$securityGroupId = $_REQUEST['record'];
				$accountId = $_REQUEST['linked_id'];
			}
			
			if (! empty($securityGroupId) && ! empty($accountId)) {
				SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups($action, $accountId, $securityGroupId, $eventLogId, false);
			}
		}
	}
?>