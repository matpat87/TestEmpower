<?php
// created: 2021-05-26 13:49:39
$subpanel_layout['list_fields'] = array (
  'number' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_NUMBER',
    'width' => '10%',
    'default' => true,
  ),
  'po_number_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'vname' => 'LBL_PO_NUMBER',
    'width' => '10%',
  ),
  'order_date_c' => 
  array (
    'type' => 'date',
    'default' => true,
    'vname' => 'LBL_ORDER_DATE',
    'width' => '10%',
  ),
  'status' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'vname' => 'LBL_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'order_type_c' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_ORDER_TYPE',
    'width' => '10%',
  ),
//-- did not include the account because it already belongs to that account
//   'accounts_ord_salesorders_1_name' => 
//   array (
//     'type' => 'relate',
//     'link' => true,
//     'vname' => 'LBL_ACCOUNTS_ODR_SALESORDERS_1_FROM_ACCOUNTS_TITLE',
//     'id' => 'ACCOUNTS_ODR_SALESORDERS_1ACCOUNTS_IDA',
//     'width' => '10%',
//     'default' => true,
//   ), 
    'site_c' => 
    array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'vname' => 'LBL_SITE',
        'width' => '10%',
    ),
    'custom_item_number' => 
    array (
        'type' => 'varchar',
        'vname' => 'LBL_ITEM_NUMBER',
        'width' => '10%',
        'default' => true,
    ),
    'custom_item_name' => 
    array (
      'type' => 'varchar',
      'vname' => 'LBL_ITEM_NAME',
      'width' => '10%',
      'default' => true,
    ),
    'custom_product_qty' => 
    array (
        'type' => 'decimal',
        'vname' => 'LBL_PRODUCT_QTY',
        'width' => '10%',
        'default' => true,
    ),
    'custom_unit_price' => 
    array (
        'type' => 'decimal',
        'vname' => 'LBL_UNIT_PRICE',
        'width' => '10%',
        'default' => true,
    ),
    'custom_req_ship_date' => 
    array (
        'type' => 'date',
        'vname' => 'LBL_REQ_SHIP_DATE',
        'width' => '10%',
        'default' => true,
    ),
    'custom_promised_date' => 
    array (
        'type' => 'date',
        'vname' => 'LBL_PROMISED_DATE',
        'width' => '10%',
        'default' => true,
    ),
    'edit_button' => 
    array (
        'vname' => 'LBL_EDIT_BUTTON',
        'widget_class' => 'SubPanelEditButton',
        'module' => 'ODR_SalesOrders',
        'width' => '4%',
        'default' => true,
    ),
    'remove_button' => 
    array (
        'vname' => 'LBL_REMOVE',
        'widget_class' => 'SubPanelRemoveButton',
        'module' => 'ODR_SalesOrders',
        'width' => '5%',
        'default' => true,
    ),
);