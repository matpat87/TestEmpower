<?php
	
include_once('include/SugarPHPMailer.php');
include_once('include/utils/db_utils.php');
require_once('custom/modules/CWG_CAPAWorkingGroup/helpers/CapaWorkingGroupHelper.php');
require_once('custom/modules/Cases/helpers/CustomerIssuesHelper.php');

class EmailNotificationsHook
{
	public function processNotification($bean, $event, $arguments)
	{
		global $app_list_strings, $log, $sugar_config, $current_user;

		$emailObj = new Email();
        $defaults = $emailObj->getSystemDefaultEmail();

		$customQABanner = $sugar_config['isQA'] == true ? '<span style="color: red;">***This is a test from the Empower QA System***</span><br><br>' : '';
		$recordURL = $sugar_config['site_url'] . '/index.php?module=Cases&action=DetailView&record=' . $bean->id;
		$sendEmail = false;

		$mail = new SugarPHPMailer();
        $mail->setMailerForSystem();
        $mail->From = $defaults['email'];
        $mail->FromName = $defaults['name'];
		$customBodyContent = '';
		$statusUpdate = '';

		$this->attachRecipients($bean, $mail); // Retrieve and attach the recipient as per Status & Severity Values

		// Default Email Subject and Body Content
		if (! $bean->fetched_row['id']) {
			$mail->Subject = "EmpowerCRM Customer Issue - New";
			$customBodyContent = "A new Customer Issue has been created.";
			$sendEmail = true;
		} else {
			$mail->Subject = "EmpowerCRM Customer Issue #{$bean->case_number} - Record Update";
			$customBodyContent = "The Customer Issue #{$bean->case_number} has been updated by {$current_user->name}";
			$sendEmail = false;
		}

		if ($bean->fetched_row['id'] && $bean->fetched_row['status'] != $bean->status) {
			$mail->Subject = "EmpowerCRM Customer Issue #{$bean->case_number} - Status Update";
			$customBodyContent = "A new status has been set to the Customer Issue";
			$sendEmail = true;
		}

		if ($bean->fetched_row['id'] && $bean->fetched_row['assigned_user_id'] != $bean->assigned_user_id) {
			$mail->Subject = "EmpowerCRM Customer Issue #{$bean->case_number} - Assignment Update";
			$customBodyContent = "A new user has been assigned to the Customer Issue";
			$sendEmail = true;
		}

		// Both assigned user and status are changed
		if ($bean->fetched_row['id'] && $bean->assigned_user_id !== $bean->fetched_row['assigned_user_id'] && $bean->status !== $bean->fetched_row['status']) {
			$mail->Subject = "EmpowerCRM Customer Issue #{$bean->case_number} - Assignment & Status Update";
			$customBodyContent = "A new user has been assigned and a new status has been set to the <a href='{$recordURL}'>Customer Issue #".$bean->case_number."</a>";
			$sendEmail = true;
			
		}

		if ($bean->fetched_row['id'] && $bean->status_update_c != '') {
			$statusUpdate = "Status Update:<br> {$bean->status_update_c}<br>";
		}
		
		// Send email only when it's is New or there is A status value update
		if ($sendEmail) {
			// Retrieve Bean again in case the assigned User was updated from the previos After Save Hook: handleAssignedToUser via an sql UPDATE Query
			$userBean = BeanFactory::getBean('Users', $bean->assigned_user_id);
			
			$mail->Body = from_html(
				"
				{$customQABanner}
	
				Hi,
				<br><br>
	
				{$customBodyContent}
				<br><br>
	
				<p>
				Account: {$bean->account_name}<br>
				Issue: {$bean->name}<br>
				Status: ".$app_list_strings['status_list'][$bean->status]."<br>
				Due Date: {$bean->due_date_c}<br>
				Assigned To: {$userBean->name}<br>
				Site: {$app_list_strings['site_list'][$bean->site_c]}<br>
				Source: {$app_list_strings['source_list'][$bean->source_c]}<br>
				Type: {$app_list_strings['ci_type_list'][$bean->ci_type_c]}<br>
				{$statusUpdate}
				</p>
	
	
				Thanks,
				<br>
				{$defaults['name']}
				<br>"
			);
	
			$mail->AddBCC($sugar_config['systemBCCEmailAddress']);
			$mail->isHTML(true);
			$mail->prepForOutbound();
			$mail->Send();
		}

	}

