<?php
// created: 2023-01-27 10:40:52
$dictionary["rd_regulatorydocuments_aos_products_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'rd_regulatorydocuments_aos_products_1' => 
    array (
      'lhs_module' => 'RD_RegulatoryDocuments',
      'lhs_table' => 'rd_regulatorydocuments',
      'lhs_key' => 'id',
      'rhs_module' => 'AOS_Products',
      'rhs_table' => 'aos_products',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'rd_regulatorydocuments_aos_products_1_c',
      'join_key_lhs' => 'rd_regulatorydocuments_aos_products_1rd_regulatorydocuments_ida',
      'join_key_rhs' => 'rd_regulatorydocuments_aos_products_1aos_products_idb',
    ),
  ),
  'table' => 'rd_regulatorydocuments_aos_products_1_c',
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
      'name' => 'rd_regulatorydocuments_aos_products_1rd_regulatorydocuments_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'rd_regulatorydocuments_aos_products_1aos_products_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'rd_regulatorydocuments_aos_products_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'rd_regulatorydocuments_aos_products_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'rd_regulatorydocuments_aos_products_1rd_regulatorydocuments_ida',
        1 => 'rd_regulatorydocuments_aos_products_1aos_products_idb',
      ),
    ),
  ),
);