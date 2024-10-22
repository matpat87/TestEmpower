<?php
	require_once('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');
	
	class AccountsBeforeRelationshipAddHook 
	{
		public function setAccountAccessSecurityGroupToChildRecords($bean, $event, $arguments)
		{
			$eventLogId = create_guid();
			$action = 'insert';
			$returnModule = $_REQUEST['return_module'];

			if ($returnModule == 'Accounts') {
				$securityGroupId = $_REQUEST['subpanel_id'];
				$accountId = $_REQUEST['record'];
			} else if ($returnModule == 'SecurityGroups') {
				$securityGroupId = $_REQUEST['record'];
				$accountId = $_REQUEST['subpanel_id'];
			}
			
			if (! empty($securityGroupId) && ! empty($accountId)) {
				SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups($action, $accountId, $securityGroupId, $eventLogId, false);
			}
		}
	}
?>