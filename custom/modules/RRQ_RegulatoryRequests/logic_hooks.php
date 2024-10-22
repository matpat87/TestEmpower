<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
$hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'Set Division Level II Security Group', 'custom/include/hooks/globalBeforeSaveHooks.php','GlobalBeforeSaveHooks', 'setDivisionLevelIISecurityGroup');
$hook_array['before_save'][] = Array(2, 'Assign ID #', 'custom/modules/RRQ_RegulatoryRequests/hooks/RRQ_RegulatoryRequestsBeforeSaveHook.php','RRQ_RegulatoryRequestsBeforeSaveHook', 'assign_id');
$hook_array['before_save'][] = Array(3, "Module's CommonBefore Save", 'custom/modules/RRQ_RegulatoryRequests/hooks/RRQ_RegulatoryRequestsBeforeSaveHook.php','RRQ_RegulatoryRequestsBeforeSaveHook', 'before_save');
$hook_array['before_save'][] = Array(4, "Handle Status Update format on detail view display", 'custom/modules/RRQ_RegulatoryRequests/hooks/RRQ_RegulatoryRequestsBeforeSaveHook.php','RRQ_RegulatoryRequestsBeforeSaveHook', 'handleStatusUpdateFormat');
// $hook_array['before_save'][] = Array(5, "handle Custom Email Notification For Assigned Users", 'custom/modules/RRQ_RegulatoryRequests/hooks/RRQ_RegulatoryRequestsBeforeSaveHook.php','RRQ_RegulatoryRequestsBeforeSaveHook', 'handleCustomEmailNotificationForAssignedUsers');

$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(1, 'Generate TR Working Group', 'custom/modules/RRQ_RegulatoryRequests/hooks/RRQ_RegulatoryRequestsAfterSaveHook.php', 'RRQ_RegulatoryRequestsAfterSaveHook', 'generate_workgroup');
$hook_array['after_save'][] = Array(2, 'Save Customer Products', 'custom/modules/RRQ_RegulatoryRequests/hooks/RRQ_RegulatoryRequestsAfterSaveHook.php', 'RRQ_RegulatoryRequestsAfterSaveHook', 'save_cust_products');
// $hook_array['after_save'][] = Array(2, 'Email Notification', 'custom/modules/RRQ_RegulatoryRequests/hooks/RRQ_RegulatoryRequestsAfterSaveHook.php', 'RRQ_RegulatoryRequestsAfterSaveHook', 'email_notif');
$hook_array['after_save'][] = Array(3, 'Handle User Assignment', 'custom/modules/RRQ_RegulatoryRequests/hooks/RRQ_RegulatoryRequestsAfterSaveHook.php', 'RRQ_RegulatoryRequestsAfterSaveHook', 'handleUserAssignment');
$hook_array['after_save'][] = Array(4, 'Email Notification', 'custom/modules/RRQ_RegulatoryRequests/hooks/RRQ_RegulatoryRequestsAfterSaveHook.php', 'RRQ_RegulatoryRequestsAfterSaveHook', 'handleAssignedEmailNotifications');
?>