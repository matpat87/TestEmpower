<?php
// created: 2022-10-09 09:17:38
$dictionary["rrq_regulatoryrequests_activities_1_emails"] = array (
  'relationships' => 
  array (
    'rrq_regulatoryrequests_activities_1_emails' => 
    array (
      'lhs_module' => 'RRQ_RegulatoryRequests',
      'lhs_table' => 'rrq_regulatoryrequests',
      'lhs_key' => 'id',
      'rhs_module' => 'Emails',
      'rhs_table' => 'emails',
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