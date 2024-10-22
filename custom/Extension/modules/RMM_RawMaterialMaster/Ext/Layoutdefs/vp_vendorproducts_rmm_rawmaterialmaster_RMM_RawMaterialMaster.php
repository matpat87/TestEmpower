<?php
 // created: 2020-11-26 08:36:39
$layout_defs["RMM_RawMaterialMaster"]["subpanel_setup"]['vp_vendorproducts_rmm_rawmaterialmaster'] = array (
  'order' => 100,
  'module' => 'VP_VendorProducts',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_VP_VENDORPRODUCTS_RMM_RAWMATERIALMASTER_FROM_VP_VENDORPRODUCTS_TITLE',
  'get_subpanel_data' => 'vp_vendorproducts_rmm_rawmaterialmaster',
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
