<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

$task_type = (isset($_REQUEST['task_type'])) ? $_REQUEST['task_type'] : $focus->task_type;

global /*$beanList, $beanFiles, */$app_list_strings/*, $timedate, $db, $mod_strings*/;

$data_source = $focus->getDataSource();

switch($data_source) {
		
	case 'form':


		break;

	case 'database':

		$audit = $focus->getAudit();
		$audit = ($audit == '1') ? true : false;

		$alternative_database = $focus->getAlternativeDatabase();

		break;

}

$task_type_list = wfm_utils::getTaskTypeList($data_source, $audit, $alternative_database);

$select_task_type = wfm_utils::wfm_generate_select($task_type_list, 'task_type', $task_type, 'onChange_task_type(this);', '');

echo $select_task_type;

?>