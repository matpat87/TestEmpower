<?php

	$layout_defs["Project"]["subpanel_setup"]["activities"]["top_buttons"] = array(
	    array('widget_class' => 'SubPanelTopCreateTaskButton'),
        array('widget_class' => 'SubPanelTopScheduleMeetingButton'),
        array('widget_class' => 'SubPanelTopScheduleCallButton')
	);

	unset($layout_defs['Project']['subpanel_setup']['accounts']);
?>