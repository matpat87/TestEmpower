<?php
 // created: 2021-03-17 12:52:08
$layout_defs["AOS_Products"]["subpanel_setup"]['aos_products_odr_salesorders_1'] = array (
  'order' => 100,
  'module' => 'ODR_SalesOrders',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_AOS_PRODUCTS_ODR_SALESORDERS_1_FROM_ODR_SALESORDERS_TITLE',
  'get_subpanel_data' => 'aos_products_odr_salesorders_1',
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
