<?php

$module = 'asol_ProcessInstances';

$viewdefs[$module]['base']['layout']['records'] = array(
	'name' => 'bwc',
	'type' => 'bwc',
	'components' =>
		array(
			array(
				'view' => 'bwc',
			),
	),
);