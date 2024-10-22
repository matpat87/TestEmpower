<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(0, 'wfm_hook', 'custom/include/wfm_hook.php','wfm_hook_process', 'execute_process'); 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'updateStatusText', 'custom/modules/PA_PreventiveActions/hooks/BeforeSave.php','PA_PreventiveActionsBeforeSaveHook', 'status_update_append_before_save'); 
$hook_array['before_delete'] = Array(); 
$hook_array['before_delete'][] = Array(2, 'wfm_hook', 'custom/include/wfm_hook.php','wfm_hook_process', 'execute_process'); 

$hook_array['after_relationship_delete'] = Array();
$hook_array['after_relationship_delete'][] = Array(
    0, 
    'Handle related Activity Module Remove or Update Parent ID', 
    'custom/modules/PA_PreventiveActions/hooks/RelationshipHooks.php',
    'PA_PreventiveActionsRelationshipHooks', 
    'handleActivityRemoveParent'); 

?>