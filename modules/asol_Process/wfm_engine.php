<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");

require_once("modules/asol_Process/wfm_engine_functions.php");

$request_superglobal = $_REQUEST;

$execution_type = $request_superglobal['execution_type'];
$async = $request_superglobal['async'];
$request = wfm_utils::wfm_convert_curl_parameter_to_array($request_superglobal['request']);
$old_bean = wfm_utils::wfm_convert_curl_parameter_to_array($request_superglobal['old_bean']);
$new_bean = wfm_utils::wfm_convert_curl_parameter_to_array($request_superglobal['new_bean']); 
$current_user_array = wfm_utils::wfm_convert_curl_parameter_to_array($request_superglobal['current_user_array']); 
$trigger_module = $request_superglobal['trigger_module']; 
$trigger_event = $request_superglobal['trigger_event']; 
$bean_id = $request_superglobal['bean_id'];
$current_user_id = $request_superglobal['current_user_id'];
$bean_ungreedy_count = $request_superglobal['bean_ungreedy_count'];

wfm_engine($request_superglobal, $execution_type, $async, $request, $old_bean, $new_bean, $current_user_array, $trigger_module, $trigger_event, $bean_id, $current_user_id, $bean_ungreedy_count);

?>