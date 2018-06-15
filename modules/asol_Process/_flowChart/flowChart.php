<?php

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
wfm_utils::wfm_log('asol', 'ENTRY', __FILE__);

wfm_utils::set_error_reporting_level();

require_once("modules/asol_Process/_flowChart/flowChartFunctions.php");

wfm_utils::wfm_log('debug', 'ENTRY POINT $_REQUEST=['.var_export($_REQUEST, true).']', __FILE__, __METHOD__, __LINE__);

$processId = $_REQUEST['uid'];

$response = generateFlowChart($processId);

echo json_encode($response);

wfm_utils::wfm_log('debug', 'EXIT', __FILE__);

?>