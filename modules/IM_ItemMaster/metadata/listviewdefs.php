<?php
$module_name = 'IM_ItemMaster';
$listViewDefs [$module_name] = 
array (
  'PART_NUMBER' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_PART_NUMBER',
    'link' => true,
    'width' => '10%',
    'default' => true,
  ),
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => false,
  ),
  'STATUS' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'IM_ITEMMASTER_AOS_PRODUCT_CATEGORIES_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_IM_ITEMMASTER_AOS_PRODUCT_CATEGORIES_FROM_AOS_PRODUCT_CATEGORIES_TITLE',
    'id' => 'IM_ITEMMASTER_AOS_PRODUCT_CATEGORIESAOS_PRODUCT_CATEGORIES_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'COST' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_COST',
    'currency_format' => true,
    'width' => '10%',
    'default' => true,
  ),
  'PRICE' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_PRICE',
    'currency_format' => true,
    'width' => '10%',
    'default' => true,
  ),
  'UNIT_MEASURE' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_UNIT_MEASURE',
    'width' => '10%',
    'default' => true,
  ),
  'WEIGHT' => 
  array (
    'type' => 'decimal',
    'default' => true,
    'label' => 'LBL_WEIGHT',
    'width' => '10%',
  ),
  'WEIGHT_PER_GAL' => 
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
);
;
?>
