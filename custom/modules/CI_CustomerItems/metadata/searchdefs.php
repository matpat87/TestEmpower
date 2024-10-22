<?php
$module_name = 'CI_CustomerItems';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'current_user_only' => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
    ),
    'advanced_search' => 
    array (
      'product_master_non_db' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_PRODUCT_MASTER_NON_DB',
        'width' => '10%',
        'default' => true,
        'name' => 'product_master_non_db',
      ),
      'product_number_c' => 
      array (
        'type' => 'varchar',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_PRODUCT_NUMBER',
        'width' => '10%',
        'name' => 'product_number_c',
      ),
      'version_c' => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_VERSION',
        'width' => '10%',
        'name' => 'version_c',
      ),
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'related_product_c' => 
      array (
        'type' => 'relate',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_RELATED_PRODUCT',
        'id' => 'CI_CUSTOMERITEMS_ID_C',
        'link' => true,
        'width' => '10%',
        'name' => 'related_product_c',
      ),
      'status' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
        'name' => 'status',
      ),
      'application_c' => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_APPLICATION',
        'width' => '10%',
        'name' => 'application_c',
      ),
      'ci_customeritems_accounts_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_CI_CUSTOMERITEMS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
        'id' => 'CI_CUSTOMERITEMS_ACCOUNTSACCOUNTS_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'ci_customeritems_accounts_name',
      ),
      'oem_account_c' => 
      array (
        'type' => 'relate',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_OEM_ACCOUNT',
        'id' => 'ACCOUNT_ID_C',
        'link' => true,
        'width' => '10%',
        'name' => 'oem_account_c',
      ),
      'mkt_newmarkets_ci_customeritems_1_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_MKT_NEWMARKETS_CI_CUSTOMERITEMS_1_FROM_MKT_NEWMARKETS_TITLE',
        'id' => 'MKT_NEWMARKETS_CI_CUSTOMERITEMS_1MKT_NEWMARKETS_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'mkt_newmarkets_ci_customeritems_1_name',
      ),
      'industry_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_INDUSTRY',
        'width' => '10%',
        'name' => 'industry_c',
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'maxColumnsBasic' => '4',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
;
?>
