<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array(); 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'Handle Survey Id Number Assignment', 'custom/modules/Surveys/hooks/SurveysBeforeSaveHook.php','SurveysBeforeSaveHook', 'handleSurveyIdNumberAssignment'); 
$hook_array['before_delete'] = Array(); 



?>