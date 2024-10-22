<?php
$module_name = 'CI_CustomerItems';
$listViewDefs [$module_name] = 
array (
  'PRODUCT_NUMBER_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_PRODUCT_NUMBER',
    'width' => '10%',
    'link' => true,
    'module' => 'CI_CustomerItems',
  ),
  'VERSION_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_VERSION',
    'width' => '10%',
  ),
  'NAME' => 
  array (
    'width' => '15%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => false,
  ),
  'PRODUCT_MASTER_NON_DB' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_PRODUCT_MASTER_NON_DB',
    'width' => '10%',
    'default' => true,
  ),
  'CI_CUSTOMERITEMS_ACCOUNTS_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CI_CUSTOMERITEMS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
    'id' => 'CI_CUSTOMERITEMS_ACCOUNTSACCOUNTS_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'OEM_ACCOUNT_C' => 
  array (
    'type' => 'relate',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_OEM_ACCOUNT',
    'id' => 'ACCOUNT_ID_C',
    'link' => true,
    'width' => '10%',
  ),
  'APPLICATION_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_APPLICATION',
    'width' => '10%',
  ),
  'MKT_NEWMARKETS_CI_CUSTOMERITEMS_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_MKT_NEWMARKETS_CI_CUSTOMERITEMS_1_FROM_MKT_NEWMARKETS_TITLE',
    'id' => 'MKT_NEWMARKETS_CI_CUSTOMERITEMS_1MKT_NEWMARKETS_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'INDUSTRY_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_INDUSTRY',
    'width' => '10%',
  ),
  'SUB_INDUSTRY_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_SUB_INDUSTRY',
    'width' => '10%',
  ),
  'SALES_PYTD_C' => 
  array (
    'type' => 'currency',
    'default' => true,
    'label' => 'LBL_SALES_PYTD',
    'currency_format' => true,
    'width' => '10%',
  ),
  'SALES_CYTD_C' => 
  array (
    'type' => 'currency',
    'default' => true,
    'label' => 'LBL_SALES_CYTD',
    'currency_format' => true,
    'width' => '10%',
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '5%',
    'default' => true,
  ),
);
;
?>
