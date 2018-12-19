<?php
	$layout_defs["Opportunities"]["subpanel_setup"]['custom_notes_history'] = array (
		'order' => 20,
        'sort_order' => 'desc',
        'sort_by' => 'date_entered',
        'title_key' => 'LBL_CUSTOM_NOTES_HISTORY_SUBPANEL_TITLE',
        'type' => 'collection',
        'subpanel_name' => 'custom_notes_history',   //this values is not associated with a physical file.
        'module' => 'Notes',

        'top_buttons' => array(
            array('widget_class' => 'SubPanelTopCreateNoteButton'),
        ),

        'collection_list' => array(
            'notes' => array(
                'module' => 'Notes',
                'subpanel_name' => 'ForHistory',
                'get_subpanel_data' => 'notes',
            ),
        ),
	);

?>