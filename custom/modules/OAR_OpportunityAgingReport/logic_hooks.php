<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
$hook_version = 1; 
$hook_array = Array();
$hook_array['before_save'] = Array();
$hook_array['process_record'] = Array();
$hook_array['process_record'][] = Array(1, 'Custom list field values', 'custom/modules/OAR_OpportunityAgingReport/hooks/ProcessRecordHook.php', 'ProcessRecordHook', 'handleListFieldValues');

?>