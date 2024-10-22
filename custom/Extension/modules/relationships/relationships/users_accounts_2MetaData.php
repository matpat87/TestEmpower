<?php
// created: 2019-11-28 06:55:56
$dictionary["users_accounts_2"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'users_accounts_2' => 
    array (
      'lhs_module' => 'Users',
      'lhs_table' => 'users',
      'lhs_key' => 'id',
      'rhs_module' => 'Accounts',
      'rhs_table' => 'accounts',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'users_accounts_2_c',
      'join_key_lhs' => 'users_accounts_2users_ida',
      'join_key_rhs' => 'users_accounts_2accounts_idb',
    ),
  ),
  'table' => 'users_accounts_2_c',
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
      'name' => 'users_accounts_2users_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'users_accounts_2accounts_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'users_accounts_2spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'users_accounts_2_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'users_accounts_2users_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'users_accounts_2_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'users_accounts_2accounts_idb',
      ),
    ),
  ),
);