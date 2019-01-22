<?php

	$layout_defs["Bugs"]["subpanel_setup"]["history"]["top_buttons"] = array(
	    array('widget_class' => 'SubPanelTopArchiveEmailButton'),
        array('widget_class' => 'SubPanelTopSummaryButton'),
	);

	$layout_defs["Bugs"]["subpanel_setup"]["history"]["collection_list"] = array(
		'meetings' => array(
            'module' => 'Meetings',
            'subpanel_name' => 'ForHistory',
            'get_subpanel_data' => 'meetings',
        ),
        'tasks' => array(
            'module' => 'Tasks',
            'subpanel_name' => 'ForHistory',
            'get_subpanel_data' => 'tasks',
        ),
        'calls' => array(
            'module' => 'Calls',
            'subpanel_name' => 'ForHistory',
            'get_subpanel_data' => 'calls',
        ),
        'emails' => array(
            'module' => 'Emails',
            'subpanel_name' => 'ForHistory',
            'get_subpanel_data' => 'emails',
        ),
	);

?>