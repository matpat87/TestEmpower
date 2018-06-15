<?php

$module = 'asol_Activity';

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");

$viewdefs[$module]['base']['menu']['header'] = array();

$viewdefs[$module]['base']['menu']['header'][] = array(
	'route' => "#bwc/index.php?module=asol_Process&action=ListView",
	'label' => 'LBL_ASOL_VIEW_ASOL_PROCESSES',
	'acl_action' => 'list',
	'acl_module' => 'asol_Process',
	'icon' => 'icon-reorder',
);
$viewdefs[$module]['base']['menu']['header'][] = array(
	'route' => "#bwc/index.php?module=asol_Process&action=EditView",
	'label' => 'LBL_ASOL_CREATE_ASOL_PROCESS',
	'acl_action' => 'create',
	'acl_module' => 'asol_Process',
	'icon' => 'icon-plus',
);
$viewdefs[$module]['base']['menu']['header'][] = array(
	'route' => "#bwc/index.php?module=asol_Events&action=ListView",
	'label' => 'LBL_ASOL_VIEW_ASOL_EVENTS',
	'acl_action' => 'list',
	'acl_module' => 'asol_Events',
	'icon' => 'icon-reorder',
);
$viewdefs[$module]['base']['menu']['header'][] = array(
	'route' => "#bwc/index.php?module=asol_Activity&action=ListView",
	'label' => 'LBL_ASOL_VIEW_ASOL_ACTIVITIES',
	'acl_action' => 'list',
	'acl_module' => 'asol_Activity',
	'icon' => 'icon-reorder',
);
$viewdefs[$module]['base']['menu']['header'][] = array(
	'route' => "#bwc/index.php?module=asol_Task&action=ListView",
	'label' => 'LBL_ASOL_VIEW_ASOL_TASKS',
	'acl_action' => 'list',
	'acl_module' => 'asol_Task',
	'icon' => 'icon-reorder',
);

if (ACLController::checkAccess('EmailTemplates', 'list', true)) {
	$viewdefs[$module]['base']['menu']['header'][] = array(
		'route' => "#bwc/index.php?module=EmailTemplates&action=ListView",
		'label' => translate('LNK_EMAIL_TEMPLATE_LIST', 'EmailTemplates'),
		'acl_action' => 'list',
		'acl_module' => 'EmailTemplates',
		'icon' => 'icon-reorder',
	);
}

if (wfm_notification_emails_utils::isNotificationEmailsInstalled()) {
	$viewdefs[$module]['base']['menu']['header'][] = array(
		'route' => "#bwc/index.php?module=asol_NotificationEmails&action=ListView",
		'label' => translate('LNK_LIST', 'asol_NotificationEmails'),
		'acl_action' => 'list',
		'acl_module' => 'asol_NotificationEmails',
		'icon' => 'icon-reorder',
	);
}

$viewdefs[$module]['base']['menu']['header'][] = array(
	'route' => "#bwc/index.php?module=asol_WorkingNodes&action=ListView",
	'label' => 'LBL_ASOL_ALINEASOL_WFM_MONITOR',
	'acl_action' => 'list',
	'acl_module' => 'asol_WorkingNodes',
	'icon' => 'icon-reorder',
);

// Login Audit
$extraParams = Array(
	'module_menu' => $viewdefs[$module]['base']['menu']['header'],
);
$addLoginAuditToModuleMenu = wfm_reports_utils::managePremiumFeature("addLoginAuditToModuleMenuHeader", "wfm_utils_premium.php", "addLoginAuditToModuleMenuHeader", $extraParams);
if ($addLoginAuditToModuleMenu !== false) {
	$viewdefs[$module]['base']['menu']['header'] = $addLoginAuditToModuleMenu;
}
    
