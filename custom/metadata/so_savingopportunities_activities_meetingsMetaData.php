<?php
// created: 2020-10-20 06:51:36
$dictionary["so_savingopportunities_activities_meetings"] = array (
  'relationships' => 
  array (
    'so_savingopportunities_activities_meetings' => 
    array (
      'lhs_module' => 'SO_SavingOpportunities',
      'lhs_table' => 'so_savingopportunities',
      'lhs_key' => 'id',
      'rhs_module' => 'Meetings',
      'rhs_table' => 'meetings',
      'rhs_key' => 'parent_id',
      'relationship_type' => 'one-to-many',
      'relationship_role_column' => 'parent_type',
      'relationship_role_column_value' => 'SO_SavingOpportunities',
    ),
  ),
  'fields' => '',
  'indices' => '',
  'table' => '',
);