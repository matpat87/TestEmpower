<?php

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
wfm_utils::wfm_log('debug', 'ENTRY', __FILE__);

$imported_workflows = $_SESSION['imported_workflows'];
$workflows_exist_process_ids = $_SESSION['workflows_exist_process_ids'];
$workflows_exist = (count($workflows_exist_process_ids) > 0);
$in_context_process_id = null;

$import_type = $_SESSION['import_type'];
$rename_type = $_SESSION['rename_type'];
$prefix = $_SESSION['prefix'];
$suffix = $_SESSION['suffix'];
$set_status_type = $_SESSION['set_status_type'];

$import_email_template_type = $_SESSION['import_email_template_type'];
$if_email_template_already_exists = $_SESSION['if_email_template_already_exists'];

$version_compatibility_type = $_REQUEST['version_compatibility_type'];

$import_domain_type = $_SESSION['import_domain_type'];
$explicit_domain = $_SESSION['explicit_domain'];

// Import
try {
	wfm_utils::importWorkFlows($imported_workflows, $workflows_exist_process_ids, $workflows_exist, $in_context_process_id, $import_type, $prefix, $suffix, $rename_type, $set_status_type, $import_domain_type, $explicit_domain, $import_email_template_type, $if_email_template_already_exists, $version_compatibility_type);
} catch (Exception $exception) {
	wfm_utils::wfm_log('fatal', wfm_utils::jTraceEx($exception), __FILE__, __METHOD__, __LINE__);
}


wfm_utils::wfm_log('debug', 'EXIT', __FILE__);
?>