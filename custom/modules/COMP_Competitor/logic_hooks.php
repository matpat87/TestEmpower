<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
$hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array(); 
$hook_array['process_record'] = Array();
$hook_array['after_save'] = Array();

$hook_array['before_save'][] = Array(1, 'Save Competition Name as name', 'custom/modules/COMP_Competitor/hooks/CompetitorBeforeSaveHook.php','CompetitorBeforeSaveHook', 'handleSaveCompetitionName'); 

$hook_array['after_save'][] = Array(1, 'Add competitor id to relationship table', 'custom/modules/COMP_Competitor/hooks/CompetitorAfterSaveHook.php','CompetitorAfterSaveHook', 'handleCompetitorValueSave'); 

$hook_array['process_record'][] = Array(1, 'Competitor value link instead of name', 'custom/modules/COMP_Competitor/hooks/CompetitorProcessRecordHook.php','CompetitorProcessRecordHook', 'handleCompetitorNameColumn'); 


