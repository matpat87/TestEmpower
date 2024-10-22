<?php
// created: 2020-12-12 07:57:52
$dictionary["securitygroups_vp_vendorproducts_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'securitygroups_vp_vendorproducts_1' => 
    array (
      'lhs_module' => 'SecurityGroups',
      'lhs_table' => 'securitygroups',
      'lhs_key' => 'id',
      'rhs_module' => 'VP_VendorProducts',
      'rhs_table' => 'vp_vendorproducts',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'securitygroups_vp_vendorproducts_1_c',
      'join_key_lhs' => 'securitygroups_vp_vendorproducts_1securitygroups_ida',
      'join_key_rhs' => 'securitygroups_vp_vendorproducts_1vp_vendorproducts_idb',
    ),
  ),
  'table' => 'securitygroups_vp_vendorproducts_1_c',
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
      'name' => 'securitygroups_vp_vendorproducts_1securitygroups_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'securitygroups_vp_vendorproducts_1vp_vendorproducts_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'securitygroups_vp_vendorproducts_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'securitygroups_vp_vendorproducts_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'securitygroups_vp_vendorproducts_1securitygroups_ida',
        1 => 'securitygroups_vp_vendorproducts_1vp_vendorproducts_idb',
      ),
    ),
  ),
);