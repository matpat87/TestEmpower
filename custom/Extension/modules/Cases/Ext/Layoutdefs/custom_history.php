<?php

	$layout_defs["Cases"]["subpanel_setup"]["history"]["top_buttons"] = array(
	    array('widget_class' => 'SubPanelTopArchiveEmailButton'),
        array('widget_class' => 'SubPanelTopSummaryButton'),
        array('widget_class' => 'SubPanelTopFilterButton'),
	);

	$layout_defs["Cases"]["subpanel_setup"]["history"]["collection_list"] = array(
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
            'subpanel_name' => 'ForUnlinkedEmailHistory',
            'get_subpanel_data' => 'function:get_emails_by_assign_or_link',
            'function_parameters' => array('import_function_file' => 'include/utils.php', 'link' => 'contacts'),
            'generate_select' => true,
        ),
	);

?>