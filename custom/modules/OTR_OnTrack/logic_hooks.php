<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(1, 'addTime', 'custom/modules/OTR_OnTrack/hooks/AfterSave.php','OTR_OnTrackAfterSaveHook', 'otr_track_time_after_save'); 
$hook_array['after_save'][] = Array(2, 'wfm_hook', 'custom/include/wfm_hook.php','wfm_hook_process', 'execute_process'); 
$hook_array['after_save'][] = Array(3, 'manage ot groups', 'custom/modules/OTR_OnTrack/hooks/AfterSave.php','OTR_OnTrackAfterSaveHook', 'manage_ot_workgroup'); 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'updateStatusText', 'custom/modules/OTR_OnTrack/hooks/BeforeSave.php','OTR_OnTrackBeforeSaveHook', 'status_update_append_before_save'); 
$hook_array['before_save'][] = Array(2, 'wfm_hook', 'custom/include/wfm_hook.php','wfm_hook_process', 'execute_process'); 
$hook_array['before_delete'] = Array(); 
$hook_array['before_delete'][] = Array(2, 'wfm_hook', 'custom/include/wfm_hook.php','wfm_hook_process', 'execute_process'); 
$hook_array['after_save'][] = Array(1, 'handleDocumentUpload', 'custom/modules/OTR_OnTrack/hooks/AfterSave.php','OTR_OnTrackAfterSaveHook', 'handleDocumentUpload'); 
// $hook_array['process_record'] = Array();
// $hook_array['process_record'][] = Array(1, 'Display Actual Hrs worked', 'custom/modules/OTR_OnTrack/hooks/ProcessRecordHook.php', 'OTR_OnTrackProcessRecordHook', 'actualHoursWorkedColumn');


?>