<?php
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
