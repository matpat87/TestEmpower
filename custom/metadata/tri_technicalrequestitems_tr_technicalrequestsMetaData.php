<?php
// created: 2021-02-03 12:14:45
$dictionary["tri_technicalrequestitems_tr_technicalrequests"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'tri_technicalrequestitems_tr_technicalrequests' => 
    array (
      'lhs_module' => 'TR_TechnicalRequests',
      'lhs_table' => 'tr_technicalrequests',
      'lhs_key' => 'id',
      'rhs_module' => 'TRI_TechnicalRequestItems',
      'rhs_table' => 'tri_technicalrequestitems',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'tri_technicalrequestitems_tr_technicalrequests_c',
      'join_key_lhs' => 'tri_techni0387equests_ida',
      'join_key_rhs' => 'tri_technif81bstitems_idb',
    ),
  ),
  'table' => 'tri_technicalrequestitems_tr_technicalrequests_c',
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
      'name' => 'tri_techni0387equests_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'tri_technif81bstitems_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'tri_technicalrequestitems_tr_technicalrequestsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'tri_technicalrequestitems_tr_technicalrequests_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'tri_techni0387equests_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'tri_technicalrequestitems_tr_technicalrequests_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'tri_technif81bstitems_idb',
      ),
    ),
  ),
);