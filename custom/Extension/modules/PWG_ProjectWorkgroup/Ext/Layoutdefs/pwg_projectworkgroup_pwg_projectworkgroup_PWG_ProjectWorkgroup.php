<?php
 // created: 2020-09-24 06:50:52
$layout_defs["PWG_ProjectWorkgroup"]["subpanel_setup"]['pwg_projeccf54rkgroup_ida'] = array (
  'order' => 100,
  'module' => 'PWG_ProjectWorkgroup',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_PWG_PROJECTWORKGROUP_PWG_PROJECTWORKGROUP_FROM_PWG_PROJECTWORKGROUP_R_TITLE',
  'get_subpanel_data' => 'function:retrieveProjectWorkgroupSubpanelData',
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
