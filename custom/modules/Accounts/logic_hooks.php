<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(1, 'Handle OEM Field Parent Child Mapping', 'custom/modules/Accounts/hooks/AfterSaveHook.php','AccountsAfterSaveHook', 'handleOEMFieldParentChildMapping'); 
$hook_array['after_save'][] = Array(2, 'wfm_hook', 'custom/include/wfm_hook.php','wfm_hook_process', 'execute_process'); 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'Set/Remove Account Access Security Group (and child modules) based on assigned user', 'custom/modules/Accounts/hooks/before_save_hook.php','AccountsBeforeSaveHook', 'setAccountAccessSecurityGroup');
$hook_array['before_save'][] = Array(4, 'Handle CAPA Working Group Asssignments', 'custom/modules/Accounts/hooks/before_save_hook.php','AccountsBeforeSaveHook', 'handleCAPAWorkingGroupAssignments'); 
$hook_array['before_save'][] = Array(5, 'Handle TR Working Group Asssignments', 'custom/modules/Accounts/hooks/before_save_hook.php','AccountsBeforeSaveHook', 'handleTRWorkingGroupAssignments'); 
$hook_array['before_save'][] = Array(6, 'Handle RR Working Group Asssignments', 'custom/modules/Accounts/hooks/before_save_hook.php','AccountsBeforeSaveHook', 'handleRRWorkingGroupAssignments'); 
$hook_array['before_save'][] = Array(7, 'wfm_hook', 'custom/include/wfm_hook.php','wfm_hook_process', 'execute_process'); 
$hook_array['before_delete'] = Array(); 
$hook_array['before_relationship_add'] = Array();
$hook_array['before_relationship_add'][] = Array(1, 'Set Account Access Security Group to child records when adding new Security Group via Subpanel', 'custom/modules/Accounts/hooks/before_relationship_add_hook.php','AccountsBeforeRelationshipAddHook', 'setAccountAccessSecurityGroupToChildRecords'); 
$hook_array['before_relationship_delete'] = Array();
$hook_array['before_relationship_delete'][] = Array(1, 'Remove Account Access Security Group from child records when removing Security Group via Subpanel', 'custom/modules/Accounts/hooks/before_relationship_delete_hook.php','AccountsBeforeRelationshipDeleteHook', 'removeAccountAccessSecurityGroupFromChildRecords'); 
$hook_array['process_record'][] = Array(1, 'Populate Current YTD Budget', 'custom/modules/Accounts/hooks/populateListViewColumnHook.php','populateListViewColumnHook', 'populateCurrentYTDBudget');
$hook_array['process_record'][] = Array(2, 'Populate Current Month Budget', 'custom/modules/Accounts/hooks/populateListViewColumnHook.php','populateListViewColumnHook', 'populateCurrentMonthBudget');



?>