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
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_language;
global $beanFiles, $beanList;
global $moduleList;
global $sugar_config;
ini_set("display_errors", 0);

require_once('custom/modules/Administration/QuickCRM_utils.php');
$qutils=new QUtils();
$qutils->LoadMobileConfig(true); // refresh first open only
$qutils->LoadServerConfig(true); // refresh first open only

$module = $_REQUEST['conf_module'];

$MBmod_strings=return_module_language($current_language, 'ModuleBuilder');

if (!isset($app_strings['LBL_THEME_COLOR'])){
	$Calmod_strings=return_module_language($current_language, 'Calendar');
	$app_strings['LBL_THEME_COLOR'] = $Calmod_strings['LBL_COLOR_SETTINGS'];
}

$ss = new Sugar_Smarty();
$ss->assign('module', $module);
$ss->assign('MOD', $mod_strings);
$ss->assign('APP_STRINGS', $app_strings);
$ss->assign('AVAILABLE', $MBmod_strings['LBL_AVAILABLE']);
$ss->assign('HIDDEN', $MBmod_strings['LBL_HIDDEN']);
$ss->assign('TITLE', $app_list_strings["moduleList"][$module]);

$colorfields = array();
$colorfields['none'] = $app_strings['LBL_NONE'];
$colorfields['assigned_user_id'] = $app_strings['LBL_LIST_ASSIGNED_USER'];
if (isset($qutils->server_config['marked'][$module])) {
	foreach ($qutils->server_config['marked'][$module] as $field => $data ){
		$colorfields[$field] = $data['label'];
	}
}
$color = '';
if (isset($qutils->mobile['marked'][$module])) $color = $qutils->mobile['marked'][$module];
$ss->assign('color_value', $color);
$ss->assign('color_options', $colorfields);

$barcodefields = array(''=>' -- ','id'=>'ID');
if (isset($qutils->server_config['barcodes'][$module])) {
	foreach ($qutils->server_config['barcodes'][$module] as $field => $data ){
		$barcodefields[$field] = $data['label'];
	}
}
$barcode = '';
if (isset($qutils->mobile['barcodes'][$module])) $barcode = $qutils->mobile['barcodes'][$module];
$ss->assign('barcode_value', $barcode);
$ss->assign('barcode_options', $barcodefields);



$mapcolor = '';
if (isset($qutils->mobile['mapcolor']) && isset($qutils->mobile['mapcolor'][$module])) $mapcolor = $qutils->mobile['mapcolor'][$module];
else $mapcolor = $color;

$ss->assign('mapcolor_value', $mapcolor);
$ss->assign('mapcolor_options', $colorfields);

$ss->assign('LISTVIEW', $MBmod_strings['LBL_LISTVIEW']);

if (in_array ('jjwg_Maps',$moduleList)){
	if (in_array ($module,$qutils->getMapModules())){
		$map_mod_strings=return_module_language($current_language, 'jjwg_Maps');
		$key='LBL_CONFIG_GROUP_FIELD_FOR_'.strtoupper($module);
		$maps_label = $app_list_strings["moduleList"]["jjwg_Maps"];
		if (isset($map_mod_strings[$key])){
			$ss->assign('MAPVIEW',$maps_label .' : '. $map_mod_strings[$key]);
		}
		else {
			$ss->assign('MAPVIEW',$app_strings['LBL_THEME_COLOR'] .' : '. $maps_label);
		}
	}
	else {
		$ss->assign('MAPVIEW', false);
	}
}
else {
	$ss->assign('MAPVIEW', false);
}

$showicon =true;
if (isset($qutils->mobile['show_icon'][$module])){
	$showicon=$qutils->mobile['show_icon'][$module];
}

$subpanelonly=false;
if (isset($qutils->mobile['create_subpanel'][$module])){
	$subpanelonly=$qutils->mobile['create_subpanel'][$module];
}

$ss->assign('showicon', $showicon);
$ss->assign('subpanelonly', $subpanelonly);

