<?php
// created: 2019-02-11 17:33:48
$dictionary["tr_technicalrequests_project"] = array (
  'true_relationship_type' => 'one-to-one',
  'relationships' => 
  array (
    'tr_technicalrequests_project' => 
    array (
      'lhs_module' => 'TR_TechnicalRequests',
      'lhs_table' => 'tr_technicalrequests',
      'lhs_key' => 'id',
      'rhs_module' => 'Project',
      'rhs_table' => 'project',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'tr_technicalrequests_project_c',
      'join_key_lhs' => 'tr_technicalrequests_projecttr_technicalrequests_ida',
      'join_key_rhs' => 'tr_technicalrequests_projectproject_idb',
    ),
  ),
  'table' => 'tr_technicalrequests_project_c',
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
      'name' => 'tr_technicalrequests_projecttr_technicalrequests_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'tr_technicalrequests_projectproject_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'tr_technicalrequests_projectspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'tr_technicalrequests_project_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'tr_technicalrequests_projecttr_technicalrequests_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'tr_technicalrequests_project_idb2',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'tr_technicalrequests_projectproject_idb',
      ),
    ),
  ),
);