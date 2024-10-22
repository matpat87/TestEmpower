<?php
$layout_defs["SecurityGroups"]["subpanel_setup"]['securitygroups_rrwg_rrworkinggroup'] = array (
  'order' => 100,
  'module' => 'RRWG_RRWorkingGroup',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SECURITYGROUPS_RRWG_RR_WORKING_GROUP_TITLE',
  'get_subpanel_data' => 'securitygroups_rrwg_rrworkinggroup',
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
