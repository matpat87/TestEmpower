<?php
 // created: 2021-01-24 06:42:41
$layout_defs["Contacts"]["subpanel_setup"]['contacts_odr_salesorders_1'] = array (
  'order' => 100,
  'module' => 'ODR_SalesOrders',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_CONTACTS_ODR_SALESORDERS_1_FROM_ODR_SALESORDERS_TITLE',
  'get_subpanel_data' => 'contacts_odr_salesorders_1',
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
