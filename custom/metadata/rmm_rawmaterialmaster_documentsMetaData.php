<?php
// created: 2020-11-10 09:32:09
$dictionary["rmm_rawmaterialmaster_documents"] = array (
  'true_relationship_type' => 'many-to-many',
  'relationships' => 
  array (
    'rmm_rawmaterialmaster_documents' => 
    array (
      'lhs_module' => 'RMM_RawMaterialMaster',
      'lhs_table' => 'rmm_rawmaterialmaster',
      'lhs_key' => 'id',
      'rhs_module' => 'Documents',
      'rhs_table' => 'documents',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'rmm_rawmaterialmaster_documents_c',
      'join_key_lhs' => 'rmm_rawmaterialmaster_documentsrmm_rawmaterialmaster_ida',
      'join_key_rhs' => 'rmm_rawmaterialmaster_documentsdocuments_idb',
    ),
  ),
  'table' => 'rmm_rawmaterialmaster_documents_c',
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
      'name' => 'rmm_rawmaterialmaster_documentsrmm_rawmaterialmaster_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'rmm_rawmaterialmaster_documentsdocuments_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
    5 => 
    array (
      'name' => 'document_revision_id',
      'type' => 'varchar',
      'len' => '36',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'rmm_rawmaterialmaster_documentsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'rmm_rawmaterialmaster_documents_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'rmm_rawmaterialmaster_documentsrmm_rawmaterialmaster_ida',
        1 => 'rmm_rawmaterialmaster_documentsdocuments_idb',
      ),
    ),
  ),
);