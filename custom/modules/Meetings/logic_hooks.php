<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array(); 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'audit_duration', 'custom/modules/Meetings/hooks/BeforeSave.php','MeetingsBeforeSaveHook', 'custom_duration_audit');
$hook_array['before_delete'] = Array(); 

$hook_array['after_relationship_add'] = Array();
$hook_array['after_relationship_add'][] = Array(
    0, 
    'Handle Meeting Remove or Update Parent ID', 
    'custom/modules/Meetings/hooks/RelationshipHooks.php',
    'MeetingsRelationshipHooks', 
    'handleAddParent'); 


?>