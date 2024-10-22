<?php
// created: 2020-10-20 06:51:36
$dictionary["so_savingopportunities_notes"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'so_savingopportunities_notes' => 
    array (
      'lhs_module' => 'SO_SavingOpportunities',
      'lhs_table' => 'so_savingopportunities',
      'lhs_key' => 'id',
      'rhs_module' => 'Notes',
      'rhs_table' => 'notes',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'so_savingopportunities_notes_c',
      'join_key_lhs' => 'so_savingopportunities_notesso_savingopportunities_ida',
      'join_key_rhs' => 'so_savingopportunities_notesnotes_idb',
    ),
  ),
  'table' => 'so_savingopportunities_notes_c',
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
      'name' => 'so_savingopportunities_notesso_savingopportunities_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'so_savingopportunities_notesnotes_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'so_savingopportunities_notesspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'so_savingopportunities_notes_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'so_savingopportunities_notesso_savingopportunities_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'so_savingopportunities_notes_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'so_savingopportunities_notesnotes_idb',
      ),
    ),
  ),
);