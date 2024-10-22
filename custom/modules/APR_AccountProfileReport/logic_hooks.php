<?php
 // Do not store anything in this file that is not part of the array or the hook
 //version.  This file will be automatically rebuilt in the future.
$hook_version = 1;
$hook_array = Array();
 // position, file, function
$hook_array['before_save'] = Array();
$hook_array['after_save'] = Array();
$hook_array['after_relationship_add'] = Array();
$hook_array['after_relationship_delete'] = Array();
$hook_array['process_record'] = Array();
$hook_array['process_record'][] = Array(
    1,
    'Handle custom Account Profile Report link',
    'custom/modules/APR_AccountProfileReport/hooks/ProcessRecordHook.php',
    'APR_AccountProfileReportProcessRecord',
    'handleCustomReportLink');