<?php
// created: 2018-06-23 09:03:50
$dictionary["re_regulatory_tasks_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    're_regulatory_tasks_1' => 
    array (
      'lhs_module' => 'RE_Regulatory',
      'lhs_table' => 're_regulatory',
      'lhs_key' => 'id',
      'rhs_module' => 'Tasks',
      'rhs_table' => 'tasks',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 're_regulatory_tasks_1_c',
      'join_key_lhs' => 're_regulatory_tasks_1re_regulatory_ida',
      'join_key_rhs' => 're_regulatory_tasks_1tasks_idb',
    ),
  ),
  'table' => 're_regulatory_tasks_1_c',
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
      'name' => 're_regulatory_tasks_1re_regulatory_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 're_regulatory_tasks_1tasks_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 're_regulatory_tasks_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 're_regulatory_tasks_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 're_regulatory_tasks_1re_regulatory_ida',
      ),
    ),
    2 => 
    array (
      'name' => 're_regulatory_tasks_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 're_regulatory_tasks_1tasks_idb',
      ),
    ),
  ),
);