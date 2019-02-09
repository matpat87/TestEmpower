<?php
$popupMeta = array (
    'moduleMain' => 'ODR_SalesOrders',
    'varName' => 'ODR_SalesOrders',
    'orderBy' => 'odr_salesorders.name',
    'whereClauses' => array (
  'name' => 'odr_salesorders.name',
  'billing_contact' => 'odr_salesorders.billing_contact',
  'billing_account' => 'odr_salesorders.billing_account',
  'number' => 'odr_salesorders.number',
  'total_amount' => 'odr_salesorders.total_amount',
  'due_date' => 'odr_salesorders.due_date',
  'status' => 'odr_salesorders.status',
  'assigned_user_id' => 'odr_salesorders.assigned_user_id',
),
    'searchInputs' => array (
  1 => 'name',
  3 => 'status',
  4 => 'billing_contact',
  5 => 'billing_account',
  6 => 'number',
  7 => 'total_amount',
  8 => 'due_date',
  9 => 'assigned_user_id',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'billing_contact' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_BILLING_CONTACT',
    'id' => 'CONTACT_ID_C',
    'link' => true,
    'width' => '10%',
    'name' => 'billing_contact',
  ),
  'billing_account' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_BILLING_ACCOUNT',
    'id' => 'ACCOUNT_ID_C',
    'link' => true,
    'width' => '10%',
    'name' => 'billing_account',
  ),
  'number' => 
  array (
    'type' => 'int',
    'label' => 'LBL_NUMBER',
    'width' => '10%',
    'name' => 'number',
  ),
  'total_amount' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_TOTAL_AMOUNT',
    'currency_format' => true,
    'width' => '10%',
    'name' => 'total_amount',
  ),
  'due_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_DUE_DATE',
    'width' => '10%',
    'name' => 'due_date',
  ),
  'status' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'name' => 'status',
  ),
  'assigned_user_id' => 
  array (
    'name' => 'assigned_user_id',
    'label' => 'LBL_ASSIGNED_TO',
    'type' => 'enum',
    'function' => 
    array (
      'name' => 'get_user_array',
      'params' => 
      array (
        0 => false,
      ),
    ),
    'width' => '10%',
  ),
),
);
