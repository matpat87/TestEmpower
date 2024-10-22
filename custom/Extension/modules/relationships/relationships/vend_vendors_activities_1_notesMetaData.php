<?php
// created: 2020-09-08 07:41:32
$dictionary["vend_vendors_activities_1_notes"] = array (
  'relationships' => 
  array (
    'vend_vendors_activities_1_notes' => 
    array (
      'lhs_module' => 'VEND_Vendors',
      'lhs_table' => 'vend_vendors',
      'lhs_key' => 'id',
      'rhs_module' => 'Notes',
      'rhs_table' => 'notes',
      'rhs_key' => 'parent_id',
      'relationship_type' => 'one-to-many',
      'relationship_role_column' => 'parent_type',
      'relationship_role_column_value' => 'VEND_Vendors',
    ),
  ),
  'fields' => '',
  'indices' => '',
  'table' => '',
);