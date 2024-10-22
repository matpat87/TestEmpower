<?php
// created: 2018-07-10 17:00:46
$dictionary["mkt_markets_documents_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'mkt_markets_documents_1' => 
    array (
      'lhs_module' => 'MKT_Markets',
      'lhs_table' => 'mkt_markets',
      'lhs_key' => 'id',
      'rhs_module' => 'Documents',
      'rhs_table' => 'documents',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'mkt_markets_documents_1_c',
      'join_key_lhs' => 'mkt_markets_documents_1mkt_markets_ida',
      'join_key_rhs' => 'mkt_markets_documents_1documents_idb',
    ),
  ),
  'table' => 'mkt_markets_documents_1_c',
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
      'name' => 'mkt_markets_documents_1mkt_markets_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'mkt_markets_documents_1documents_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
    5 => 
    array (
      'name' => 'document_revision_id',
      'type' => 'varchar',
      'len' => '36',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'mkt_markets_documents_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'mkt_markets_documents_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'mkt_markets_documents_1mkt_markets_ida',
        1 => 'mkt_markets_documents_1documents_idb',
      ),
    ),
  ),
);