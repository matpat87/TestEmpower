<?php
// created: 2019-11-01 11:28:22
$dictionary["tr_technicalrequests_dsbtn_distributionitems_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'tr_technicalrequests_dsbtn_distributionitems_1' => 
    array (
      'lhs_module' => 'TR_TechnicalRequests',
      'lhs_table' => 'tr_technicalrequests',
      'lhs_key' => 'id',
      'rhs_module' => 'DSBTN_DistributionItems',
      'rhs_table' => 'dsbtn_distributionitems',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'tr_technicalrequests_dsbtn_distributionitems_1_c',
      'join_key_lhs' => 'tr_technic76a9equests_ida',
      'join_key_rhs' => 'tr_technic2a06onitems_idb',
    ),
  ),
  'table' => 'tr_technicalrequests_dsbtn_distributionitems_1_c',
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
      'name' => 'tr_technic76a9equests_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'tr_technic2a06onitems_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'tr_technicalrequests_dsbtn_distributionitems_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'tr_technicalrequests_dsbtn_distributionitems_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'tr_technic76a9equests_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'tr_technicalrequests_dsbtn_distributionitems_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'tr_technic2a06onitems_idb',
      ),
    ),
  ),
);