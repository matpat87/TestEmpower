<?php 
 //WARNING: The contents of this file are auto-generated



$admin_option_defs=array();
$admin_option_defs['Administration']['asol_common_config']= array('asol_Common',translate('LBL_ASOL_CONFIG_TITLE', 'asol_Common'),translate('LBL_ASOL_CONFIG_DESC', 'asol_Common'),'./index.php?module=asol_Common&action=index&view=edit');
$admin_option_defs['Administration']['asol_common_menus_management'] = array('asol_Common', translate('LBL_COMMON_MENU_MANAGEMENT_ACTION', 'asol_Common'), translate('LBL_COMMON_MENU_MANAGEMENT_ACTION', 'asol_Common'), './index.php?module=asol_Common&action=ManageCommonMenus');

//***********************//
//***AlineaSol Premium***//
//***********************//
require_once("modules/asol_Common/include/commonUtils.php");

$adminTemplatesPanel = asol_CommonUtils::managePremiumFeature("commonTemplatesManagement", "commonFunctions.php", "getCommonTemplatesManagementAdminPanel", null);
if ($adminTemplatesPanel !== false) {
	$admin_option_defs['Administration']['asol_common_templates_management'] = $adminTemplatesPanel;
}

$adminFieldsPanel = asol_CommonUtils::managePremiumFeature("commonFieldsManagement", "commonFunctions.php", "getCommonFieldsManagementAdminPanel", null);
if ($adminFieldsPanel !== false) {
	$admin_option_defs['Administration']['asol_common_fields_management'] = $adminFieldsPanel;
}

$adminPropertiesPanel = asol_CommonUtils::managePremiumFeature("commonPropertiesManagement", "commonFunctions.php", "getCommonPropertiesManagementAdminPanel", null);
if ($adminPropertiesPanel !== false) {
	$admin_option_defs['Administration']['asol_common_properties_management'] = $adminPropertiesPanel;
}

$adminLicensePanel = asol_CommonUtils::managePremiumFeature("commonLicenseManagement", "commonFunctions.php", "getCommonLicensingManagementAdminPanel", null);
if ($adminLicensePanel !== false) {
	$admin_option_defs['Administration']['asol_license_information'] = $adminLicensePanel;
}
//***********************//
//***AlineaSol Premium***//
//***********************//

$admin_group_header[]= array(translate('LBL_ASOL_COMMON_TITLE', 'asol_Common'),'',false,$admin_option_defs, translate('LBL_ASOL_ADMIN_PANEL_DESC', 'asol_Common'));




//global $mod_strings;

$admin_option_defs=array();
$admin_option_defs['Administration']['asol_wfm'] = array('asolAdministration','LBL_ASOL_WORKFLOWMANAGER','LBL_ASOL_WORKFLOWMANAGER_DESC','./index.php?module=asol_Process&action=index');
$admin_option_defs['Administration']['asol_wfm_2'] = array('asolAdministration','LBL_ASOL_CLEANUP','LBL_ASOL_CLEANUP_DESC','./index.php?module=asol_Process&action=cleanWFM.step1');
$admin_option_defs['Administration']['asol_wfm_3'] = array('asolAdministration','LBL_ASOL_MONITOR','LBL_ASOL_MONITOR_DESC','./index.php?module=asol_WorkingNodes&action=index');
$admin_option_defs['Administration']['asol_wfm_4'] = array('asolAdministration','LBL_ASOL_REBUILD','LBL_ASOL_REBUILD_DESC','./index.php?module=asol_Process&action=rebuild');
$admin_option_defs['Administration']['asol_wfm_5'] = array('asolAdministration','LBL_ASOL_CHECKCONFIGURATIONDEFS','LBL_ASOL_CHECKCONFIGURATIONDEFS_DESC','./index.php?module=asol_Process&action=CheckConfigurationDefs');
$admin_option_defs['Administration']['asol_wfm_6'] = array('asolAdministration','LBL_REPAIR_PHP_CUSTOM','LBL_REPAIR_PHP_CUSTOM_DESC','./index.php?module=asol_Process&action=repairPhpCustom');
$admin_option_defs['Administration']['asol_wfm_7'] = array('asolAdministration','LBL_ABOUT_WFM','LBL_ABOUT_WFM_DESC','./index.php?module=asol_Process&action=About');

$admin_group_header[]= array('LBL_ASOL_WFM_PANEL','',false,$admin_option_defs, 'LBL_ASOL_WFM_PANEL_DESC');


?>