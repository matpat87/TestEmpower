<?php
// created: 2023-10-06 16:51:34
$dictionary["apx_lots_aos_products_quotes_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'apx_lots_aos_products_quotes_1' => 
    array (
      'lhs_module' => 'APX_Lots',
      'lhs_table' => 'apx_lots',
      'lhs_key' => 'id',
      'rhs_module' => 'AOS_Products_Quotes',
      'rhs_table' => 'aos_products_quotes',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'apx_lots_aos_products_quotes_1_c',
      'join_key_lhs' => 'apx_lots_aos_products_quotes_1apx_lots_ida',
      'join_key_rhs' => 'apx_lots_aos_products_quotes_1aos_products_quotes_idb',
    ),
  ),
  'table' => 'apx_lots_aos_products_quotes_1_c',
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
      'name' => 'apx_lots_aos_products_quotes_1apx_lots_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'apx_lots_aos_products_quotes_1aos_products_quotes_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'apx_lots_aos_products_quotes_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'apx_lots_aos_products_quotes_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'apx_lots_aos_products_quotes_1apx_lots_ida',
        1 => 'apx_lots_aos_products_quotes_1aos_products_quotes_idb',
      ),
    ),
  ),
);