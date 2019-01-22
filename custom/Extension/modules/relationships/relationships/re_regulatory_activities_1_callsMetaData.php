<?php
// created: 2018-07-26 03:52:55
$dictionary["re_regulatory_activities_1_calls"] = array (
  'relationships' => 
  array (
    're_regulatory_activities_1_calls' => 
    array (
      'lhs_module' => 'RE_Regulatory',
      'lhs_table' => 're_regulatory',
      'lhs_key' => 'id',
      'rhs_module' => 'Calls',
      'rhs_table' => 'calls',
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