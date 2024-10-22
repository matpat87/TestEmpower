<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(1, 'Send Email Acknowledgement', 'custom/modules/Leads/hooks/LeadsAfterSaveHook.php','LeadsAfterSaveHook', 'send_email_acknowledgement'); 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(
    0, 
    'Custom Email Notification Trigger', 
    'custom/modules/Leads/hooks/LeadsBeforeSaveHook.php',
    'LeadsBeforeSaveHook', 
    'customCheckNotify'); 
$hook_array['before_delete'] = Array(); 



?>