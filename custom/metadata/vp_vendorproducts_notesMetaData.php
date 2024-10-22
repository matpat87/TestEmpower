<?php
// created: 2020-11-26 08:36:39
$dictionary["vp_vendorproducts_notes"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'vp_vendorproducts_notes' => 
    array (
      'lhs_module' => 'VP_VendorProducts',
      'lhs_table' => 'vp_vendorproducts',
      'lhs_key' => 'id',
      'rhs_module' => 'Notes',
      'rhs_table' => 'notes',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'vp_vendorproducts_notes_c',
      'join_key_lhs' => 'vp_vendorproducts_notesvp_vendorproducts_ida',
      'join_key_rhs' => 'vp_vendorproducts_notesnotes_idb',
    ),
  ),
  'table' => 'vp_vendorproducts_notes_c',
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
      'name' => 'vp_vendorproducts_notesvp_vendorproducts_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'vp_vendorproducts_notesnotes_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'vp_vendorproducts_notesspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'vp_vendorproducts_notes_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'vp_vendorproducts_notesvp_vendorproducts_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'vp_vendorproducts_notes_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'vp_vendorproducts_notesnotes_idb',
      ),
    ),
  ),
);