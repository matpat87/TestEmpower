<?php

$module = 'asol_WorkFlowManagerCommon';

$viewdefs[$module]['base']['menu']['header'] = array();

$viewdefs[$module]['base']['menu']['header'][] = array(
	'route' => "#bwc/index.php?module=asol_WorkFlowManagerCommon=ListView",
	'label' => 'LNK_LIST',
	'acl_action' => 'list',
	'acl_module' => 'asol_WorkFlowManagerCommon',
	'icon' => 'icon-reorder',
);
