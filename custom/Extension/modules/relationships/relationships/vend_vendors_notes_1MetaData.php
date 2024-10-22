<?php
// created: 2020-09-08 08:10:24
$dictionary["vend_vendors_notes_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'vend_vendors_notes_1' => 
    array (
      'lhs_module' => 'VEND_Vendors',
      'lhs_table' => 'vend_vendors',
      'lhs_key' => 'id',
      'rhs_module' => 'Notes',
      'rhs_table' => 'notes',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'vend_vendors_notes_1_c',
      'join_key_lhs' => 'vend_vendors_notes_1vend_vendors_ida',
      'join_key_rhs' => 'vend_vendors_notes_1notes_idb',
    ),
  ),
  'table' => 'vend_vendors_notes_1_c',
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
      'name' => 'vend_vendors_notes_1vend_vendors_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'vend_vendors_notes_1notes_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'vend_vendors_notes_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'vend_vendors_notes_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'vend_vendors_notes_1vend_vendors_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'vend_vendors_notes_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'vend_vendors_notes_1notes_idb',
      ),
    ),
  ),
);