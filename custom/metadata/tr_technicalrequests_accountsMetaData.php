<?php
// created: 2019-02-11 17:33:48
$dictionary["tr_technicalrequests_accounts"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'tr_technicalrequests_accounts' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => 'TR_TechnicalRequests',
      'rhs_table' => 'tr_technicalrequests',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'tr_technicalrequests_accounts_c',
      'join_key_lhs' => 'tr_technicalrequests_accountsaccounts_ida',
      'join_key_rhs' => 'tr_technicalrequests_accountstr_technicalrequests_idb',
    ),
  ),
  'table' => 'tr_technicalrequests_accounts_c',
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
      'name' => 'tr_technicalrequests_accountsaccounts_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'tr_technicalrequests_accountstr_technicalrequests_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'tr_technicalrequests_accountsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'tr_technicalrequests_accounts_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'tr_technicalrequests_accountsaccounts_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'tr_technicalrequests_accounts_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'tr_technicalrequests_accountstr_technicalrequests_idb',
      ),
    ),
  ),
);