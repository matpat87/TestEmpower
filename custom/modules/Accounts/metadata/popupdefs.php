<?php
$popupMeta = array (
    'moduleMain' => 'Account',
    'varName' => 'ACCOUNT',
    'orderBy' => 'name',
    'whereClauses' => array (
  'name' => 'accounts.name',
  'billing_address_city' => 'accounts.billing_address_city',
),
    'searchInputs' => array (
  0 => 'name',
  1 => 'billing_address_city',
),
    'create' => array (
  'formBase' => 'AccountFormBase.php',
  'formBaseClass' => 'AccountFormBase',
  'getFormBodyParams' => 
  array (
    0 => '',
    1 => '',
    2 => 'AccountSave',
  ),
  'createButton' => 'LNK_NEW_ACCOUNT',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'billing_address_city' => 
  array (
    'name' => 'billing_address_city',
    'width' => '10%',
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'width' => '40%',
    'label' => 'LBL_LIST_ACCOUNT_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
    'customCode' => '<a href="javascript:void(0)" onclick="send_back(\'Accounts\',\'{$ID}\');">{$NAME}</a>',
  ),
  'ACCOUNT_TYPE' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_TYPE',
    'width' => '10%',
    'default' => true,
    'name' => 'account_type',
  ),
  'BILLING_ADDRESS_CITY' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_CITY',
    'default' => true,
    'name' => 'billing_address_city',
  ),
  'BILLING_ADDRESS_STATE' => 
  array (
    'width' => '7%',
    'label' => 'LBL_STATE',
    'default' => true,
    'name' => 'billing_address_state',
  ),
  'BILLING_ADDRESS_COUNTRY' => 
  array (
    'width' => '10%',
    'label' => 'LBL_COUNTRY',
    'default' => true,
    'name' => 'billing_address_country',
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '2%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'default' => true,
    'name' => 'assigned_user_name',
  ),
  'CUST_NUM_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_CUST_NUM',
    'width' => '10%',
  ),
),
);
