<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
$hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array(); 
$hook_array['before_save'] = Array(); 
$hook_array['before_delete'] = Array(); 

$hook_array['process_record'][] = Array(1, 'Custom Relate To Values', 'custom/modules/SAR_SalesActivityReport/hooks/SalesActivityProcessRecordHook.php', 'SalesActivityProcessRecordHook', 'processStatusColumn');
?>