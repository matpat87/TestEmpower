<?php
// created: 2018-07-10 16:56:01
$dictionary["mkt_markets_leads_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'mkt_markets_leads_1' => 
    array (
      'lhs_module' => 'MKT_Markets',
      'lhs_table' => 'mkt_markets',
      'lhs_key' => 'id',
      'rhs_module' => 'Leads',
      'rhs_table' => 'leads',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'mkt_markets_leads_1_c',
      'join_key_lhs' => 'mkt_markets_leads_1mkt_markets_ida',
      'join_key_rhs' => 'mkt_markets_leads_1leads_idb',
    ),
  ),
  'table' => 'mkt_markets_leads_1_c',
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
      'name' => 'mkt_markets_leads_1mkt_markets_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'mkt_markets_leads_1leads_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'mkt_markets_leads_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'mkt_markets_leads_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'mkt_markets_leads_1mkt_markets_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'mkt_markets_leads_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'mkt_markets_leads_1leads_idb',
      ),
    ),
  ),
);