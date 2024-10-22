<?php
// created: 2020-09-09 10:30:10
$dictionary["vi_vendorissues_activities_notes"] = array (
  'relationships' => 
  array (
    'vi_vendorissues_activities_notes' => 
    array (
      'lhs_module' => 'VI_VendorIssues',
      'lhs_table' => 'vi_vendorissues',
      'lhs_key' => 'id',
      'rhs_module' => 'Notes',
      'rhs_table' => 'notes',
      'rhs_key' => 'parent_id',
      'relationship_type' => 'one-to-many',
      'relationship_role_column' => 'parent_type',
      'relationship_role_column_value' => 'VI_VendorIssues',
    ),
  ),
  'fields' => '',
  'indices' => '',
  'table' => '',
);