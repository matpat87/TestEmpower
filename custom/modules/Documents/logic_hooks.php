<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array(); 
$hook_array['before_save'] = Array();
$hook_array['before_save'][] = Array(1, 'Save non-db related to field value to subpanel', 'custom/modules/Documents/hooks/before_save_hook.php','BeforeSaveHook', 'saveNonDbFieldValueToSubpanel'); 
$hook_array['before_delete'] = Array(); 



?>