	protected function attachRecipients($customerIssueBean, $mail)
	{
		global $log;
		$recipientBeans = array();

		// Capa Role Users to Retrieve according to Customer Issue Severity/Priority value (key)
		$capaRolesAssignment['Low'] = array('SalesPerson', 'QualityControlManager', 'CustomerServiceManager');
		$capaRolesAssignment['Medium'] = array_merge(['SalesManager'], $capaRolesAssignment['Low']);
		$capaRolesAssignment['High'] = $capaRolesAssignment['Medium'];

		
		switch ($customerIssueBean->status) 
		{
			case 'Draft':
				$assignedUserBeans = [];
				// When status == Draft, should send notification to related Account's assigned to User & Sales Mgr of Sales Rep
				// As per Ontrack #1589 -  Remove notifs when Status = 'Draft'
				// $assignedUserBeans = CapaWorkingGroupHelper::getCapaUsers($customerIssueBean, ['SalesPerson', 'SalesManager']);
				break;
			case 'New':
				if (isset($customerIssueBean->priority) && $customerIssueBean->priority !='') {
					$capaRolesAssignment['Low'] = ['QualityControlManager'];
					unset($capaRolesAssignment['Medium']);
					unset($capaRolesAssignment['High']);
					
					$assignedUserBeans = $this->filterRecipientsBySeverity($customerIssueBean, $capaRolesAssignment);
				} else {
					$workgroupUser = CapaWorkingGroupHelper::getCapaUsers($customerIssueBean, ['QualityControlManager']);
					
					$assignedUserBeans = ($workgroupUser)
						? CapaWorkingGroupHelper::getCapaUsers($customerIssueBean, ['QualityControlManager']) 
						: retrieveUserBySecurityGroupTypeDivision('Quality Control Manager', 'CAPAWorkingGroup', $customerIssueBean->site_c, $customerIssueBean->division_c);
					
				}

				break;
			case 'Approved':
				array_push($capaRolesAssignment['Low'], 'DepartmentManager');
				$capaRolesAssignment['Medium'] = array_merge(['SalesManager', 'PlantManager'], $capaRolesAssignment['Low']);
				$capaRolesAssignment['High'] = $capaRolesAssignment['Medium'];
				
				$assignedUserBeans = $this->filterRecipientsBySeverity($customerIssueBean, $capaRolesAssignment);
				break;
			case 'InProcess':
				$assignedUserBeans  = [];
				if (isset($customerIssueBean->priority) && $customerIssueBean->priority =='Low') {
					$assignedUserBeans =  CapaWorkingGroupHelper::getCapaUsers($customerIssueBean, ['DepartmentManager']); // send to Assigned User [Department Manager]
				}
				// $assignedUserBeans = $this->filterRecipientsBySeverity($customerIssueBean, $capaRolesAssignment);


				break;
			case 'CAPAReview':

				$assignedUserBeans = CapaWorkingGroupHelper::getCapaUsers($customerIssueBean, ['CAPACoordinator']) ?? [];
				// OnTrack 1589: Depracated user recipients according to Severity value
				// array_push($capaRolesAssignment['Low'], 'DepartmentManager');
				// $capaRolesAssignment['Medium'] = array_merge(['SalesManager', 'PlantManager'], $capaRolesAssignment['Low']);
				// $capaRolesAssignment['High'] = $capaRolesAssignment['Medium'];

				// $assignedUserBeans = $this->filterRecipientsBySeverity($customerIssueBean, $capaRolesAssignment);
				break;
			case 'CAPAApproved':
				array_push($capaRolesAssignment['Low'], 'DepartmentManager');
				$capaRolesAssignment['Medium'] = array_merge(['SalesManager', 'PlantManager'], $capaRolesAssignment['Low']);
				$capaRolesAssignment['High'] = $capaRolesAssignment['Medium'];

				$assignedUserBeans = $this->filterRecipientsBySeverity($customerIssueBean, $capaRolesAssignment);
				
				// Retrieve the Assigned User for this Status and push to $assignedUserBeans array if not yet included
				$workgroupUser = CapaWorkingGroupHelper::getCapaUsers($customerIssueBean, ['CAPACoordinator']) ?? null;
				if (!empty($workgroupUser) && !in_array($workgroupUser[0]->id, array_column($assignedUserBeans, 'id'))) {
					$assignedUserBeans[] = $workgroupUser[0];
				}
				
				break;
			case 'CAPAComplete':
				
				$assignedUserBeans = CapaWorkingGroupHelper::getCapaUsers($customerIssueBean, ['InternalAuditor']) ?? [];
				
				// array_push($capaRolesAssignment['Low'], 'DepartmentManager', 'InternalAuditor');
				// $capaRolesAssignment['Medium'] = array_merge(['SalesManager', 'PlantManager'], $capaRolesAssignment['Low']);
				// $capaRolesAssignment['High'] = $capaRolesAssignment['Medium'];

				// $assignedUserBeans = $this->filterRecipientsBySeverity($customerIssueBean, $capaRolesAssignment);
				break;
			case 'Closed':
				$assignedUserBeans = CapaWorkingGroupHelper::getCapaUsers($customerIssueBean, ['CAPACoordinator']) ?? [];
				// array_push($capaRolesAssignment['Low'], 'DepartmentManager', 'InternalAuditor');
				// $capaRolesAssignment['Medium'] = array_merge(['SalesManager', 'PlantManager'], $capaRolesAssignment['Low']);
				// $capaRolesAssignment['High'] = $capaRolesAssignment['Medium'];

				// $assignedUserBeans = $this->filterRecipientsBySeverity($customerIssueBean, $capaRolesAssignment);
				break;
			case 'AwaitingInformation':
				$assignedUserBeans = CapaWorkingGroupHelper::getCapaUsers($customerIssueBean, ['SalesPerson']) ?? [];
				// array_push($capaRolesAssignment['Low'], 'DepartmentManager');
				// $capaRolesAssignment['Medium'] = array_merge(['SalesManager', 'PlantManager'], $capaRolesAssignment['Low']);
				// $capaRolesAssignment['High'] = $capaRolesAssignment['Medium'];

				// $assignedUserBeans = $this->filterRecipientsBySeverity($customerIssueBean, $capaRolesAssignment);
				break;
			case 'Rejected':
				$assignedUserBeans = CapaWorkingGroupHelper::getCapaUsers($customerIssueBean, ['Creator']) ?? [];
				// array_push($capaRolesAssignment['Low'], 'DepartmentManager');
				// $capaRolesAssignment['Medium'] = array_merge(['SalesManager', 'PlantManager'], $capaRolesAssignment['Low']);
				// $capaRolesAssignment['High'] = $capaRolesAssignment['Medium'];

				// $assignedUserBeans = $this->filterRecipientsBySeverity($customerIssueBean, $capaRolesAssignment);
				break;
			case 'Cancelled':
				// $assignedUserBeans = CapaWorkingGroupHelper::getCapaUsers($customerIssueBean, ['SalesPerson', 'SalesManager']);
				$assignedUserBeans = [];
				break;
		} // END OF SWITCH CASE

		if (is_array($assignedUserBeans)) {

			$recipientBeans = array_merge($recipientBeans, $assignedUserBeans);
		} else {
			array_push($recipientBeans, $assignedUserBeans);
		}
		
		foreach ($recipientBeans as $key => $recipient) {
			if (isset($recipient->id) ) {
				$mail->AddAddress($recipient->emailAddress->getPrimaryAddress($recipient), $recipient->name);
			}
        }
	}

