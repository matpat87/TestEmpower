<?php
// created: 2020-10-19 11:08:51
$dictionary["vc_vendorcontacts_vi_vendorissues_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'vc_vendorcontacts_vi_vendorissues_1' => 
    array (
      'lhs_module' => 'VC_VendorContacts',
      'lhs_table' => 'vc_vendorcontacts',
      'lhs_key' => 'id',
      'rhs_module' => 'VI_VendorIssues',
      'rhs_table' => 'vi_vendorissues',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'vc_vendorcontacts_vi_vendorissues_1_c',
      'join_key_lhs' => 'vc_vendorcontacts_vi_vendorissues_1vc_vendorcontacts_ida',
      'join_key_rhs' => 'vc_vendorcontacts_vi_vendorissues_1vi_vendorissues_idb',
    ),
  ),
  'table' => 'vc_vendorcontacts_vi_vendorissues_1_c',
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
      'name' => 'vc_vendorcontacts_vi_vendorissues_1vc_vendorcontacts_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'vc_vendorcontacts_vi_vendorissues_1vi_vendorissues_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'vc_vendorcontacts_vi_vendorissues_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'vc_vendorcontacts_vi_vendorissues_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'vc_vendorcontacts_vi_vendorissues_1vc_vendorcontacts_ida',
        1 => 'vc_vendorcontacts_vi_vendorissues_1vi_vendorissues_idb',
      ),
    ),
  ),
);