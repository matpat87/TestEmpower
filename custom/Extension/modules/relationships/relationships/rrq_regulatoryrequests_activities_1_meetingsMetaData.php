<?php
// created: 2022-10-09 09:17:35
$dictionary["rrq_regulatoryrequests_activities_1_meetings"] = array (
  'relationships' => 
  array (
    'rrq_regulatoryrequests_activities_1_meetings' => 
    array (
      'lhs_module' => 'RRQ_RegulatoryRequests',
      'lhs_table' => 'rrq_regulatoryrequests',
      'lhs_key' => 'id',
      'rhs_module' => 'Meetings',
      'rhs_table' => 'meetings',
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