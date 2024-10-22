<?php
$popupMeta = array (
    'moduleMain' => 'CI_CustomerItems',
    'varName' => 'CI_CustomerItems',
    'orderBy' => 'ci_customeritems.name',
    'whereClauses' => array (
  'name' => 'ci_customeritems.name',
  'product_number_c' => 'ci_customeritems_cstm.product_number_c',
  'account_name_nondb' => 'ci_customeritems.account_name_nondb',
),
    'searchInputs' => array (
  1 => 'name',
  9 => 'product_number_c',
  13 => 'account_name_nondb',
),
    'searchdefs' => array (
  'account_name_nondb' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CI_CUSTOMERITEMS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
    'width' => '10%',
    'name' => 'account_name_nondb',
  ),
  'product_number_c' => 
  array (
    'type' => 'varchar',
    'studio' => 'visible',
    'label' => 'LBL_PRODUCT_NUMBER',
    'width' => '10%',
    'name' => 'product_number_c',
  ),
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
),
    'listviewdefs' => array (
  'PRODUCT_NUMBER_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_PRODUCT_NUMBER',
    'width' => '10%',
    'link' => true,
    'module' => NULL,
    'name' => 'product_number_c',
  ),
  'VERSION_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_VERSION',
    'width' => '10%',
    'name' => 'version_c',
  ),
  'CI_NAME_NON_DB' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_NAME',
    'width' => '10%',
    'default' => true,
    'name' => 'ci_name_non_db',
  ),
  'PRODUCT_MASTER_NON_DB' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_PRODUCT_MASTER_NON_DB',
    'width' => '10%',
    'default' => true,
    'name' => 'product_master_non_db',
  ),
  'STATUS' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'default' => true,
    'name' => 'status',
  ),
  'PRICE' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_PRICE',
    'currency_format' => true,
    'width' => '10%',
    'default' => true,
    'name' => 'price',
  ),
  'CI_CUSTOMERITEMS_ACCOUNTS_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CI_CUSTOMERITEMS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
    'id' => 'CI_CUSTOMERITEMS_ACCOUNTSACCOUNTS_IDA',
    'width' => '10%',
    'default' => true,
    'name' => 'ci_customeritems_accounts_name',
  ),
),
);
