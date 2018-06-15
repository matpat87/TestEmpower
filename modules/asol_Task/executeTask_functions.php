<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
require_once("modules/asol_Process/___common_WFM/php/Basic_wfm.php");
require_once("modules/asol_Process/generateQuery_wfm.php");

wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

//require_once("include/SugarPHPMailer.php");

//global $beanList, $beanFiles, $app_list_strings;

function executeTask($task_id, $task_type, $task_implementation, $alternative_database, $trigger_module, $bean_id, $process_instance_id, $working_node_id, $bean_ungreedy_count, $old_bean, $new_bean, & $custom_variables, $current_user_id, $audit) {
	wfm_utils::wfm_log('flow_debug', "ENTRY", __FILE__, __METHOD__, __LINE__);
	wfm_utils::wfm_log('debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);

	global $sugar_config;

	// FIXME change success to executeResult?????
	
	switch ($task_type) {
		case 'send_email':
			$success = task_send_email($task_id, $task_implementation, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
			break;
		case 'create_object':
			$success = task_create_object($task_implementation , $alternative_database, $trigger_module, $bean_id, $bean_ungreedy_count, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit); // if succesful -> return Array('object_id' => $object_id,'object_module' =>$module ) else return false
			break;
		case 'modify_object':
			$success = task_modify_object($bean_id, $task_implementation, $alternative_database, $bean_ungreedy_count, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit); // if succesful -> return Array('object_id' => $object_id,'object_module' =>$module ) else return false
			break;
		case 'php_custom':
			$success = task_php_custom($task_id, $task_implementation, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
			break;
		case 'end':
			$success = task_end($task_implementation, $process_instance_id, $working_node_id);
			break;
		case 'call_process':
			$success = task_call_process($task_implementation, $alternative_database, $trigger_module, $bean_id, $process_instance_id, $working_node_id, $bean_ungreedy_count, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
			break;
		case 'add_custom_variables':
			$success = task_add_custom_variables($task_implementation, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
			break;
		case 'get_objects':
			$success = task_get_objects($task_id, $task_implementation, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
			break;
		case 'forms_response':
			$success = task_forms_response($task_id, $task_implementation, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit, $process_instance_id, $working_node_id);
			break;
		case 'forms_error_message':
			$success = task_forms_error_message($task_id, $task_implementation, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
			break;
	}

	wfm_utils::wfm_log('debug', "EXIT", __FILE__, __METHOD__, __LINE__);
	return $success;
}

function task_send_email($task_id, $implementationField, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit) {
	wfm_utils::wfm_log('flow_debug', "ENTRY", __FILE__, __METHOD__, __LINE__);
	wfm_utils::wfm_log('debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);

	global $beanList, $beanFiles, $app_list_strings, $db, $sugar_config;

	$fields = explode('${pipe}', $implementationField);

	// Get EmailTemplate bean
	require_once("modules/EmailTemplates/EmailTemplate.php");
	$templateBean = new EmailTemplate();
	$templateBean->retrieve($fields[0]);

	$bodyHtml = $templateBean->body_html;
	// wfm_utils::wfm_log('debug', '$bodyHtml=['.var_export($bodyHtml, true).']', __FILE__, __METHOD__, __LINE__);
	//$bodyHtml = html_entity_decode($bodyHtml, ENT_COMPAT, "ISO-8859-1"); // PHP 5.4 and 5.5 will use UTF-8 as the default. Earlier versions of PHP use ISO-8859-1. 
	$bodyHtml = html_entity_decode($bodyHtml, ENT_COMPAT, "UTF-8");
	// wfm_utils::wfm_log('debug', '$bodyHtml=['.var_export($bodyHtml, true).']', __FILE__, __METHOD__, __LINE__);

	$body = $templateBean->body;
	//$body = html_entity_decode($body, ENT_COMPAT);
	//$body = html_entity_decode($body, ENT_COMPAT, "ISO-8859-1");
	//$body = iconv("ISO-8859-1", "UTF-8//TRANSLIT//IGNORE", $body); // email_template is written in ISO-8859-1
	$body = html_entity_decode($body, ENT_COMPAT, "UTF-8");
	$body = preg_replace('/(\'|&#0*39;)/', "'", $body);
	//wfm_utils::wfm_log('debug', '$body=['.var_export($body, true).']', __FILE__, __METHOD__, __LINE__);

	// Get the body-HTML with the variables translated to their values
	$bodyHtml = replace_wfm_vars('body_as_html', $bodyHtml, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
	// Get body with the variables translated to their values
	$body = replace_wfm_vars('body_as_plain_text', $body, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
	// Get the subject with the variables translated to their values
	$subject = $templateBean->subject;
	// wfm_utils::wfm_log('debug', '1 $subject=['.var_export($subject, true).']', __FILE__, __METHOD__, __LINE__);
	//$subject = html_entity_decode($subject, ENT_COMPAT, "ISO-8859-1");
	$subject = html_entity_decode($subject, ENT_COMPAT, "UTF-8");
	//$subject = html_entity_decode($subject, ENT_COMPAT);
	$subject = preg_replace('/(\'|&#0*39;)/', "'", $subject);
	// wfm_utils::wfm_log('debug', '2 $subject=['.var_export($subject, true).']', __FILE__, __METHOD__, __LINE__);
	$subject = replace_wfm_vars('subject', $subject, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
	// wfm_utils::wfm_log('debug', '3 $subject=['.var_export($subject, true).']', __FILE__, __METHOD__, __LINE__);
	
	$from = replace_wfm_vars(null, urldecode($fields[2]), $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
	$replyto = replace_wfm_vars(null, urldecode($fields[15]), $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
	$return_path = replace_wfm_vars(null, urldecode($fields[16]), $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);

	// wfm_utils::wfm_log('debug', '$bodyHtml=['.var_export($bodyHtml, true).']', __FILE__, __METHOD__, __LINE__);


	/********BEGIN TinyMCE**********/

	//	$bodyHtml = str_replace("<p>", "", $bodyHtml);
	//	$bodyHtml = str_replace("</p><br />", "", $bodyHtml);
	//	$bodyHtml = str_replace("</p>", "<br>", $bodyHtml);
	//	$bodyHtml = str_replace("</p>", "<br>", $bodyHtml);
	//
	//	$bodyHtml = str_replace("ñ", "&ntilde;", $bodyHtml);
	//	$bodyHtml = str_replace("Ñ", "&Ntilde;", $bodyHtml);

	//$bodyHtml=stripslashes(ereg_replace("'","&#34;",$bodyHtml));

	//wfm_utils::wfm_log('asol', '$bodyHtml=['.var_export($bodyHtml, true).']', __FILE__, __METHOD__, __LINE__);

	/********END TinyMCE**********/

	// Get SugarPHPMailer bean

	$sugarPHPMailer = new WFM_SugarPHPMailer();
	$sugarPHPMailer->setMailerForSystem();
	
	$sugarPHPMailer->From = $from;
	$sugarPHPMailer->AddReplyTo($replyto, $replyto);
	$sugarPHPMailer->sender = $return_path;
	$sugarPHPMailer->FromName = $from;
	$sugarPHPMailer->Timeout = 30;

	$sugarPHPMailer->Subject = $subject;
	$sugarPHPMailer->CharSet = "UTF-8";

	$text_only = false;
	if (isset($templateBean->text_only) && $templateBean->text_only){
		$text_only = true;
	}

	if ($text_only) {
		$sugarPHPMailer->Body = nl2br($body);
		$sugarPHPMailer->AltBody = $body;
		$sugarPHPMailer->IsHTML(false);
	} else {
		$sugarPHPMailer->Body = $bodyHtml;
		$sugarPHPMailer->AltBody = $body;
		$sugarPHPMailer->IsHTML(true);
	}

	// Attachments
	$attachmentsQuery = $db->query("SELECT * FROM notes WHERE parent_type='Emails' AND parent_id='{$templateBean->id}' AND deleted = 0");
	while($row = $db->fetchByAssoc($attachmentsQuery)) {
		$sugarPHPMailer->AddAttachment(getcwd()."/upload/{$row['id']}", $row['filename']);
	}

	// Get send_email addresses
	$to_cc_bcc = Array(3 => 'to', 4 => 'cc', 5 => 'bcc');
	foreach($to_cc_bcc as $key_to_cc_bcc => $value_to_cc_bcc) {

		//------ users select: to,cc,bcc -->(3,4,5)
		// Get emails from selected Users in the send email task.
		$users_string = $fields[$key_to_cc_bcc];
		$users = explode('${comma}', $users_string);
		// wfm_utils::wfm_log('debug', '$users=['.var_export($users, true).']', __FILE__, __METHOD__, __LINE__);

		if (!empty($users[0])) {
			wfm_utils::initializeEmailArray($emailArray);
			$emailArray["users_{$value_to_cc_bcc}"] = $users;
			wfm_utils::setSendEmailAddresses($sugarPHPMailer, $emailArray, $new_bean['asol_domain_id']);
		}

		//------ acl_roles select: to,cc,bcc -->(6,7,8)
		// Get emails from selected Roles in the send email task.
		$acl_roles__string = $fields[$key_to_cc_bcc+3];
		$acl_roles = explode('${comma}', $acl_roles__string);
		// wfm_utils::wfm_log('debug', '$acl_roles=['.var_export($acl_roles, true).']', __FILE__, __METHOD__, __LINE__);

		// For each role, we get his users(it can be more than one). And once we have the role's users, we get the user's email.
		if (!empty($acl_roles[0])) {
			wfm_utils::initializeEmailArray($emailArray);
			$emailArray["roles_{$value_to_cc_bcc}"] = $acl_roles;
			wfm_utils::setSendEmailAddresses($sugarPHPMailer, $emailArray, $new_bean['asol_domain_id']);
		}

		//------ email_list textarea: to,cc,bcc -->(9,10,11)
		$emails_string = replace_wfm_vars(null, urldecode($fields[$key_to_cc_bcc+6]), $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);

		$emails = explode(',', $emails_string); // It could be more than one email. Emails have to be separated by commas(with no blanks).
		//if (!empty($emails[0])) {
		foreach ($emails as $email) {
			wfm_utils::wfm_AddAddress($value_to_cc_bcc, $email, $sugarPHPMailer);
		}
		//}

		//------ notificationEmails select: to,cc,bcc -->(12,13,14)
		// Get emails from selected Users in the send email task.
		$notificationEmails_string = $fields[$key_to_cc_bcc+9];
		$notificationEmails = explode('${comma}', $notificationEmails_string);
		// wfm_utils::wfm_log('debug', '$notificationEmails=['.var_export($notificationEmails, true).']', __FILE__, __METHOD__, __LINE__);

		if (!empty($notificationEmails[0])) {
			wfm_utils::initializeEmailArray($emailArray);
			$emailArray["notificationEmails_{$value_to_cc_bcc}"] = $notificationEmails;
			wfm_utils::setSendEmailAddresses($sugarPHPMailer, $emailArray, $new_bean['asol_domain_id']);
		}
	}

	$there_is_destination_address = ($there_is_address['to'] || $there_is_address['cc'] || $there_is_address['bcc']) || true;// TODO

	//sleep(10);
	//// wfm_utils::wfm_log('debug', "sleep", __FILE__, __METHOD__, __LINE__);

	//wfm_utils::wfm_log('asol', '$sugarPHPMailer=['.print_r($sugarPHPMailer, true).']', __FILE__, __METHOD__, __LINE__);

	// SEND EMAIL
	
	$tries=0;
	
	if ($there_is_destination_address) {

		$success = $sugarPHPMailer->Send();
		$tries=1;

		while (!($success) && ($tries < 5)) {
			sleep(5);
			$success = $sugarPHPMailer->Send();
			$tries++;
		}
	} else {
		$success = false;
		wfm_utils::wfm_log('asol', "There is no destination-addresses", __FILE__, __METHOD__, __LINE__);
	}

	// Log Email
	$logEmail = Array(
		'tries' => $tries,
		'from' => $sugarPHPMailer->From,
		'to' => $sugarPHPMailer->getAddresses('to'),
		'cc' => $sugarPHPMailer->getAddresses('cc'),
		'bcc' => $sugarPHPMailer->getAddresses('bcc'),
		'subject' => $sugarPHPMailer->Subject,
		'body' => $sugarPHPMailer->Body,
	);
	wfm_utils::wfm_log('asol', '$logEmail=['.var_export($logEmail, true).']', __FILE__, __METHOD__, __LINE__);

	// Success?
	if (!$success) {
		wfm_utils::wfm_log('fatal', "ERROR sending e-mail (method: ". var_export($sugarPHPMailer->Mailer, true).", (error: ". var_export($sugarPHPMailer->ErrorInfo, true) .")", __FILE__, __METHOD__, __LINE__);
	} else {
		wfm_utils::wfm_log('asol', "e-mail successfully sent", __FILE__, __METHOD__, __LINE__);
	}

	wfm_utils::wfm_log('flow_debug', "EXIT", __FILE__, __METHOD__, __LINE__);
	return $success;
}

function task_php_custom($task_id, $task_implementation, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, & $custom_variables, $current_user_id, $audit) {
	wfm_utils::wfm_log('flow_debug', "ENTRY", __FILE__, __METHOD__, __LINE__);

	$fileName = "{$task_id}.php";
	$fileCompletePath = "modules/asol_Task/_temp_php_custom_Files/{$fileName}";

	if (!file_exists($fileCompletePath)) {
		wfm_utils::wfm_SavePhpCustomToFile($task_id, $task_implementation);
	}

	require($fileCompletePath);// do not use require_one -> if several objects -> will take the first values always

	wfm_utils::wfm_log('flow_debug', "EXIT", __FILE__, __METHOD__, __LINE__);
	return $executeResult;
}

function task_end($task_implementation, $process_instance_id, $working_node_id) {
	wfm_utils::wfm_log('flow_debug', "ENTRY", __FILE__, __METHOD__, __LINE__);

	global $db;

	// Terminate working_node
	$date_modified = gmdate('Y-m-d H:i:s');

	$db->query("
		UPDATE asol_workingnodes 
		SET status = 'terminated', date_modified = '{$date_modified}' 
		WHERE id = '{$working_node_id}'
	");

	// Terminate all working_nodes from this process_instance
	if ($task_implementation == 'true') { // If terminate_process is checked
		wfm_utils::wfm_log('debug', "Terminate Process", __FILE__, __METHOD__, __LINE__);

		$db->query("
			UPDATE asol_workingnodes 
			SET status = 'terminated', date_modified = '{$date_modified}' 
			WHERE asol_processinstances_id_c = '{$process_instance_id}'
		");
	}

	wfm_utils::wfm_log('flow_debug', "EXIT", __FILE__, __METHOD__, __LINE__);
	return 'task_end';
}

function task_continue() {
	wfm_utils::wfm_log('flow_debug', "ENTRY", __FILE__, __METHOD__, __LINE__);
	// Do nothing
	wfm_utils::wfm_log('flow_debug', "EXIT", __FILE__, __METHOD__, __LINE__);
	return true;
}

function task_create_object($taskImplementation, $alternative_database, $trigger_module, $bean_id, $bean_ungreedy_count, $old_bean, $new_bean, & $custom_variables, $current_user_id, $audit) {
	wfm_utils::wfm_log('flow_debug', "ENTRY", __FILE__, __METHOD__, __LINE__);

	global $beanList, $beanFiles, $app_list_strings, $sugar_config;

	$taskImplementationArray = explode('${mod}', $taskImplementation);
	$objectModule = $taskImplementationArray[0]; // create_object => object_module != trigger_module
	$fieldsAndRelationshipsArray =  explode('${relationships}', $taskImplementationArray[1]);
	$fields = $fieldsAndRelationshipsArray[0];
	$relationships = $fieldsAndRelationshipsArray[1];

	if (empty($objectModule)) {
		wfm_utils::wfm_log('asol', "No module selected", __FILE__, __METHOD__, __LINE__);
		return false;
	}

	// Create Object.

	$class_name = $beanList[$objectModule];
	require_once($beanFiles[$class_name]);
	$bean = new $class_name();

	// replace fields
	replace_fields($bean, $fields, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $bean_ungreedy_count, $audit);

	$object_id = $bean->save();
	wfm_utils::wfm_log('asol', '$object_id=['.var_export($object_id, true).']', __FILE__, __METHOD__, __LINE__);

	// Create Relationships.
	createRelationships($bean, $relationships, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id);

	// Return.

	wfm_utils::wfm_log('flow_debug', "EXIT", __FILE__, __METHOD__, __LINE__);
	if ($object_id != false) {
		$created_object = wfm_utils::wfm_get_bean_variable_array_from_bean_field_defs_not_equals_non_db($bean);
		return Array('object_id' => $object_id, 'object_module' => $objectModule, 'created_object' => $created_object);
	}
	return $object_id; // It has to be false if the flow comes this away.
}

function task_modify_object($object_id, $taskImplementation, $alternative_database, $bean_ungreedy_count, $old_bean, $new_bean, & $custom_variables, $current_user_id, $audit) {
	wfm_utils::wfm_log('flow_debug', "ENTRY", __FILE__, __METHOD__, __LINE__);
	wfm_utils::wfm_log('debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);

	global $beanList, $beanFiles, $app_list_strings, $sugar_config;

	$taskImplementationArray = explode('${mod}', $taskImplementation);
	$objectModule = $taskImplementationArray[0];
	
	// If a wfm-task modify_object is defined in a subprocess then the $object_id can belong to an object of different module than the subprocess's trigger_module.
	if ($new_bean['module_dir'] !== $objectModule) { // FIXME
		wfm_utils::wfm_log('asol', '$new_bean["module_dir"]=['.$new_bean["module_dir"].'] !== $objectModule=['.$objectModule.']', __FILE__, __METHOD__, __LINE__);
		//return false; // FIXME
	}
	
	$fieldsAndRelationshipsArray =  explode('${relationships}', $taskImplementationArray[1]);
	$fields = $fieldsAndRelationshipsArray[0];
	$relationships = $fieldsAndRelationshipsArray[1];
	$trigger_module = $objectModule;  //  modify_object => object_module == trigger_module

	$class_name = $beanList[$objectModule];
	require_once($beanFiles[$class_name]);
	$bean = new $class_name();
	$bean->retrieve($object_id);
	$bean_id = $object_id;

	// replace fields
	replace_fields($bean, $fields, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $bean_ungreedy_count, $audit);
	
	wfm_utils::wfm_log('asol', '$bean->ungreedy_count=['.var_export($bean->ungreedy_count, true).']', __FILE__, __METHOD__, __LINE__);

	$object_id = $bean->save(); // Be careful -> this return all the object, not just the id (in case of modify_object... in case of create_object returns only the id... it is weird, but it is just like that)
	//wfm_utils::wfm_log('asol', '$object_id=['.print_r($object_id, true).']', __FILE__, __METHOD__, __LINE__);

	// Create Relationships.
	createRelationships($bean, $relationships, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id);

	// Return.

	wfm_utils::wfm_log('flow_debug', "EXIT", __FILE__, __METHOD__, __LINE__);
	if ($object_id != false) {
		return Array('object_id' => $bean->id, 'object_module' => $objectModule);
	}
	return $object_id; // It has to be false if the flow comes this away.
}

function task_call_process($task_implementation, $alternative_database, $parent_trigger_module, $parent_bean_id, $parent_process_instance_id, $parent_working_node_id, $bean_ungreedy_count, $old_bean, $new_bean, &$custom_variables, $current_user_id, $audit) {
	wfm_utils::wfm_log('flow_debug', "ENTRY", __FILE__, __METHOD__, __LINE__);
	wfm_utils::wfm_log('asol_debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);

	global $db, $sugar_config, $app_list_strings;
	
	$custom_variables['parent_process_bean']['new_bean'] = $new_bean;
	$custom_variables['parent_process_bean']['old_bean'] = $old_bean;
	
	$task_implementation = str_replace("&quot;", '"', $task_implementation);

	$task_implementation_array = json_decode($task_implementation, true);
	
	$process_id = $task_implementation_array['process_id'];
	$process_name = $task_implementation_array['process_name'];
	$event_id = $task_implementation_array['event_id'];
	$event_name = $task_implementation_array['event_name'];
	$object_module = $task_implementation_array['object_module'];
	$object_ids = $task_implementation_array['object_ids'];
	$execute_subprocess_immediately = $task_implementation_array['execute_subprocess_immediately'];
	
	// wfm_utils::wfm_log('debug', '$process_id=['.var_export($process_id, true).']', __FILE__, __METHOD__, __LINE__);
	// wfm_utils::wfm_log('debug', '$process_name=['.var_export($process_name, true).']', __FILE__, __METHOD__, __LINE__);
	// wfm_utils::wfm_log('debug', '$event_id=['.var_export($event_id, true).']', __FILE__, __METHOD__, __LINE__);
	// wfm_utils::wfm_log('debug', '$event_name=['.var_export($event_name, true).']', __FILE__, __METHOD__, __LINE__);
	// wfm_utils::wfm_log('debug', '$object_module=['.var_export($object_module, true).']', __FILE__, __METHOD__, __LINE__);
	// wfm_utils::wfm_log('debug', '$object_ids=['.var_export($object_ids, true).']', __FILE__, __METHOD__, __LINE__);
	// wfm_utils::wfm_log('debug', '$execute_subprocess_immediately=['.var_export($execute_subprocess_immediately, true).']', __FILE__, __METHOD__, __LINE__);
	
	$process_name = urldecode($process_name);
	$event_name = urldecode($event_name);
	
	// wfm_utils::wfm_log('debug', '$process_name=['.var_export($process_name, true).']', __FILE__, __METHOD__, __LINE__);
	// wfm_utils::wfm_log('debug', '$event_name=['.var_export($event_name, true).']', __FILE__, __METHOD__, __LINE__);
	
	if (strpos($process_name, '${') !== false) {
		$process_id = replace_wfm_vars(null, $process_name, $alternative_database, $parent_trigger_module, $parent_bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
	}
	
	if (strpos($event_name, '${') !== false) {
		$event_id = replace_wfm_vars(null, $event_name, $alternative_database, $parent_trigger_module, $parent_bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
	}
	
	// wfm_utils::wfm_log('debug', '$process_id=['.var_export($process_id, true).']', __FILE__, __METHOD__, __LINE__);
	// wfm_utils::wfm_log('debug', '$event_id=['.var_export($event_id, true).']', __FILE__, __METHOD__, __LINE__);
	
	$object_module = urldecode($object_module);
	$object_module = replace_wfm_vars(null, $object_module, $alternative_database, $parent_trigger_module, $parent_bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
	$object_ids = urldecode($object_ids);
	$object_ids = replace_wfm_vars(null, $object_ids, $alternative_database, $parent_trigger_module, $parent_bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
	
	// wfm_utils::wfm_log('debug', '$object_module=['.var_export($object_module, true).']', __FILE__, __METHOD__, __LINE__);
	// wfm_utils::wfm_log('debug', '$object_ids=['.var_export($object_ids, true).']', __FILE__, __METHOD__, __LINE__);
	
	/*-- BEGIN - {object_module, object_ids} --*/
	
	$recalculate_new_bean = false;
	
	if (empty($object_ids)) {
		$object_id = $parent_bean_id;
		$object_ids = $parent_bean_id;
		$trigger_module = $parent_trigger_module;
	} else {
	
		$object_ids_array = explode('${pipe}', $object_ids);
		$object_id = $object_ids_array[0];
		if ($object_id == $parent_bean_id) {
			$object_id = $parent_bean_id;
			$object_ids = $parent_bean_id;
			$trigger_module = $parent_trigger_module;
		} else {
			
			$recalculate_new_bean = true;
			//$new_bean = wfm_utils::wfm_get_bean_variable_array($alternative_database, $object_module, $object_id); // FIXME -> OJO! -> $alternative_database no tiene relación con $object_module ---> process vs. subprocess
			$old_bean = null;
			$trigger_module = $object_module;
		}
	}
	
	if (empty($object_module)) {
		$object_id = $parent_bean_id;
		$object_ids = $parent_bean_id;
		$trigger_module = $parent_trigger_module;
	}
	
	/*-- END - {object_module, object_ids} --*/

	$process_and_event_list = Array();
	
	/*-- BEGIN - {process_id, event_id} --*/
	
	if ((empty($process_id)) && (empty($event_id))) {
		
		$object_id = $parent_bean_id;
		$object_ids = $parent_bean_id;
		$trigger_module = $parent_trigger_module;
		
		return false;
		
	} elseif ((!empty($process_id)) && (empty($event_id))) {

		if (wfm_utils::str_starts_with($process_id, ';')){ // If wfm-variable
			// wfm_utils::wfm_log('debug', '1', __FILE__, __METHOD__, __LINE__);
			
			$process_ids_array = explode(";;", substr($process_id, 1, -1));
			// wfm_utils::wfm_log('debug', '$process_ids_array=['.var_export($process_ids_array, true).']', __FILE__, __METHOD__, __LINE__);
			
			$trigger_type = 'subprocess'; // Only execute subprocess, not subprocess_local
			
			foreach ($process_ids_array as $iter_process_id) {
				$event_ids = wfm_utils::getEventIds_byProcessId_byTriggerType($iter_process_id, $trigger_type);
			
				foreach ($event_ids as $iter_event_id) {
					$process_and_event_list[] = Array('process_id' => $iter_process_id, 'event_id' => $iter_event_id);
				}
			}
			
		} else {
			// wfm_utils::wfm_log('debug', '2', __FILE__, __METHOD__, __LINE__);
				
			$trigger_type = 'subprocess'; // Only execute subprocess, not subprocess_local
			
			$event_ids = wfm_utils::getEventIds_byProcessId_byTriggerType($process_id, $trigger_type);
				
			foreach ($event_ids as $iter_event_id) {
				$process_and_event_list[] = Array('process_id' => $process_id, 'event_id' => $iter_event_id);
			}
		}
		
	} elseif ((empty($process_id)) && (!empty($event_id))) {
		
		$event = wfm_utils::getBean('asol_Events', $event_id);
		$process_id = $event->asol_proce6f14process_ida;
		$trigger_type = $event->trigger_type;
		
		$process_and_event_list[] = Array('process_id' => $process_id, 'event_id' => $event_id);
	
	} elseif ((!empty($process_id)) && (!empty($event_id))) {
		
		$process_and_event_list[] = Array('process_id' => $process_id, 'event_id' => $event_id);
		$event = wfm_utils::getBean('asol_Events', $event_id);
		$trigger_type = $event->trigger_type;
		
	}
	
	wfm_utils::wfm_log('debug', '$process_and_event_list=['.var_export($process_and_event_list, true).']', __FILE__, __METHOD__, __LINE__);
	
	/*-- END - {process_id, event_id} --*/
	
	if ($recalculate_new_bean) {
		if (count($process_and_event_list) > 0) {
			$aux_process_id = $process_and_event_list[0]['process_id'];
			
			$data_source = wfm_utils::getDataSource_fromProcessId($process_id);
			
			$audit = wfm_utils::getAudit_fromProcessId($aux_process_id);
			$audit = ($audit == '1') ? true : false;
			
			if ($data_source == 'form') {
				
			} else {
				if ($audit) {
					$new_bean = wfm_utils::getAuditRecord($object_module, $object_id);
				} else {
					$new_bean = wfm_utils::wfm_get_bean_variable_array($alternative_database, $object_module, $object_id); // FIXME -> OJO! -> $alternative_database no tiene relación con $object_module ---> process vs. subprocess
				}
			}
		}
	}
	
	$bean_ungreedy_count++;
	
	foreach ($process_and_event_list as $process_and_event) {
		
		$process_id = $process_and_event['process_id'];
		$event_id = $process_and_event['event_id'];
		
		$subprocess_type = Basic_wfm::getField('asol_events', $event_id, 'subprocess_type');
		
		// Avoid that a process can call_process itselft at run-time.
		$process_id__from_parent_process_instance_id__query = $db->query("
			SELECT asol_process_id_c
			FROM asol_processinstances
			WHERE id = '{$parent_process_instance_id}'
		");
		$process_id__from_parent_process_instance_id__row = $db->fetchByAssoc($process_id__from_parent_process_instance_id__query);
		
		if ($process_id == $process_id__from_parent_process_instance_id__row['asol_process_id_c']) {
			// TODO
			//wfm_utils::wfm_log('asol', "process_id == subprocess_id -> do NOT execute.", __FILE__, __METHOD__, __LINE__);
			//return false;
		}
		
		// TODO -> deleted???
		
		// Avoid that a process can call_process a subprocess that is inactive.
		$subprocess_query = $db->query("
			SELECT *
			FROM asol_process
			WHERE id = '{$process_id}'
		");
		$subprocess_row = $db->fetchByAssoc($subprocess_query);
		
		if ($subprocess_row['status'] == 'inactive') {
			wfm_utils::wfm_log('asol', "Subprocess is inactive -> do NOT execute.", __FILE__, __METHOD__, __LINE__);
			return false;
		}
		
		// FIXME // Avoid that a process can call_process a subprocess that has a different Module.
		$parent_process_query = $db->query("
			SELECT status, trigger_module
			FROM asol_process
			WHERE id = '{$process_id__from_parent_process_instance_id__row['asol_process_id_c']}'
		");
		$parent_process_row = $db->fetchByAssoc($parent_process_query);
		
		if ($subprocess_row['trigger_module'] != $parent_process_row['trigger_module']) {
			//wfm_utils::wfm_log('asol', "\$subprocess_row['trigger_module'] != \$parent_process_row['trigger_module'] -> do NOT execute.", __FILE__, __METHOD__, __LINE__);
			//return false;
		}
		
		// INSTANCIATE SUBPROCESS
		
		// For the wfm-event, we get its wfm-activities
		$activities = Array(); // [0->[event_idX, activity_id0],..., ]
		$activity_query = $db->query("
			SELECT asol_event87f4_events_ida AS event_id, asol_event8042ctivity_idb AS activity_id
			FROM asol_eventssol_activity_c
			WHERE (asol_event87f4_events_ida = '{$event_id}' AND deleted = 0)
		");
		while ($activity_row = $db->fetchByAssoc($activity_query)) {
			$activities[] = $activity_row;
		}
		// wfm_utils::wfm_log('debug', '$activities=['.var_export($activities, true).']', __FILE__, __METHOD__, __LINE__);
		
		if (count($activities) == 0) { // Allow that an event can have no activities. Otherwise, it will not clean the database correctly.
			wfm_utils::wfm_log('flow_debug', "Allow that an event can have no activities. Otherwise, it will not clean the database correctly.", __FILE__, __METHOD__, __LINE__);
			return false;
		}
		
		// TODO - event-duplicity
		
		// asol_domains
		$subprocess_row['asol_domain_id'] = (!empty($subprocess_row['asol_domain_id'])) ? $subprocess_row['asol_domain_id'] : "''";
		$isDomainsInstalled = wfm_domains_utils::wfm_isDomainsInstalled();
		$asol_domains_query_1 = ($isDomainsInstalled) ? ', asol_domain_id' : '';
		$asol_domains_query_2 = ($isDomainsInstalled) ? ", {$subprocess_row['asol_domain_id']}" : '';
		
		// Add process_instance to DB
		$id1 = create_guid();
		$name1 = "p_i_".$id1;
		// $bean_ungreedy_count++;
		$date_entered = gmdate('Y-m-d H:i:s');
		$date_modified = $date_entered;
		$created_by = $current_user_id;
		$modified_user_id = $current_user_id;
		$assigned_user_id = $current_user_id;
		
		$db->query("
			INSERT INTO asol_processinstances (id, name, date_entered, date_modified, asol_process_id_c, asol_processinstances_id_c, bean_ungreedy_count, created_by, modified_user_id, assigned_user_id {$asol_domains_query_1})
			VALUES ('{$id1}', '{$name1}', '{$date_entered}', '{$date_modified}', '{$process_id}', '{$parent_process_instance_id}', {$bean_ungreedy_count}, '{$created_by}', '{$modified_user_id}', '{$assigned_user_id}' {$asol_domains_query_2})
		");
		
		// Add working_nodes to DB
		$working_node_ids = Array();
		foreach ($activities as $activity) {
		
			$trigger_type = $trigger_type;
			$priority = $app_list_strings['wfm_working_node_priority'][$trigger_type][$subprocess_type];
		
			$id2 = create_guid();
			$working_node_ids[] = $id2;
			$name2 = "w_n_".$id2;
			$type = "{$trigger_type}_{$subprocess_type}";
			$date_entered = gmdate('Y-m-d H:i:s');
			$date_modified = $date_entered;
			$current_activity = $activity['activity_id'];
			//$object_ids = $parent_bean_id;
			$object_ids = $object_ids;
			$iter_object = 0;
			//$trigger_module = $parent_trigger_module;
			//$object_id = $parent_bean_id;
			$current_task = 'null';
			$delay_wakeup_time = '0000-00-00 00:00:00';
			$created_by = $current_user_id;
			$modified_user_id = $current_user_id;
			$assigned_user_id = $current_user_id;
			$status = 'not_started';
			$old_bean_to_db = base64_encode(serialize($old_bean));
			$new_bean_to_db = base64_encode(serialize($new_bean));
			$custom_variables_to_db = base64_encode(serialize($custom_variables));
		
			$db->query("
				INSERT asol_workingnodes (id, name, type, asol_processinstances_id_c, priority, date_entered, date_modified, asol_events_id_c, asol_activity_id_c, object_ids, iter_object, parent_type, parent_id, asol_task_id_c, delay_wakeup_time, created_by, modified_user_id, assigned_user_id, status, old_bean, new_bean, custom_variables {$asol_domains_query_1})
				VALUES ('{$id2}', '{$name2}', '{$type}', '{$id1}', {$priority}, '{$date_entered}', '{$date_modified}', '{$event_id}', '{$current_activity}', '{$object_ids}', {$iter_object}, '{$trigger_module}', '{$object_id}', {$current_task}, '{$delay_wakeup_time}', '{$created_by}', '{$modified_user_id}', '{$assigned_user_id}', '{$status}', '{$old_bean_to_db}', '{$new_bean_to_db}', '{$custom_variables_to_db}' {$asol_domains_query_2})
			");
		}
		
		if ($execute_subprocess_immediately) {
			
			$custom_variables_subprocess = null;
			$executeResult = execute_WFM($working_node_ids, $custom_variables_subprocess);
			wfm_utils::wfm_log('asol_debug', '$executeResult=['.var_export($executeResult, true).']', __FILE__, __METHOD__, __LINE__);
			wfm_utils::wfm_log('asol_debug', '$custom_variables_subprocess=['.var_export($custom_variables_subprocess, true).']', __FILE__, __METHOD__, __LINE__);
			
			if (isset($custom_variables_subprocess['sys_composite_forms_response'])) {
				$custom_variables['sys_composite_forms_response'] = $custom_variables_subprocess['sys_composite_forms_response'];
				$custom_variables['sys_forms_success'] = $custom_variables['sys_composite_forms_response']['success'];
				wfm_utils::wfm_log('asol_debug', '$custom_variables=['.var_export($custom_variables, true).']', __FILE__, __METHOD__, __LINE__);
			} else {
				execute_WFM(); // more than 1 next_activity => current_working_node dies and WFM creates new working_nodes
			}
		} else {
			$executeResult = true;
		}
	}

	wfm_utils::wfm_log('flow_debug', "EXIT", __FILE__, __METHOD__, __LINE__);
	return $executeResult;
}

function task_add_custom_variables($task_implementation, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, & $custom_variables, $current_user_id, $audit) {
	wfm_utils::wfm_log('flow_debug', "ENTRY", __FILE__, __METHOD__, __LINE__);
	wfm_utils::wfm_log('debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);

	$aux0 = wfm_utils::wfm_getHourOffset_and_TimeZone($current_user_id);
	$hourOffset = $aux0['hourOffset'];
	$userTZ = $aux0['userTZ'];

	$modulesTables = wfm_utils::wfm_get_moduleName_moduleTableName_conversion_array($current_user_id);

	$new_custom_variables = explode('${pipe}', $task_implementation);

	foreach ($new_custom_variables as $new_custom_variable) {

		//$new_custom_variable = replace_wfm_vars(null, $new_custom_variable, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);

		$new_custom_variable_array = explode('${dp}', $new_custom_variable);
		$name = $new_custom_variable_array[0];
		$type = $new_custom_variable_array[1];
		$moduleField = $new_custom_variable_array[2];
		$ffunction = $new_custom_variable_array[3];
		$isGlobal = $new_custom_variable_array[7];

		$moduleField_array = explode('${comma}', $moduleField);
		$moduleField_array_value = $moduleField_array[0];

		$ffunction_array = explode('${comma}', $ffunction);
		
		$new_custom_variable_value = null;

		switch ($type) {
			case 'sql':

				//********************************************//
				//*****Managing External Database Queries*****//
				//********************************************//
				$alternativeDb = ($alternative_database >= 0) ? $alternative_database : false;
				$externalDataBaseQueryParams = wfm_reports_utils::wfm_manageExternalDatabaseQueries($alternativeDb, $trigger_module);

				$trigger_module_table = $externalDataBaseQueryParams["report_table"];

				if (!empty($moduleField_array_value)) {

					if ($alternative_database >= 0) {
						$rs = Basic_wfm::getSelectionResults("SHOW COLUMNS FROM ".$trigger_module_table, true, $alternativeDb);
						foreach($rs as $value){
							$fieldConstraint = $value['Key'];//PRI  MUL
							if ($fieldConstraint == 'PRI') {
								$field_ID_name = $value['Field'];
							}
						}
					}

					$field_ID_name = (empty($field_ID_name)) ? 'id' : $field_ID_name;

					// Translate WFM-custom_variables to Reports-fields_and_filters
					$conditions = $field_ID_name.'${comma}LBL_ID${comma}id${dp}new\_bean${dp}true${dp}equals${dp}'.$bean_id.'${dp}${dp}char(36)${dp}${dp}false${dp}15${dp}${dp}${dp}0:${dp}0${comma}';
					$aux = generateQuery_wfm::translate_conditions_to_filterValues_and_fieldValues($conditions, true, $field_ID_name);
					$field_values = $aux['field_values'];
					$filter_values = $aux['filter_values'];

					$aux2 = generateQuery_wfm::translate_customVariables_to_filterValues_and_fieldValues($new_custom_variable);
					$aux2['field_values'][0][5] = str_replace("&#039;", "'", html_entity_decode($aux2['field_values'][0][5], ENT_COMPAT, "UTF-8"));
					$aux2['field_values'][0][5] = replace_wfm_vars('custom_variable_sql', $aux2['field_values'][0][5], $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
					$field_values[] = $aux2['field_values'][0];

					$sql_array = generateQuery_wfm::getQueryArray_fromConditions_or_fromCustomVariables($field_values, $filter_values, $trigger_module, $userTZ, $modulesTables, $current_user_id, $alternative_database, $audit);
					//// wfm_utils::wfm_log('debug', '$sql_array=['.print_r($sql_array, true).']', __FILE__, __METHOD__, __LINE__);

					$sql = generateQuery_wfm::getSql($sql_array);
					//// wfm_utils::wfm_log('debug', '$sql=['.print_r($sql, true).']', __FILE__, __METHOD__, __LINE__);

					$new_custom_variable_value = generateQuery_wfm::getCustomVariableValue($sql, $moduleField_array_value, $alternativeDb);

				} else {

					$sql = $ffunction_array[1];
					$sql = str_replace("&#039;", "'", html_entity_decode($sql, ENT_COMPAT, "UTF-8"));
					$sql = replace_wfm_vars(null, $sql, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);

					$new_custom_variable_value_array = generateQuery_wfm::getCustomSqlResults($sql, $alternativeDb); // Only one item, inside this item there is other item (key => value)
					
					$new_custom_variable_value_array_aux = $new_custom_variable_value_array[0];
					
					foreach ($new_custom_variable_value_array_aux as $value) {
						$new_custom_variable_value = $value;
					}
				}

				break;

			case 'php_eval':

				$php_eval = $ffunction_array[1];
				$php_eval = str_replace("&#039;", "'", html_entity_decode($php_eval, ENT_COMPAT, "UTF-8"));
				$php_eval = replace_wfm_vars('custom_variable_php_eval', $php_eval, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
				wfm_utils::wfm_log('debug', '$php_eval=['.var_export($php_eval, true).']', __FILE__, __METHOD__, __LINE__);
				
				$new_custom_variable_value = eval("return {$php_eval};");

				break;

			case 'literal':

				$literal = $ffunction_array[1];
				$literal = str_replace("&#039;", "'", html_entity_decode($literal, ENT_COMPAT, "UTF-8"));
				$literal = replace_wfm_vars('custom_variable_literal', $literal, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
				
				$new_custom_variable_value = $literal;

				break;
		}

		if ($isGlobal == 'true') {
			$custom_variables['GLOBAL_CVARS'][$name] = $new_custom_variable_value;
		} else {
			$custom_variables[$name] = $new_custom_variable_value;
		}

		wfm_utils::wfm_log('asol', '$new_custom_variable_value=['.var_export($new_custom_variable_value, true).']', __FILE__, __METHOD__, __LINE__);

	}

	$aux_custom_variables = $custom_variables;
	unset($aux_custom_variables['server']);
	unset($aux_custom_variables['request']);
	//unset($aux_custom_variables['current_user']);
	unset($aux_custom_variables['env']);
	//unset($aux_custom_variables['modified_new_bean']);
	unset($aux_custom_variables['sugar_config']);

	wfm_utils::wfm_log('debug', '$custom_variables=['.var_export($custom_variables, true).']', __FILE__, __METHOD__, __LINE__);

	// wfm_utils::wfm_log('debug', '(* user_defined)$custom_variables=['.var_export($aux_custom_variables, true).']', __FILE__, __METHOD__, __LINE__);

	// wfm_utils::wfm_log('debug', 'GLOBAL_CVARS=['.var_export($custom_variables['GLOBAL_CVARS'], true).']', __FILE__, __METHOD__, __LINE__);

	wfm_utils::wfm_log('flow_debug', "EXIT", __FILE__, __METHOD__, __LINE__);
	return true;
}

function task_get_objects($task_id, $task_implementation, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, & $custom_variables, $current_user_id, $audit) {
	wfm_utils::wfm_log('flow_debug', "ENTRY", __FILE__, __METHOD__, __LINE__);
	wfm_utils::wfm_log('debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);
	
	$task_implementation_array = explode('${module}', $task_implementation);
	$objectModule = $task_implementation_array[0];
	$aux_array = explode('${conditions}', $task_implementation_array[1]);
	$custom_variable_get_objects_name = $aux_array[0];
	$conditions = $aux_array[1];
	$conditions = html_entity_decode($conditions);
	$conditions = replace_wfm_vars('condition', $conditions, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
	// FIXME - $conditions is recalculated inside function generateQuery_wfm::getObjectsIds_fromTaskId
	
	$aux = wfm_utils::wfm_getHourOffset_and_TimeZone($current_user_id);
	$hourOffset = $aux['hourOffset'];
	$userTZ = $aux['userTZ'];
	
	$object_ids = generateQuery_wfm::getObjectsIds_fromTaskId($task_id, $alternative_database, $objectModule, $userTZ, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id);
	$object_ids_string = implode('${pipe}', $object_ids);
	
	// wfm_utils::wfm_log('debug', '$objectModule=['.var_export($objectModule, true).']', __FILE__, __METHOD__, __LINE__);
	// wfm_utils::wfm_log('debug', '$object_ids_string=['.var_export($object_ids_string, true).']', __FILE__, __METHOD__, __LINE__);
	
	$custom_variables['get_objects'][$custom_variable_get_objects_name] = Array ('object_module' => $objectModule, 'object_ids' => $object_ids_string);
	
	return true;
}

function task_forms_response($task_id, $task_implementation, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, & $custom_variables, $current_user_id, $audit, $process_instance_id, $working_node_id) {
	wfm_utils::wfm_log('flow_debug', "ENTRY", __FILE__, __METHOD__, __LINE__);
	wfm_utils::wfm_log('asol_debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);
	
	global $db;
	
	$task_implementation = rawurldecode($task_implementation);
	$task_implementation = replace_wfm_vars(null, $task_implementation, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
	
	$this_task_forms_response = json_decode($task_implementation, true);
	
	wfm_utils::wfm_log('asol_debug', '$this_task_forms_response=['.var_export($this_task_forms_response, true).']', __FILE__, __METHOD__, __LINE__);
	
	if ($this_task_forms_response['success'] === 'sys_forms_success') {
		$this_task_forms_response['success'] = $custom_variables['sys_forms_success'];
	}
	
	wfm_utils::wfm_log('asol_debug', '$this_task_forms_response=['.var_export($this_task_forms_response, true).']', __FILE__, __METHOD__, __LINE__);
	
	$this_task_forms_response['success'] = (boolean)($this_task_forms_response['success']);
	
	if (isset($custom_variables['sys_composite_forms_response'])) {
		
		$custom_variables['sys_composite_forms_response']['success'] = ($custom_variables['sys_composite_forms_response']['success'] && $this_task_forms_response['success']);
		
		if (is_array($custom_variables['sys_composite_forms_response']['messages']) && is_array($this_task_forms_response['messages'])) {
			$custom_variables['sys_composite_forms_response']['messages'] = array_merge($custom_variables['sys_composite_forms_response']['messages'], $this_task_forms_response['messages']);
		} elseif (is_array($custom_variables['sys_composite_forms_response']['messages'])) {
			//$custom_variables['sys_composite_forms_response']['messages'] = $custom_variables['sys_composite_forms_response']['messages'];
		} elseif (is_array($this_task_forms_response['messages'])) {
			$custom_variables['sys_composite_forms_response']['messages'] = $this_task_forms_response['messages'];
		} else {
		}
		
		if (is_array($custom_variables['sys_composite_forms_response']['actions']) && is_array($this_task_forms_response['actions'])) {
			$custom_variables['sys_composite_forms_response']['actions'] = array_merge($custom_variables['sys_composite_forms_response']['actions'], $this_task_forms_response['actions']);
		} elseif (is_array($custom_variables['sys_composite_forms_response']['actions'])) {
			//$custom_variables['sys_composite_forms_response']['actions'] = $custom_variables['sys_composite_forms_response']['actions'];
		} elseif (is_array($this_task_forms_response['actions'])) {
			$custom_variables['sys_composite_forms_response']['actions'] = $this_task_forms_response['actions'];
		} else {
		}
		
	} else {
		$custom_variables['sys_composite_forms_response'] = $this_task_forms_response;
	}
	
	$custom_variables['sys_forms_success'] = $custom_variables['sys_composite_forms_response']['success'];
	$executeResult = $custom_variables['sys_composite_forms_response'];
	
	wfm_utils::wfm_log('asol_debug', '$custom_variables=['.var_export($custom_variables, true).']', __FILE__, __METHOD__, __LINE__);
	
	// BEGIN - Terminate working_node
	
	$date_modified = gmdate('Y-m-d H:i:s');
	
	$db->query("
		UPDATE asol_workingnodes
		SET status = 'terminated', date_modified = '{$date_modified}'
		WHERE id = '{$working_node_id}'
	");
	
	// Terminate all working_nodes from this process_instance
	wfm_utils::wfm_log('debug', "Terminate Process", __FILE__, __METHOD__, __LINE__);

	$db->query("
		UPDATE asol_workingnodes
		SET status = 'terminated', date_modified = '{$date_modified}'
		WHERE asol_processinstances_id_c = '{$process_instance_id}'
	");
	
	// END - Terminate working_node
	
	return $executeResult;
}

function task_forms_error_message($task_id, $task_implementation, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, & $custom_variables, $current_user_id, $audit) {
	wfm_utils::wfm_log('flow_debug', "ENTRY", __FILE__, __METHOD__, __LINE__);
	wfm_utils::wfm_log('asol_debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);

	$task_implementation = rawurldecode($task_implementation);
	$task_implementation = replace_wfm_vars(null, $task_implementation, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
	
	$this_task_forms_response = json_decode($task_implementation, true);
	
	$this_task_forms_response['success'] = false;
	
	wfm_utils::wfm_log('asol_debug', '$this_task_forms_response=['.var_export($this_task_forms_response, true).']', __FILE__, __METHOD__, __LINE__);

	if (isset($custom_variables['sys_composite_forms_response'])) {

		$custom_variables['sys_composite_forms_response']['success'] = ($custom_variables['sys_composite_forms_response']['success'] && $this_task_forms_response['success']);

		if (is_array($custom_variables['sys_composite_forms_response']['messages']) && is_array($this_task_forms_response['messages'])) {
			$custom_variables['sys_composite_forms_response']['messages'] = array_merge($custom_variables['sys_composite_forms_response']['messages'], $this_task_forms_response['messages']);
		} elseif (is_array($custom_variables['sys_composite_forms_response']['messages'])) {
			//$custom_variables['sys_composite_forms_response']['messages'] = $custom_variables['sys_composite_forms_response']['messages'];
		} elseif (is_array($this_task_forms_response['messages'])) {
			$custom_variables['sys_composite_forms_response']['messages'] = $this_task_forms_response['messages'];
		} else {
		}

	} else {
		$custom_variables['sys_composite_forms_response'] = $this_task_forms_response;
	}

	$custom_variables['sys_forms_success'] = $custom_variables['sys_composite_forms_response']['success'];
	$executeResult = $custom_variables['sys_composite_forms_response'];

	return $executeResult;
}

/////////////////////////
///// AUX FUNCTIONS /////
/////////////////////////

function replace_fields(& $bean, $fieldsString, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, & $custom_variables, $current_user_id, $bean_ungreedy_count, $audit) {

	$bean->set_created_by = false;
	$bean->update_modified_by = false;
	$bean->ungreedy_count = $bean_ungreedy_count + 1;

	$fields = explode('${pipe}', $fieldsString);
	wfm_utils::wfm_log('debug', '$fields=['.var_export($fields, true).']', __FILE__, __METHOD__, __LINE__);

	if (empty($fields[0])) {
		$fields  = Array();
	}

	foreach ($fields as $field) {
		$field_array = explode('${dp}', $field);
		// wfm_utils::wfm_log('debug', '$field_array=['.var_export($field_array, true).']', __FILE__, __METHOD__, __LINE__);

		$field_value = $field_array[1];
		//wfm_utils::wfm_log('debug', '$field_value=['.var_export($field_value, true).']', __FILE__, __METHOD__, __LINE__);
		$field_value = urldecode($field_value);
		//wfm_utils::wfm_log('debug', '$field_value=['.var_export($field_value, true).']', __FILE__, __METHOD__, __LINE__);
		
		$field_value = utf8_encode($field_value);
		//$field_value = iconv("ISO-8859-1", "UTF-8//TRANSLIT//IGNORE", $field_value);
		//$field_value = html_entity_decode($field_value, ENT_COMPAT, "UTF-8");
		//wfm_utils::wfm_log('debug', '$field_value=['.var_export($field_value, true).']', __FILE__, __METHOD__, __LINE__);
		
		$field_name = explode('${comma}', $field_array[0]);
		$field_name_aux = explode('.', $field_name[0]);
		if (count($field_name_aux) == 2) { // custom_fields
			$field_name = $field_name_aux[1];
		} else {
			$field_name = $field_name[0];
		}
		
		$field_value = replace_wfm_vars('replace_fields', $field_value, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit, $bean->field_name_map, $field_name);

		wfm_utils::wfm_log('debug', '$field_name=['.var_export($field_name, true).']' .','. '$field_value=['.var_export($field_value, true).']', __FILE__, __METHOD__, __LINE__);

		$bean->$field_name = $field_value;
		$custom_variables['modified_new_bean'][$field_name] = $field_value;
	}
}

function replace_wfm_vars($type, $text_with_wfm_vars, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit, $bean_field_name_map_from_replace_fields=null, $field_name_from_replace_fields=null) {
	wfm_utils::wfm_log('debug', "ENTRY", __FILE__, __METHOD__, __LINE__);
	wfm_utils::wfm_log('debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);

	global $timedate, $beanList, $beanFiles, $app_list_strings, $sugar_config/*, $current_user*/;

	//// wfm_utils::wfm_log('debug', "\$timedate=[".print_r($timedate,true)."]", __FILE__, __METHOD__, __LINE__);

	// Encoding/Decoding ISO/UTF-8 problems
	$text_with_wfm_vars = str_replace("&nbsp;", " ", $text_with_wfm_vars);///+++ necesario???????!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

	// Set timezone
	require_once('modules/Users/User.php');
	$theUser = new User();
	$theUser->retrieve($current_user_id);
	//// wfm_utils::wfm_log('debug', "\$theUser->user_name=[$theUser->user_name]  ", __FILE__, __METHOD__, __LINE__);

	$userTZ = $theUser->getPreference("timezone");
	//// wfm_utils::wfm_log('debug', "\$userTZ=[$userTZ]  ", __FILE__, __METHOD__, __LINE__);

	// (*deprecated, bug, problems some times*) Override global $current_user
	//$current_user = $theUser;// When we use $theUser->getUserDateTimePreferences(), we are calling a function that uses $current_user. So we have to override $current_user in order to get the proper datetime user-preferences

	date_default_timezone_set($userTZ);

	if ($alternative_database == -1) {
		
		if ($audit) {
			$bean = wfm_utils::getAuditRecord($trigger_module, $bean_id);
		} else {
			// Get bean
			$class_name = $beanList[$trigger_module];
			require_once($beanFiles[$class_name]);
			$bean = new $class_name();
			$bean->retrieve($bean_id);
		}
	}

	/********************************************************************************************************************/
	/** BEGIN - Manage { 1.- task_type=create_object/modify_object with fieldType=relate, 2.- make_datetime/make_date} **/
	/********************************************************************************************************************/
	
	switch ($type) {

		case 'custom_variable_sql':
		case 'custom_variable_php_eval':
		case 'custom_variable_literal':
		case 'condition':
			break;
			
		default:

			// When task_type=create_object/modify_object -> check if fieldType=relate
			// [id]${comma}[name]
			$id_and_name_of_relate = explode('${comma}', $text_with_wfm_vars);
			if (count($id_and_name_of_relate) == 2) {
				$pos_aux = strpos($id_and_name_of_relate[1], '${'); // A relate can be defined by either the sugarcrm-way with the popup or with a wfm-variable
				if ($pos_aux !== false) {
					$text_with_wfm_vars = $id_and_name_of_relate[1];
				} else {
					$text_with_wfm_vars = $id_and_name_of_relate[0];
				}
			}

			// make_datetime
			// ${old_bean->date_start}${make_datetime}+${offset}YY-mm-dd HH:ii
			// It needs no TimeZone, because this is written to database, not to use by end-users.
			$baseDateTime_offset = explode('${make_datetime}', $text_with_wfm_vars);
			if (count($baseDateTime_offset) == 2) {
				$baseDateTime = $baseDateTime_offset[0];
				$offset = $baseDateTime_offset[1];

				$offset_array = explode('${offset}', $offset);
				$offset_sign = $offset_array[0];
				// wfm_utils::wfm_log('debug', '$offset_sign=['.var_export($offset_sign, true).']', __FILE__, __METHOD__, __LINE__);
				$offset_value = $offset_array[1];

				// offset
				$delta = $offset_value;
				$delta__array = explode(' ',$delta);
				$delta_date = $delta__array[0];
				$delta_time = $delta__array[1];

				$delta_date__array = explode('-',$delta_date);
				$o_years = $delta_date__array[0];
				$o_months = $delta_date__array[1];
				$o_days = $delta_date__array[2];

				$delta_time__array = explode(':',$delta_time);
				$o_hours = $delta_time__array[0];
				$o_minutes = $delta_time__array[1];

				// baseDateTime
				// wfm_utils::wfm_log('debug', '$baseDateTime=['.var_export($baseDateTime, true).']', __FILE__, __METHOD__, __LINE__);
				$baseDateTime = replace_wfm_vars('make_datetime', $baseDateTime, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
				// wfm_utils::wfm_log('debug', '$baseDateTime=['.var_export($baseDateTime, true).']', __FILE__, __METHOD__, __LINE__);

				$delta = $baseDateTime;
				$delta__array = explode(' ',$delta);
				$delta_date = $delta__array[0];
				$delta_time = $delta__array[1];

				$delta_date__array = explode('-',$delta_date);
				$b_years = $delta_date__array[0];
				$b_months = $delta_date__array[1];
				$b_days = $delta_date__array[2];

				$delta_time__array = explode(':',$delta_time);
				$b_hours = $delta_time__array[0];
				$b_minutes = $delta_time__array[1];

				// wfm_utils::wfm_log('debug', '$b_years=['.var_export($b_years, true).']', __FILE__, __METHOD__, __LINE__);
				// wfm_utils::wfm_log('debug', '$b_months=['.var_export($b_months, true).']', __FILE__, __METHOD__, __LINE__);
				// wfm_utils::wfm_log('debug', '$b_days=['.var_export($b_days, true).']', __FILE__, __METHOD__, __LINE__);
				// wfm_utils::wfm_log('debug', '$b_hours=['.var_export($b_hours, true).']', __FILE__, __METHOD__, __LINE__);
				// wfm_utils::wfm_log('debug', '$b_minutes=['.var_export($b_minutes, true).']', __FILE__, __METHOD__, __LINE__);

				// wfm_utils::wfm_log('debug', '$o_years=['.var_export($o_years, true).']', __FILE__, __METHOD__, __LINE__);
				// wfm_utils::wfm_log('debug', '$o_months=['.var_export($o_months, true).']', __FILE__, __METHOD__, __LINE__);
				// wfm_utils::wfm_log('debug', '$o_days=['.var_export($o_days, true).']', __FILE__, __METHOD__, __LINE__);
				// wfm_utils::wfm_log('debug', '$o_hours=['.var_export($o_hours, true).']', __FILE__, __METHOD__, __LINE__);
				// wfm_utils::wfm_log('debug', '$o_minutes=['.var_export($o_minutes, true).']', __FILE__, __METHOD__, __LINE__);

				switch ($offset_sign) {
					case 'add':
						$current_datetime__plus__delta  = date("Y-m-d H:i:s", mktime($b_hours + $o_hours, $b_minutes + $o_minutes, 0, $b_months + $o_months, $b_days + $o_days, $b_years + $o_years));
						break;
					case 'substract':
						$current_datetime__plus__delta  = date("Y-m-d H:i:s", mktime($b_hours - $o_hours, $b_minutes - $o_minutes, 0, $b_months - $o_months, $b_days - $o_days, $b_years - $o_years));
						break;
				}

				// wfm_utils::wfm_log('debug', '$current_datetime__plus__delta=['.var_export($current_datetime__plus__delta, true).']', __FILE__, __METHOD__, __LINE__);

				$text_with_wfm_vars = $current_datetime__plus__delta;
			}

			// make_date
			// ${old_bean->date_closed}${make_date}+${offset}YY-mm-dd
			// It needs no TimeZone, because this is written to database, not to use by end-users.
			$baseDate_offset = explode('${make_date}', $text_with_wfm_vars);
			if (count($baseDate_offset) == 2) {
				$baseDate = $baseDate_offset[0];
				$offset = $baseDate_offset[1];

				$offset_array = explode('${offset}', $offset);
				$offset_sign = $offset_array[0];
				// wfm_utils::wfm_log('debug', '$offset_sign=['.var_export($offset_sign, true).']', __FILE__, __METHOD__, __LINE__);
				$offset_value = $offset_array[1];

				// offset
				$delta = $offset_value;
				$delta_date = $delta;

				$delta_date__array = explode('-',$delta_date);
				$o_years = $delta_date__array[0];
				$o_months = $delta_date__array[1];
				$o_days = $delta_date__array[2];

				// baseDate
				$baseDate = replace_wfm_vars('make_date', $baseDate, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);
				// wfm_utils::wfm_log('debug', '$baseDate=['.var_export($baseDate, true).']', __FILE__, __METHOD__, __LINE__);

				$delta = $baseDate;
				$delta_date = $delta;

				$delta_date__array = explode('-',$delta_date);
				$b_years = $delta_date__array[0];
				$b_months = $delta_date__array[1];
				$b_days = $delta_date__array[2];

				// wfm_utils::wfm_log('debug', '$b_years=['.var_export($b_years, true).']', __FILE__, __METHOD__, __LINE__);
				// wfm_utils::wfm_log('debug', '$b_months=['.var_export($b_months, true).']', __FILE__, __METHOD__, __LINE__);
				// wfm_utils::wfm_log('debug', '$b_days=['.var_export($b_days, true).']', __FILE__, __METHOD__, __LINE__);

				// wfm_utils::wfm_log('debug', '$o_years=['.var_export($o_years, true).']', __FILE__, __METHOD__, __LINE__);
				// wfm_utils::wfm_log('debug', '$o_months=['.var_export($o_months, true).']', __FILE__, __METHOD__, __LINE__);
				// wfm_utils::wfm_log('debug', '$o_days=['.var_export($o_days, true).']', __FILE__, __METHOD__, __LINE__);

				switch ($offset_sign) {
					case 'add':
						$current_date__plus__delta  = date("Y-m-d", mktime(0, 0, 0, $b_months + $o_months, $b_days + $o_days, $b_years + $o_years));
						break;
					case 'substract':
						$current_date__plus__delta  = date("Y-m-d", mktime(0, 0, 0, $b_months - $o_months, $b_days - $o_days, $b_years - $o_years));
						break;
				}

				// wfm_utils::wfm_log('debug', '$current_date__plus__delta=['.var_export($current_date__plus__delta, true).']', __FILE__, __METHOD__, __LINE__);

				$text_with_wfm_vars = $current_date__plus__delta;
			}

			break;
	}
	
	/******************************************************************************************************************/
	/** END - Manage { 1.- task_type=create_object/modify_object with fieldType=relate, 2.- make_datetime/make_date } **/
	/******************************************************************************************************************/

	// Get wfm_vars_name_list
	$wfm_vars_name_list = Array();

	$tmpText = $text_with_wfm_vars;
	// wfm_utils::wfm_log('debug', '$tmpText=['.var_export($tmpText, true).']', __FILE__, __METHOD__, __LINE__);
	$pos = strpos($tmpText, '${');
	//// wfm_utils::wfm_log('debug', '$pos=['.var_export($pos, true).']', __FILE__, __METHOD__, __LINE__);

	while ($pos !== false) {

		$tmp_last = substr($tmpText, $pos);
		$posEnd = strpos($tmp_last, '}');

		$first = ($pos === 0) ? "" : substr($tmpText, 0, $pos-1);
		$possible_wfm_var_name = substr($tmp_last, 0, $posEnd+1);
		// wfm_utils::wfm_log('debug', '$possible_wfm_var_name=['.var_export($possible_wfm_var_name, true).']', __FILE__, __METHOD__, __LINE__);
		$last = substr($tmp_last, $posEnd+1);

		$tmpText = $first."[ASOL]".$last;
		// wfm_utils::wfm_log('debug', '$tmpText=['.var_export($tmpText, true).']', __FILE__, __METHOD__, __LINE__);

		switch ($type) {
			case 'custom_variable_sql':
				if (wfm_utils::str_starts_with($possible_wfm_var_name, '${c_var')) { // Only replace custom_variables, not bean_variables because they are used to generate the query
					$wfm_vars_name_list[] = $possible_wfm_var_name;
				}
				break;
			case 'custom_variable_php_eval':
			case 'custom_variable_literal':
				switch ($possible_wfm_var_name) {
					case '${comma}': // mysql_functions token in custom_variables
						break;
					default:
						$wfm_vars_name_list[] = $possible_wfm_var_name;
						break;
				}
				break;
			case 'condition':
				switch ($possible_wfm_var_name) {
					case '${comma}':
					case '${pipe}':
					case '${dp}':
					case '${dollar}':
						break;
					default:
						$wfm_vars_name_list[] = $possible_wfm_var_name;
						break;
				}
				break;
			default:
				switch ($possible_wfm_var_name) {
					case '${comma}': // mysql_functions token in create_object/modify_object

						break;
					default:
						$wfm_vars_name_list[] = $possible_wfm_var_name;
						break;
				}
				break;
		}

		$pos = strpos($tmpText, '${');
		//// wfm_utils::wfm_log('debug', '$pos=['.var_export($pos, true).']', __FILE__, __METHOD__, __LINE__);
	}
	// wfm_utils::wfm_log('debug', '$wfm_vars_name_list=['.var_export($wfm_vars_name_list, true).']', __FILE__, __METHOD__, __LINE__);

	// Replace wfm_var
	foreach($wfm_vars_name_list as $wfm_var_name) {
		//// wfm_utils::wfm_log('debug', '$wfm_var_name=['.var_export($wfm_var_name, true).']', __FILE__, __METHOD__, __LINE__);

		$wfm_var_value = "";
		
		$tmp_wfm_var_name = substr($wfm_var_name, 2);
		$tmp_wfm_var_name = substr($tmp_wfm_var_name, 0, -1);
		$wfm_var_name_array = explode("->", $tmp_wfm_var_name);
		// wfm_utils::wfm_log('debug', '$wfm_var_name_array=['.var_export($wfm_var_name_array, true).']', __FILE__, __METHOD__, __LINE__);

		switch (count($wfm_var_name_array)) {

			case 1:
				// wfm_utils::wfm_log('debug', "count(beanValues)==1", __FILE__, __METHOD__, __LINE__);

				$m = explode(' ',microtime());
				list($totalSeconds, $extraMilliseconds) = array($m[1], (int)round($m[0]*1000,3));

				$extraMilliseconds = strval($extraMilliseconds);
				if (strlen($extraMilliseconds) == 1)
				$extraMilliseconds = '00'.$extraMilliseconds;
				else if (strlen($extraMilliseconds) == 2)
				$extraMilliseconds = '0'.$extraMilliseconds;

				switch ($wfm_var_name_array[0]) {
					case 'current_datetime_db_format':
						$current_datetime  = date("Y-m-d H:i:s", mktime(gmdate("H"), gmdate("i"), gmdate("s") , gmdate("m"), gmdate("d"), gmdate("Y")));
						$wfm_var_value = $current_datetime;
						break;
							
					case 'current_datetime_with_millis_db_format':
						$current_datetime  = date("Y-m-d H:i:s", mktime(gmdate("H"), gmdate("i"), gmdate("s") , gmdate("m"), gmdate("d"), gmdate("Y")));
						$wfm_var_value = $current_datetime.','. $extraMilliseconds;
						break;

					case 'current_date_db_format':
						$current_date  = date("Y-m-d", mktime(gmdate("H") , gmdate("i") , gmdate("s") , gmdate("m"), gmdate("d"), gmdate("Y")));
						$wfm_var_value = $current_date;

						break;

					case 'current_datetime':
						$current_datetime  = date("Y-m-d H:i:s", mktime(gmdate("H"), gmdate("i"), gmdate("s") , gmdate("m"), gmdate("d"), gmdate("Y")));
						$wfm_var_value = $current_datetime;
						$wfm_var_value = $timedate->handle_offset($wfm_var_value, $timedate->get_db_date_time_format(), true, null, $userTZ);
						$userDateTimeFormat = $theUser->getPreference("datef").' '.$theUser->getPreference("timef");
						$wfm_var_value = $timedate->swap_formats($wfm_var_value, $timedate->get_db_date_time_format(), $userDateTimeFormat);

						break;

					case 'current_date':
						$current_date  = date("Y-m-d", mktime(gmdate("H") , gmdate("i") , gmdate("s") , gmdate("m"), gmdate("d"), gmdate("Y")));
						$wfm_var_value = $current_date;
						$userDateFormat = $theUser->getPreference("datef");
						$wfm_var_value = $timedate->swap_formats($wfm_var_value, $timedate->get_db_date_format(), $userDateFormat);

						break;
							
					case 'session_id':
						$wfm_var_value = session_id();
						break;

					case 'getmypid':
						$wfm_var_value = getmypid();
						break;
				}

				break;
					
			case 2:
				// wfm_utils::wfm_log('debug', "count(beanValues)==2", __FILE__, __METHOD__, __LINE__);

				switch ($wfm_var_name_array[0]) {

					case 'bean':
					case 'old_bean':

						switch ($wfm_var_name_array[0]) {
							case 'bean':
								$wfm_var_value = $new_bean[$wfm_var_name_array[1]];
								break;
							case 'old_bean':
								$wfm_var_value = $old_bean[$wfm_var_name_array[1]];
								break;
						}
						
						wfm_utils::wfm_log('debug', '$wfm_var_value=['.var_export($wfm_var_value, true).']', __FILE__, __METHOD__, __LINE__);

						// Format {enum, date, datetime, decimal, interger}
				
						if ($alternative_database == -1) {
							
							if (!$audit) {
								
								$field_name = $wfm_var_name_array[1];
								
								$fieldNameMap = $bean->field_name_map;
								wfm_utils::wfm_log('debug', '$fieldNameMap=['.var_export($fieldNameMap, true).']', __FILE__, __METHOD__, __LINE__);
	
								manage_empty_and_null_values($fieldNameMap, $field_name, $wfm_var_value);
								
								$change_to_user_format = (in_array($type, Array('replace_fields', 'body_as_html', 'body_as_plain_text', 'subject')));
								if ($change_to_user_format) {
									change_to_user_format($fieldNameMap, $field_name, $wfm_var_value, $userTZ, $theUser);
								}
							}
						}

						break;

					case 'c_var':

						// wfm_utils::wfm_log('debug', "c_var", __FILE__, __METHOD__, __LINE__);
							
						$wfm_var_value = (isset($custom_variables[$wfm_var_name_array[1]])) ? $custom_variables[$wfm_var_name_array[1]] : '';
						
						if ($type == 'replace_fields') { // TODO - For now I can not know what field-type is the custom_variable expect when I am on wfm-task create_object/modify_object.
							
							$field_name = $field_name_from_replace_fields; // If wfm-variable is inside a field then this wfm-variable is formated depending on this field-type.
							$fieldNameMap = $bean_field_name_map_from_replace_fields;
							wfm_utils::wfm_log('debug', '$fieldNameMap=['.var_export($fieldNameMap, true).']', __FILE__, __METHOD__, __LINE__);
	
							manage_empty_and_null_values($fieldNameMap, $field_name, $wfm_var_value);
									
							$change_to_user_format = (in_array($type, Array('replace_fields', 'body_as_html', 'body_as_plain_text', 'subject')));
							if ($change_to_user_format) {
								change_to_user_format($fieldNameMap, $field_name, $wfm_var_value, $userTZ, $theUser);
							}
						}
						
						break;
				}
					
				break;
					
			case 3:
				// wfm_utils::wfm_log('debug', "count(beanValues)==3", __FILE__, __METHOD__, __LINE__);

				switch ($wfm_var_name_array[0]) {
					case 'c_var':
						$wfm_var_value = $custom_variables[$wfm_var_name_array[1]][$wfm_var_name_array[2]];
						
						// TODO add manage_empty_and_null_values and change_to_user_format
						
						break;

					default:
						if ($alternative_database == -1) {
							
							// Get related_bean
							$class_name = $beanList[$wfm_var_name_array[0]];
							$filename = $beanFiles[$class_name];
							
							if (file_exists($filename)) {
								
								require_once($filename);
								$related_bean = new $class_name();
								
								if ($audit) {
									$related_bean->retrieve($bean[$wfm_var_name_array[1]]);
								} else {
									$related_bean->retrieve($bean->$wfm_var_name_array[1]);
								}
								
								$related_array = wfm_utils::getBeanFieldsNotAnObjectNotAnArray($related_bean);
								$wfm_var_value = $related_array[$wfm_var_name_array[2]];
								
								$field_name = $wfm_var_name_array[2];
									
								$fieldNameMap = $related_bean->field_name_map;
								wfm_utils::wfm_log('debug', '$fieldNameMap=['.var_export($fieldNameMap, true).']', __FILE__, __METHOD__, __LINE__);
								
								manage_empty_and_null_values($fieldNameMap, $field_name, $wfm_var_value);
								
								$change_to_user_format = (in_array($type, Array('replace_fields', 'body_as_html', 'body_as_plain_text', 'subject')));
								if ($change_to_user_format) {
									change_to_user_format($fieldNameMap, $field_name, $wfm_var_value, $userTZ, $theUser);
								}
								
							} else {
								wfm_utils::wfm_log('flow_debug', "File does not exist.", __FILE__, __METHOD__, __LINE__);
								$wfm_var_value = '';
							}
						}
							
						break;
				}

				break;

			case 4:
				// wfm_utils::wfm_log('debug', "count(beanValues)==4", __FILE__, __METHOD__, __LINE__);

				switch ($wfm_var_name_array[0]) {
					case 'c_var':
						
						if ($wfm_var_name_array[2] == 'bean') {
							$wfm_var_name_array[2] = 'new_bean';
						}
						
						$wfm_var_value = $custom_variables[$wfm_var_name_array[1]][$wfm_var_name_array[2]][$wfm_var_name_array[3]];
						break;
				}

				break;

			case 5:
				// wfm_utils::wfm_log('debug', "count(beanValues)==5", __FILE__, __METHOD__, __LINE__);

				switch ($wfm_var_name_array[0]) {
					case 'c_var':
						$wfm_var_value = $custom_variables[$wfm_var_name_array[1]][$wfm_var_name_array[2]][$new_bean['asol_domain_id']][$wfm_var_name_array[4]];
						break;
				}

				break;
		}

		if (isset($sugar_config['WFM_sugarcrmEmailTemplateBody_doNotExecute_nl2br']) && ($sugar_config['WFM_sugarcrmEmailTemplateBody_doNotExecute_nl2br'] == true)) {
		} else {
			if ($type == 'body_as_html') {
				$wfm_var_value = nl2br($wfm_var_value); // nl2br -> for fields with newlines (Ex: log) and only for task_type=send_email, for task_type=create_object we do not want nl2br
			}
		}

		$wfm_var_value = str_replace("&#039;", "'", html_entity_decode($wfm_var_value, ENT_COMPAT, "UTF-8"));

		//if (isset($sugar_config['WFM_sugarcrm_emailTemplate_charset']) && ($sugar_config['WFM_sugarcrm_emailTemplate_charset'] == 'ISO')) {
			//if (in_array($type, Array('body', 'replace_fields'))) {
				//$wfm_var_value = iconv("UTF-8", "ISO-8859-1//TRANSLIT//IGNORE", $wfm_var_value); // $bean is written in UTF-8
			//}
		//}

		switch (count($wfm_var_name_array)) {
			case 1:
			case 2:
			case 3:
			case 4:
			case 5:
				wfm_utils::wfm_log('debug', "Replace \$wfm_var_name=[{$wfm_var_name}] by \$wfm_var_value=[{$wfm_var_value}]", __FILE__, __METHOD__, __LINE__);
				$text_with_wfm_vars = str_replace($wfm_var_name, $wfm_var_value, $text_with_wfm_vars);
				break;
		}

	}

	// We want to send emails in UTF-8
	//if (isset($sugar_config['WFM_sugarcrm_emailTemplate_charset']) && ($sugar_config['WFM_sugarcrm_emailTemplate_charset'] == 'ISO')) {
		//if (in_array($type, Array('body', 'replace_fields'))) {
			//$text_with_wfm_vars = iconv("ISO-8859-1", "UTF-8//TRANSLIT//IGNORE", $text_with_wfm_vars); // email_template is written in ISO-8859-1
		//}
	//}

	wfm_utils::wfm_log('debug', "EXIT", __FILE__, __METHOD__, __LINE__);
	
	return $text_with_wfm_vars;
}

function createRelationships(&$bean, $relationships, $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id) {

	$relationshipsArray = explode('${pipe}', $relationships);

	// wfm_utils::wfm_log('debug', '$relationshipsArray=['.var_export($relationshipsArray, true).']', __FILE__, __METHOD__, __LINE__);

	if ($relationshipsArray[0] == '') {
		$relationshipsArray = Array();
	}

	foreach ($relationshipsArray as $relationship) {

		$relationshipArray = explode('${dp}', $relationship);
		$relationshipName = $relationshipArray[0];
		$relationshipValue = replace_wfm_vars(null, urldecode($relationshipArray[1]), $alternative_database, $trigger_module, $bean_id, $old_bean, $new_bean, $custom_variables, $current_user_id, $audit);

		$relationshipNameArray = explode('${comma}', $relationshipName);
		$name = $relationshipNameArray[0];
		//$relationship = $relationshipNameArray[1];
		$module = $relationshipNameArray[2];
		$vname = $relationshipNameArray[3];
		$label = $relationshipNameArray[4];

		$relationshipValueArray = explode('${comma}', $relationshipValue);

		$bean->load_relationship($name);
		$bean->$name->add($relationshipValueArray[0]);
		$bean->save();

	}
}

// Aux class WFM_SugarPHPMailer
require_once("include/SugarPHPMailer.php");
class WFM_SugarPHPMailer extends SugarPHPMailer {
	function WFM_SugarPHPMailer() {
		return parent::SugarPHPMailer();
	}
	public function getAddresses($type) {
		return $this->$type;
	}
}

function manage_empty_and_null_values($fieldNameMap, $field_name, & $wfm_var_value) {
	
	switch($fieldNameMap[$field_name]['type']) {
		case 'double' :
		case 'decimal' :
		case 'float' :
			if ($wfm_var_value === '' || $wfm_var_value == NULL || $wfm_var_value == 'NULL') {
				$wfm_var_value = 0;
			}
			break;
		case 'uint' :
		case 'ulong' :
		case 'long' :
		case 'short' :
		case 'tinyint' :
		case 'int' :
			if ($wfm_var_value === '' || $wfm_var_value == NULL || $wfm_var_value == 'NULL') {
				$wfm_var_value = 0;
			}
			break;
		case 'currency' :
			if ($wfm_var_value === '' || $wfm_var_value == NULL || $wfm_var_value == 'NULL') {
				$wfm_var_value = 0;
			}
			break;
		case 'enum' :
			break;
		case 'datetime' :
		case 'datetimecombo' :
		case 'timestamp' :
			if ($wfm_var_value === '' || $wfm_var_value == NULL || $wfm_var_value == 'NULL') {
				$wfm_var_value = '';
			}
			break;
		case 'date' :
			if ($wfm_var_value === '' || $wfm_var_value == NULL || $wfm_var_value == 'NULL') {
				$wfm_var_value = '';
			}
			break;
	}
}

function change_to_user_format($fieldNameMap, $field_name, & $wfm_var_value, $userTZ, $theUser) {
	wfm_utils::wfm_log('debug', "ENTRY", __FILE__, __METHOD__, __LINE__);
	wfm_utils::wfm_log('debug', '$field_name=['.var_export($field_name, true).']', __FILE__, __METHOD__, __LINE__);
	wfm_utils::wfm_log('debug', '$wfm_var_value=['.var_export($wfm_var_value, true).']', __FILE__, __METHOD__, __LINE__);
	wfm_utils::wfm_log('debug', '$userTZ=['.var_export($userTZ, true).']', __FILE__, __METHOD__, __LINE__);
	wfm_utils::wfm_log('debug', '$fieldNameMap=['.var_export($fieldNameMap, true).']', __FILE__, __METHOD__, __LINE__);
	
	global $app_list_strings, $timedate;
	
	switch ($fieldNameMap[$field_name]['type']) {
		case 'double' :
		case 'decimal' :
		case 'float' :
			$wfm_var_value = format_number ( $wfm_var_value );
			break;
		case 'uint' :
		case 'ulong' :
		case 'long' :
		case 'short' :
		case 'tinyint' :
		case 'int' :
			$wfm_var_value = format_number ( $wfm_var_value, 0, 0 );
			break;
		case 'currency' :
			$wfm_var_value = currency_format_number ( $wfm_var_value, $params = array (
					'currency_symbol' => false 
			) );
			break;
		case 'enum' :
			$wfm_var_value = $app_list_strings [$fieldNameMap [$field_name] ['options']] [$wfm_var_value];
			break;
		case 'datetime' :
		case 'datetimecombo' :
		case 'timestamp' :
			if (($wfm_var_value != "") /*&& ($type != 'make_datetime')*/) {
				$wfm_var_value = $timedate->handle_offset ( $wfm_var_value, $timedate->get_db_date_time_format (), true, null, $userTZ );
				$userDateTimeFormat = $theUser->getPreference ( "datef" ) . ' ' . $theUser->getPreference ( "timef" );
				$wfm_var_value = $timedate->swap_formats ( $wfm_var_value, $timedate->get_db_date_time_format (), $userDateTimeFormat );
			}
			break;
		case 'date' :
			if (($wfm_var_value != "") /*&& ($type != 'make_date')*/) {
				$userDateFormat = $theUser->getPreference ( "datef" );
				$wfm_var_value = $timedate->swap_formats ( $wfm_var_value, $timedate->get_db_date_format (), $userDateFormat );
			}
			break;
	}
}

?>