<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(1, 'New User Default Role', 'custom/modules/Users/hooks/after_save_hook.php','UsersAfterSaveHook', 'newUserDefaultRole'); 
$hook_array['after_save'][] = Array(2, 'Handle New User Outbound Email Account', 'custom/modules/Users/hooks/after_save_hook.php','UsersAfterSaveHook', 'handleNewUserOutboundEmailAccount');
$hook_array['after_save'][] = Array(3, 'wfm_hook', 'custom/include/wfm_hook.php','wfm_hook_process', 'execute_process');
$hook_array['before_save'] = Array();
$hook_array['before_save'][] = Array(1, 'New User Welcome Email', 'custom/modules/Users/hooks/before_save_hook.php','UsersBeforeSaveHook', 'newUserWelcomeEmail'); 
$hook_array['before_save'][] = Array(2, 'wfm_hook', 'custom/include/wfm_hook.php','wfm_hook_process', 'execute_process'); 
$hook_array['before_save'][] = Array(3, 'Before Save', 'custom/modules/Users/hooks/before_save_hook.php','UsersBeforeSaveHook', 'before_save'); 
$hook_array['before_delete'] = Array(); 
$hook_array['before_delete'][] = Array(2, 'wfm_hook', 'custom/include/wfm_hook.php','wfm_hook_process', 'execute_process'); 
$hook_array['after_login'] = Array(); 
$hook_array['after_login'][] = Array(2, 'wfm_hook', 'custom/include/wfm_hook.php','wfm_hook_process', 'execute_process'); 
$hook_array['before_logout'] = Array(); 
$hook_array['before_logout'][] = Array(2, 'wfm_hook', 'custom/include/wfm_hook.php','wfm_hook_process', 'execute_process'); 
$hook_array['login_failed'] = Array();
$hook_array['after_relationship_add'] = Array();
// Deprecated as feature is now handled via Security Group (OnTrack #1611)
// $hook_array['after_relationship_add'][] = Array(
//     1,
//     'Handle CAPA Workgroup assignments when site related user role is changed',
//     'custom/modules/Users/hooks/CAPAWorkgroupUpdateHook.php',
//     'CAPAWorkgroupUpdateHook',
//     'updateCapaUsers');
$hook_array['process_record'] = Array();
$hook_array['process_record'][] = Array(1, 'Custom Column Values', 'custom/modules/Users/hooks/UserProcessRecordHook.php', 'UserProcessRecordHook', 'processCustomColumn');

?>