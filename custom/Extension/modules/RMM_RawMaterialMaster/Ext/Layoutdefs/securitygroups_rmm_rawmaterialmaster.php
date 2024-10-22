<?php
 // created: 2019-10-14 13:17:27
$layout_defs["RMM_RawMaterialMaster"]["subpanel_setup"]['securitygroups_rmm_rawmaterialmaster'] = array (
  'order' => 100,
  'module' => 'SecurityGroups',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SECURITY_GROUPS_RMM_RAWMATERIALMASTER_TITLE',
  'get_subpanel_data' => 'SecurityGroups',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
