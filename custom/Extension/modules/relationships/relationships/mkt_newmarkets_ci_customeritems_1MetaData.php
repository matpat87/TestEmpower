<?php
// created: 2021-05-04 10:41:29
$dictionary["mkt_newmarkets_ci_customeritems_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'mkt_newmarkets_ci_customeritems_1' => 
    array (
      'lhs_module' => 'MKT_NewMarkets',
      'lhs_table' => 'mkt_newmarkets',
      'lhs_key' => 'id',
      'rhs_module' => 'CI_CustomerItems',
      'rhs_table' => 'ci_customeritems',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'mkt_newmarkets_ci_customeritems_1_c',
      'join_key_lhs' => 'mkt_newmarkets_ci_customeritems_1mkt_newmarkets_ida',
      'join_key_rhs' => 'mkt_newmarkets_ci_customeritems_1ci_customeritems_idb',
    ),
  ),
  'table' => 'mkt_newmarkets_ci_customeritems_1_c',
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
      'name' => 'mkt_newmarkets_ci_customeritems_1mkt_newmarkets_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'mkt_newmarkets_ci_customeritems_1ci_customeritems_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'mkt_newmarkets_ci_customeritems_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'mkt_newmarkets_ci_customeritems_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'mkt_newmarkets_ci_customeritems_1mkt_newmarkets_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'mkt_newmarkets_ci_customeritems_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'mkt_newmarkets_ci_customeritems_1ci_customeritems_idb',
      ),
    ),
  ),
);