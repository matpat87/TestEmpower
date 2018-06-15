<?php


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