<?php
// created: 2018-07-03 16:43:44
$dictionary["ehs_ehs_documents_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'ehs_ehs_documents_1' => 
    array (
      'lhs_module' => 'EHS_EHS',
      'lhs_table' => 'ehs_ehs',
      'lhs_key' => 'id',
      'rhs_module' => 'Documents',
      'rhs_table' => 'documents',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'ehs_ehs_documents_1_c',
      'join_key_lhs' => 'ehs_ehs_documents_1ehs_ehs_ida',
      'join_key_rhs' => 'ehs_ehs_documents_1documents_idb',
    ),
  ),
  'table' => 'ehs_ehs_documents_1_c',
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
      'name' => 'ehs_ehs_documents_1ehs_ehs_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'ehs_ehs_documents_1documents_idb',
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
      'name' => 'ehs_ehs_documents_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'ehs_ehs_documents_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'ehs_ehs_documents_1ehs_ehs_ida',
        1 => 'ehs_ehs_documents_1documents_idb',
      ),
    ),
  ),
);