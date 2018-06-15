<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

$data_source = $focus->getDataSource();

$trigger_event = isset($_REQUEST['trigger_event']) ? $_REQUEST['trigger_event'] : $focus->trigger_event;

echo wfm_utils::wfm_generate_trigger_event_select($trigger_module, 'trigger_event', $trigger_event, '', '', $data_source);

?>
