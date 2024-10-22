<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array();
$hook_array['before_save'] = Array();
$hook_array['before_save'] = Array();
$hook_array['before_save'][] = Array(2, 'updateStatusText', 'custom/modules/Cases/hooks/BeforeSave.php','CasesBeforeSaveHook', 'status_update_append_before_save'); 
$hook_array['before_save'][] = Array(
	3, 
	'Change status to Closed when Verified by Site Auditor', 
	'custom/modules/Cases/hooks/BeforeSave.php',
	'CasesBeforeSaveHook', 
	'set_status_close_on_verify'
); 
$hook_array['before_save'][] = Array(
	4, 
	'Set Date Closed when status is Closed', 
	'custom/modules/Cases/hooks/BeforeSave.php',
	'CasesBeforeSaveHook', 
	'handleDateClosed'
); 
$hook_array['before_save'][] = Array(
	5, 
	'Handle After Save when Audit Status is Rejected assigned user is Department Manager',
	'custom/modules/Cases/hooks/BeforeSave.php',
	'CasesBeforeSaveHook', 
	'handleAssignedUserOnRejectedAuditStatus'
); 
// $hook_array['before_save'][] = Array(
//         1,
// 		'Send email to assigned to + list when assigned to or status is updated',
// 		'custom/modules/Cases/hooks/workflowHook.php',
// 		'workflowHook',
// 		'sendEmail'
// );
$hook_array['before_delete'] = Array(); 
$hook_array['after_save'][] = Array(
        1,
		'Generate CAPA Working Group',
		'custom/modules/Cases/hooks/CapaWorkgroupAfterSaveHook.php',
		'CapaWorkgroupAfterSaveHook',
		'generate_workgroup'
);
$hook_array['after_save'][] = Array(
	2,
	'Handle Issue Assigned User value according to Status Value',
	'custom/modules/Cases/hooks/CapaWorkflowHook.php',
	'CapaWorkflowHook',
	'handleAssignedToUser'
);
$hook_array['after_save'][] = Array(
	3,
	'Send email to assigned to + list when assigned to or status is updated v2',
	'custom/modules/Cases/hooks/EmailNotificationsHook.php',
	'EmailNotificationsHook',
	'processNotification'
);
$hook_array['after_save'][] = Array(
	4,
	'Handle After Save Invoice relation data',
	'custom/modules/Cases/hooks/AfterSave.php',
	'CasesAfterSaveHook',
	'saveRelatedInvoice'
);

$hook_array['after_save'][] = Array(
	5,
	'Handle After Save Customer Product relation data',
	'custom/modules/Cases/hooks/AfterSave.php',
	'CasesAfterSaveHook',
	'saveRelatedCustomerProduct'
);

$hook_array['process_record'] = Array();
$hook_array['process_record'][] = Array(
	1,
	'Handle Product # value in List View',
	'custom/modules/Cases/hooks/ProcessRecord.php',
	'ProcessRecordHook',
	'handleProductNumberColumn'
);
$hook_array['process_record'][] = Array(
	2,
	'Handle Case Number value in List View',
	'custom/modules/Cases/hooks/ProcessRecord.php',
	'ProcessRecordHook',
	'handleIssueNumberColumn'
);
$hook_array['process_record'][] = Array(
	3,
	'Handle Return Authorization By in List View',
	'custom/modules/Cases/hooks/ProcessRecord.php',
	'ProcessRecordHook',
	'handleReturnAuthorizationByColumn'
);



?>