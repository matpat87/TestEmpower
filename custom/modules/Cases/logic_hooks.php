<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array();
$hook_array['before_save'] = Array();
$hook_array['before_save'][] = Array(
        1,
		'Send email to assigned to + list when assigned to or status is updated',
		'custom/modules/Cases/hooks/workflowHook.php',
		'workflowHook',
		'sendEmail'
); 
$hook_array['before_delete'] = Array(); 



?>