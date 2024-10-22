<?php
// created: 2022-04-06 07:02:54
$dictionary["ci_customeritems_tr_technicalrequests_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'ci_customeritems_tr_technicalrequests_1' => 
    array (
      'lhs_module' => 'CI_CustomerItems',
      'lhs_table' => 'ci_customeritems',
      'lhs_key' => 'id',
      'rhs_module' => 'TR_TechnicalRequests',
      'rhs_table' => 'tr_technicalrequests',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'ci_customeritems_tr_technicalrequests_1_c',
      'join_key_lhs' => 'ci_customeritems_tr_technicalrequests_1ci_customeritems_ida',
      'join_key_rhs' => 'ci_customeritems_tr_technicalrequests_1tr_technicalrequests_idb',
    ),
  ),
  'table' => 'ci_customeritems_tr_technicalrequests_1_c',
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
      'name' => 'ci_customeritems_tr_technicalrequests_1ci_customeritems_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'ci_customeritems_tr_technicalrequests_1tr_technicalrequests_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'ci_customeritems_tr_technicalrequests_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'ci_customeritems_tr_technicalrequests_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'ci_customeritems_tr_technicalrequests_1ci_customeritems_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'ci_customeritems_tr_technicalrequests_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'ci_customeritems_tr_technicalrequests_1tr_technicalrequests_idb',
      ),
    ),
  ),
);