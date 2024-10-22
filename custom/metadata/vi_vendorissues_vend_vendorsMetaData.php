<?php
// created: 2020-09-09 10:30:10
$dictionary["vi_vendorissues_vend_vendors"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'vi_vendorissues_vend_vendors' => 
    array (
      'lhs_module' => 'VEND_Vendors',
      'lhs_table' => 'vend_vendors',
      'lhs_key' => 'id',
      'rhs_module' => 'VI_VendorIssues',
      'rhs_table' => 'vi_vendorissues',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'vi_vendorissues_vend_vendors_c',
      'join_key_lhs' => 'vi_vendorissues_vend_vendorsvend_vendors_ida',
      'join_key_rhs' => 'vi_vendorissues_vend_vendorsvi_vendorissues_idb',
    ),
  ),
  'table' => 'vi_vendorissues_vend_vendors_c',
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
      'name' => 'vi_vendorissues_vend_vendorsvend_vendors_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'vi_vendorissues_vend_vendorsvi_vendorissues_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'vi_vendorissues_vend_vendorsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'vi_vendorissues_vend_vendors_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'vi_vendorissues_vend_vendorsvend_vendors_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'vi_vendorissues_vend_vendors_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'vi_vendorissues_vend_vendorsvi_vendorissues_idb',
      ),
    ),
  ),
);