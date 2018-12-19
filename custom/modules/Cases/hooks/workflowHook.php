<?php
	
	include_once('include/SugarPHPMailer.php');
	include_once('include/utils/db_utils.php');

	class workflowHook {
		public function sendEmail($bean, $event, $arguments) {
			
			global $sugar_config;

			$mail = new SugarPHPMailer();
			$emailObj = new Email();
			$defaults = $emailObj->getSystemDefaultEmail();
			$mail = new SugarPHPMailer();
			$mail->setMailerForSystem();
			$mail->From = $defaults['email'];
			$mail->FromName = $defaults['name'];

			$newAssignedTo = $bean->users_cases_1users_ida;
			$newStatus = $bean->status;

			$newUserBean = BeanFactory::getBean('Users', $newAssignedTo);
			$newAssignedUserName = $newUserBean->first_name . ' ' . $newUserBean->last_name;

			$recordURL = $sugar_config['site_url'] . '/index.php?module=Cases&action=DetailView&record=' . $bean->id;

			$mail->Subject = $sugar_config['isQA'] == true ? '[QA] ' : '';

			if(!$bean->fetched_row['id']) {
				$mail->Subject .= 'Customer Issue - New Record';
				$customBodyContent = 'A new customer issue has been created and is assigned to '.$newAssignedUserName.'.';
			} else {
				
				$currentAssignedTo = $bean->rel_fields_before_value['users_cases_1users_ida'];
				$currentStatus = $bean->fetched_row['status'];

				$previousUserBean = BeanFactory::getBean('Users', $currentAssignedTo);
				$previousAssignedUserName = $previousUserBean->first_name . ' ' . $previousUserBean->last_name;

				if($newAssignedTo != $currentAssignedTo && $newStatus == $currentStatus) {

					$mail->Subject .= 'Customer Issue #' .$bean->case_number. ' - Assigned User Update';
					$customBodyContent = 'This record has now been assigned to '.$newAssignedUserName.' from '.$previousAssignedUserName.'.';
					
				} else if($newAssignedTo == $currentAssignedTo && $newStatus != $currentStatus) {

					$mail->Subject .= 'Customer Issue #' .$bean->case_number. ' - Status Update';
					$customBodyContent = 'The status of this record is now set to '.$newStatus.' from '.$currentStatus.'.';

					if($newStatus == 'Responded') {
						$bean->users_cases_1users_ida = $siteLabManager['id'];
						$siteLabManager = $this->retrieveSiteLabManager($bean->site_c, $bean->users_cases_1users_ida);
						$siteLabManagerName = $siteLabManager->first_name . ' ' . $siteLabManager->last_name;
						
						$mail->Subject .= 'Customer Issue #' .$bean->case_number. ' - Assigned User and Status Update';
						$customBodyContent = 'This record has now been assigned to '.$siteLabManagerName.' from '.$previousAssignedUserName.'.
											  <br>
											  The status of this record is now set to '.$newStatus.' from '.$currentStatus.'.';
					}
				} else if($newAssignedTo != $currentAssignedTo && $newStatus != $currentStatus) {
					$mail->Subject .= 'Customer Issue #' .$bean->case_number. ' - Assigned User and Status Update';
					$customBodyContent = 'This record has now been assigned to '.$newAssignedUserName.' from '.$previousAssignedUserName.'.
										  <br>
										  The status of this record is now set to '.$newStatus.' from '.$currentStatus.'.';
				}
			}

			$mail->Body = from_html('Hello,
				<br><br>
				'.$customBodyContent.'

				<br><br>

				Click here to access the record: '.$recordURL.'

				<br><br>

				Thanks,<br>
				'.$defaults['name'].'
			');

			$mail->isHTML(true);
			$mail->prepForOutbound();
			$recipientIDs = $this->retrieveEmailRecipients($bean);
			$this->attachEmailRecipients($recipientIDs, $mail);			
			$mail->Send();
		}

		public function retrieveSiteLabManager($site, $assignedUserID) {
			global $db;

			$sql = "SELECT id, first_name, last_name
					FROM users 
					LEFT JOIN users_cstm
						ON users.id = users_cstm.id_c
					WHERE site_c = '".$site."'
						AND deleted = 0
						AND status = 'Active'
						AND role_c LIKE '%^LabManager^%'
						AND users.id = '".$assignedUserID."'
					ORDER BY id ASC
					LIMIT 1";

			$result = $db->query($sql);
			$row = $db->fetchByAssoc($result);

			return $row;
		}

		public function retrieveEmailRecipients($bean) {
			global $db;

			$sql = "SELECT users.id
					FROM users 
					LEFT JOIN users_cstm
						ON users.id = users_cstm.id_c
					WHERE (
						-- Assigned To
					    (users.id = '".$bean->users_cases_1users_ida."') OR
						-- Site Lab Manager
						(users_cstm.site_c = '".$bean->site_c."' AND users_cstm.role_c LIKE '%^LabManager^%') OR
						-- Paul Legnetti
						(users.first_name = 'Paul' and users.last_name = 'Legnetti') OR
					    -- Sales Person
					    (users.id = '".$bean->assigned_user_id."') OR
						-- Sales Manager of Sales Person
					    (users.id = (SELECT reports_to_id AS id FROM users WHERE users.id = '".$bean->assigned_user_id."' LIMIT 1)) OR
					    -- Customer Service Manager
					    (users_cstm.site_c = '".$bean->site_c."' AND users_cstm.role_c LIKE '%^CustomerServiceManager^%')
					)
						AND users.status = 'Active'
						AND users.deleted = 0;";

			$result = $db->query($sql);

			$emailRecipientsArray = array();
			
			$recipientIDs = '';

			while($row = $db->fetchByAssoc($result) )
			{
				array_push($emailRecipientsArray, "'" . $row['id'] . "'");
			}

			$recipientIDs = implode(', ', $emailRecipientsArray);

			return $recipientIDs;
		}

		public function attachEmailRecipients($recipientIDs, $mail) {
			global $db;

			$sql = "SELECT email_address 
					FROM email_addresses
					LEFT JOIN email_addr_bean_rel
						ON email_addresses.id = email_addr_bean_rel.email_address_id
					LEFT JOIN users
						ON email_addr_bean_rel.bean_id = users.id
					WHERE email_addr_bean_rel.bean_module = 'Users'
						AND users.status = 'Active'
						AND users.id IN (".$recipientIDs.")
						AND users.deleted = 0
						AND email_addresses.deleted = 0
						AND email_addr_bean_rel.deleted = 0;";

			$result = $db->query($sql);

			while($row = $db->fetchByAssoc($result)) {
				$mail->AddAddress($row['email_address']);
			}

			return $mail;
		}
	}