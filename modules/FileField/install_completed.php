<?php
	require_once('modules/Administration/QuickRepairAndRebuild.php');
    $modules = Array('Notes','Documents');
	$selected_actions = array(
			'clearTpls',
	);
    $RepairAndClear = new RepairAndClear();
    $RepairAndClear->repairAndClearAll($selected_actions, $modules, true, false);    

	SugarApplication::redirect("index.php?module=Administration&action=index");
?>