<?php
// created: 2018-07-10 17:04:24
$dictionary["mkt_markets_prospectlists_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'mkt_markets_prospectlists_1' => 
    array (
      'lhs_module' => 'MKT_Markets',
      'lhs_table' => 'mkt_markets',
      'lhs_key' => 'id',
      'rhs_module' => 'ProspectLists',
      'rhs_table' => 'prospect_lists',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'mkt_markets_prospectlists_1_c',
      'join_key_lhs' => 'mkt_markets_prospectlists_1mkt_markets_ida',
      'join_key_rhs' => 'mkt_markets_prospectlists_1prospectlists_idb',
    ),
  ),
  'table' => 'mkt_markets_prospectlists_1_c',
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
      'name' => 'mkt_markets_prospectlists_1mkt_markets_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'mkt_markets_prospectlists_1prospectlists_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'mkt_markets_prospectlists_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'mkt_markets_prospectlists_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'mkt_markets_prospectlists_1mkt_markets_ida',
        1 => 'mkt_markets_prospectlists_1prospectlists_idb',
      ),
    ),
  ),
);