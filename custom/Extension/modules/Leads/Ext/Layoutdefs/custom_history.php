<?php

	$layout_defs["Leads"]["subpanel_setup"]["history"]["top_buttons"] = array(
	    array('widget_class' => 'SubPanelTopArchiveEmailButton'),
        array('widget_class' => 'SubPanelTopSummaryButton'),
        array('widget_class' => 'SubPanelTopFilterButton'),
	);

	$layout_defs["Leads"]["subpanel_setup"]["history"]["collection_list"] = array(
		'meetings' => array(
            'module' => 'Meetings',
            'subpanel_name' => 'ForHistory',
            'get_subpanel_data' => 'meetings',
        ),
        'oldmeetings' => array(
            'module' => 'Meetings',
            'subpanel_name' => 'ForHistory',
            'get_subpanel_data' => 'function:get_old_related_meetings',
            'generate_select' => true,
            'set_subpanel_data' => 'oldmeetings',
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
        'oldcalls' => array(
            'module' => 'Calls',
            'subpanel_name' => 'ForHistory',
            'get_subpanel_data' => 'function:get_old_related_calls',
            'set_subpanel_data' => 'oldcalls',
            'generate_select' => true,
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