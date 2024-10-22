<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
$hook_version = 1; 
$hook_array = Array(); 

$hook_array['before_save'] = Array();
$hook_array['before_save'][] = Array(1, 'TR Items Before Save', 'custom/modules/TRI_TechnicalRequestItems/hooks/TechnicalRequestItemsBeforeSaveHook.php','TechnicalRequestItemsBeforeSaveHook', 'TechnicalRequestItemsBeforeSave');
// Deprecated as behavior is similar to DistributionBeforeSaveHook - before_save
// $hook_array['before_save'][] = Array(1, 'Handle TR Chips Or Quote Approved Workflow', 'custom/modules/TRI_TechnicalRequestItems/hooks/TechnicalRequestItemsBeforeSaveHook.php','TechnicalRequestItemsBeforeSaveHook', 'handleTRChipsOrQuoteApprovedWorkflow');  

$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(1, 'Completed TR Item Notification', 'custom/modules/TRI_TechnicalRequestItems/hooks/TechnicalRequestItemsAfterSaveHook.php','TechnicalRequestItemsAfterSaveHook', 'handleCompletedTrItemNotification'); 
$hook_array['after_save'][] = Array(2, 'TR Item Qty Changed Notification', 'custom/modules/TRI_TechnicalRequestItems/hooks/TechnicalRequestItemsAfterSaveHook.php','TechnicalRequestItemsAfterSaveHook', 'handleQtyChangedEmailNotification'); 
$hook_array['after_save'][] = Array(3, 'Insert Document to related TR - Document Subpanel', 'custom/modules/TRI_TechnicalRequestItems/hooks/TechnicalRequestItemsAfterSaveHook.php','TechnicalRequestItemsAfterSaveHook', 'insertTRIDocumentToTRDocumentsSubpanel'); 
$hook_array['after_save'][] = Array(4, 'Set TR to Development - In Process, if any TR Item Status is set to anything not New', 'custom/modules/TRI_TechnicalRequestItems/hooks/TechnicalRequestItemsAfterSaveHook.php','TechnicalRequestItemsAfterSaveHook', 'handleTrItemStatusChanged'); 
$hook_array['after_save'][] = Array(5, 'Create or update time record', 'custom/modules/TRI_TechnicalRequestItems/hooks/TechnicalRequestItemsAfterSaveHook.php','TechnicalRequestItemsAfterSaveHook', 'createOrUpdateTime'); 
$hook_array['after_save'][] = Array(6, 'Handle Remove Document Clicked', 'custom/modules/TRI_TechnicalRequestItems/hooks/TechnicalRequestItemsAfterSaveHook.php','TechnicalRequestItemsAfterSaveHook', 'handleRemoveDocumentClicked'); 
$hook_array['after_save'][] = Array(7, 'Handle Custom Mail Notif When Assigned User is updated', 'custom/modules/TRI_TechnicalRequestItems/hooks/TechnicalRequestItemsGenericHook.php','TechnicalRequestItemsGenericHook', 'handleAssignedUserNotification'); 
$hook_array['after_save'][] = Array(8, 'Handle Completed Colormatch', 'custom/modules/TRI_TechnicalRequestItems/hooks/TechnicalRequestItemsAfterSaveHook.php','TechnicalRequestItemsAfterSaveHook', 'handleCompletedColormatch'); 

$hook_array['after_relationship_add'] = Array();
$hook_array['after_relationship_add'][] = Array(0, 'Handle Custom Mail Notif When Assigned User is updated', 'custom/modules/TRI_TechnicalRequestItems/hooks/TechnicalRequestItemsGenericHook.php','TechnicalRequestItemsGenericHook', 'handleAssignedUserNotification'); 

$hook_array['process_record'] = Array();
$hook_array['process_record'][] = Array(1, 'Set custom column values', 'custom/modules/TRI_TechnicalRequestItems/hooks/TechnicalRequestItemsProcessRecordHook.php', 'TechnicalRequestItemsProcessRecordHook', 'handleCustomColumnValues');
$hook_array['process_record'][] = Array(2, 'Handle Created Date column to display as Date only', 'custom/modules/TRI_TechnicalRequestItems/hooks/TechnicalRequestItemsProcessRecordHook.php', 'TechnicalRequestItemsProcessRecordHook', 'handleSubpanelColumns');

?>