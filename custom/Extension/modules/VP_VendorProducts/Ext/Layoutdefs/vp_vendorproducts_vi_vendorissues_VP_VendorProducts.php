<?php
 // created: 2020-11-26 08:36:39
$layout_defs["VP_VendorProducts"]["subpanel_setup"]['vp_vendorproducts_vi_vendorissues'] = array (
  'order' => 100,
  'module' => 'VI_VendorIssues',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_VP_VENDORPRODUCTS_VI_VENDORISSUES_FROM_VI_VENDORISSUES_TITLE',
  'get_subpanel_data' => 'vp_vendorproducts_vi_vendorissues',
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
