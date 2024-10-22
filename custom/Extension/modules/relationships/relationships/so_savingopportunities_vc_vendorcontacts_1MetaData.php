<?php
// created: 2020-11-03 07:45:29
$dictionary["so_savingopportunities_vc_vendorcontacts_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'so_savingopportunities_vc_vendorcontacts_1' => 
    array (
      'lhs_module' => 'SO_SavingOpportunities',
      'lhs_table' => 'so_savingopportunities',
      'lhs_key' => 'id',
      'rhs_module' => 'VC_VendorContacts',
      'rhs_table' => 'vc_vendorcontacts',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'so_savingopportunities_vc_vendorcontacts_1_c',
      'join_key_lhs' => 'so_savingoe2bdunities_ida',
      'join_key_rhs' => 'so_savingopportunities_vc_vendorcontacts_1vc_vendorcontacts_idb',
    ),
  ),
  'table' => 'so_savingopportunities_vc_vendorcontacts_1_c',
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
      'name' => 'so_savingoe2bdunities_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'so_savingopportunities_vc_vendorcontacts_1vc_vendorcontacts_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'so_savingopportunities_vc_vendorcontacts_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'so_savingopportunities_vc_vendorcontacts_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'so_savingoe2bdunities_ida',
        1 => 'so_savingopportunities_vc_vendorcontacts_1vc_vendorcontacts_idb',
      ),
    ),
  ),
);