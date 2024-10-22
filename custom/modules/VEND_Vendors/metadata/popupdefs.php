<?php
$popupMeta = array (
    'moduleMain' => 'VEND_Vendors',
    'varName' => 'VEND_Vendors',
    'orderBy' => 'vend_vendors.name',
    'whereClauses' => array (
  'name' => 'vend_vendors.name',
  'vendor_number_c' => 'vend_vendors_cstm.vendor_number_c',
  'address_city' => 'vend_vendors.address_city',
  'address_state' => 'vend_vendors.address_state',
  'address_postalcode' => 'vend_vendors.address_postalcode',
  'address_country' => 'vend_vendors.address_country',
),
    'searchInputs' => array (
  0 => 'name',
  4 => 'vendor_number_c',
  5 => 'address_city',
  6 => 'address_state',
  7 => 'address_postalcode',
  8 => 'address_country',
),
    'searchdefs' => array (
  'vendor_number_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_VENDOR_NUMBER',
    'width' => '10%',
    'name' => 'vendor_number_c',
  ),
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'address_city' => 
  array (
    'name' => 'address_city',
    'label' => 'LBL_CITY',
    'type' => 'name',
    'width' => '10%',
  ),
  'address_state' => 
  array (
    'name' => 'address_state',
    'label' => 'LBL_STATE',
    'type' => 'name',
    'width' => '10%',
  ),
  'address_postalcode' => 
  array (
    'name' => 'address_postalcode',
    'label' => 'LBL_POSTAL_CODE',
    'type' => 'name',
    'width' => '10%',
  ),
  'address_country' => 
  array (
    'name' => 'address_country',
    'label' => 'LBL_COUNTRY',
    'type' => 'name',
    'width' => '10%',
  ),
),
    'listviewdefs' => array (
  'VENDOR_NUMBER_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_VENDOR_NUMBER',
    'width' => '10%',
    'name' => 'vendor_number_c',
  ),
  'NAME' => 
  array (
    'width' => '40%',
    'label' => 'LBL_ACCOUNT_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'BILLING_ADDRESS_CITY' => 
  array (
    'width' => '10%',
    'label' => 'LBL_CITY',
    'default' => true,
    'name' => 'billing_address_city',
  ),
  'BILLING_ADDRESS_STATE' => 
  array (
    'width' => '7%',
    'label' => 'LBL_BILLING_ADDRESS_STATE',
    'name' => 'billing_address_state',
    'default' => true,
  ),
  'BILLING_ADDRESS_POSTALCODE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_BILLING_ADDRESS_POSTALCODE',
    'name' => 'billing_address_postalcode',
    'default' => true,
  ),
  'BILLING_ADDRESS_COUNTRY' => 
  array (
    'width' => '10%',
    'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
    'name' => 'billing_address_country',
    'default' => true,
  ),
),
);
