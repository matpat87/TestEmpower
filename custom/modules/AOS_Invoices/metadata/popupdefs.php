<?php
$popupMeta = array (
  'moduleMain' => 'AOS_Invoices',
  'varName' => 'AOS_Invoices',
  'orderBy' => 'aos_invoices.name',
  'whereClauses' => array (
    'billing_account' => 'aos_invoices.billing_account',
    'number' => 'aos_invoices.number',
  ),
  'searchInputs' => array (
    4 => 'account_name_nondb',
    5 => 'number',
    6 => 'customer_product_number_nondb',
  ),
  'searchdefs' => array (
    'account_name_nondb' => 
    array (
      'name' => 'account_name_nondb',
      'width' => '10%', 
    ),
    'number' => 
    array (
      'name' => 'number',
      'width' => '10%',
    ),
    'customer_product_number_nondb' => 
    array (
      'name' => 'customer_product_number_nondb',
      'width' => '10%',
    ),
  ),
);
