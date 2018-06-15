<?php

$module = 'asol_WorkFlowManagerCommon';

$viewdefs[$module]['base']['menu']['header'] = array();

$viewdefs[$module]['base']['menu']['header'][] = array(
	'route' => "#asol_WorkFlowManagerCommon",
	'label' => 'LNK_LIST',
	'acl_action' => 'list',
	'acl_module' => 'asol_WorkFlowManagerCommon',
	'icon' => 'icon-reorder',
);

