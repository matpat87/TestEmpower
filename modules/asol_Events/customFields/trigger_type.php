<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

wfm_utils::wfm_log('debug', '$_REQUEST=['.var_export($_REQUEST, true).']', __FILE__, __METHOD__, __LINE__);

// Get wfm-event bean-object (If I use "$focus = $GLOBALS['FOCUS'];" => I can not access the member-functions of the class)
$focus = new asol_Events();
$focusId = (isset($_REQUEST['record'])) ? $_REQUEST['record'] : '';

if (!empty($focusId)) { // Modify
	$focus->retrieve($focusId);
}

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

$trigger_type = isset($_REQUEST['trigger_type']) ? $_REQUEST['trigger_type'] : $focus->trigger_type;

$trigger_type_list = wfm_utils::getTriggerTypeList($data_source, $audit, $alternative_database);

echo wfm_utils::wfm_generate_select($trigger_type_list, 'trigger_type', $trigger_type, '', '');





?>
