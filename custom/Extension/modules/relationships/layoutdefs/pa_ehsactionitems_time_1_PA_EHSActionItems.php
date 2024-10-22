<?php
 // created: 2021-06-30 13:45:41
$layout_defs["PA_EHSActionItems"]["subpanel_setup"]['pa_ehsactionitems_time_1'] = array (
  'order' => 100,
  'module' => 'Time',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_PA_EHSACTIONITEMS_TIME_1_FROM_TIME_TITLE',
  'get_subpanel_data' => 'pa_ehsactionitems_time_1',
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
