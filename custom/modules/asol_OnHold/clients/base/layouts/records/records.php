<?php

$module = 'asol_OnHold';

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