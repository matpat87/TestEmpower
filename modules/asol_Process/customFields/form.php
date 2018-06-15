<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

$asol_forms_id_c = isset($_REQUEST['asol_forms_id_c']) ? $_REQUEST['asol_forms_id_c'] : $focus->asol_forms_id_c;
$form_id = $asol_forms_id_c;

if (!empty($focusId)) { // Modify
	$form_disabled = true;
} else {
	$form_disabled = false;
}

if (!empty($form_id)) {
	$form_bean = wfm_utils::getBean('asol_Forms', $form_id);
	$form_name = $form_bean->name;
} else {
	$form_name = '';
}

echo wfm_utils::wfm_generate_field_relate('asol_forms_id_c', $form_id, 'form', $form_name, 'asol_Forms', $form_disabled);



?>
