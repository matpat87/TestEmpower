<?php
 // created: 2019-02-09 10:43:31
$layout_defs["ODR_SalesOrders"]["subpanel_setup"]['odr_salesorders_aos_quotes'] = array (
  'order' => 100,
  'module' => 'AOS_Quotes',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ODR_SALESORDERS_AOS_QUOTES_FROM_AOS_QUOTES_TITLE',
  'get_subpanel_data' => 'odr_salesorders_aos_quotes',
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
