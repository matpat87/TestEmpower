<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $app_strings, $sugar_config, $current_user;

$hideDashlets = true;

if ($current_user->is_admin) {
	$hideDashlets = false;
} else {
	$hideDashlets = (isset($sugar_config['WFM_hideDashlets'])) ? $sugar_config['WFM_hideDashlets'] : true;
}

$dashletMeta['asol_OnHoldDashlet'] = 
	array(
			'module' => 'asol_OnHold',
			'title' => translate('LBL_HOMEPAGE_TITLE', 'asol_OnHold'), 
			'description' => 'A customizable view into asol_OnHold',
			'icon' => 'icon_asol_OnHold_32.gif',
			'category' => 'Module Views',
			'hidden' => $hideDashlets,
	);