<?php
$dashletData['ODR_SalesOrdersDashlet']['searchFields'] = array (
  'date_entered' => 
  array (
    'default' => '',
  ),
  'date_modified' => 
  array (
    'default' => '',
  ),
  'assigned_user_id' => 
  array (
    'type' => 'assigned_user_name',
    'default' => 'Ralph Siasat',
  ),
);
$dashletData['ODR_SalesOrdersDashlet']['columns'] = array (
  'accounts_odr_salesorders_1_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_ACCOUNTS_ODR_SALESORDERS_1_FROM_ACCOUNTS_TITLE',
    'id' => 'ACCOUNTS_ODR_SALESORDERS_1ACCOUNTS_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'number' => 
  array (
    'type' => 'int',
    'label' => 'LBL_NUMBER',
    'width' => '5%',
    'default' => true,
    'name' => 'number',
  ),
  'custom_item_name' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ITEM_NAME',
    'width' => '10%',
    'default' => true,
    'name' => 'custom_item_name',
  ),
  'custom_product_qty' => 
  array (
    'type' => 'decimal',
    'label' => 'LBL_PRODUCT_QTY',
    'width' => '10%',
    'default' => true,
    'name' => 'custom_product_qty',
  ),
  'total_amount' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_TOTAL_AMOUNT',
    'currency_format' => true,
    'width' => '15%',
    'default' => true,
    'name' => 'total_amount',
  ),
  'billing_contact' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_BILLING_CONTACT',
    'id' => 'CONTACT_ID_C',
    'link' => true,
    'width' => '15%',
    'default' => false,
    'name' => 'billing_contact',
  ),
  'invoice_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_INVOICE_DATE',
    'width' => '15%',
    'default' => false,
    'name' => 'invoice_date',
  ),
  'date_entered' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => false,
    'name' => 'date_entered',
  ),
  'name' => 
  array (
    'width' => '20%',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'default' => false,
    'name' => 'name',
  ),
  'status' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '15%',
    'default' => false,
    'name' => 'status',
  ),
  'date_modified' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_MODIFIED',
    'name' => 'date_modified',
    'default' => false,
  ),
  'created_by' => 
  array (
    'width' => '8%',
    'label' => 'LBL_CREATED',
    'name' => 'created_by',
    'default' => false,
  ),
  'due_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_DUE_DATE',
    'width' => '15%',
    'default' => false,
    'name' => 'due_date',
  ),
  'assigned_user_name' => 
  array (
    'width' => '8%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'name' => 'assigned_user_name',
    'default' => false,
  ),
);
