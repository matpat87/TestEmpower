<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
$hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array(); 
$hook_array['before_save'] = Array(); 
$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(0, 'Save Actual Hours On Ontrack Table', 'custom/modules/Time/hooks/TimeAfterSaveHook.php','TimeAfterSaveHook', 'saveOntrackActualHours'); 
$hook_array['after_save'][] = Array(1, 'Handle Email Notification', 'custom/modules/Time/hooks/TimeAfterSaveHook.php','TimeAfterSaveHook', 'handleEmailNotification'); 
$hook_array['before_relationship_delete'] = Array();

$hook_array['process_record'] = Array();
$hook_array['process_record'][] = Array(1, 'Custom Relate To Values', 'custom/modules/Time/hooks/TimeProcessRecordHook.php', 'TimeProcessRecordHook', 'processCustomColumnStyle');
$hook_array['after_relationship_delete'][] = Array(); 
$hook_array['after_relationship_delete'][] = Array(0, 'Deduct actual hours saved in Ontrack record', 'custom/modules/Time/hooks/TimeAfterDeleteHook.php','TimeAfterDeleteHook', 'deductOnTrackActualHours'); 

?>