<?php
// created: 2020-11-26 08:36:39
$dictionary["vp_vendorproducts_rmm_rawmaterialmaster"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'vp_vendorproducts_rmm_rawmaterialmaster' => 
    array (
      'lhs_module' => 'RMM_RawMaterialMaster',
      'lhs_table' => 'rmm_rawmaterialmaster',
      'lhs_key' => 'id',
      'rhs_module' => 'VP_VendorProducts',
      'rhs_table' => 'vp_vendorproducts',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'vp_vendorproducts_rmm_rawmaterialmaster_c',
      'join_key_lhs' => 'vp_vendorproducts_rmm_rawmaterialmasterrmm_rawmaterialmaster_ida',
      'join_key_rhs' => 'vp_vendorproducts_rmm_rawmaterialmastervp_vendorproducts_idb',
    ),
  ),
  'table' => 'vp_vendorproducts_rmm_rawmaterialmaster_c',
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
      'name' => 'vp_vendorproducts_rmm_rawmaterialmasterrmm_rawmaterialmaster_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'vp_vendorproducts_rmm_rawmaterialmastervp_vendorproducts_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'vp_vendorproducts_rmm_rawmaterialmasterspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'vp_vendorproducts_rmm_rawmaterialmaster_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'vp_vendorproducts_rmm_rawmaterialmasterrmm_rawmaterialmaster_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'vp_vendorproducts_rmm_rawmaterialmaster_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'vp_vendorproducts_rmm_rawmaterialmastervp_vendorproducts_idb',
      ),
    ),
  ),
);