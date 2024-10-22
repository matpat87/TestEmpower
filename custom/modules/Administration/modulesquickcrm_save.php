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
if(!isset($_REQUEST['enabled']))
	sugar_die("No modules selected");

global $sugar_config;
global $mod_strings;

require_once('custom/modules/Administration/QuickCRM_utils.php');
$qutils=new QUtils();

$QuickCRM_enabled_modules= array();

$enabled=explode(",", $_REQUEST['enabled']);
foreach($enabled as $module){
	array_push($QuickCRM_enabled_modules,substr ($module ,2));
}
$qutils->LoadMobileConfig(false);

$removed_modules = array();
foreach($qutils->mobile['modules'] as $module){
	if (!in_array($module,$QuickCRM_enabled_modules)){
		$removed_modules[]=$module;
	}
}
// cleanup views. // remove relate fields to removed modules. and 
if (count($removed_modules) > 0){
	// remove views for removed modules
	$views = array('fields','detail','list','highlighted','basic_search','search','popupsearch');

	foreach ($removed_modules as $module){
		foreach ($views as $view){
			if (isset($qutils->mobile[$view][$module])){
				unset($qutils->mobile[$view][$module]);
			}
		}
		foreach ($qutils->mobile['profiles'] as $profile_id => $profile_views){
			$view_fields = $profile_views[$view];
			if (isset($view_fields[$module])){
    			unset($qutils->mobile['profiles'][$profile_id][$view][$module]);
			}
		}
	}
	
	foreach ($QuickCRM_enabled_modules as $module){
		// remove relate fields to removed modules. 
		$nodeModule = Q_new_bean($module);
		$fields_to_remove = array();
		// find fields to remove  
		foreach($nodeModule->field_name_map as $field_name => $field_defs){
			if ($field_defs['type'] == 'relate'){
				if (isset($field_defs['module']) && in_array($field_defs['module'],$removed_modules)){
					$fields_to_remove[]=$field_name;
				}
			}
		}

		// remove them from default views  
		foreach ($views as $view){
			if (isset($qutils->mobile[$view][$module])){
				foreach($fields_to_remove as $field_to_remove){
					if (is_array($qutils->mobile[$view][$module]) && ($key = array_search($field_to_remove, $qutils->mobile[$view][$module])) !== false) {
    					unset($qutils->mobile[$view][$module][$key]);
					}
				}
			}
		}
		// remove them from profile specific views  
		foreach ($qutils->mobile['profiles'] as $profile_id => $profile_views){
			$view_fields = $profile_views[$view];
			if (isset($view_fields[$module])){
				foreach($fields_to_remove as $field_to_remove){
					if (is_array($qutils->mobile['profiles'][$profile_id][$view][$module]) && ($key = array_search($field_to_remove, $qutils->mobile['profiles'][$profile_id][$view][$module])) !== false) {
    					unset($qutils->mobile['profiles'][$profile_id][$view][$module][$key]);
					}
				}
			}

		}
	}
}

$qutils->mobile['modules']=$QuickCRM_enabled_modules;
$qutils->UpdateModules();
$qutils->SaveMobileConfig(true);
header("Location: index.php?module=Administration&action=modulesquickcrm&saved=1");

?>