<?php
$module_name = 'APR_AccountProfileReport';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'apr_account_name_nondb' => 
      array (
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_NAME',
        'id' => 'ACCOUNT_ID_C',
        'link' => true,
        'width' => '10%',
        'default' => true,
        'name' => 'apr_account_name_nondb',
      ),
      'customer_number' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_CUSTOMER_NUMBER',
        'width' => '10%',
        'default' => true,
        'name' => 'customer_number',
      ),
      'account_status' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_ACCOUNT_STATUS',
        'width' => '10%',
        'name' => 'account_status',
      ),
      'account_type' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_ACCOUNT_TYPE',
        'width' => '10%',
        'name' => 'account_type',
      ),
      'date_entered' => 
      array (
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => true,
        'name' => 'date_entered',
      ),
    ),
    'advanced_search' => 
    array (
      'apr_account_name_nondb' => 
      array (
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_NAME',
        'id' => 'ACCOUNT_ID_C',
        'link' => true,
        'width' => '10%',
        'default' => true,
        'name' => 'apr_account_name_nondb',
      ),
      'customer_number' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_CUSTOMER_NUMBER',
        'width' => '10%',
        'default' => true,
        'name' => 'customer_number',
      ),
      'account_status' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_ACCOUNT_STATUS',
        'width' => '10%',
        'name' => 'account_status',
      ),
      'account_type' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_ACCOUNT_TYPE',
        'width' => '10%',
        'name' => 'account_type',
      ),
      'date_entered' => 
      array (
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => true,
        'name' => 'date_entered',
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
