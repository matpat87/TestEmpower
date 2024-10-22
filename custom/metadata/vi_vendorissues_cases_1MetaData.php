<?php
// created: 2020-11-11 12:34:39
$dictionary["vi_vendorissues_cases_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'vi_vendorissues_cases_1' => 
    array (
      'lhs_module' => 'VI_VendorIssues',
      'lhs_table' => 'vi_vendorissues',
      'lhs_key' => 'id',
      'rhs_module' => 'Cases',
      'rhs_table' => 'cases',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'vi_vendorissues_cases_1_c',
      'join_key_lhs' => 'vi_vendorissues_cases_1vi_vendorissues_ida',
      'join_key_rhs' => 'vi_vendorissues_cases_1cases_idb',
    ),
  ),
  'table' => 'vi_vendorissues_cases_1_c',
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
      'name' => 'vi_vendorissues_cases_1vi_vendorissues_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'vi_vendorissues_cases_1cases_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'vi_vendorissues_cases_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'vi_vendorissues_cases_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'vi_vendorissues_cases_1vi_vendorissues_ida',
        1 => 'vi_vendorissues_cases_1cases_idb',
      ),
    ),
  ),
);