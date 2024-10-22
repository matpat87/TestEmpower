<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will
// be automatically rebuilt in the future.
 $hook_version = 1;
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array();
$hook_array['after_save'][] = Array(
    1,
    'Handle Parent Module Line Item Change Log Transactions (New/Edit)',
    'custom/modules/AOS_Products_Quotes/hooks/AOSProductsQuotesAfterSaveHook.php',
    'AOSProductsQuotesAfterSaveHook',
    'HandleParentModuleLineItemChangeLogTransactions'
);
$hook_array['before_delete'] = Array();
$hook_array['before_delete'][] = Array(
    1,
    'Handle Parent Module Line Item Change Log Transactions (Delete)',
    'custom/modules/AOS_Products_Quotes/hooks/AOSProductsQuotesBeforeDeleteHook.php',
    'AOSProductsQuotesBeforeDeleteHook',
    'HandleParentModuleLineItemChangeLogTransactions'
);