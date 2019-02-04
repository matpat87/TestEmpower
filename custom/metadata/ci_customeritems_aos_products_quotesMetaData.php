<?php
// created: 2019-02-04 16:24:24
$dictionary["ci_customeritems_aos_products_quotes"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'ci_customeritems_aos_products_quotes' => 
    array (
      'lhs_module' => 'CI_CustomerItems',
      'lhs_table' => 'ci_customeritems',
      'lhs_key' => 'id',
      'rhs_module' => 'AOS_Products_Quotes',
      'rhs_table' => 'aos_products_quotes',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'ci_customeritems_aos_products_quotes_c',
      'join_key_lhs' => 'ci_customeritems_aos_products_quotesci_customeritems_ida',
      'join_key_rhs' => 'ci_customeritems_aos_products_quotesaos_products_quotes_idb',
    ),
  ),
  'table' => 'ci_customeritems_aos_products_quotes_c',
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
      'name' => 'ci_customeritems_aos_products_quotesci_customeritems_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'ci_customeritems_aos_products_quotesaos_products_quotes_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'ci_customeritems_aos_products_quotesspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'ci_customeritems_aos_products_quotes_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'ci_customeritems_aos_products_quotesci_customeritems_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'ci_customeritems_aos_products_quotes_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'ci_customeritems_aos_products_quotesaos_products_quotes_idb',
      ),
    ),
  ),
);