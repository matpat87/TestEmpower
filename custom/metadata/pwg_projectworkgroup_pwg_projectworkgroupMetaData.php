<?php
// created: 2020-09-24 06:50:52
$dictionary["pwg_projectworkgroup_pwg_projectworkgroup"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'pwg_projectworkgroup_pwg_projectworkgroup' => 
    array (
      'lhs_module' => 'PWG_ProjectWorkgroup',
      'lhs_table' => 'pwg_projectworkgroup',
      'lhs_key' => 'id',
      'rhs_module' => 'PWG_ProjectWorkgroup',
      'rhs_table' => 'pwg_projectworkgroup',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'pwg_projectworkgroup_pwg_projectworkgroup_c',
      'join_key_lhs' => 'pwg_projeccf54rkgroup_ida',
      'join_key_rhs' => 'pwg_projec8acdrkgroup_idb',
    ),
  ),
  'table' => 'pwg_projectworkgroup_pwg_projectworkgroup_c',
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
      'name' => 'pwg_projeccf54rkgroup_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'pwg_projec8acdrkgroup_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'pwg_projectworkgroup_pwg_projectworkgroupspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'pwg_projectworkgroup_pwg_projectworkgroup_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'pwg_projeccf54rkgroup_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'pwg_projectworkgroup_pwg_projectworkgroup_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'pwg_projec8acdrkgroup_idb',
      ),
    ),
  ),
);