<?php
 // created: 2023-01-27 10:40:52
$layout_defs["RD_RegulatoryDocuments"]["subpanel_setup"]['rd_regulatorydocuments_aos_products_1'] = array (
  'order' => 100,
  'module' => 'AOS_Products',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_RD_REGULATORYDOCUMENTS_AOS_PRODUCTS_1_FROM_AOS_PRODUCTS_TITLE',
  'get_subpanel_data' => 'rd_regulatorydocuments_aos_products_1',
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
