<?php

	$layout_defs["Contacts"]["subpanel_setup"]["history"]["top_buttons"] = array(
	    array('widget_class' => 'SubPanelTopArchiveEmailButton'),
        array('widget_class' => 'SubPanelTopSummaryButton'),
        array('widget_class' => 'SubPanelTopFilterButton'),
	);

    $layout_defs["Contacts"]["subpanel_setup"]["history"]["collection_list"] = array(
        'tasks' => array(
            'module' => 'Tasks',
            'subpanel_name' => 'ForHistory',
            'get_subpanel_data' => 'tasks',
        ),
        'tasks_parent' => array(
            'module' => 'Tasks',
            'subpanel_name' => 'ForHistory',
            'get_subpanel_data' => 'tasks_parent',
        ),
        'meetings' => array(
            'module' => 'Meetings',
            'subpanel_name' => 'ForHistory',
            'get_subpanel_data' => 'meetings',
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
        'linkedemails' => array(
            'module' => 'Emails',
            'subpanel_name' => 'ForUnlinkedEmailHistory',
            'get_subpanel_data' => 'function:get_unlinked_email_query',
            'generate_select' => true,
            'function_parameters' => array('return_as_array' => 'true'),
        ),
    );

?>