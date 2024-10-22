<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'Handle Distro Item Mass Update', 'custom/modules/DSBTN_Distribution/hooks/DistributionMassUpdateHook.php', 'DistributionMassUpdateHook', 'handleDistroItemMassUpdate');
$hook_array['before_save'][] = Array(2, 'Before Save Hook', 'custom/modules/DSBTN_Distribution/hooks/DistributionBeforeSaveHook.php', 'DistributionBeforeSaveHook', 'before_save');

$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(1, 'Handle TR Items Data', 'custom/modules/DSBTN_Distribution/hooks/DistributionAfterSaveHook.php','DistributionAfterSaveHook', 'handleTRItemsData');

$hook_array['process_record'] = Array(); 
$hook_array['process_record'][] = Array(2, 'Process Record', 'custom/modules/DSBTN_Distribution/hooks/DSBTN_DistributionProcessRecordHook.php', 'DSBTN_DistributionProcessRecordHook', 'process_record');

?>