$titles=array(	'fields'=>$MBmod_strings['LBL_EDITVIEW'],
				'detail'=>$MBmod_strings['LBL_DETAILVIEW'],
				'search'=>$mod_strings['LBL_SEARCH_FIELDS_TITLE'],
				'popupsearch'=>$MBmod_strings['LBL_POPUPSEARCH'],
				'list'=>$MBmod_strings['LBL_LISTVIEW'],
				'subpanels'=> $mod_strings['LBL_VISIBLE_PANELS']
	);
$buttons = array(
);
$buttons['fields'] = array(
	'title' => $MBmod_strings['LBL_EDITVIEW'],
	'imageName' => 'EditView',
	
);
$buttons['detail'] = array(
	'title' => $MBmod_strings['LBL_DETAILVIEW'],
	'imageName' => 'DetailView',
	
);
$buttons['search'] = array(
	'title' => $mod_strings['LBL_SEARCH_FIELDS_TITLE'],
	'imageName' => 'BasicSearch',
	
);

$buttons['popupsearch'] = array(
	'title' => $MBmod_strings['LBL_POPUPSEARCH'],
	'imageName' => 'BasicSearch',	
);

$buttons['list'] = array(
	'title' => $MBmod_strings['LBL_LISTVIEW'],
	'imageName' => 'ListView',
	
);
$buttons['subpanels'] = array(
	'title' => $mod_strings['LBL_VISIBLE_PANELS'],
	'imageName' => 'Subpanels',
	
);

$ss->assign ( 'buttons', $buttons) ;

// display or not message for roles/SG choice
if (in_array ('SecurityGroups',$moduleList)){
/*
	$ExistProfiles = false;
	if (!isset($qutils->mobile['profiles'])) $qutils->mobile['profiles'] = array();
	foreach ($qutils->mobile['profiles'] as $profile){
		if (isset($profile['detail']) && count($profile['detail']) > 0){
			$ExistProfiles = true;
			break;
		}
		if (isset($profile['fields']) && count($profile['fields']) > 0){
			$ExistProfiles = true;
			break;
		}
		if (isset($profile['list']) && count($profile['list']) > 0){
			$ExistProfiles = true;
			break;
		}
		if (isset($profile['subpanels']) && count($profile['subpanels']) > 0){
			$ExistProfiles = true;
			break;
		}
	}
	if (!$ExistProfiles){
		$ss->assign('HEADER_WARNING', $mod_strings["LBL_MULTIVIEW_DEFAULT"]);
	}
*/
}

//get roles or security groups that do not have a layout for this module yet
$group_module = $qutils->mobile['profilemode'];

$copy_groups = array('_default'=> $mod_strings['LBL_QDEFAULT']); 
$available_groups = array(); 
$defined_groups = array(); 

if ($group_module  != 'none'){

	$ss->assign ( 'group_mode', $app_list_strings["moduleList"][$group_module]) ;

	if ($sugar_config['sugar_version']<'6.3'){
		require_once($beanFiles[$beanList[$group_module]]);
		$group_bean = new $beanList[$group_module];
	}
	else {
		$group_bean = BeanFactory::getBean($group_module);
	}

	$groups = $group_bean->get_full_list("name");
	if(!empty($groups)) {
    	foreach($groups as $group) {
			$already_exists = false;
        	if (isset($qutils->mobile['profiles']) && isset($qutils->mobile['profiles'][$group->id])){
				$profile = $qutils->mobile['profiles'][$group->id];
				if (isset($profile['fields'][$module]) || isset($profile['list'][$module]) || isset($profile['search'][$module]))
					$already_exists = true;
        	}
        	if(!$already_exists) {
            	$available_groups[$group->id] = $group->name;
        	}
        	else {
            	$copy_groups[$group->id] = $group->name;
            	$defined_groups=array('id'=> $group->id, 'name' => $group->name);
        	}
    	}
	}
}

//if (count($available_groups) == 0) die();
$ss->assign ( 'hideprofiles', count($available_groups) == 0) ;

$ss->assign ( 'available_groups', $available_groups) ;
$ss->assign ( 'copy_from', $copy_groups) ;
$ss->assign ( 'groups_defined', count($copy_groups) > 1) ;
$ss->assign ( 'defined_groups', $defined_groups) ;

$ss->display('custom/modules/Administration/tpls/QCRMModule.tpl');

?>