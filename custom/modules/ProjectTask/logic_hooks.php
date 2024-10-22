<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array(); 
$hook_array['before_save'] = Array(); 
$hook_array['before_delete'] = Array(); 

$hook_array['before_save'][] = Array(1, 'checkProjectNumber', 'custom/modules/ProjectTask/hooks/BeforeSave.php','ProjectTaskBeforeSaveHook', 'check_project_number'); 
$hook_array['before_save'][] = Array(2, 'statusUpdateFormat', 'custom/modules/ProjectTask/hooks/BeforeSave.php','ProjectTaskBeforeSaveHook', 'status_update_append_before_save'); 

$hook_array['after_save'][] = Array(1, 'saveAttachedDocument', 'custom/modules/ProjectTask/hooks/AfterSave.php','ProjectTaskAfterSaveHook', 'document_save'); 
$hook_array['after_save'][] = Array(1, 'otr_track_time_after_save', 'custom/modules/ProjectTask/hooks/AfterSave.php','ProjectTaskAfterSaveHook', 'otr_track_time_after_save'); 
$hook_array['process_record'][] = Array(1, 'Custom Relate To Values', 'custom/modules/ProjectTask/hooks/ProcessRecords.php', 'ProjectTaskProcessRecordHook', 'processCustomColumnStyle');
?>