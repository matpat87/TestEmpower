<?php
$module_name = 'IM_ItemMaster';
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
      'part_number' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_PART_NUMBER',
        'width' => '10%',
        'default' => true,
        'name' => 'part_number',
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
      'im_itemmaster_aos_product_categories_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_IM_ITEMMASTER_AOS_PRODUCT_CATEGORIES_FROM_AOS_PRODUCT_CATEGORIES_TITLE',
        'id' => 'IM_ITEMMASTER_AOS_PRODUCT_CATEGORIESAOS_PRODUCT_CATEGORIES_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'im_itemmaster_aos_product_categories_name',
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
