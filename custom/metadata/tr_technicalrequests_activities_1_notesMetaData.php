<?php
// created: 2019-10-14 13:15:34
$dictionary["tr_technicalrequests_activities_1_notes"] = array (
  'relationships' => 
  array (
    'tr_technicalrequests_activities_1_notes' => 
    array (
      'lhs_module' => 'TR_TechnicalRequests',
      'lhs_table' => 'tr_technicalrequests',
      'lhs_key' => 'id',
      'rhs_module' => 'Notes',
      'rhs_table' => 'notes',
      'rhs_key' => 'parent_id',
      'relationship_type' => 'one-to-many',
      'relationship_role_column' => 'parent_type',
      'relationship_role_column_value' => 'TR_TechnicalRequests',
    ),
  ),
  'fields' => '',
  'indices' => '',
  'table' => '',
);