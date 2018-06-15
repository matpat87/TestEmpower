<?php

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
wfm_utils::wfm_log('debug', 'ENTRY', __FILE__);

wfm_utils::wfm_log('debug', '$_REQUEST=['.var_export($_REQUEST, true).']', __FILE__, __METHOD__, __LINE__);

if ($_REQUEST['clean_deleted_wfm_entities']) {
	wfm_utils::cleanDeletedWFMEntitiesAndRelationships();
}

if ($_REQUEST['clean_unrelated_wfm_entities']) {
	wfm_utils::cleanUnrelatedWFMEntities();
}

if ($_REQUEST['clean_deleted_login_audit']) {
	wfm_utils::cleanDeletedLoginAudit();
}

if ($_REQUEST['clean_deleted_email_templates']) {
	wfm_utils::cleanDeletedEmailTemplates();
}

switch ($_REQUEST['clean_wfm_working_tables_type']) {
	case 'clean_broken_working_nodes':
		wfm_utils::cleanWFMBrokenWorkingNodes();
		break;
	case 'clean_wfm_working_tables':
		wfm_utils::cleanWFMWorkingTables();
		break;
}

wfm_utils::wfm_log('debug', 'EXIT', __FILE__);

?>

<b>Done.</b>