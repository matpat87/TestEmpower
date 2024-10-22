<?php
// created: 2021-10-28 12:58:50
$dictionary["cases_ci_customeritems_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'cases_ci_customeritems_1' => 
    array (
      'lhs_module' => 'Cases',
      'lhs_table' => 'cases',
      'lhs_key' => 'id',
      'rhs_module' => 'CI_CustomerItems',
      'rhs_table' => 'ci_customeritems',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'cases_ci_customeritems_1_c',
      'join_key_lhs' => 'cases_ci_customeritems_1cases_ida',
      'join_key_rhs' => 'cases_ci_customeritems_1ci_customeritems_idb',
    ),
  ),
  'table' => 'cases_ci_customeritems_1_c',
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
      'name' => 'cases_ci_customeritems_1cases_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'cases_ci_customeritems_1ci_customeritems_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'cases_ci_customeritems_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'cases_ci_customeritems_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'cases_ci_customeritems_1cases_ida',
        1 => 'cases_ci_customeritems_1ci_customeritems_idb',
      ),
    ),
  ),
);