<?php
 // created: 2020-07-27 08:00:26
$layout_defs["Users"]["subpanel_setup"]['users_projecttask_1'] = array (
  'order' => 100,
  'module' => 'ProjectTask',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_USERS_PROJECTTASK_1_FROM_PROJECTTASK_TITLE',
  'get_subpanel_data' => 'users_projecttask_1',
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
