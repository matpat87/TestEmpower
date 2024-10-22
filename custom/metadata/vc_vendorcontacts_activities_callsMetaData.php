<?php
// created: 2020-10-19 11:04:27
$dictionary["vc_vendorcontacts_activities_calls"] = array (
  'relationships' => 
  array (
    'vc_vendorcontacts_activities_calls' => 
    array (
      'lhs_module' => 'VC_VendorContacts',
      'lhs_table' => 'vc_vendorcontacts',
      'lhs_key' => 'id',
      'rhs_module' => 'Calls',
      'rhs_table' => 'calls',
      'rhs_key' => 'parent_id',
      'relationship_type' => 'one-to-many',
      'relationship_role_column' => 'parent_type',
      'relationship_role_column_value' => 'VC_VendorContacts',
    ),
  ),
  'fields' => '',
  'indices' => '',
  'table' => '',
);