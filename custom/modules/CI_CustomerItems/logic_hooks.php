<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
$hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'Set assigned user id to logged user when creating new record', 'custom/modules/CI_CustomerItems/hooks/CustomerProductBeforeSaveHook.php','CustomerProductBeforeSaveHook', 'setAssignedUser'); 
$hook_array['before_save'][] = Array(2, 'Handle Industry and Sub-Industry DB values before save', 'custom/modules/CI_CustomerItems/hooks/CustomerProductBeforeSaveHook.php','CustomerProductBeforeSaveHook', 'handleIndustryDbValues'); 

$hook_array['process_record'] = Array();
$hook_array['process_record'][] = Array(1, 'Custom list view columns display', 'custom/modules/CI_CustomerItems/hooks/CustomerProductProcessRecordHook.php', 'CustomerProductProcessRecordHook', 'processCustomColumnStyle');

$hook_array['after_save'][] = Array(1, 'send_mail_notifications', 'custom/modules/CI_CustomerItems/hooks/CustomerProductAfterSaveHook.php','CustomerProductAfterSaveHook', 'send_mail_notification'); 
$hook_array['after_save'][] = Array(2, 'Custom Industry ID save hook', 'custom/modules/CI_CustomerItems/hooks/CustomerProductAfterSaveHook.php','CustomerProductAfterSaveHook', 'custom_industry_ida_value'); 
$hook_array['after_save'][] = Array(3, 'Custom Markets ID save hook', 'custom/modules/CI_CustomerItems/hooks/CustomerProductAfterSaveHook.php','CustomerProductAfterSaveHook', 'custom_markets_id_save');

$hook_array['after_relationship_delete'] = Array();
$hook_array['after_relationship_delete'][] = Array(
    1,
    'Delete Cases related customer products',
    'custom/modules/CI_CustomerItems/hooks/CustomerProductAfterRelationshipDelete.php',
    'CustomerProductAfterRelationshipDelete',
    'removeRelatedProduct');


?>