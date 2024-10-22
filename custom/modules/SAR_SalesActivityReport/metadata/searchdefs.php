<?php
$module_name = 'SAR_SalesActivityReport';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'assigned_to_c' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_ASSIGNED_USER',
        'width' => '10%',
        'default' => true,
        'name' => 'assigned_to_c',
      ),
      'assigned_account_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_ASSIGNED_ACCOUNT',
        'width' => '10%',
        'name' => 'assigned_account_c',
      ),
      'activity_type_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_ACTIVITY_TYPE',
        'width' => '10%',
        'name' => 'activity_type_c',
      ),
      'status_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'name' => 'status_c',
      ),
      'related_to_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_RELATED_TO',
        'width' => '20%',
        'name' => 'related_to_c',
      ),
      'sales_group_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_SALES_GROUP',
        'width' => '10%',
        'name' => 'sales_group_c',
      ),
      'date_from_c' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_DATE_FROM',
        'width' => '50%',
        'name' => 'date_from_c',
      ),
      'date_to_c' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_DATE_TO',
        'width' => '50%',
        'name' => 'date_to_c',
      ),
      'highlights_c' => 
      array (
        'type' => 'bool',
        'label' => 'LBL_HIGHLIGHTS',
        'width' => '30%',
        'default' => true,
        'name' => 'highlights_c',
      ),
    ),
    'advanced_search' => 
    array (
      'assigned_to_c' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_ASSIGNED_USER',
        'width' => '10%',
        'default' => true,
        'name' => 'assigned_to_c',
      ),
      'assigned_account_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_ASSIGNED_ACCOUNT',
        'width' => '10%',
        'name' => 'assigned_account_c',
      ),
      'activity_type_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_ACTIVITY_TYPE',
        'width' => '10%',
        'name' => 'activity_type_c',
      ),
      'status_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'name' => 'status_c',
      ),
      'related_to_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_RELATED_TO',
        'width' => '20%',
        'name' => 'related_to_c',
      ),
      'sales_group_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_SALES_GROUP',
        'width' => '10%',
        'name' => 'sales_group_c',
      ),
      'date_from_c' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_DATE_FROM',
        'width' => '50%',
        'name' => 'date_from_c',
      ),
      'date_to_c' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_DATE_TO',
        'width' => '50%',
        'name' => 'date_to_c',
      ),
      'highlights_c' => 
      array (
        'type' => 'bool',
        'label' => 'LBL_HIGHLIGHTS',
        'width' => '30%',
        'default' => true,
        'name' => 'highlights_c',
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
