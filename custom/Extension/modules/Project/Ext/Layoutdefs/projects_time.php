<?php
 // created: 2018-08-11 09:36:18
$layout_defs["Project"]["subpanel_setup"]['project_time'] = array (
  'order' => 100,
  'module' => 'Time',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_TIME_SUBPANEL_TITLE',
  'get_subpanel_data' => 'times',
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
