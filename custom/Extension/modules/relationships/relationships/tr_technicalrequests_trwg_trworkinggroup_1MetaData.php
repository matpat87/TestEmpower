<?php
// created: 2021-05-27 05:56:40
$dictionary["tr_technicalrequests_trwg_trworkinggroup_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'tr_technicalrequests_trwg_trworkinggroup_1' => 
    array (
      'lhs_module' => 'TR_TechnicalRequests',
      'lhs_table' => 'tr_technicalrequests',
      'lhs_key' => 'id',
      'rhs_module' => 'TRWG_TRWorkingGroup',
      'rhs_table' => 'trwg_trworkinggroup',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'tr_technicalrequests_trwg_trworkinggroup_1_c',
      'join_key_lhs' => 'tr_technic9742equests_ida',
      'join_key_rhs' => 'tr_technic7dfcnggroup_idb',
    ),
  ),
  'table' => 'tr_technicalrequests_trwg_trworkinggroup_1_c',
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
      'name' => 'tr_technic9742equests_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'tr_technic7dfcnggroup_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'tr_technicalrequests_trwg_trworkinggroup_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'tr_technicalrequests_trwg_trworkinggroup_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'tr_technic9742equests_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'tr_technicalrequests_trwg_trworkinggroup_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'tr_technic7dfcnggroup_idb',
      ),
    ),
  ),
);