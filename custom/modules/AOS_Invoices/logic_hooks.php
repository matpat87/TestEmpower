<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array(); 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'Save invoice name', 'custom/modules/AOS_Invoices/hooks/BeforeSave.php','AOS_InvoicesBeforeSaveHook', 'handleInvoiceName'); 
$hook_array['before_delete'] = Array(); 

$hook_array['after_relationship_delete'] = Array();
$hook_array['after_relationship_delete'][] = Array(
    1,
    'Delete Cases related invoices',
    'custom/modules/AOS_Invoices/hooks/AfterRelatedInvoiceDelete.php',
    'AfterRelatedInvoiceDelete',
    'removeRelatedInvoice');

    $hook_array['process_record'] = Array();
    $hook_array['process_record'][] = Array(1, 'Process Records', 'custom/modules/AOS_Invoices/hooks/ProcessRecordsHook.php', 'AOS_InvoicesProcessRecordHook', 'process_records');

?>