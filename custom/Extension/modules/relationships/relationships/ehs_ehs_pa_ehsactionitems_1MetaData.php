<?php
// created: 2021-06-30 11:58:11
$dictionary["ehs_ehs_pa_ehsactionitems_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'ehs_ehs_pa_ehsactionitems_1' => 
    array (
      'lhs_module' => 'EHS_EHS',
      'lhs_table' => 'ehs_ehs',
      'lhs_key' => 'id',
      'rhs_module' => 'PA_EHSActionItems',
      'rhs_table' => 'pa_ehsactionitems',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'ehs_ehs_pa_ehsactionitems_1_c',
      'join_key_lhs' => 'ehs_ehs_pa_ehsactionitems_1ehs_ehs_ida',
      'join_key_rhs' => 'ehs_ehs_pa_ehsactionitems_1pa_ehsactionitems_idb',
    ),
  ),
  'table' => 'ehs_ehs_pa_ehsactionitems_1_c',
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
      'name' => 'ehs_ehs_pa_ehsactionitems_1ehs_ehs_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'ehs_ehs_pa_ehsactionitems_1pa_ehsactionitems_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'ehs_ehs_pa_ehsactionitems_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'ehs_ehs_pa_ehsactionitems_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'ehs_ehs_pa_ehsactionitems_1ehs_ehs_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'ehs_ehs_pa_ehsactionitems_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'ehs_ehs_pa_ehsactionitems_1pa_ehsactionitems_idb',
      ),
    ),
  ),
);