<?php
 // created: 2020-09-09 10:30:10
$layout_defs["VI_VendorIssues"]["subpanel_setup"]['vi_vendorissues_documents'] = array (
  'order' => 100,
  'module' => 'Documents',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_VI_VENDORISSUES_DOCUMENTS_FROM_DOCUMENTS_TITLE',
  'get_subpanel_data' => 'vi_vendorissues_documents',
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
