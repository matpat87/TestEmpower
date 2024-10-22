<?php
 // created: 2020-05-03 11:11:35
$layout_defs["Users"]["subpanel_setup"]['time_assigned_user'] = array (
  'order' => 100,
  'module' => 'Time',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_USERS_TIME_CREATED_BY_FROM_USERS_TITLE',
  'get_subpanel_data' => 'function:get_user_times',
  'function_parameters' => array(
    'import_function_file' => 'custom/modules/Users/get_user_times.php'
  ),
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
