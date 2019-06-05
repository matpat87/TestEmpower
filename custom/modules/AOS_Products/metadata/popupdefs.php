<?php
$popupMeta = array (
    'moduleMain' => 'AOS_Products',
    'varName' => 'AOS_Products',
    'orderBy' => 'aos_products.name',
    'whereClauses' => array (
  'name' => 'aos_products.name',
  'part_number' => 'aos_products.part_number',
  'cost' => 'aos_products.cost',
  'price' => 'aos_products.price',
  'created_by' => 'aos_products.created_by',
  'division_c' => 'aos_products_cstm.division_c',
  'category' => 'aos_products.category',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'part_number',
  5 => 'cost',
  6 => 'price',
  7 => 'created_by',
  8 => 'division_c',
  9 => 'category',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'part_number' => 
  array (
    'name' => 'part_number',
    'width' => '10%',
  ),
  'division_c' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_DIVISION',
    'width' => '10%',
    'name' => 'division_c',
  ),
  'cost' => 
  array (
    'name' => 'cost',
    'width' => '10%',
  ),
  'price' => 
  array (
    'name' => 'price',
    'width' => '10%',
  ),
  'category' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_CATEGORY',
    'width' => '10%',
    'name' => 'category',
  ),
  'created_by' => 
  array (
    'name' => 'created_by',
    'label' => 'LBL_CREATED',
    'type' => 'enum',
    'function' => 
    array (
      'name' => 'get_user_array',
      'params' => 
      array (
        0 => false,
      ),
    ),
    'width' => '10%',
  ),
),
    'listviewdefs' => array (
  'PART_NUMBER' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PART_NUMBER',
    'default' => true,
    'name' => 'part_number',
  ),
  'NAME' => 
  array (
    'width' => '25%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
    'name' => 'name',
  ),
  'STATUS_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
  ),
  'CATEGORY' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_CATEGORY',
    'width' => '10%',
    'default' => true,
  ),
  'COST' => 
  array (
    'width' => '10%',
    'label' => 'LBL_COST',
    'default' => true,
    'name' => 'cost',
  ),
  'PRICE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PRICE',
    'default' => true,
    'name' => 'price',
  ),
  'UNIT_MEASURE_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_UNIT_MEASURE',
    'width' => '10%',
  ),
  'WEIGHT_C' => 
  array (
    'type' => 'decimal',
    'default' => true,
    'label' => 'LBL_WEIGHT',
    'width' => '10%',
  ),
  'WEIGHT_PER_GAL_C' => 
  array (
    'type' => 'decimal',
    'default' => true,
    'label' => 'LBL_WEIGHT_PER_GAL',
    'width' => '10%',
  ),
  'CREATED_BY_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'default' => true,
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
  ),
),
);
