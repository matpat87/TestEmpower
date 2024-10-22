<?php
/*********************************************************************************
 * This file is part of QuickCRM Mobile Full.
 * QuickCRM Mobile Full is a mobile client for Sugar/SuiteCRM
 * 
 * Author : NS-Team (http://www.ns-team.fr)
 * All rights (c) 2011-2020 by NS-Team
 *
 * This Version of the QuickCRM Mobile Full is licensed software and may only be used in 
 * alignment with the License Agreement received with this Software.
 * This Software is copyrighted and may not be further distributed without
 * written consent of NS-Team
 * 
 * You can contact NS-Team at NS-Team - 55 Chemin de Mervilla - 31320 Auzeville - France
 * or via email at infos@ns-team.fr
 * 
 ********************************************************************************/
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

include('custom/modules/Administration/QuickCRM_utils.php');
global $sugar_config;
$qutils=new QUtils();
$qutils->LoadMobileConfig();

if ($qutils->mobile['profilemode']!=$_REQUEST['profilemode']){
	// remove existing profiles
	unset ($qutils->mobile['profiles']);
	$qutils->mobile['profiles'] = array();
}

$qutils->mobile['show_logo']=$_REQUEST['logomode'];
$qutils->mobile['profilemode']=$_REQUEST['profilemode'];
$qutils->mobile['languages']=$_REQUEST['languages'];
$qutils->mobile['offline_max_days']=$_REQUEST['offline_max_days'];
$qutils->mobile['rowsperpage']=$_REQUEST['rowsperpage'];
$qutils->mobile['rowsperdashlet']=$_REQUEST['rowsperdashlet'];
$qutils->mobile['rowspersubpanel']=$_REQUEST['rowspersubpanel'];
$qutils->mobile['groupusers']=(isset($_REQUEST['groupusers'])&&$_REQUEST['groupusers']=='on');
$qutils->mobile['native_cal']=(isset($_REQUEST['native_cal'])&&$_REQUEST['native_cal']=='on');
$qutils->mobile['force_lock']=(isset($_REQUEST['force_lock'])&&$_REQUEST['force_lock']=='on');
$qutils->mobile['audio_notes']=(isset($_REQUEST['audio_notes'])&&$_REQUEST['audio_notes']=='on');
$qutils->mobile['documents_sync']=(isset($_REQUEST['documents_sync'])&&$_REQUEST['documents_sync']=='on');
if (isset($sugar_config['suitecrm_version'])){
		$qutils->mobile['productimage']=(isset($_REQUEST['productimage'])&&$_REQUEST['productimage']=='on');
}
$qutils->mobile['trackermode']=$_REQUEST['trackermode'];
$qutils->mobile['trackerfreq']=$_REQUEST['trackerfreq'];
$qutils->mobile['trackerrole']=($_REQUEST['trackermode']=='ACLRoles'?$_REQUEST['trackerrole']:'');
if (isset($_REQUEST['trackergroup'])){
	$qutils->mobile['trackergroup']=($_REQUEST['trackermode']=='SecurityGroups'?$_REQUEST['trackergroup']:'');
}
$qutils->mobile['trackerviewer']=$_REQUEST['trackerviewer'];

require_once 'modules/Configurator/Configurator.php';
$configurator = new Configurator();
$configurator->loadConfig();


if (!empty($_REQUEST['trackermode'])){
	$configurator->config['quickcrm_tracker_menu'] = empty($_REQUEST['trackerviewer']) ?'admin':$_REQUEST['trackerviewer'];
}
else{
	$configurator->config['quickcrm_tracker_menu'] = false;
}
$configurator->handleOverride();

$qutils->mobile['whatsapp']=(isset($_REQUEST['whatsapp'])&&$_REQUEST['whatsapp']=='on');

if (!empty($_REQUEST['phone_country_code'])){
	$code = trim($_REQUEST['phone_country_code']);
	if (substr($code, 0, 1) != '+'){
		$code = '+' . $code;
	}
	$qutils->mobile['phone_country_code']=$code;
}

$qutils->SaveMobileConfig(true);
header ("Location: index.php?module=Administration&action=index");