	protected function filterRecipientsBySeverity($customerIssueBean, $capaRolesAssignment)
	{
		global $log;

		$userBeans = array();
		$testArray = array();
		
		if ($customerIssueBean->priority == 'Low') {
			// Low - Sales Rep, Quality Manager, CS Manager
			$userBeans = CapaWorkingGroupHelper::getCapaUsers($customerIssueBean, $capaRolesAssignment['Low']);
		}
		
		if ($customerIssueBean->priority == 'Medium') {
			$plantManagerBean = retrieveUserByRoleSiteDivision('Plant Manager', $customerIssueBean->site_c, $customerIssueBean->division_c);
			// Medium – LOW + Sales Manager, Site Department Manager
			$userBeans = CapaWorkingGroupHelper::getCapaUsers($customerIssueBean, $capaRolesAssignment['Medium']);

			if ($customerIssueBean->ci_department_c != 'Operations' && in_array('PlantManager', $capaRolesAssignment['Medium']) && isset($plantManagerBean)) {
				$plantManagerBean->capa_role = 'PlantManager';
				array_push($userBeans, $plantManagerBean);
			}

		}           
		
		if ($customerIssueBean->priority == 'High') {
			// High – LOW + MED + Sales Manager's Manager (Sales VP), Dept Manager's Manager (OPS VP), Quality Manager's Manager, VP Sales' Manager (President)
			$userBeans = CapaWorkingGroupHelper::getCapaUsers($customerIssueBean, $capaRolesAssignment['High']);
			$plantManagerBean = retrieveUserByRoleSiteDivision('Plant Manager', $customerIssueBean->site_c, $customerIssueBean->division_c);
			
			// If the Department is not Operations, we still need to Retrieve the site Plant Manager (if any)
			if ($customerIssueBean->ci_department_c != 'Operations' && in_array('PlantManager', $capaRolesAssignment['Medium']) && isset($plantManagerBean)) {
				$plantManagerBean->capa_role = 'PlantManager';
				array_push($userBeans, $plantManagerBean);
			}

			// GET SALES VP User beans
			$managers = array();
			
			foreach ($userBeans as $bean) {

				if ($bean->capa_role == 'SalesManager' || $bean->capa_role == 'DepartmentManager' || $bean->capa_role == 'QualityControlManager' || $bean->capa_role=='PlantManager') {
					$manager = BeanFactory::getBean('Users', $bean->reports_to_id);
					
					if (isset($manager->id) && !in_array($manager->id, array_column($userBeans, 'id'))) {
						$manager->capa_role = "{$bean->capa_role}_Manager";
						array_push($managers, $manager);

						if ($bean->capa_role == 'SalesManager') {
							// Retrieve SALES VP's Manager
							$president = BeanFactory::getBean('Users', $manager->reports_to_id);
							if (isset($president->id)) {
								$president->capa_role = 'President';
								// array_push($managers, $president); // Ontrack 1589: Exlude President (Sales VP's manager) from list of notification recipients
							} // end of if isset(president)
						}
					}
				}

				$userBeans = array_merge($userBeans, $managers);
			} // end of foreach
			
			
		}


		// foreach ($userBeans as $user) {
		// 	$testArray[$user->capa_role] = $user->full_name;
		// }

		// $log->fatal(print_r($testArray, true));
		// $log->fatal(print_r($capaRolesAssignment, true));
		return $userBeans;

	}

}