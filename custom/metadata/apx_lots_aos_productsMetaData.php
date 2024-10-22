<?php
// created: 2023-08-31 16:58:52
$dictionary["apx_lots_aos_products"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'apx_lots_aos_products' => 
    array (
      'lhs_module' => 'AOS_Products',
      'lhs_table' => 'aos_products',
      'lhs_key' => 'id',
      'rhs_module' => 'APX_Lots',
      'rhs_table' => 'apx_lots',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'apx_lots_aos_products_c',
      'join_key_lhs' => 'apx_lots_aos_productsaos_products_ida',
      'join_key_rhs' => 'apx_lots_aos_productsapx_lots_idb',
    ),
  ),
  'table' => 'apx_lots_aos_products_c',
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
      'name' => 'apx_lots_aos_productsaos_products_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'apx_lots_aos_productsapx_lots_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'apx_lots_aos_productsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'apx_lots_aos_products_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'apx_lots_aos_productsaos_products_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'apx_lots_aos_products_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'apx_lots_aos_productsapx_lots_idb',
      ),
    ),
  ),
);