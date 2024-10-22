<?php
 // created: 2018-08-11 09:36:18
$layout_defs["Project"]["subpanel_setup"]['project_pwg_projectworkgroup'] = array (
  'order' => 100,
  'module' => 'PWG_ProjectWorkgroup',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_PROJECT_WORKGROUP_SUBPANEL_TITLE',
  'get_subpanel_data' => 'pwg_projectworkgroup',
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
