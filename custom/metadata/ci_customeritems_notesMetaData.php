<?php
// created: 2019-02-04 16:24:24
$dictionary["ci_customeritems_notes"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'ci_customeritems_notes' => 
    array (
      'lhs_module' => 'CI_CustomerItems',
      'lhs_table' => 'ci_customeritems',
      'lhs_key' => 'id',
      'rhs_module' => 'Notes',
      'rhs_table' => 'notes',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'ci_customeritems_notes_c',
      'join_key_lhs' => 'ci_customeritems_notesci_customeritems_ida',
      'join_key_rhs' => 'ci_customeritems_notesnotes_idb',
    ),
  ),
  'table' => 'ci_customeritems_notes_c',
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
      'name' => 'ci_customeritems_notesci_customeritems_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'ci_customeritems_notesnotes_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'ci_customeritems_notesspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'ci_customeritems_notes_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'ci_customeritems_notesci_customeritems_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'ci_customeritems_notes_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'ci_customeritems_notesnotes_idb',
      ),
    ),
  ),
);