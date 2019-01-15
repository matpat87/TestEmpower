<?php
// created: 2019-01-14 16:45:34
$dictionary["im_itemmaster_aos_product_categories"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'im_itemmaster_aos_product_categories' => 
    array (
      'lhs_module' => 'AOS_Product_Categories',
      'lhs_table' => 'aos_product_categories',
      'lhs_key' => 'id',
      'rhs_module' => 'IM_ItemMaster',
      'rhs_table' => 'im_itemmaster',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'im_itemmaster_aos_product_categories_c',
      'join_key_lhs' => 'im_itemmaster_aos_product_categoriesaos_product_categories_ida',
      'join_key_rhs' => 'im_itemmaster_aos_product_categoriesim_itemmaster_idb',
    ),
  ),
  'table' => 'im_itemmaster_aos_product_categories_c',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'im_itemmaster_aos_product_categoriesaos_product_categories_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'im_itemmaster_aos_product_categoriesim_itemmaster_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'im_itemmaster_aos_product_categoriesspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'im_itemmaster_aos_product_categories_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'im_itemmaster_aos_product_categoriesaos_product_categories_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'im_itemmaster_aos_product_categories_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'im_itemmaster_aos_product_categoriesim_itemmaster_idb',
      ),
    ),
  ),
);