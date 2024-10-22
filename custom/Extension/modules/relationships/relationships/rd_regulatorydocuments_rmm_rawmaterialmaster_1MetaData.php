<?php
// created: 2023-01-27 08:37:36
$dictionary["rd_regulatorydocuments_rmm_rawmaterialmaster_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'rd_regulatorydocuments_rmm_rawmaterialmaster_1' => 
    array (
      'lhs_module' => 'RD_RegulatoryDocuments',
      'lhs_table' => 'rd_regulatorydocuments',
      'lhs_key' => 'id',
      'rhs_module' => 'RMM_RawMaterialMaster',
      'rhs_table' => 'rmm_rawmaterialmaster',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'rd_regulatorydocuments_rmm_rawmaterialmaster_1_c',
      'join_key_lhs' => 'rd_regulatba2fcuments_ida',
      'join_key_rhs' => 'rd_regulat50f2lmaster_idb',
    ),
  ),
  'table' => 'rd_regulatorydocuments_rmm_rawmaterialmaster_1_c',
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
      'name' => 'rd_regulatba2fcuments_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'rd_regulat50f2lmaster_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'rd_regulatorydocuments_rmm_rawmaterialmaster_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'rd_regulatorydocuments_rmm_rawmaterialmaster_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'rd_regulatba2fcuments_ida',
        1 => 'rd_regulat50f2lmaster_idb',
      ),
    ),
  ),
);