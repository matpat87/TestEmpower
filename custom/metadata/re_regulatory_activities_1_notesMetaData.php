<?php
// created: 2018-07-26 03:52:56
$dictionary["re_regulatory_activities_1_notes"] = array (
  'relationships' => 
  array (
    're_regulatory_activities_1_notes' => 
    array (
      'lhs_module' => 'RE_Regulatory',
      'lhs_table' => 're_regulatory',
      'lhs_key' => 'id',
      'rhs_module' => 'Notes',
      'rhs_table' => 'notes',
      'rhs_key' => 'parent_id',
      'relationship_type' => 'one-to-many',
      'relationship_role_column' => 'parent_type',
      'relationship_role_column_value' => 'RE_Regulatory',
    ),
  ),
  'fields' => '',
  'indices' => '',
  'table' => '',
);