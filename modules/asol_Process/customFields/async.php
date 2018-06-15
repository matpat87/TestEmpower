<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

$async = isset($_REQUEST['async']) ? $_REQUEST['async'] : $focus->async;

echo wfm_utils::wfm_generate_field_select('wfm_process_async_list', 'async', $async, '', '');


?>
