<?php
$listViewDefs ['AOS_Products'] = 
array (
  'PART_NUMBER' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PART_NUMBER',
    'default' => true,
    'link' => true,
  ),
  'NAME' => 
  array (
    'width' => '15%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => false,
  ),
  'STATUS_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
  ),
  'AOS_PRODUCT_CATEGORY_NAME' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_AOS_PRODUCT_CATEGORYS_NAME',
    'id' => 'AOS_PRODUCT_CATEGORY_ID',
    'link' => true,
    'width' => '10%',
    'default' => true,
    'related_fields' => 
    array (
      0 => 'aos_product_category_id',
    ),
  ),
  'COST' => 
  array (
    'width' => '10%',
    'label' => 'LBL_COST',
    'currency_format' => true,
    'default' => true,
  ),
  'PRICE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PRICE',
    'currency_format' => true,
    'default' => true,
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
    'width' => '10%',
    'label' => 'LBL_CREATED',
    'default' => true,
    'module' => 'Users',
    'link' => true,
    'id' => 'CREATED_BY',
  ),
  'DATE_ENTERED' => 
  array (
    'width' => '5%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => true,
  ),
);
;
?>
