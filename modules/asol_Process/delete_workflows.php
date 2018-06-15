<?php

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
wfm_utils::wfm_log('debug', 'ENTRY', __FILE__);

global $mod_strings;

// Extract process_ids from $_REQUEST
$process_ids_array = explode(',', $_REQUEST['uid']);

try {
	wfm_utils::deleteWorkFlows($process_ids_array);
} catch (Exception $exception) {
	wfm_utils::wfm_log('fatal', wfm_utils::jTraceEx($exception), __FILE__, __METHOD__, __LINE__);
}

wfm_utils::wfm_echo('delete_workflows', $mod_strings['LBL_DELETE_WORKFLOWS_OK']);

wfm_utils::wfm_log('debug', 'EXIT', __FILE__);

?>

