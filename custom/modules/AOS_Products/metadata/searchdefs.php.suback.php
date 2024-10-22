<?php
$module_name = 'AOS_Products';
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
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'product_number_c' => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_PRODUCT_NUMBER',
        'width' => '10%',
        'name' => 'product_number_c',
      ),
      'related_product_number_non_db_c' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_RELATED_PRODUCT',
        'sortable' => false,
        'width' => '10%',
        'default' => true,
        'name' => 'related_product_number_non_db_c',
      ),
      'cost' => 
      array (
        'name' => 'cost',
        'default' => true,
        'width' => '10%',
      ),
      'price' => 
      array (
        'name' => 'price',
        'default' => true,
        'width' => '10%',
      ),
      'category' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_CATEGORY',
        'width' => '10%',
        'default' => true,
        'name' => 'category',
      ),
      'due_date_c' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_DUE_DATE',
        'width' => '10%',
        'name' => 'due_date_c',
      ),
      'assigned_user_id' => 
      array (
        'name' => 'assigned_user_id',
        'type' => 'enum',
        'label' => 'LBL_ASSIGNED_TO',
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
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
;
?>
