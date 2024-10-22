<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
$hook_version = 1; 
$hook_array = Array();
$hook_array['before_save'] = Array();
$hook_array['before_save'][] = Array(1, 'Handle Mass Update', 'custom/modules/RRWG_RRWorkingGroup/hooks/RRWorkingGroupMassUpdateHook.php', 'RRWorkingGroupMassUpdateHook', 'handleMassUpdate');
$hook_array['before_save'][] = Array(2, 'Handle Duplicate Role', 'custom/modules/RRWG_RRWorkingGroup/hooks/RRWorkingGroupBeforeSaveHook.php', 'RRWorkingGroupBeforeSaveHook', 'handleDuplicateRole');

$hook_array['process_record'] = Array();
$hook_array['process_record'][] = Array(1, 'Custom Relate To Values', 'custom/modules/RRWG_RRWorkingGroup/hooks/RRWorkingGroupProcessRecordHook.php', 'RRWorkingGroupProcessRecordHook', 'customNameColumn');

?>