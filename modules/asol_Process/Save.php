<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

global $current_user;

wfm_utils::wfm_log('flow_debug', '$_REQUEST=['.var_export($_REQUEST,true).']', __FILE__, __METHOD__, __LINE__);

$recordId = wfm_utils::saveProcess($_REQUEST);

$return_id = (!empty($_REQUEST['return_id'])) ? $_REQUEST['return_id'] : $recordId;
$return_record = (empty($return_id)) ? $_REQUEST['record'] : $return_id;

if ($_REQUEST['return_action'] == 'wfeEditView') {
	header("Location: index.php?module=asol_Process&action=wfeEditView&record={$recordId}&sugar_body_only=true");
} else {
	header("Location: index.php?entryPoint=wfm_layout&uid={$recordId}");
}

?>