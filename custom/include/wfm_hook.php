<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

function errorHandler($error_level, $error_message, $error_file, $error_line, $error_context)
{
	$error = "lvl: " . $error_level . " | msg:" . $error_message . " | file:" . $error_file . " | ln:" . $error_line;
	switch ($error_level) {
	    case E_ERROR:
	    case E_CORE_ERROR:
	    case E_COMPILE_ERROR:
	    case E_PARSE:
	        //logPHPError($error, "fatal");
	        break;
	    case E_USER_ERROR:
	    case E_RECOVERABLE_ERROR:
	        //logPHPError($error, "error");
	        break;
	    case E_WARNING:
	    case E_CORE_WARNING:
	    case E_COMPILE_WARNING:
	    case E_USER_WARNING:
	        //logPHPError($error, "warn");
	        break;
	    case E_NOTICE:
	    case E_USER_NOTICE:
	        //logPHPError($error, "info");
	        break;
	    case E_STRICT:
	        //logPHPError($error, "debug");
	        break;
	    default:
	        //logPHPError($error, "warn");
	}
}

function shutdownHandler() // Called by register_shutdown_function. // It will be called when php script ends
{
	$lasterror = error_get_last(); // If you do not use an errorHandler then the last error retrieved will be always the same.
	switch ($lasterror['type'])	{
	    case E_ERROR:
	    case E_CORE_ERROR:
	    case E_COMPILE_ERROR:
	    case E_USER_ERROR:
	    case E_RECOVERABLE_ERROR:
	    case E_CORE_WARNING:
	    case E_COMPILE_WARNING:
	    //case E_PARSE:
	        $error = "[SHUTDOWN] lvl:" . $lasterror['type'] . " | msg:" . $lasterror['message'] . " | file:" . $lasterror['file'] . " | ln:" . $lasterror['line'];
	        logPHPError($error, "fatal");
	        
	        // Redirect
	        wfm_utils::redirect('', '&_________WFM_phpError_________');
	}
}

function logPHPError($error, $errlvl)
{
	wfm_utils::wfm_log($errlvl, $error, __FILE__, __METHOD__, __LINE__);
}

class wfm_hook_process {
	
