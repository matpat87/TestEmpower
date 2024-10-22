<?php
// created: 2020-10-19 11:04:27
$dictionary["vc_vendorcontacts_vend_vendors"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'vc_vendorcontacts_vend_vendors' => 
    array (
      'lhs_module' => 'VEND_Vendors',
      'lhs_table' => 'vend_vendors',
      'lhs_key' => 'id',
      'rhs_module' => 'VC_VendorContacts',
      'rhs_table' => 'vc_vendorcontacts',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'vc_vendorcontacts_vend_vendors_c',
      'join_key_lhs' => 'vc_vendorcontacts_vend_vendorsvend_vendors_ida',
      'join_key_rhs' => 'vc_vendorcontacts_vend_vendorsvc_vendorcontacts_idb',
    ),
  ),
  'table' => 'vc_vendorcontacts_vend_vendors_c',
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
      'name' => 'vc_vendorcontacts_vend_vendorsvend_vendors_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'vc_vendorcontacts_vend_vendorsvc_vendorcontacts_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'vc_vendorcontacts_vend_vendorsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'vc_vendorcontacts_vend_vendors_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'vc_vendorcontacts_vend_vendorsvend_vendors_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'vc_vendorcontacts_vend_vendors_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'vc_vendorcontacts_vend_vendorsvc_vendorcontacts_idb',
      ),
    ),
  ),
);