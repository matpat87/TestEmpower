<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

$audit = isset($_REQUEST['audit']) ? $_REQUEST['audit'] : $focus->audit;
$audit = (empty($focusId)) ? 0 : $audit;
$disabled = (empty($focusId)) ? '' : 'disabled';

echo wfm_utils::wfm_generate_field_checkbox('audit', $audit, $disabled);

?>
