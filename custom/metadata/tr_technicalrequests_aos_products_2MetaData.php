<?php
// created: 2022-05-03 06:20:49
$dictionary["tr_technicalrequests_aos_products_2"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'tr_technicalrequests_aos_products_2' => 
    array (
      'lhs_module' => 'TR_TechnicalRequests',
      'lhs_table' => 'tr_technicalrequests',
      'lhs_key' => 'id',
      'rhs_module' => 'AOS_Products',
      'rhs_table' => 'aos_products',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'tr_technicalrequests_aos_products_2_c',
      'join_key_lhs' => 'tr_technicalrequests_aos_products_2tr_technicalrequests_ida',
      'join_key_rhs' => 'tr_technicalrequests_aos_products_2aos_products_idb',
    ),
  ),
  'table' => 'tr_technicalrequests_aos_products_2_c',
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
      'name' => 'tr_technicalrequests_aos_products_2tr_technicalrequests_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'tr_technicalrequests_aos_products_2aos_products_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'tr_technicalrequests_aos_products_2spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'tr_technicalrequests_aos_products_2_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'tr_technicalrequests_aos_products_2tr_technicalrequests_ida',
        1 => 'tr_technicalrequests_aos_products_2aos_products_idb',
      ),
    ),
  ),
);