<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array(); 
$hook_array['before_save'] = Array(); 
$hook_array['before_delete'] = Array();
$hook_array['process_record'] = Array();

$hook_array['before_save'][] = Array(1, 'checkProductNumber', 'custom/modules/RMM_RawMaterialMaster/hooks/BeforeSave.php','RMM_RawMaterialMasterBeforeSaveHook', 'check_product_number'); 
// $hook_array['before_save'][] = Array(2, 'handleDocumentUpload', 'custom/modules/RMM_RawMaterialMaster/hooks/BeforeSave.php','RMM_RawMaterialMasterBeforeSaveHook', 'handleDocumentUpload'); 
$hook_array['process_record'][] = Array(1, 'Custom Link for Product Number', 'custom/modules/RMM_RawMaterialMaster/hooks/ProcessRecord.php', 'RMM_RawMaterialMasterProcessRecordHook', 'process_product_number_column');
$hook_array['after_save'][] = Array(1, 'handleDocumentUpload', 'custom/modules/RMM_RawMaterialMaster/hooks/AfterSave.php','RMM_RawMaterialMasterAfterSaveHook', 'handleDocumentUpload'); 
?>