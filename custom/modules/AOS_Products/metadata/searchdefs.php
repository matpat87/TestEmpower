<?php
// created: 2023-03-30 08:57:28
$searchdefs['AOS_Products'] = array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      0 => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      1 => 
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
      0 => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      1 => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_PRODUCT_NUMBER',
        'width' => '10%',
        'name' => 'product_number_c',
      ),
      2 => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_RELATED_PRODUCT',
        'sortable' => false,
        'width' => '10%',
        'default' => true,
        'name' => 'related_product_number_non_db_c',
      ),
      3 => 
      array (
        'name' => 'cost',
        'default' => true,
        'width' => '10%',
      ),
      4 => 
      array (
        'name' => 'price',
        'default' => true,
        'width' => '10%',
      ),
      5 => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_CATEGORY',
        'width' => '10%',
        'default' => true,
        'name' => 'category',
      ),
      6 => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_DUE_DATE',
        'width' => '10%',
        'name' => 'due_date_c',
      ),
      7 => 
      array (
        'type' => 'enum',
        'label' => 'LBL_ASSIGNED_TO',
        'id' => 'ASSIGNED_USER_ID',
        'link' => true,
        'name' => 'assigned_user_id',
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
    'maxColumnsBasic' => '3',
  ),
);