<?php
// created: 2023-06-20 09:16:34
$dictionary["rrq_regulatoryrequests_rrwg_rrworkinggroup_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'rrq_regulatoryrequests_rrwg_rrworkinggroup_1' => 
    array (
      'lhs_module' => 'RRQ_RegulatoryRequests',
      'lhs_table' => 'rrq_regulatoryrequests',
      'lhs_key' => 'id',
      'rhs_module' => 'RRWG_RRWorkingGroup',
      'rhs_table' => 'rrwg_rrworkinggroup',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c',
      'join_key_lhs' => 'rrq_regula2443equests_ida',
      'join_key_rhs' => 'rrq_regulaffdanggroup_idb',
    ),
  ),
  'table' => 'rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c',
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
      'name' => 'rrq_regula2443equests_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'rrq_regulaffdanggroup_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'rrq_regulatoryrequests_rrwg_rrworkinggroup_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'rrq_regulatoryrequests_rrwg_rrworkinggroup_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'rrq_regula2443equests_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'rrq_regulatoryrequests_rrwg_rrworkinggroup_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'rrq_regulaffdanggroup_idb',
      ),
    ),
  ),
);