<?php
 // created: 2020-11-26 08:36:39
$layout_defs["VP_VendorProducts"]["subpanel_setup"]['vp_vendorproducts_notes'] = array (
  'order' => 100,
  'module' => 'Notes',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_VP_VENDORPRODUCTS_NOTES_FROM_NOTES_TITLE',
  'get_subpanel_data' => 'vp_vendorproducts_notes',
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