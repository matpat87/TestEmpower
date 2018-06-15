<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : $focus->status;

echo wfm_utils::wfm_generate_field_select('wfm_process_status_list', 'status', $status, '', '');

?>
