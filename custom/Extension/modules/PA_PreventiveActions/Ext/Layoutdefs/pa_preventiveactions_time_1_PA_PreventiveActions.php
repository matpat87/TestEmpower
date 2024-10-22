<?php
 // created: 2021-04-08 10:02:28
$layout_defs["PA_PreventiveActions"]["subpanel_setup"]['pa_preventiveactions_time_1'] = array (
  'order' => 100,
  'module' => 'Time',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_PA_PREVENTIVEACTIONS_TIME_1_FROM_TIME_TITLE',
  'get_subpanel_data' => 'pa_preventiveactions_time_1',
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
