<?php
 // created: 2020-11-26 08:36:39
$layout_defs["VP_VendorProducts"]["subpanel_setup"]['vp_vendorproducts_vend_vendors'] = array (
  'order' => 100,
  'module' => 'VEND_Vendors',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_VP_VENDORPRODUCTS_VEND_VENDORS_FROM_VEND_VENDORS_TITLE',
  'get_subpanel_data' => 'vp_vendorproducts_vend_vendors',
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

unset($layout_defs["VP_VendorProducts"]["subpanel_setup"]['vp_vendorproducts_vend_vendors']);