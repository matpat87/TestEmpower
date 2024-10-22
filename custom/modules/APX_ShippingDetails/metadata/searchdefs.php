<?php
$module_name = 'APX_ShippingDetails';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      0 => 'name',
      1 => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
      ),
    ),
    'advanced_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'delivered_date' => 
      array (
        'type' => 'date',
        'label' => 'LBL_DELIVERED_DATE',
        'width' => '10%',
        'default' => true,
        'name' => 'delivered_date',
      ),
      'ship_tracker' => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_SHIP_TRACKER',
        'width' => '10%',
        'name' => 'ship_tracker',
      ),
      'pl_line_number' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_PL_LINE_NUMBER',
        'width' => '10%',
        'default' => true,
        'name' => 'pl_line_number',
      ),
      'assigned_user_id' => 
      array (
        'name' => 'assigned_user_id',
        'label' => 'LBL_ASSIGNED_TO',
        'type' => 'enum',
        'function' => 
        array (
          'name' => 'get_user_array',
          'params' => 
          array (
            0 => false,
          ),
        ),
        'default' => true,
        'width' => '10%',
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
