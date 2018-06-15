<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

$focus = new asol_Activity();
$focusId = (isset($_REQUEST['record'])) ? $_REQUEST['record'] : '';

if (!empty($focusId)) { // Modify
	$focus->retrieve($focusId);
}

$name = isset($_REQUEST['name']) ? $_REQUEST['name'] : $focus->name;

echo wfm_utils::wfm_generate_field_input('name', $name, 100, 'wfm_name_input', 'width: auto; max-width: none;');

?>
