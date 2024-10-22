<?php
 // created: 2020-09-08 08:27:05
$layout_defs["Documents"]["subpanel_setup"]['vend_vendors_documents_1'] = array (
  'order' => 100,
  'module' => 'VEND_Vendors',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_VEND_VENDORS_DOCUMENTS_1_FROM_VEND_VENDORS_TITLE',
  'get_subpanel_data' => 'vend_vendors_documents_1',
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
