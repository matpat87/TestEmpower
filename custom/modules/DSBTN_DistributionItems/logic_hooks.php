<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['process_record'] = Array(); 
$hook_array['process_record'][] = Array(1, 'Process Record Hook', 'custom/modules/DSBTN_DistributionItems/hooks/ProcessRecord.php','ProcessRecord', 'process_record');
$hook_array['process_record'][] = Array(2, 'Handle Date Completed Column', 'custom/modules/DSBTN_DistributionItems/hooks/ProcessRecord.php','ProcessRecord', 'handle_date_completed');
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'Handle Distro Completed Date Value', 'custom/modules/DSBTN_DistributionItems/hooks/DistributionItemsBeforeSave.php', 'DistributionItemsBeforeSave', 'handleCompletedDateValue');

?>