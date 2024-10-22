<?php
// created: 2021-08-15 13:43:48
$dictionary["contacts_chl_challenges_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'contacts_chl_challenges_1' => 
    array (
      'lhs_module' => 'Contacts',
      'lhs_table' => 'contacts',
      'lhs_key' => 'id',
      'rhs_module' => 'CHL_Challenges',
      'rhs_table' => 'chl_challenges',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'contacts_chl_challenges_1_c',
      'join_key_lhs' => 'contacts_chl_challenges_1contacts_ida',
      'join_key_rhs' => 'contacts_chl_challenges_1chl_challenges_idb',
    ),
  ),
  'table' => 'contacts_chl_challenges_1_c',
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
      'name' => 'contacts_chl_challenges_1contacts_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'contacts_chl_challenges_1chl_challenges_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'contacts_chl_challenges_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'contacts_chl_challenges_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'contacts_chl_challenges_1contacts_ida',
        1 => 'contacts_chl_challenges_1chl_challenges_idb',
      ),
    ),
  ),
);