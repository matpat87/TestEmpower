<?php 
 //WARNING: The contents of this file are auto-generated




function executeWFMTaskJob($job) {
	
	require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
	
	//$data = $job->data; // - PHP Fatal error:  Call-time pass-by-reference has been removed in /var/www/vhosts/sugarcrm/htdocs/custom/modules/Schedulers/Ext/ScheduledTasks/scheduledtasks.ext.php on line 19, referer: http://sugarcrm-test.traders-trust.com/index.php?module=Schedulers&action=index
	$job = (array) $job;
	$data = $job['data'];
	
	$data = json_decode($data, true);
	
	if ((!empty($data)) && is_array($data) && (count($data) > 0))	{
		
		require_once("modules/asol_Task/executeTask_functions.php");
		
		executeTask($data['task_id'], $data['task_type'], $data['task_implementation'], $data['alternative_database'], $data['trigger_module'], $data['bean_id'], $data['process_instance_id'], $data['working_node_id'], $data['bean_ungreedy_count'], $data['old_bean'], $data['new_bean'], $data['custom_variables'], $data['current_user_id'], $data['audit']);
		
		return true;
		
	} else {
		return false;
	}
}


function execute_wfm_engine_job($job) {
	
	require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
	
	//$data = $job->data; // - PHP Fatal error:  Call-time pass-by-reference has been removed in /var/www/vhosts/sugarcrm/htdocs/custom/modules/Schedulers/Ext/ScheduledTasks/scheduledtasks.ext.php on line 19, referer: http://sugarcrm-test.traders-trust.com/index.php?module=Schedulers&action=index
	$job = (array) $job;
	$data = $job['data'];
	
	$data = json_decode($data, true);
	
	if ((!empty($data)) && is_array($data) && (count($data) > 0))	{
		
		require_once("modules/asol_Process/wfm_engine_functions.php");
		
		$request_superglobal = $data['request_superglobal'];
		$execution_type = $data['execution_type'];
		$async = $data['async'];
		$request = $data['request'];
		$old_bean = $data['old_bean'];
		$new_bean = $data['new_bean'];
		$current_user_array = $data['current_user_array'];
		$trigger_module = $data['trigger_module'];
		$trigger_event = $data['trigger_event'];
		$bean_id = $data['bean_id'];
		$current_user_id = $data['current_user_id'];
		$bean_ungreedy_count = $data['bean_ungreedy_count'];
		
		wfm_engine($request_superglobal, $execution_type, $async, $request, $old_bean, $new_bean, $current_user_array, $trigger_module, $trigger_event, $bean_id, $current_user_id, $bean_ungreedy_count);
		
		return true;
		
	} else {
		return false;
	}
}
?>