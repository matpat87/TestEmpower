<?php
$module_name = 'SAS_SalesActivityStatistics';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'division_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_DIVISION',
        'width' => '10%',
        'name' => 'division_c',
      ),
      'assigned_to' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_ASSIGNED_USER',
        'width' => '10%',
        'name' => 'assigned_to',
      ),
      'department' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_DEPARTMENT',
        'width' => '10%',
        'name' => 'department',
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
      'date_from' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_DATE_FROM',
        'width' => '10%',
        'name' => 'date_from',
      ),
      'date_to' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_DATE_TO',
        'width' => '10%',
        'name' => 'date_to',
      ),
      'status' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
        'name' => 'status',
      ),
    ),
    'advanced_search' => 
    array (
      'division_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_DIVISION',
        'width' => '10%',
        'name' => 'division_c',
      ),
      'assigned_to' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_ASSIGNED_USER',
        'width' => '10%',
        'name' => 'assigned_to',
      ),
      'department' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_DEPARTMENT',
        'width' => '10%',
        'name' => 'department',
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
      'date_from' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_DATE_FROM',
        'width' => '10%',
        'name' => 'date_from',
      ),
      'date_to' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_DATE_TO',
        'width' => '10%',
        'name' => 'date_to',
      ),
      'status' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
        'name' => 'status',
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
