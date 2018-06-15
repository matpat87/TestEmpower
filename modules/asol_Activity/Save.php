<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

$recordId = wfm_utils::saveActivity($_REQUEST);

$return_id = (!empty($_REQUEST['return_id'])) ? $_REQUEST['return_id'] : $recordId; 
$return_record = (empty($return_id)) ? $_REQUEST['record'] : $return_id;

$return_action = (empty($_REQUEST['return_action'])) ? 'DetailView' : $_REQUEST['return_action'];
$return_module = (empty($_REQUEST['return_module'])) ? 'asol_Activity' : $_REQUEST['return_module'];

header("Location: index.php?action={$return_action}&module={$return_module}&record={$return_record}");

?>