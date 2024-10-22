<?php
// created: 2022-10-09 09:17:33
$dictionary["rrq_regulatoryrequests_activities_1_calls"] = array (
  'relationships' => 
  array (
    'rrq_regulatoryrequests_activities_1_calls' => 
    array (
      'lhs_module' => 'RRQ_RegulatoryRequests',
      'lhs_table' => 'rrq_regulatoryrequests',
      'lhs_key' => 'id',
      'rhs_module' => 'Calls',
      'rhs_table' => 'calls',
      'rhs_key' => 'parent_id',
      'relationship_type' => 'one-to-many',
      'relationship_role_column' => 'parent_type',
      'relationship_role_column_value' => 'RRQ_RegulatoryRequests',
    ),
  ),
  'fields' => '',
  'indices' => '',
  'table' => '',
);