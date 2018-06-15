<?php 
 //WARNING: The contents of this file are auto-generated


 // created: 2014-08-18 12:21:23
$layout_defs["asol_Process"]["subpanel_setup"]['asol_process_asol_activity'] = array (
  'order' => 100,
  'module' => 'asol_Activity',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ASOL_PROCESS_ASOL_ACTIVITY_FROM_ASOL_ACTIVITY_TITLE',
  'get_subpanel_data' => 'asol_process_asol_activity',
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


 // created: 2014-08-18 12:21:23
$layout_defs["asol_Process"]["subpanel_setup"]['asol_process_asol_events_1'] = array (
  'order' => 100,
  'module' => 'asol_Events',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ASOL_PROCESS_ASOL_EVENTS_1_FROM_ASOL_EVENTS_TITLE',
  'get_subpanel_data' => 'asol_process_asol_events_1',
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



$index = (isset($_REQUEST['record'])) ? $_REQUEST['record'] : "";

$layout_defs["asol_Process"]["subpanel_setup"]["asol_process_asol_events2"] = array (
  'order' => 100,
  'module' => 'asol_Events',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ASOL_PROCESS_ASOL_EVENTS_FROM_ASOL_EVENTS_TITLE',
  'get_subpanel_data' => 'asol_process_asol_events',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonAsolCreateEvent',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect&parent_module=asol_Process&parent_id='.$index,
    ),
  ),
);



 // created: 2014-08-18 12:21:23
$layout_defs["asol_Process"]["subpanel_setup"]['asol_process_asol_task'] = array (
  'order' => 100,
  'module' => 'asol_Task',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ASOL_PROCESS_ASOL_TASK_FROM_ASOL_TASK_TITLE',
  'get_subpanel_data' => 'asol_process_asol_task',
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

?>