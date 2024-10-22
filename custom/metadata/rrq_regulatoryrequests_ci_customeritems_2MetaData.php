<?php
// created: 2023-07-05 08:09:08
$dictionary["rrq_regulatoryrequests_ci_customeritems_2"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'rrq_regulatoryrequests_ci_customeritems_2' => 
    array (
      'lhs_module' => 'RRQ_RegulatoryRequests',
      'lhs_table' => 'rrq_regulatoryrequests',
      'lhs_key' => 'id',
      'rhs_module' => 'CI_CustomerItems',
      'rhs_table' => 'ci_customeritems',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'rrq_regulatoryrequests_ci_customeritems_2_c',
      'join_key_lhs' => 'rrq_regula7aeaequests_ida',
      'join_key_rhs' => 'rrq_regulatoryrequests_ci_customeritems_2ci_customeritems_idb',
    ),
  ),
  'table' => 'rrq_regulatoryrequests_ci_customeritems_2_c',
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
      'name' => 'rrq_regula7aeaequests_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'rrq_regulatoryrequests_ci_customeritems_2ci_customeritems_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'rrq_regulatoryrequests_ci_customeritems_2spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'rrq_regulatoryrequests_ci_customeritems_2_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'rrq_regula7aeaequests_ida',
        1 => 'rrq_regulatoryrequests_ci_customeritems_2ci_customeritems_idb',
      ),
    ),
  ),
);