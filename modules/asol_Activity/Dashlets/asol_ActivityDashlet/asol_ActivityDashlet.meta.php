<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $app_strings, $sugar_config, $current_user;

$hideDashlets = true;

if ($current_user->is_admin) {
	$hideDashlets = false;
} else {
	$hideDashlets = (isset($sugar_config['WFM_hideDashlets'])) ? $sugar_config['WFM_hideDashlets'] : true;
}

$dashletMeta['asol_ActivityDashlet'] = 
	array(
			'module' => 'asol_Activity',
			'title' => translate('LBL_HOMEPAGE_TITLE', 'asol_Activity'), 
			'description' => 'A customizable view into asol_Activity',
			'icon' => 'icon_asol_Activity_32.gif',
			'category' => 'Module Views',
			'hidden' => $hideDashlets,
	);