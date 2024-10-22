<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(2, 'wfm_hook', 'custom/include/wfm_hook.php','wfm_hook_process', 'execute_process'); 
$hook_array['after_save'][] = Array(3, 'audit_status', 'custom/modules/Calls/hooks/AfterSave.php','CallsAfterSaveHook', 'custom_status_audit'); 

$hook_array['after_save'][] = Array(1, 'WakeUp Holded Item', 'custom/include/wfm_on_hold.php','wfm_hook_on_hold', 'wakeup_on_hold'); 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(2, 'wfm_hook', 'custom/include/wfm_hook.php','wfm_hook_process', 'execute_process'); 
$hook_array['before_delete'] = Array(); 
$hook_array['before_delete'][] = Array(2, 'wfm_hook', 'custom/include/wfm_hook.php','wfm_hook_process', 'execute_process'); 

$hook_array['after_relationship_add'] = Array();
$hook_array['after_relationship_add'][] = Array(
    0, 
    'Handle Meeting Remove or Update Parent ID', 
    'custom/modules/Calls/hooks/RelationshipHooks.php',
    'CallsRelationshipHooks', 
    'handleAddParent'); 



?>