<?php
  require_once('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');
  $job_strings[] = 'updateAccountSecurityGroupsScheduler';

  function updateAccountSecurityGroupsScheduler()
  {
    global $db, $sugar_config;

    $db = DBManagerFactory::getInstance();

    $integrationUserBean = BeanFactory::getBean('Users')->retrieve_by_string_fields(
      array(
          "user_name" => 'INTEGRATION',
      ), false, true
    );
    
    $accountSQL = " SELECT accounts.id, accounts_audit.before_value_string, accounts_audit.after_value_string 
                    FROM accounts
                    LEFT JOIN accounts_cstm
                      ON accounts.id = accounts_cstm.id_c
                    LEFT JOIN accounts_audit 
                      ON accounts.id = accounts_audit.parent_id
                    WHERE accounts.deleted = 0
                      AND accounts_audit.field_name = 'assigned_user_id'
                      AND accounts.assigned_user_id = accounts_audit.after_value_string
                      AND accounts_cstm.erp_updated_assigned_user_c = 1
                      AND accounts_audit.created_by = '{$integrationUserBean->id}'
                    GROUP BY accounts.id
                    ORDER BY accounts_audit.date_created DESC";
    $accountResult = $db->query($accountSQL);
    
    $GLOBALS['log']->fatal("Update Account Security Groups Scheduler - START");

    while($accountRow = $db->fetchByAssoc($accountResult) ) {
      $eventLogId = create_guid();
      $accountBean = BeanFactory::getBean('Accounts', $accountRow['id']);
      
      $GLOBALS['log']->fatal("ACCOUNT ID: {$accountBean->id}");
      $GLOBALS['log']->fatal("ACCOUNT NAME: {$accountBean->name}");
      
      if (isset($accountRow['before_value_string']) && $accountRow['before_value_string'] == $accountRow['after_value_string']) {
				$assignedUserAccessSecGroup = SecurityGroupHelper::retrieveSecGroupAcctAccessBean($accountRow['after_value_string'], 'Account Access');

				if (! SecurityGroupHelper::checkIfRecordExistsInSecurityGroup($assignedUserAccessSecGroup->id, $accountBean->id, 'Accounts')) {
					SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('insert', $accountBean->id, $assignedUserAccessSecGroup->id, $eventLogId, true, 'Sales', $accountRow['before_value_string']);
				}
      }
      
      if (! $accountRow['before_value_string'] && $accountRow['after_value_string']) {
				$newAssignedUserAccessSecGroup = SecurityGroupHelper::retrieveSecGroupAcctAccessBean($accountRow['after_value_string'], 'Account Access');

				if ($newAssignedUserAccessSecGroup && $newAssignedUserAccessSecGroup->load_relationship('securitygroups_accounts')) {	
					SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('insert', $accountBean->id, $newAssignedUserAccessSecGroup->id, $eventLogId, true, 'Sales', $accountRow['before_value_string']);
				}
			}
      
      if (isset($accountRow['before_value_string']) && $accountRow['before_value_string'] != $accountRow['after_value_string']) {
				
				$oldAssignedUserAccessSecGroup = SecurityGroupHelper::retrieveSecGroupAcctAccessBean($accountRow['before_value_string'], 'Account Access');
				$newAssignedUserAccessSecGroup = SecurityGroupHelper::retrieveSecGroupAcctAccessBean($accountRow['after_value_string'], 'Account Access');

        if ($oldAssignedUserAccessSecGroup) SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('delete', $accountBean->id, $oldAssignedUserAccessSecGroup->id, $eventLogId, true, 'Sales', $accountRow['before_value_string']);
        if ($newAssignedUserAccessSecGroup) SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('insert', $accountBean->id, $newAssignedUserAccessSecGroup->id, $eventLogId, true, 'Sales', $accountRow['before_value_string']);
      }
      
      if (isset($accountRow['before_value_string']) && (! $accountRow['after_value_string'])) {
				$oldAssignedUserAccessSecGroup = SecurityGroupHelper::retrieveSecGroupAcctAccessBean($accountRow['before_value_string'], 'Account Access');

				if ($oldAssignedUserAccessSecGroup && $oldAssignedUserAccessSecGroup->load_relationship('securitygroups_accounts')) {
					SecurityGroupHelper::insertOrDeleteAccountChildModuleSecurityGroups('delete', $accountBean->id, $oldAssignedUserAccessSecGroup->id, $eventLogId, true, 'Sales', $accountRow['before_value_string']);
				}
      }
      
      if ($oldAssignedUserAccessSecGroup) {
        $GLOBALS['log']->fatal("OLD SECURITYGROUP ID: {$oldAssignedUserAccessSecGroup->id}");
        $GLOBALS['log']->fatal("OLD SECURITYGROUP NAME: {$oldAssignedUserAccessSecGroup->name}");
      }
      
      if ($newAssignedUserAccessSecGroup) {
        $GLOBALS['log']->fatal("NEW SECURITYGROUP ID: {$newAssignedUserAccessSecGroup->id}");
        $GLOBALS['log']->fatal("NEW SECURITYGROUP NAME: {$newAssignedUserAccessSecGroup->name}");
      }

      $assignedUserBean = BeanFactory::getBean('Users', $accountBean->assigned_user_id);

      if ($assignedUserBean && $assignedUserBean->id) {
        $customQABanner = $sugar_config['isQA'] == true ? '<span style="color: red;">***This is a test from the Empower QA System***</span><br><br>' : '';
        $url = "{$sugar_config['site_url']}/index.php?module={$accountBean->module_dir}&action=DetailView&record={$accountBean->id}";

        $body = "
          {$customQABanner}

          <p><b>{$integrationUserBean->name}</b> has assigned an Account to <b>{$assignedUserBean->name}</b>.</p>
          <p>
          Name: {$accountBean->name}<br/>
          Type: {$accountBean->account_type}<br/>
          Description: {$accountBean->description}
          </p>
          <p>You may <a href={$url}>review this Account</a>.</p>
        ";

        $emailObj = new Email();
        $defaults = $emailObj->getSystemDefaultEmail();

        $mail = new SugarPHPMailer();
        $mail->setMailerForSystem();
        $mail->From = $defaults['email'];
        $mail->FromName = $defaults['name'];
        $mail->Subject = "EmpowerCRM Account {$accountBean->name} - Assignment Update";
        $mail->Body = from_html($body);
        $mail->AddAddress($assignedUserBean->emailAddress->getPrimaryAddress($assignedUserBean), $assignedUserBean->name);
        $mail->AddBCC($sugar_config['systemBCCEmailAddress']);
        $mail->isHTML(true);
        $mail->prepForOutbound();
        $mail->Send();
      }
      
      $accountBean->erp_updated_assigned_user_c = 0;
      $accountBean->save();
    }

    $GLOBALS['log']->fatal("Update Account Security Groups Scheduler - END");
    return true;
  }