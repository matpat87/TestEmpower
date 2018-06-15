<input type="hidden" id="task_implementation_hidden" name="task_implementation_hidden" value="">

<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

wfm_utils::wfm_log('debug', 'ENTRY', __FILE__);

global $mod_strings;

$task_implementation = (isset($_REQUEST['task_implementation_hidden'])) ? $_REQUEST['task_implementation_hidden'] : $focus->task_implementation;

switch ($task_type) {
	case 'create_object':
	case 'modify_object':
		require_once ('task_implementation.create_modify_object.php');
		break;
	case 'add_custom_variables':
		require_once ('task_implementation.add_custom_variables.php');
		break;
	case 'get_objects':
			require_once ('task_implementation.get_objects.php');
			break;
	default:
		require_once ('task_implementation.default.php');
		break;
}

require_once("modules/asol_Process/___common_WFM/php/javascript_common_process_event_activity_task.php");
require_once("modules/asol_Task/customFields/javascript.php"); 
?>