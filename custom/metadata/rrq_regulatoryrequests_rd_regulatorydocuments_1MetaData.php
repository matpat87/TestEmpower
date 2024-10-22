<?php
// created: 2023-06-12 07:56:57
$dictionary["rrq_regulatoryrequests_rd_regulatorydocuments_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'rrq_regulatoryrequests_rd_regulatorydocuments_1' => 
    array (
      'lhs_module' => 'RRQ_RegulatoryRequests',
      'lhs_table' => 'rrq_regulatoryrequests',
      'lhs_key' => 'id',
      'rhs_module' => 'RD_RegulatoryDocuments',
      'rhs_table' => 'rd_regulatorydocuments',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'rrq_regulatoryrequests_rd_regulatorydocuments_1_c',
      'join_key_lhs' => 'rrq_regula991fequests_ida',
      'join_key_rhs' => 'rrq_regulad2fecuments_idb',
    ),
  ),
  'table' => 'rrq_regulatoryrequests_rd_regulatorydocuments_1_c',
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
      'name' => 'rrq_regula991fequests_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'rrq_regulad2fecuments_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'rrq_regulatoryrequests_rd_regulatorydocuments_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'rrq_regulatoryrequests_rd_regulatorydocuments_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'rrq_regula991fequests_ida',
        1 => 'rrq_regulad2fecuments_idb',
      ),
    ),
  ),
);