<?php
 // created: 2021-01-24 06:32:52
$layout_defs["Accounts"]["subpanel_setup"]['accounts_odr_salesorders_1'] = array (
  'order' => 100,
  'module' => 'ODR_SalesOrders',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ACCOUNTS_ODR_SALESORDERS_1_FROM_ODR_SALESORDERS_TITLE',
  'get_subpanel_data' => 'accounts_odr_salesorders_1',
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
