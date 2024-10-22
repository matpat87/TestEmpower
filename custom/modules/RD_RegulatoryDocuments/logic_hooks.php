<?php
	// Do not store anything in this file that is not part of the array or the hook version.  This file will	
	// be automatically rebuilt in the future. 
	$hook_version = 1; 
	$hook_array = Array(); 
	// position, file, function 
	$hook_array['after_save'] = Array(); 
	$hook_array['before_save'] = Array();
	$hook_array['before_save'][] = Array(1, 'Save non-db related to field value to subpanel', 'custom/modules/RD_RegulatoryDocuments/hooks/BeforeSaveHook.php','RegulatoryDocumentsBeforeSaveHook', 'saveNonDbFieldValueToSubpanel'); 
	$hook_array['before_delete'] = Array(); 
	$hook_array['process_record'] = Array(); 
	$hook_array['process_record'][] = Array(
		1, 
		'Handle File link display on module list view', 
		'custom/modules/RD_RegulatoryDocuments/hooks/ProcessRecordHook.php',
		'RD_RegulatoryDocumentsProcessRecordHook',
		'handleFileLinkColumn'
	);

?>