<?php
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
