<?php
 // created: 2020-12-04 15:53:46
$layout_defs["SecurityGroups"]["subpanel_setup"]['securitygroups_rmm_rawmaterialmaster'] = array (
  'order' => 100,
  'module' => 'RMM_RawMaterialMaster',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SECURITYGROUPS_RMM_RAWMATERIALMASTER_FROM_DOCUMENTS_TITLE',
  'get_subpanel_data' => 'securitygroups_rmm_rawmaterialmaster',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
