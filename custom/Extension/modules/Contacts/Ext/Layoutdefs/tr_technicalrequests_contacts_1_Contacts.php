<?php
 // created: 2022-09-17 07:22:39
$layout_defs["Contacts"]["subpanel_setup"]['tr_technicalrequests_contacts_1'] = array (
	'order' => 100,
	'module' => 'TR_TechnicalRequests',
	'subpanel_name' => 'default',
	'sort_order' => 'asc',
	'sort_by' => 'id',
	'title_key' => 'LBL_TR_TECHNICALREQUESTS_CONTACTS_1_TITLE',
	'get_subpanel_data' => 'function:tr_technicalrequests_contacts_1',
	'generate_select' => true,
    'get_distinct_data' => true,
	'function_parameters' => array(
		'import_function_file' => 'custom/modules/Contacts/helpers/CustomSubpanelData.php',
		'link' => 'tr_technicalrequests_contacts_1',
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
