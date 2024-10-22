<?php
 // created: 2022-09-17 07:22:39
$layout_defs["Contacts"]["subpanel_setup"]['custom_dsbtn_distribution'] = array (
	'order' => 100,
	'module' => 'DSBTN_Distribution',
	'subpanel_name' => 'default',
	'sort_order' => 'asc',
	'sort_by' => 'id',
	'title_key' => 'LBL_DSBTN_DISTRIBUTION_TITLE',
	'get_subpanel_data' => 'function:custom_dsbtn_distributioncustom_dsbtn_distribution',
	'generate_select' => true,
    'get_distinct_data' => true,
	'function_parameters' => array(
		'import_function_file' => 'custom/modules/Contacts/helpers/CustomSubpanelData.php',
		'return_as_array' => true
	),
	'top_buttons' => 
	array (
		0 =>  
		array (
			'widget_class' => 'SubPanelTopButtonQuickCreate',
		),
		1 => 
		array (
			'widget_class' => 'SubPanelTopSelectButton',
			'mode' => 'MultiSelect',
		),
	),
);
