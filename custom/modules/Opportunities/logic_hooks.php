<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array(); 
// $hook_array['after_save'][] = Array(1, 'wfm_hook', 'custom/include/wfm_hook.php','wfm_hook_process', 'execute_process'); 
$hook_array['after_save'][] = Array(1, 'Handle TR Data Map', 'custom/modules/Opportunities/hooks/OpportunitiesAfterSave.php','OpportunitiesAfterSave', 'handleTRDataMap'); 
$hook_array['after_save'][] = Array(2, 'send_mail_notifications', 'custom/modules/Opportunities/hooks/AfterSave.php','OpportunitiesAfterSaveHook', 'send_mail_notification'); 
$hook_array['after_save'][] = Array(3, 'Redirect to Opportunity Detail Page on New Opportunity when Created from Account - Opportunity Subpanel', 'custom/modules/Opportunities/hooks/OpportunitiesAfterSave.php','OpportunitiesAfterSave', 'redirectNewAccountOpportunity'); 
$hook_array['before_save'] = Array();
$hook_array['before_save'][] = Array(1, 'wfm_hook', 'custom/include/wfm_hook.php','wfm_hook_process', 'execute_process'); 
$hook_array['before_save'][] = Array(2, 'Set Closed Date', 'custom/modules/Opportunities/hooks/BeforeSave.php','OpportunitiesBeforeSaveHook', 'set_closed_date'); 
$hook_array['before_save'][] = Array(3, 'Calculate Opportunity Amount', 'custom/modules/Opportunities/hooks/BeforeSave.php','OpportunitiesBeforeSaveHook', 'calculateOpportunityAmount'); 
$hook_array['before_save'][] = Array(4, 'Next Step Edited', 'custom/modules/Opportunities/hooks/BeforeSave.php','OpportunitiesBeforeSaveHook', 'next_step_edited_before_save'); 
$hook_array['before_save'][] = Array(5, 'Set Amount Weighted', 'custom/modules/Opportunities/hooks/BeforeSave.php','OpportunitiesBeforeSaveHook', 'set_amount_weighted'); 
$hook_array['before_save'][] = Array(6, 'Set or Check Opp ID', 'custom/modules/Opportunities/hooks/BeforeSave.php','OpportunitiesBeforeSaveHook', 'opp_id_checker'); 
$hook_array['before_save'][] = Array(7, 'Handle Industry and Sub-Industry DB values before save', 'custom/modules/Opportunities/hooks/BeforeSave.php','OpportunitiesBeforeSaveHook', 'handleIndustryDbValues'); 

$hook_array['before_delete'] = Array(); 


$hook_array['after_relationship_add'] = Array();
$hook_array['after_relationship_add'][] = Array(1, 'After Add Relationship of Opportunities', 
'custom/modules/Opportunities/hooks/OpportunitiesAfterAddRelationshipHook.php', 'OpportunitiesAfterAddRelationshipHook', 'form_after_add_relationship_save');

$hook_array['after_relationship_delete'] = Array();
$hook_array['after_relationship_delete'][] = Array(1, 'Remove from Primary Contact if Contact is removed from Subpanel', 
'custom/modules/Opportunities/hooks/OpportunitiesAfterDeleteRelationshipHook.php', 'OpportunitiesAfterDeleteRelationshipHook', 'handleUnlinkPrimaryContact');

$hook_array['process_record'] = Array();
$hook_array['process_record'][] = Array(1, 'Custom Column Display', 'custom/modules/Opportunities/hooks/OpportunitiesProcessRecordHook.php', 'OpportunitiesProcessRecordHook', 'processCustomColumnDisplay');

$hook_array['after_save'][] = Array(4, 'Custom Save Industry relationship ID into db relationship table', 'custom/modules/Opportunities/hooks/AfterSave.php','OpportunitiesAfterSaveHook', 'custom_industry_ida_value'); 
$hook_array['after_save'][] = Array(5, 'Custom Save Industry relationship ID into db relationship table', 'custom/modules/Opportunities/hooks/AfterSave.php','OpportunitiesAfterSaveHook', 'custom_markets_id_save'); 
$hook_array['after_save'][] = Array(6, 'Handle Link Primary Contact To Subpanel', 'custom/modules/Opportunities/hooks/OpportunitiesAfterSave.php','OpportunitiesAfterSave', 'handleLinkPrimaryContactToSubpanel'); 

?>