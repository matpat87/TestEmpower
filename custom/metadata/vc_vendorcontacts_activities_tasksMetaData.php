<?php
// created: 2020-10-19 11:04:27
$dictionary["vc_vendorcontacts_activities_tasks"] = array (
  'relationships' => 
  array (
    'vc_vendorcontacts_activities_tasks' => 
    array (
      'lhs_module' => 'VC_VendorContacts',
      'lhs_table' => 'vc_vendorcontacts',
      'lhs_key' => 'id',
      'rhs_module' => 'Tasks',
      'rhs_table' => 'tasks',
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