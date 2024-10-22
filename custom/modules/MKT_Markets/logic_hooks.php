<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(1, 'Send Email Acknowledgement', 'custom/modules/MKT_Markets/hooks/LeadsAfterSaveHook.php','LeadsAfterSaveHook', 'send_email_acknowledgement'); 
// $hook_array['after_save'][] = Array(2, 'Save Name value', 'custom/modules/MKT_Markets/hooks/AfterSave.php','MKT_MarketsAfterSaveHook', 'saveNameWithIndustryValue'); 
$hook_array['before_save'] = Array(); 
$hook_array['before_delete'] = Array(); 
$hook_array['process_record'] = Array();
$hook_array['process_record'][] = Array(1, 'Set Industry as linked column', 'custom/modules/MKT_Markets/hooks/ProcessRecord.php', 'ProcessRecord', 'customNameColume');

?>