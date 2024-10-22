<?php
	require_once('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');

	class AccountsBeforeSaveHook 
	{
		public function sendNewAssignedManagerEmail($bean, $managerBean, $title) {
			global $current_user, $sugar_config;

			$addressArray = [$bean->billing_address_country, $bean->billing_address_street, $bean->billing_address_city, $bean->billing_address_state, $bean->billing_address_postalcode];
			$address = implode(", ", $addressArray);

			$customQABanner = $sugar_config['isQA'] == true ? '<span style="color: red;">***This is a test from the Empower QA System***</span><br><br>' : '';

			return sendEmail(
				"EmpowerCRM Account - {$bean->name}",
				"
					{$customQABanner}

					<p>
						<b>{$current_user->first_name} {$current_user->last_name}</b> has assigned <b>{$managerBean->first_name} {$managerBean->last_name}</b> to be the new {$title} for this Account.
					</p>

					<p>
						Name: {$bean->name}<br>
						Type: {$bean->account_type}<br>
						Customer #: {$bean->cust_num_c}<br>
						Address: {$address}<br>
						Description: {$bean->description}
					</p>

					<p>You may <a target='_blank' rel='noopener noreferrer' href='{$sugar_config['site_url']}/index.php?module=Accounts&action=DetailView&record={$bean->id}'>review this Account</a>.</p>
				",
				[ $managerBean->email1 ]
			);
		}

		public function setAccountAccessSecurityGroup(&$bean, $event, $arguments)
		{
			$eventLogId = create_guid();

			if (isset($bean->fetched_rel_row['assigned_user_name']) && $bean->fetched_rel_row['assigned_user_name'] == $bean->assigned_user_name) {
				$assignedUserAccessSecGroup = SecurityGroupHelper::retrieveSecGroupAcctAccessBean($bean->assigned_user_id, 'Account Access');

				if (! SecurityGroupHelper::checkIfRecordExistsInSecurityGroup($assignedUserAccessSecGroup->id, $bean->id, 'Accounts')) {
					SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('insert', $bean->id, $assignedUserAccessSecGroup->id, $eventLogId, true, 'Sales', $bean->fetched_row['assigned_user_id']);
				}
			}

			if (! $bean->fetched_rel_row['assigned_user_name'] && $bean->assigned_user_name) {
				$newAssignedUserAccessSecGroup = SecurityGroupHelper::retrieveSecGroupAcctAccessBean($bean->assigned_user_id, 'Account Access');

				if ($newAssignedUserAccessSecGroup && $newAssignedUserAccessSecGroup->load_relationship('securitygroups_accounts')) {	
					SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('insert', $bean->id, $newAssignedUserAccessSecGroup->id, $eventLogId, true, 'Sales', $bean->fetched_row['assigned_user_id']);
				}
			}

			if (isset($bean->fetched_rel_row['assigned_user_name']) && $bean->fetched_rel_row['assigned_user_name'] != $bean->assigned_user_name) {
				
				$oldAssignedUserAccessSecGroup = SecurityGroupHelper::retrieveSecGroupAcctAccessBean($bean->fetched_rel_row['assigned_user_id'], 'Account Access');
				$newAssignedUserAccessSecGroup = SecurityGroupHelper::retrieveSecGroupAcctAccessBean($bean->assigned_user_id, 'Account Access');

				if ($oldAssignedUserAccessSecGroup) SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('delete', $bean->id, $oldAssignedUserAccessSecGroup->id, $eventLogId, true, 'Sales', $bean->fetched_row['assigned_user_id']);
				if ($newAssignedUserAccessSecGroup) SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('insert', $bean->id, $newAssignedUserAccessSecGroup->id, $eventLogId, true, 'Sales', $bean->fetched_row['assigned_user_id']);
			}

			if (isset($bean->fetched_rel_row['assigned_user_name']) && (! $bean->assigned_user_name)) {
				$oldAssignedUserAccessSecGroup = SecurityGroupHelper::retrieveSecGroupAcctAccessBean($bean->fetched_rel_row['assigned_user_id'], 'Account Access');

				if ($oldAssignedUserAccessSecGroup && $oldAssignedUserAccessSecGroup->load_relationship('securitygroups_accounts')) {
					SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('delete', $bean->id, $oldAssignedUserAccessSecGroup->id, $eventLogId, true, 'Sales', $bean->fetched_row['assigned_user_id']);
				}
			}
		}

		public function handleCAPAWorkingGroupAssignments(&$bean, $event, $arguments)
		{
			$customerIssueBean = BeanFactory::getBean('Cases');
    		$customerIssueBeanList = $customerIssueBean->get_full_list("", "cases.status != 'Closed' AND cases.account_id = '{$bean->id}'", false, 0);

			// Check if Customer Issue(s) exist for an account before proceeding process
			if($customerIssueBeanList != null && count($customerIssueBeanList) > 0) {

				// Check if Sales Rep has been changed
				if (isset($bean->fetched_rel_row['assigned_user_name']) && $bean->fetched_rel_row['assigned_user_name'] != $bean->assigned_user_name) {
					$this->createOrUpdateCAPAWorkingGroup($bean->assigned_user_id, $bean->assigned_user_name, $customerIssueBeanList, 'SalesPerson', $bean->fetched_row['assigned_user_id'], true);

					// Update Sales Manager since Sales Rep has been changed
					$salesRepBean = BeanFactory::getBean('Users', $bean->assigned_user_id);
					$prevSalesRepBean = BeanFactory::getBean('Users', $bean->fetched_row['assigned_user_id']);
					$salesManagerBean = BeanFactory::getBean('Users', $salesRepBean->reports_to_id);
					$prevSalesManagerBean = BeanFactory::getBean('Users', $prevSalesRepBean->reports_to_id);
					$this->createOrUpdateCAPAWorkingGroup($salesManagerBean->id, $salesManagerBean->name, $customerIssueBeanList, 'SalesManager', $prevSalesManagerBean->id);
				}
			}
		}

		private function createOrUpdateCAPAWorkingGroup($beanUserId, $beanUserFullName, $customerIssueBeanList, $capaRole, $prevBeanUserId, $newAssignedUser = false)
		{
			global $db, $current_user_id;

			if (is_object($beanUserId)) {
				$query = "SELECT id FROM users WHERE CONCAT(first_name, ' ', last_name) = '{$beanUserFullName}'";
				$userId = $db->getOne($query);
			} else {
				$userId = $beanUserId;
			}
			
			$userBean = BeanFactory::getBean('Users', $userId);

			foreach ($customerIssueBeanList as $customerIssueBean) {
				$customerIssueBean->load_relationship('cases_cwg_capaworkinggroup_1');

				$workgroupBeanList = $customerIssueBean->get_linked_beans(
					'cases_cwg_capaworkinggroup_1',
					'CWG_CAPAWorkingGroup',
					array(),
					0,
					-1,
					0,
					"cwg_capaworkinggroup.capa_roles = '{$capaRole}' AND parent_type = 'Users' AND parent_id = '{$prevBeanUserId}'"
				);

				// Check if User Bean exists, else, remove CAPA Working Group Record if it exists
				if ($userBean && $userBean->id) {
					// Check if record exists then update, else create a new one
					if($workgroupBeanList != null && count($workgroupBeanList) > 0) {
						$workgroupBean = $workgroupBeanList[0];
						$workgroupBean->parent_id = $userBean->id;
						$workgroupBean->save();
					} else {
						$workgroupBean = BeanFactory::newBean('CWG_CAPAWorkingGroup');
						$workgroupBean->capa_roles = $capaRole;
						$workgroupBean->assigned_user_id = $current_user_id;
						$workgroupBean->created_by = $current_user_id;
						$workgroupBean->parent_type = 'Users';
						$workgroupBean->parent_id = $userBean->id;
						$workgroupBean->save();
						
						$customerIssueBean->cases_cwg_capaworkinggroup_1->add($workgroupBean);
					}
				} else {
					if($workgroupBeanList != null && count($workgroupBeanList) > 0) {
						$workgroupBean = $workgroupBeanList[0];

						if(in_array($capaRole, ['SalesManager'])) {
							$customerIssueBean->cases_cwg_capaworkinggroup_1->delete($customerIssueBean->id, $workgroupBean->id);
							$workgroupBean->mark_deleted($workgroupBean->id);
						} else {
							$workgroupBean->parent_id = '';
						}

						$workgroupBean->save();
					}
				}

				// If Account Assigned User has been updated
				if ($newAssignedUser) {
					// If Customer Issues (Cases) is assigned to Previous Assigned user and set to new value
					if ($customerIssueBean->assigned_user_id === $prevBeanUserId && $userBean && $userBean->id) {
						$updateQuery = "UPDATE cases SET assigned_user_id = '{$userBean->id}' WHERE id = '{$customerIssueBean->id}'";
                		$db->query($updateQuery);
					}
				}
			}
		}

		public function handleTRWorkingGroupAssignments(&$bean, $event, $arguments)
		{
			$bean->load_relationship('tr_technicalrequests_accounts');

			$trBeanList = $bean->get_linked_beans(
				'tr_technicalrequests_accounts',
				'TR_TechnicalRequests',
				array(),
				0,
				-1,
				0,
				"tr_technicalrequests.approval_stage NOT IN ('closed', 'closed_won', 'closed_lost', 'closed_rejected')"
			);

			// Check if Technical Request(s) exist for an account before proceeding process
			if($trBeanList != null && count($trBeanList) > 0) {

				// Check if Sales Rep has been changed
				if (isset($bean->fetched_rel_row['assigned_user_name']) && $bean->fetched_rel_row['assigned_user_name'] != $bean->assigned_user_name) {
					$this->createOrUpdateTRWorkingGroup($bean->assigned_user_id, $bean->assigned_user_name, $trBeanList, 'SalesPerson', $bean->fetched_row['assigned_user_id'], true);

					// Update Sales Manager since Sales Rep has been changed
					$salesRepBean = BeanFactory::getBean('Users', $bean->assigned_user_id);
					$prevSalesRepBean = BeanFactory::getBean('Users', $bean->fetched_row['assigned_user_id']);
					$salesManagerBean = BeanFactory::getBean('Users', $salesRepBean->reports_to_id);
					$prevSalesManagerBean = BeanFactory::getBean('Users', $prevSalesRepBean->reports_to_id);
					$this->createOrUpdateTRWorkingGroup($salesManagerBean->id, $salesManagerBean->name, $trBeanList, 'SalesManager', $prevSalesManagerBean->id);
				}
			}
		}

		private function createOrUpdateTRWorkingGroup($beanUserId, $beanUserFullName, $trBeanList, $trRole, $prevBeanUserId, $newAssignedUser = false)
		{
			global $db, $current_user_id;

			$_REQUEST['skip_hook'] = true; // Used to fix issue where it double saves or causes white screen error on SAM/MDM change on Account before save hook
			
			if (is_object($beanUserId)) {
				$query = "SELECT id FROM users WHERE CONCAT(first_name, ' ', last_name) = '{$beanUserFullName}'";
				$userId = $db->getOne($query);
			} else {
				$userId = $beanUserId;
			}
			
			$userBean = BeanFactory::getBean('Users', $userId);

			foreach ($trBeanList as $trBean) {
				$trBean->load_relationship('tr_technicalrequests_trwg_trworkinggroup_1');

				$workgroupBeanList = $trBean->get_linked_beans(
					'tr_technicalrequests_trwg_trworkinggroup_1',
					'TRWG_TRWorkingGroup',
					array(),
					0,
					-1,
					0,
					"trwg_trworkinggroup.tr_roles = '{$trRole}' AND parent_type = 'Users' AND parent_id = '{$prevBeanUserId}'"
				);

				// Check if User Bean exists, else, remove TR Working Group Record if it exists
				if ($userBean && $userBean->id) {
					// Check if record exists then update, else create a new one
					if($workgroupBeanList != null && count($workgroupBeanList) > 0) {
						$workgroupBean = $workgroupBeanList[0];
						$workgroupBean->parent_id = $userBean->id;
						$workgroupBean->save();
					} else {
						$workgroupBean = BeanFactory::newBean('TRWG_TRWorkingGroup');
						$workgroupBean->tr_roles = $trRole;
						$workgroupBean->assigned_user_id = $current_user_id;
						$workgroupBean->created_by = $current_user_id;
						$workgroupBean->parent_type = 'Users';
						$workgroupBean->parent_id = $userBean->id;
						$workgroupBean->save();
						
						$trBean->tr_technicalrequests_trwg_trworkinggroup_1->add($workgroupBean);
					}
				} else {
					if($workgroupBeanList != null && count($workgroupBeanList) > 0) {
						$workgroupBean = $workgroupBeanList[0];
						$workgroupBean->parent_id = '';
						$workgroupBean->save();
					}
				}

				// If Account Assigned User has been updated
				if ($newAssignedUser) {
					// If TR is assigned to Previous Assigned user and set to new value
					if ($trBean->assigned_user_id === $prevBeanUserId && $userBean && $userBean->id) {
						$updateQuery = "UPDATE tr_technicalrequests SET assigned_user_id = '{$userBean->id}' WHERE id = '{$trBean->id}'";
                		$db->query($updateQuery);
					}
				}
			}
		}

		public function handleRRWorkingGroupAssignments(&$bean, $event, $arguments)
		{
			$bean->load_relationship('accounts_rrq_regulatoryrequests_1');

			$rrBeanList = $bean->get_linked_beans(
				'accounts_rrq_regulatoryrequests_1',
				'RRQ_RegulatoryRequests',
				array(),
				0,
				-1,
				0,
				"rrq_regulatoryrequests_cstm.status_c NOT IN ('complete', 'rejected', 'created_in_error')"
			);

			// Check if Regulatory Request(s) exist for an account before proceeding process
			if($rrBeanList != null && count($rrBeanList) > 0) {
				// Check if Sales Rep has been changed
				if (isset($bean->fetched_rel_row['assigned_user_name']) && $bean->fetched_rel_row['assigned_user_name'] != $bean->assigned_user_name) {
					$this->createOrUpdateRRWorkingGroup($bean->assigned_user_id, $bean->assigned_user_name, $rrBeanList, 'SalesPerson', $bean->fetched_row['assigned_user_id'], true);
				}
			}
		}

		private function createOrUpdateRRWorkingGroup($beanUserId, $beanUserFullName, $rrBeanList, $rrRole, $prevBeanUserId, $newAssignedUser = false)
		{
			global $db, $current_user_id;

			$_REQUEST['skip_hook'] = true; // Used to fix issue where it double saves or causes white screen error on SAM/MDM change on Account before save hook
			
			if (is_object($beanUserId)) {
				$query = "SELECT id FROM users WHERE CONCAT(first_name, ' ', last_name) = '{$beanUserFullName}'";
				$userId = $db->getOne($query);
			} else {
				$userId = $beanUserId;
			}
			
			$userBean = BeanFactory::getBean('Users', $userId);

			foreach ($rrBeanList as $rrBean) {
				$rrBean->load_relationship('rrq_regulatoryrequests_rrwg_rrworkinggroup_1');

				$workgroupBeanList = $rrBean->get_linked_beans(
					'rrq_regulatoryrequests_rrwg_rrworkinggroup_1',
					'RRWG_RRWorkingGroup',
					array(),
					0,
					-1,
					0,
					"rrwg_rrworkinggroup.rr_roles = '{$rrRole}' AND parent_type = 'Users' AND parent_id = '{$prevBeanUserId}'"
				);

				// Check if User Bean exists, else, remove RR Working Group Record if it exists
				if ($userBean && $userBean->id) {
					// Check if record exists then update, else create a new one
					if($workgroupBeanList != null && count($workgroupBeanList) > 0) {
						$workgroupBean = $workgroupBeanList[0];
						$workgroupBean->parent_id = $userBean->id;
						$workgroupBean->save();
					} else {
						$workgroupBean = BeanFactory::newBean('RRWG_RRWorkingGroup');
						$workgroupBean->rr_roles = $rrRole;
						$workgroupBean->assigned_user_id = $current_user_id;
						$workgroupBean->created_by = $current_user_id;
						$workgroupBean->parent_type = 'Users';
						$workgroupBean->parent_id = $userBean->id;
						$workgroupBean->save();
						
						$rrBean->rrq_regulatoryrequests_rrwg_rrworkinggroup_1->add($workgroupBean);
					}
				} else {
					if($workgroupBeanList != null && count($workgroupBeanList) > 0) {
						$workgroupBean = $workgroupBeanList[0];
						$workgroupBean->parent_id = '';
						$workgroupBean->save();
					}
				}

				// If Account Assigned User has been updated
				if ($newAssignedUser) {
					// If RR is assigned to Previous Assigned user and set to new value
					if ($rrBean->assigned_user_id === $prevBeanUserId && $userBean && $userBean->id) {
						$updateQuery = "UPDATE rrq_regulatoryrequests SET assigned_user_id = '{$userBean->id}' WHERE id = '{$rrBean->id}'";
                		$db->query($updateQuery);
					}
				}
			}
		}
	}
?>