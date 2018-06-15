<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");

global $mod_strings, $app_strings, $current_user;

$module_menu[]=Array("index.php?module=asol_Process&action=index", $mod_strings["LBL_ASOL_VIEW_ASOL_PROCESSES"],"asol_Process");
$module_menu[]=Array("index.php?module=asol_Process&action=EditView", $mod_strings["LBL_ASOL_CREATE_ASOL_PROCESS"],"Createasol_Process");
$module_menu[]=Array("index.php?module=asol_Events&action=index", $mod_strings["LBL_ASOL_VIEW_ASOL_EVENTS"],"asol_Events");
$module_menu[]=Array("index.php?module=asol_Activity&action=index", $mod_strings["LBL_ASOL_VIEW_ASOL_ACTIVITIES"],"asol_Activity");
$module_menu[]=Array("index.php?module=asol_Task&action=index", $mod_strings["LBL_ASOL_VIEW_ASOL_TASKS"],"asol_Task");
if(ACLController::checkAccess('EmailTemplates', 'list', true)) $module_menu[]=Array("index.php?module=EmailTemplates&action=index", translate('LNK_EMAIL_TEMPLATE_LIST', 'EmailTemplates'),"EmailTemplates");
if (wfm_notification_emails_utils::isNotificationEmailsInstalled()) $module_menu[]=Array("index.php?module=asol_NotificationEmails&action=index", translate('LNK_LIST', 'asol_NotificationEmails'),"asol_NotificationEmails");
if (wfm_domains_utils::wfm_isDomainsInstalled() && (ACLController::checkAccess('asol_Domains', 'list', true))) $module_menu[]=Array("index.php?module=asol_Domains&action=index", translate('LNK_LIST', 'asol_Domains'),"asol_Domains");
$module_menu[]=Array("index.php?module=asol_WorkingNodes&action=index", $mod_strings["LBL_ASOL_ALINEASOL_WFM_MONITOR"],"asol_WorkingNodes");

// Login Audit
$extraParams = Array(
	'module_menu' => $module_menu,
);
$addLoginAuditToModuleMenu = wfm_reports_utils::managePremiumFeature("addLoginAuditToModuleMenu", "wfm_utils_premium.php", "addLoginAuditToModuleMenu", $extraParams);
if ($addLoginAuditToModuleMenu !== false) {
	$module_menu = $addLoginAuditToModuleMenu;
}

//if(ACLController::checkAccess('Accounts', 'edit', true))$module_menu[]=Array("index.php?module=Accounts&action=EditView&return_module=Accounts&return_action=index", $mod_strings['LNK_NEW_ACCOUNT'],"CreateAccounts", 'Accounts');
//if(ACLController::checkAccess('Accounts', 'list', true))$module_menu[]=Array("index.php?module=Accounts&action=index&return_module=Accounts&return_action=DetailView", $mod_strings['LNK_ACCOUNT_LIST'],"Accounts", 'Accounts');
//if(ACLController::checkAccess('Accounts', 'import', true))$module_menu[]=Array("index.php?module=Import&action=Step1&import_module=Accounts&return_module=Accounts&return_action=index", $mod_strings['LNK_IMPORT_ACCOUNTS'],"Import", 'Accounts');

?>