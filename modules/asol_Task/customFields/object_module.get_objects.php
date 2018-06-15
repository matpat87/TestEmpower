<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

global $current_user, $mod_strings, $app_strings, $timedate, $app_list_strings, $db;

// Get the module of the object to create or to modify
$trigger_module = $focus->getTriggerModule();

$task_implementation_array = explode('${module}', $focus->task_implementation);
$focus_mod = (count($task_implementation_array) == 2) ? $task_implementation_array[0] : "";

$objModule = (isset($_REQUEST['objectModule'])) ? $_REQUEST['objectModule'] : $focus_mod;
$objectModule = ($task_type == "modify_object") ? $trigger_module : $objModule;

//*********************************//
//***Get External Databases Info***//
//*********************************//
$sel_altDb = $focus->getAlternativeDatabase();

$extraParams = array(
	'alternative_database' => $sel_altDb,
	'report_module' => $objectModule,
);

$externalDatabasesInfo = wfm_reports_utils::managePremiumFeature("externalDatabasesReports", "wfm_reports_utils_premium.php", "wfm_getExternalDatabasesInfo", $extraParams);
wfm_utils::wfm_log('debug', '$externalDatabasesInfo=['.var_export($externalDatabasesInfo, true).']', __FILE__, __METHOD__, __LINE__);

if ($externalDatabasesInfo !== false) {
	$alternativeDb = $externalDatabasesInfo['alternativeDb'];
	$available_alternative_db_tables = $externalDatabasesInfo['available_alternative_db_tables'];
	$sel_altDbTable = $externalDatabasesInfo['sel_altDbTable'];
} else {
	$alternativeDb = null;
	$available_alternative_db_tables = null;
	$sel_altDbTable = null;
}
//*********************************//
//***Get External Databases Info***//
//*********************************//

// trigger_module
echo "<input type='hidden' id='trigger_module' value='{$trigger_module}'>";

// Generate objectModule select
switch ($task_type) {
	case 'get_objects':
		$selectModules = wfm_utils::wfm_generate_field_module_select('objectModule', $objectModule, 'onChange_objectModule(this);', '');
		break;
}

echo $selectModules;

?>