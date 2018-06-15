<?php
// created: 2014-08-18 12:21:23
$dictionary["asol_process_asol_activity"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'asol_process_asol_activity' => 
    array (
      'lhs_module' => 'asol_Process',
      'lhs_table' => 'asol_process',
      'lhs_key' => 'id',
      'rhs_module' => 'asol_Activity',
      'rhs_table' => 'asol_activity',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'asol_process_asol_activity_c',
      'join_key_lhs' => 'asol_process_asol_activityasol_process_ida',
      'join_key_rhs' => 'asol_process_asol_activityasol_activity_idb',
    ),
  ),
  'table' => 'asol_process_asol_activity_c',
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
      'name' => 'asol_process_asol_activityasol_process_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'asol_process_asol_activityasol_activity_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'asol_process_asol_activityspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'asol_process_asol_activity_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'asol_process_asol_activityasol_process_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'asol_process_asol_activity_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'asol_process_asol_activityasol_activity_idb',
      ),
    ),
  ),
);