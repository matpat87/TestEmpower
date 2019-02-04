<?php
// created: 2019-02-04 16:24:24
$dictionary["ci_customeritems_aos_product_categories"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'ci_customeritems_aos_product_categories' => 
    array (
      'lhs_module' => 'AOS_Product_Categories',
      'lhs_table' => 'aos_product_categories',
      'lhs_key' => 'id',
      'rhs_module' => 'CI_CustomerItems',
      'rhs_table' => 'ci_customeritems',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'ci_customeritems_aos_product_categories_c',
      'join_key_lhs' => 'ci_custome38beegories_ida',
      'join_key_rhs' => 'ci_customeritems_aos_product_categoriesci_customeritems_idb',
    ),
  ),
  'table' => 'ci_customeritems_aos_product_categories_c',
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
      'name' => 'ci_custome38beegories_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'ci_customeritems_aos_product_categoriesci_customeritems_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'ci_customeritems_aos_product_categoriesspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'ci_customeritems_aos_product_categories_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'ci_custome38beegories_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'ci_customeritems_aos_product_categories_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'ci_customeritems_aos_product_categoriesci_customeritems_idb',
      ),
    ),
  ),
);