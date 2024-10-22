<?php
 // created: 2021-04-08 09:58:11
$layout_defs["PA_PreventiveActions"]["subpanel_setup"]['pa_preventiveactions_calls_1'] = array (
  'order' => 100,
  'module' => 'Calls',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_PA_PREVENTIVEACTIONS_CALLS_1_FROM_CALLS_TITLE',
  'get_subpanel_data' => 'pa_preventiveactions_calls_1',
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
