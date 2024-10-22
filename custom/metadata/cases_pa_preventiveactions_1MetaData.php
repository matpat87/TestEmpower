<?php
// created: 2021-04-08 09:34:48
$dictionary["cases_pa_preventiveactions_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'cases_pa_preventiveactions_1' => 
    array (
      'lhs_module' => 'Cases',
      'lhs_table' => 'cases',
      'lhs_key' => 'id',
      'rhs_module' => 'PA_PreventiveActions',
      'rhs_table' => 'pa_preventiveactions',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'cases_pa_preventiveactions_1_c',
      'join_key_lhs' => 'cases_pa_preventiveactions_1cases_ida',
      'join_key_rhs' => 'cases_pa_preventiveactions_1pa_preventiveactions_idb',
    ),
  ),
  'table' => 'cases_pa_preventiveactions_1_c',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'cases_pa_preventiveactions_1cases_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'cases_pa_preventiveactions_1pa_preventiveactions_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'cases_pa_preventiveactions_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'cases_pa_preventiveactions_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'cases_pa_preventiveactions_1cases_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'cases_pa_preventiveactions_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'cases_pa_preventiveactions_1pa_preventiveactions_idb',
      ),
    ),
  ),
);