	function execute_process(&$bean, $event, $arguments='login_failed') {
		
		wfm_utils::set_error_reporting_level();
		
		wfm_utils::wfm_log('asol', "ENTRY", __FILE__, __METHOD__, __LINE__);
		
		set_error_handler("errorHandler");
		register_shutdown_function("shutdownHandler");
		
		wfm_utils::wfm_log('flow_debug', '***********LOGIC_HOOK**************', __FILE__, __METHOD__, __LINE__);
		
		global $sugar_config;
		
		// Disable wfm_hook if needed
		$WFM_disable_wfm_completely = ((isset($sugar_config['WFM_disable_wfm_completely'])) && ($sugar_config['WFM_disable_wfm_completely'])) ? true : false;
		$WFM_disable_wfmHook = ((isset($sugar_config['WFM_disable_wfmHook'])) && ($sugar_config['WFM_disable_wfmHook'])) ? true : false;
		
		if ($WFM_disable_wfm_completely || $WFM_disable_wfmHook) {
			wfm_utils::wfm_log('asol', "EXIT by sugar_config WFM_disable", __FILE__, __METHOD__, __LINE__);
			return;
		}
		
		wfm_utils::wfm_log('asol', "\$event=[{$event}], \$bean->module_dir=[{$bean->module_dir}], \$bean->name=[{$bean->name}], \$bean->id=[{$bean->id}]", __FILE__, __METHOD__, __LINE__);
		wfm_utils::wfm_log('debug', '***$_REQUEST=['.var_export($_REQUEST, true).']', __FILE__, __METHOD__, __LINE__);
		wfm_utils::wfm_log('debug', '$bean=['.print_r($bean, true).']', __FILE__, __METHOD__, __LINE__);

		global $current_user, $sugar_config, $db;
		
		wfm_utils::wfm_log('debug', '$current_user->user_name=['.var_export($current_user->user_name, true).']', __FILE__, __METHOD__, __LINE__);
		wfm_utils::wfm_log('debug', '$current_user->asol_default_domain=['.var_export($current_user->asol_default_domain, true).']', __FILE__, __METHOD__, __LINE__);
		// wfm_utils::wfm_log('debug', '$current_user=['.print_r($current_user, true).']', __FILE__, __METHOD__, __LINE__);
		
		$trigger_module = (!empty($bean->module_dir)) ? $bean->module_dir : $_REQUEST['module'];
		$trigger_event = "";
		$bean_id = $bean->id;

		// Sugar strangely doesn't populate event on login_failed
		if (empty($event)) {
			$event = 'login_failed';
		}

		// Bifurcate event
		switch ($event) {
			
			case 'on_init':
			case 'before_submit':
			case 'on_submit':
			case 'after_submit':
			
				
				$trigger_event = $event;
				
				$old_bean = (empty($bean->fetched_row)) ? Array() : $bean->fetched_row;
				$new_bean = wfm_utils::getBeanFieldsNotAnObjectNotAnArray($bean);
				
				break;
			
			case 'before_save':

				if (!empty($bean->fetched_row)) {
					$trigger_event = "on_modify__before_save";

					// old_bean
					$old_bean = (empty($bean->fetched_row)) ? Array() : $bean->fetched_row; // email1 is within $bean->fetched_row
					
					// asol_email_list
					if (isset($bean->emailAddress)) { // Not all modules have emailAddresses
						// Get old emails from this module (get them from DB)
						$emailAddressObject = new SugarEmailAddress();
						$old_emails = $emailAddressObject->getAddressesByGUID($bean_id, $trigger_module);
						// wfm_utils::wfm_log('debug', "wfm_hook \$old_emails=[".print_r($old_emails,true)."]", __FILE__, __METHOD__, __LINE__);
						$old_emails_string = "";
						foreach($old_emails as $key => $value) {
							$old_emails_string .= $old_emails[$key]['email_address'] . ',';
						}
						$old_emails_string = substr($old_emails_string, 0, -1);
					}
					$old_bean['asol_email_list'] = $old_emails_string;
				} else {
					$trigger_event = "on_create__before_save";

					// old_bean
					$old_bean = Array();
				}

				// new_bean
				$new_bean = wfm_utils::getBeanFieldsNotAnObjectNotAnArray($bean);
// 				$new_bean['email1'] = $bean->email1;
// 				$new_bean['asol_email_list'] = $new_emails_string;
				$new_bean['date_entered'] = $old_bean['date_entered']; // date_entered is null within $bean
				
				// TODO $sugar_config['WFM_get_fields_from_bean_non_db']
				$new_bean['remoteCurrentDomainId'] = $bean->remoteCurrentDomainId;
				$new_bean['remoteTicketDomainUrl'] = $bean->remoteTicketDomainUrl;

				// CAC disabled fields => bean->field=NULL
				foreach ($new_bean as $key_field => $value_field) {
					if ((!isset($_REQUEST[$key_field])) && ($bean->$key_field === null)) {// disabled field, empty field(not disabled), date_modified(not in $_REQUEST but in $bean)
						$new_bean[$key_field] = (!empty($new_bean[$key_field])) ? $new_bean[$key_field] : $old_bean[$key_field];
					}
				}
				
				// Save within php-session the arrays for passing them from before-save to after-save logic_hook-execution
				$_SESSION['old_bean'] = $old_bean;
				$_SESSION['new_bean'] = $new_bean;

				break;

			case 'after_save':

				if (!empty($bean->fetched_row)) {

					$trigger_event = "on_modify";

					// Get from  php-session the bean-arrays
					if (isset($_SESSION['old_bean'])) {
						$old_bean = $_SESSION['old_bean'];
						unset($_SESSION['old_bean']);
					}
					if (isset($_SESSION['new_bean'])) {
						$new_bean = $_SESSION['new_bean'];
						unset($_SESSION['new_bean']);
					}
				} else {

					$trigger_event = "on_create";

					$old_bean = Array();

					if (isset($_SESSION['new_bean'])) {
						$new_bean = $_SESSION['new_bean'];
						unset($_SESSION['new_bean']);
					}
				}

				break;
					
			case 'before_delete':

				$trigger_event = "on_delete";
					
				$old_bean = (empty($bean->fetched_row)) ? Array() : $bean->fetched_row;// email1 is in $bean->fetched_row
				$old_bean['asol_email_list'] = $old_emails_string;

				$new_bean = Array();
					
				break;

			case 'after_delete':
				// Do nothing
				break;

			case 'login_failed':
			case 'after_login':
			case 'before_logout':
				$trigger_event = $event;
				break;
		}

		
		
		// Get fields from database
		if (isset($sugar_config['WFM_get_fields_from_db'][$bean->table_name])) {
			foreach ($sugar_config['WFM_get_fields_from_db'][$bean->table_name] as $field) {
				$sql = "SELECT {$field} FROM {$bean->table_name} WHERE id='{$bean->id}'";
				// wfm_utils::wfm_log('debug', '$sql=['.var_export($sql, true).']', __FILE__, __METHOD__, __LINE__);
				$field_query = $db->query($sql);
				$field_row = $db->fetchByAssoc($field_query);
				// wfm_utils::wfm_log('debug', '$field_row=['.var_export($field_row, true).']', __FILE__, __METHOD__, __LINE__);
				$new_bean[$field] = $field_row[$field];
				$old_bean[$field] = $new_bean[$field];
			}
		}

		// Only for CAC // login_failed -> user does not have domain, because there is actually no user
		if (isset($sugar_config['WFM_asolDefaultDomain_whenEmptyDomain'])) {
			if (empty($new_bean['asol_default_domain'])) {
				$new_bean['asol_default_domain'] = $sugar_config['WFM_asolDefaultDomain_whenEmptyDomain'];
			}
		}

		wfm_utils::wfm_log('asol_debug', '$old_bean=['.print_r($old_bean, true).']', __FILE__, __METHOD__, __LINE__);
		wfm_utils::wfm_log('asol_debug', '$trigger_module=['.print_r($trigger_module, true).']', __FILE__, __METHOD__, __LINE__);
		
		$old_bean['module_dir'] = $trigger_module;
		$new_bean['module_dir'] = $trigger_module;
		
		// Debug
		wfm_utils::wfm_log('flow_debug', "\$trigger_event=[{$trigger_event}]", __FILE__, __METHOD__, __LINE__);
		wfm_utils::wfm_log('flow_debug', '$old_bean=['.var_export($old_bean, true).']', __FILE__, __METHOD__, __LINE__);
		wfm_utils::wfm_log('flow_debug', '$new_bean=['.var_export($new_bean, true).']', __FILE__, __METHOD__, __LINE__);

		// Avoid infinite-loops
		$WFM_MAX_loops = (isset($sugar_config['WFM_MAX_loops'])) ? $sugar_config['WFM_MAX_loops'] : 10;
		$bean_ungreedy_count = (empty($bean->ungreedy_count)) ? 0 : $bean->ungreedy_count;
		wfm_utils::wfm_log('flow_debug', '$bean_ungreedy_count=['.var_export($bean_ungreedy_count, true).']', __FILE__, __METHOD__, __LINE__);

		if (($WFM_MAX_loops != 'unlimited') && ($bean_ungreedy_count >= $WFM_MAX_loops)) { // To avoid that the code crash when the user defines a process that performs an action that triggers its execution (trigger=on_modify, task_type=modify_object; trigger=on_create, task_type=create_object with objectModule=trigger_module).
			wfm_utils::wfm_log('fatal', '$WFM_MAX_loops reached!', __FILE__, __METHOD__, __LINE__);
			return;
		}

		// Calculate current_user_array
		if (!empty($current_user->id)) {
			$userRoles_array = $_SESSION['asolUserRoles'] = ((isset($_SESSION['asolUserRoles'])) && (!empty($_SESSION['asolUserRoles']))) ? $_SESSION['asolUserRoles'] : ACLRole::getUserRoles($current_user->id);
			
			$userRoles = implode(',', $userRoles_array);
			$isAdmin = $current_user->is_admin;
		} else {
			$userRoles = '-';
			$isAdmin = '-';
		}

		$current_user_array = wfm_utils::getBeanFieldsNotAnObjectNotAnArray($current_user);
		$current_user_array['is_admin'] = $isAdmin;
		$current_user_array['roles'] = $userRoles;
		$current_user_array['asol_default_domain'] = $current_user->asol_default_domain;
		wfm_utils::wfm_log('flow_debug', '$current_user_array=['.var_export($current_user_array, true).']', __FILE__, __METHOD__, __LINE__);
		
		// urlencode_serialized bean_variable_arrays and custom_variables
		$urlencode_serialized_old_bean = wfm_utils::wfm_convert_array_to_curl_parameter($old_bean);
		$urlencode_serialized_new_bean = wfm_utils::wfm_convert_array_to_curl_parameter($new_bean);
		
		if (isset($_REQUEST['entryPoint']) && ($_REQUEST['entryPoint'] == 'wfm_engine')) { // cURL
			$request = $_REQUEST;
			unset($request['old_bean']);
			unset($request['new_bean']);
			unset($request['request']);
			$request = Array();
		} else {
			$request = $_REQUEST;
		}
		$request['ajaxRequest'] = json_decode(file_get_contents('php://input'), true); // sugarcrm 7.5
		wfm_utils::wfm_log('flow_debug', '$request[\'ajaxRequest\']=['.var_export($request['ajaxRequest'], true).']', __FILE__, __METHOD__, __LINE__);
		$urlencode_serialized_request = wfm_utils::wfm_convert_array_to_curl_parameter($request);
		
		$urlencode_serialized_current_user_array = wfm_utils::wfm_convert_array_to_curl_parameter($current_user_array);

		$current_user_id = (!empty($current_user->id)) ? $current_user->id : $bean->modified_user_id;
		$current_user_id = (!empty($current_user_id)) ? $current_user_id : '1'; // login_failed. WFM always need a user_id in order to get datetimes
		
		$session_id = session_id();
		
		$execution_type = 'logic_hook';
		
		$request_superglobal = $_REQUEST;
		
		//********** BEGIN: $app_list_strings['wfm_process_async_list']['async_sugar_job_queue'] ***********//
		
		$WFM_enable_async_sugar_job_queue = ((isset($sugar_config['WFM_enable_async_sugar_job_queue'])) && ($sugar_config['WFM_enable_async_sugar_job_queue'])) ? true : false;
		
		if ($WFM_enable_async_sugar_job_queue) {
			
			$async = 'async_sugar_job_queue';
			
			require_once('include/SugarQueue/SugarJobQueue.php');
				
			// First, let's create the new job
			$job = new SchedulersJob();
			
			$data = Array(
				'request_superglobal' => $request_superglobal,
				'execution_type' => $execution_type,
				'async' => $async,
				'request' => $request,
				'old_bean' => $old_bean,
				'new_bean' => $new_bean,
				'current_user_array' => $current_user_array,
				'trigger_module' => $trigger_module,
				'trigger_event' => $trigger_event,
				'bean_id' => $bean_id,
				'current_user_id' => $current_user_id,
				'bean_ungreedy_count' => $bean_ungreedy_count,
			);
			
			wfm_utils::wfm_log('asol_debug', '$data=['.var_export($data, true).']', __FILE__, __METHOD__, __LINE__);
			
			$data = json_encode($data);
			$job->data = $data;
			
			$job_name = Array(
				'bean_id' => $bean_id,
				'trigger_module' => $trigger_module,
				'session_id' => $session_id,
			);
			$job->name = json_encode($job_name);
			
			// key piece, this is data we are passing to the job that it can use to run it.
			$job->target = "function::execute_wfm_engine_job";
			//user the job runs as
			$job->assigned_user_id = $current_user_id;
			// Now push into the queue to run
			$jq = new SugarJobQueue();
			$jobid = $jq->submitJob($job);
		}
		
		//********** END: $app_list_strings['wfm_process_async_list']['async_sugar_job_queue'] ***********//
		
		//********** BEGIN: $app_list_strings['wfm_process_async_list']['async_curl'] ***********//
		
		$WFM_disable_async_curl = ((isset($sugar_config['WFM_disable_async_curl'])) && ($sugar_config['WFM_disable_async_curl'])) ? true : false;
		
		if (!$WFM_disable_async_curl) {
			// To fork execution and web-user-control (we do not want to make the user wait)
			wfm_utils::wfm_log('flow_debug', "********** cURL=[fork execution and web-user-control] **********", __FILE__, __METHOD__, __LINE__);
			$async = 'async_curl';
			$query_string = "entryPoint=wfm_engine&async={$async}&execution_type={$execution_type}&trigger_module={$trigger_module}&trigger_event={$trigger_event}&bean_id={$bean_id}&current_user_id={$current_user_id}&bean_ungreedy_count={$bean_ungreedy_count}&old_bean={$urlencode_serialized_old_bean}&new_bean={$urlencode_serialized_new_bean}&request={$urlencode_serialized_request}&current_user_array={$urlencode_serialized_current_user_array}&session_id={$session_id}";
			wfm_utils::wfm_curl('post', null, $query_string, false, 1);
			//ob_clean(); // FIXME // TODO clear response, if there is an ajax that expects a json as response, and there is some save-records; the WFM will add unexpected(if any php-error, ...) text to the response. But if you perfom ob_clean then you remove html that sometimes is necessary(module_tabs, ...).
		}
		
		//********** END: $app_list_strings['wfm_process_async_list']['async_curl'] ***********//

		//********** BEGIN: $app_list_strings['wfm_process_async_list']['sync'] ***********//
		require_once("modules/asol_Process/wfm_engine_functions.php");
		$async = 'sync';
		$executeResult = wfm_engine($request_superglobal, $execution_type, $async, $request, $old_bean, $new_bean, $current_user_array, $trigger_module, $trigger_event, $bean_id, $current_user_id, $bean_ungreedy_count);
		//********** END: $app_list_strings['wfm_process_async_list']['sync'] ***********//
		
		wfm_utils::wfm_log('asol', "\$event=[{$event}], \$bean->module_dir=[{$bean->module_dir}], \$bean->name=[{$bean->name}], \$bean->id=[{$bean->id}]", __FILE__, __METHOD__, __LINE__);
		wfm_utils::wfm_log('asol', "EXIT", __FILE__, __METHOD__, __LINE__);
		
		wfm_utils::wfm_log('asol_debug', '$executeResult=['.var_export($executeResult,true).']'." for wfm-task=[name=[{$task['name']}], id=[{$task['id']}]]", __FILE__, __METHOD__, __LINE__);
		return $executeResult;
	}
}

?>