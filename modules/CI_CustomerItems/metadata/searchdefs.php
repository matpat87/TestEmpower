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
      'status' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
        'name' => 'status',
      ),
      'division' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_DIVISION',
        'width' => '10%',
        'default' => true,
        'name' => 'division',
      ),
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'part_number' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_PART_NUMBER',
        'width' => '10%',
        'default' => true,
        'name' => 'part_number',
      ),
      'type' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_TYPE',
        'width' => '10%',
        'default' => true,
        'name' => 'type',
      ),
      'ci_customeritems_opportunities_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_CI_CUSTOMERITEMS_OPPORTUNITIES_FROM_OPPORTUNITIES_TITLE',
        'id' => 'CI_CUSTOMERITEMS_OPPORTUNITIESOPPORTUNITIES_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'ci_customeritems_opportunities_name',
      ),
      'ci_customeritems_project_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_CI_CUSTOMERITEMS_PROJECT_FROM_PROJECT_TITLE',
        'id' => 'CI_CUSTOMERITEMS_PROJECTPROJECT_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'ci_customeritems_project_name',
      ),
      'cost' => 
      array (
        'type' => 'currency',
        'label' => 'LBL_COST',
        'currency_format' => true,
        'width' => '10%',
        'default' => true,
        'name' => 'cost',
      ),
      'price' => 
      array (
        'type' => 'currency',
        'label' => 'LBL_PRICE',
        'currency_format' => true,
        'width' => '10%',
        'default' => true,
        'name' => 'price',
      ),
      'ci_customeritems_aos_product_categories_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_CI_CUSTOMERITEMS_AOS_PRODUCT_CATEGORIES_FROM_AOS_PRODUCT_CATEGORIES_TITLE',
        'id' => 'CI_CUSTOME38BEEGORIES_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'ci_customeritems_aos_product_categories_name',
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
      'created_by' => 
      array (
        'type' => 'assigned_user_name',
        'label' => 'LBL_CREATED',
        'width' => '10%',
        'default' => true,
        'name' => 'created_by',
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
