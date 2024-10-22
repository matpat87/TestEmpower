<?php
// created: 2021-11-19 10:00:49
$dictionary["comp_competitor_accounts"] = array (
  'true_relationship_type' => 'many-to-many',
  'relationships' => 
  array (
    'comp_competitor_accounts' => 
    array (
      'lhs_module' => 'COMP_Competitor',
      'lhs_table' => 'comp_competitor',
      'lhs_key' => 'id',
      'rhs_module' => 'Accounts',
      'rhs_table' => 'accounts',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'comp_competitor_accounts_c',
      'join_key_lhs' => 'comp_competitor_accountscomp_competitor_ida',
      'join_key_rhs' => 'comp_competitor_accountsaccounts_idb',
    ),
  ),
  'table' => 'comp_competitor_accounts_c',
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
      'name' => 'comp_competitor_accountscomp_competitor_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'comp_competitor_accountsaccounts_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'comp_competitor_accountsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'comp_competitor_accounts_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'comp_competitor_accountscomp_competitor_ida',
        1 => 'comp_competitor_accountsaccounts_idb',
      ),
    ),
  ),
);