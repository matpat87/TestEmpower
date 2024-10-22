<?php
 // created: 2023-08-24 08:32:41
$layout_defs["Documents"]["subpanel_setup"]['odr_salesorders_documents_1'] = array (
  'order' => 100,
  'module' => 'ODR_SalesOrders',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ODR_SALESORDERS_DOCUMENTS_1_FROM_ODR_SALESORDERS_TITLE',
  'get_subpanel_data' => 'odr_salesorders_documents_1',
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
