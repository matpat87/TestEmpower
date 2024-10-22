<?php
$module_name = 'ODR_SalesOrders';
$listViewDefs [$module_name] = 
array (
  'CUSTOM_ADDITIONAL_INFO' => 
  array (
    'type' => 'html',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_ADDITIONAL_INFO',
    'sortable' => false,
    'width' => '10%',
  ),
  'NUMBER' => 
  array (
    'type' => 'int',
    'label' => 'LBL_NUMBER',
    'width' => '5%',
    'default' => true,
    'link' => true,
  ),
  'ORDER_TYPE_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_ORDER_TYPE',
    'width' => '10%',
  ),
  'ACCOUNTS_ODR_SALESORDERS_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_ACCOUNTS_ODR_SALESORDERS_1_FROM_ACCOUNTS_TITLE',
    'id' => 'ACCOUNTS_ODR_SALESORDERS_1ACCOUNTS_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'SITE_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_SITE',
    'width' => '10%',
  ),
  'CUSTOM_ITEM_NUMBER' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ITEM_NUMBER',
    'width' => '10%',
    'default' => true,
  ),
  'CUSTOM_ITEM_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ITEM_NAME',
    'width' => '10%',
    'default' => true,
  ),
  'CUSTOM_PRODUCT_QTY' => 
  array (
    'type' => 'decimal',
    'label' => 'LBL_PRODUCT_QTY',
    'width' => '10%',
    'default' => true,
  ),
  'CUSTOM_UNIT_PRICE' => 
  array (
    'type' => 'decimal',
    'label' => 'LBL_UNIT_PRICE',
    'width' => '10%',
    'default' => true,
  ),
  'CUSTOM_REQUESTED_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_CUSTOM_REQUESTED_DATE',
    'width' => '10%',
    'default' => true,
  ),
  'CUSTOM_REQ_SHIP_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_REQ_SHIP_DATE',
    'width' => '10%',
    'default' => true,
  ),
  'CUSTOM_PROMISED_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_PROMISED_DATE',
    'width' => '10%',
    'default' => true,
  ),
  'CUSTOM_ORDER_LINE_STATUS' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ORDER_LINE_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'ORDER_DATE_C' => 
  array (
    'type' => 'date',
    'label' => 'LBL_ORDER_DATE',
    'width' => '10%',
    'default' => true,
  ),
  'CUSTOM_CUST_NUM' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CUST_NUM',
    'width' => '10%',
    'default' => true,
  ),
  'PO_NUMBER_C' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_PO_NUMBER',
    'width' => '10%',
    'default' => true,
  ),
);
;
?>
