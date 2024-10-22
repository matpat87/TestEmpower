<?php
$layout_defs["SecurityGroups"]["subpanel_setup"]['securitygroups_trwg_trworkinggroup'] = array (
  'order' => 100,
  'module' => 'TRWG_TRWorkingGroup',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SECURITYGROUPS_TRWG_TR_WORKING_GROUP_TITLE',
  'get_subpanel_data' => 'securitygroups_trwg_trworkinggroup',
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
