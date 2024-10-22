<?php
 // created: 2020-12-12 07:57:52
$layout_defs["SecurityGroups"]["subpanel_setup"]['securitygroups_vp_vendorproducts_1'] = array (
  'order' => 100,
  'module' => 'VP_VendorProducts',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SECURITYGROUPS_VP_VENDORPRODUCTS_1_FROM_VP_VENDORPRODUCTS_TITLE',
  'get_subpanel_data' => 'securitygroups_vp_vendorproducts_1',
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
