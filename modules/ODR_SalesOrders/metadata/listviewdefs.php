<?php
$module_name = 'ODR_SalesOrders';
$listViewDefs [$module_name] = 
array (
  'NUMBER' => 
  array (
    'type' => 'int',
    'label' => 'LBL_NUMBER',
    'width' => '5%',
    'default' => true,
  ),
  'NAME' => 
  array (
    'width' => '15%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'STATUS' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'BILLING_CONTACT' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_BILLING_CONTACT',
    'id' => 'CONTACT_ID_C',
    'link' => true,
    'width' => '11%',
    'default' => true,
  ),
  'BILLING_ACCOUNT' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_BILLING_ACCOUNT',
    'id' => 'ACCOUNT_ID_C',
    'link' => true,
    'width' => '15%',
    'default' => true,
  ),
  'TOTAL_AMOUNT' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_TOTAL_AMOUNT',
    'currency_format' => true,
    'width' => '10%',
    'default' => true,
  ),
  'DUE_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_DUE_DATE',
    'width' => '10%',
    'default' => true,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '10%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '5%',
    'default' => true,
  ),
  'BILLING_ADDRESS_STREET' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_BILLING_ADDRESS_STREET',
    'width' => '10%',
    'default' => false,
  ),
  'BILLING_ADDRESS_CITY' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_BILLING_ADDRESS_CITY',
    'width' => '10%',
    'default' => false,
  ),
  'BILLING_ADDRESS_STATE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_BILLING_ADDRESS_STATE',
    'width' => '10%',
    'default' => false,
  ),
  'BILLING_ADDRESS_POSTALCODE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_BILLING_ADDRESS_POSTALCODE',
    'width' => '10%',
    'default' => false,
  ),
  'BILLING_ADDRESS_COUNTRY' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
    'width' => '10%',
    'default' => false,
  ),
  'SHIPPING_ADDRESS_CITY' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SHIPPING_ADDRESS_CITY',
    'width' => '10%',
    'default' => false,
  ),
  'SHIPPING_ADDRESS_STREET' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SHIPPING_ADDRESS_STREET',
    'width' => '10%',
    'default' => false,
  ),
  'SHIPPING_ADDRESS_POSTALCODE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
    'width' => '10%',
    'default' => false,
  ),
  'SHIPPING_ADDRESS_COUNTRY' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
    'width' => '10%',
    'default' => false,
  ),
);
;
?>
