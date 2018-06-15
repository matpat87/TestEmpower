<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

$data_source = isset($_REQUEST['data_source']) ? $_REQUEST['data_source'] : $focus->data_source;

if (!empty($focusId)) { // Modify
	$data_source_disabled = 'disabled';
} else {
	$data_source_disabled = '';
}

echo wfm_utils::wfm_generate_field_select('wfm_process_data_source_list', 'data_source', $data_source, '', $data_source_disabled);

?>
