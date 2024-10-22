<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(2, 'Product Updates', 'custom/modules/AOS_Products/hooks/AOS_ProductsBeforeSaveHook.php','AOS_ProductsBeforeSaveHook', 'form_before_save'); 

$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(1, 'Handle TR Item Product Number Update', 'custom/modules/AOS_Products/hooks/AOS_ProductsAfterSaveHook.php','AOS_ProductsAfterSaveHook', 'handleTRItemProductNumberUpdate'); 

$hook_array['process_record'] = Array(); 
$hook_array['process_record'][] = Array(1, 'Product Retrieve', 'custom/modules/AOS_Products/hooks/AOS_ProductsProcessRecords.php','AOS_ProductsProcessRecords', 'process_records'); 

?>