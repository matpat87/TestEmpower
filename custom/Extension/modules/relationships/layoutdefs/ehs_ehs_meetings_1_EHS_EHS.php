<?php
 // created: 2018-07-03 16:51:31
$layout_defs["EHS_EHS"]["subpanel_setup"]['ehs_ehs_meetings_1'] = array (
  'order' => 100,
  'module' => 'Meetings',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_EHS_EHS_MEETINGS_1_FROM_MEETINGS_TITLE',
  'get_subpanel_data' => 'ehs_ehs_meetings_1',
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
