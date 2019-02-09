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
  'number' => 
  array (
    'type' => 'int',
    'label' => 'LBL_NUMBER',
    'width' => '5%',
    'default' => true,
  ),
  'name' => 
  array (
    'width' => '20%',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'status' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '15%',
    'default' => true,
  ),
  'total_amount' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_TOTAL_AMOUNT',
    'currency_format' => true,
    'width' => '15%',
    'default' => true,
  ),
  'due_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_DUE_DATE',
    'width' => '15%',
    'default' => true,
  ),
  'billing_account' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_BILLING_ACCOUNT',
    'id' => 'ACCOUNT_ID_C',
    'link' => true,
    'width' => '20%',
    'default' => false,
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
  ),
  'invoice_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_INVOICE_DATE',
    'width' => '15%',
    'default' => false,
  ),
  'date_entered' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => false,
    'name' => 'date_entered',
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
  'assigned_user_name' => 
  array (
    'width' => '8%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'name' => 'assigned_user_name',
    'default' => false,
  ),
);
