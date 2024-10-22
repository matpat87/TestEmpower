<?php
// created: 2023-08-24 08:32:41
$dictionary["odr_salesorders_documents_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'odr_salesorders_documents_1' => 
    array (
      'lhs_module' => 'ODR_SalesOrders',
      'lhs_table' => 'odr_salesorders',
      'lhs_key' => 'id',
      'rhs_module' => 'Documents',
      'rhs_table' => 'documents',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'odr_salesorders_documents_1_c',
      'join_key_lhs' => 'odr_salesorders_documents_1odr_salesorders_ida',
      'join_key_rhs' => 'odr_salesorders_documents_1documents_idb',
    ),
  ),
  'table' => 'odr_salesorders_documents_1_c',
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
      'name' => 'odr_salesorders_documents_1odr_salesorders_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'odr_salesorders_documents_1documents_idb',
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
      'name' => 'odr_salesorders_documents_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'odr_salesorders_documents_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'odr_salesorders_documents_1odr_salesorders_ida',
        1 => 'odr_salesorders_documents_1documents_idb',
      ),
    ),
  ),
);