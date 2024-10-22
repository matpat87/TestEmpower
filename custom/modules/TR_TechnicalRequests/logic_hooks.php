<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
$hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array(); 
$hook_array['before_save'] = Array();
$hook_array['before_save'][] = Array(1, 'Technical Request Updates', 'custom/modules/TR_TechnicalRequests/hooks/TechnicalRequestBeforeSaveHook.php','TechnicalRequestBeforeSaveHook', 'logTechnicalRequestUpdates'); 
$hook_array['before_save'][] = Array(2, 'Technical Request Updates', 'custom/modules/TR_TechnicalRequests/hooks/TechnicalRequestBeforeSaveHook.php','TechnicalRequestBeforeSaveHook', 'form_before_save'); 

$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(1, 'Generate TR Working Group', 'custom/modules/TR_TechnicalRequests/hooks/TechnicalRequestAfterSaveHook.php', 'TechnicalRequestAfterSaveHook', 'generate_workgroup');
$hook_array['after_save'][] = Array(2, 'Send Email Notifications', 'custom/modules/TR_TechnicalRequests/hooks/TechnicalRequestAfterSaveHook.php','TechnicalRequestAfterSaveHook', 'sendEmailNotifications');
$hook_array['after_save'][] = Array(3, 'Handle TR Items Data', 'custom/modules/TR_TechnicalRequests/hooks/TechnicalRequestAfterSaveHook.php','TechnicalRequestAfterSaveHook', 'handleTRItemsData');
$hook_array['after_save'][] = Array(4, 'Technical Request After Save', 'custom/modules/TR_TechnicalRequests/hooks/TechnicalRequestAfterSaveHook.php','TechnicalRequestAfterSaveHook', 'form_after_save'); 
$hook_array['after_save'][] = Array(5, 'Handle Document Upload', 'custom/modules/TR_TechnicalRequests/hooks/TechnicalRequestAfterSaveHook.php','TechnicalRequestAfterSaveHook', 'handleDocumentUpload');
$hook_array['after_save'][] = Array(6, 'Handle Product Master Status Change', 'custom/modules/TR_TechnicalRequests/hooks/TechnicalRequestAfterSaveHook.php','TechnicalRequestAfterSaveHook', 'handleProductMasterStatusChange');
$hook_array['after_save'][] = Array(7, 'Handle Product Master Reassignment', 'custom/modules/TR_TechnicalRequests/hooks/TechnicalRequestAfterSaveHook.php','TechnicalRequestAfterSaveHook', 'handleProductMasterReassignment');
$hook_array['after_save'][] = Array(8, 'Handle Send Email Notification on setting TBD market', 'custom/modules/TR_TechnicalRequests/hooks/TechnicalRequestAfterSaveHook.php','TechnicalRequestAfterSaveHook', 'send_mail_notification');
$hook_array['after_save'][] = Array(9, 'Handle Rejected TR - Close Distro and TR Items that are not Complete', 'custom/modules/TR_TechnicalRequests/hooks/TechnicalRequestAfterSaveHook.php','TechnicalRequestAfterSaveHook', 'handleRejectedTR');
$hook_array['after_save'][] = Array(10, 'Handle Distro Item Reassignment', 'custom/modules/TR_TechnicalRequests/hooks/TechnicalRequestAfterSaveHook.php','TechnicalRequestAfterSaveHook', 'handleDistroItemReassignment');
$hook_array['after_save'][] = Array(11, 'Handle Email Notification Est Completion Date Modified', 'custom/modules/TR_TechnicalRequests/hooks/TechnicalRequestAfterSaveHook.php','TechnicalRequestAfterSaveHook', 'handleEmailNotificationEstCompletionDateModified');
$hook_array['after_save'][] = Array(12, 'Handle On Hold Distro Items and Tr Items', 'custom/modules/TR_TechnicalRequests/hooks/TechnicalRequestAfterSaveHook.php','TechnicalRequestAfterSaveHook', 'handleDistroTRItemOnHold');
$hook_array['after_save'][] = Array(13, 'Handle Add Competitor to TR Account', 'custom/modules/TR_TechnicalRequests/hooks/TechnicalRequestAfterSaveHook.php','TechnicalRequestAfterSaveHook', 'handleAddCompetitorToTrAccount');

$hook_array['before_relationship_delete'] = Array();
$hook_array['before_relationship_delete'][] = Array(1, 'After Remove Relationship of TR', 
    'custom/modules/TR_TechnicalRequests/hooks/TechnicalRequestBeforeRemoveRelationshipHook.php', 'TechnicalRequestBeforeRemoveRelationshipHook', 'form_before_remove_relationship_save');

// $hook_array['after_relationship_add'] = Array();
// $hook_array['after_relationship_add'][] = Array(1, 'After Add Relationship of TR', 
//     'custom/modules/TR_TechnicalRequests/hooks/TechnicalRequestAfterAddRelationshipHook.php', 'TechnicalRequestAfterAddRelationshipHook', 'form_after_add_relationship_save');

$hook_array['process_record'] = Array();
$hook_array['process_record'][] = Array(1, 'Align column center', 'custom/modules/TR_TechnicalRequests/hooks/TechnicalRequestProcessRecordHook.php', 'TechnicalRequestProcessRecordHook', 'processCustomColumnStyle');

?>