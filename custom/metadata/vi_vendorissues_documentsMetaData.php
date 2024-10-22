<?php
// created: 2020-09-09 10:30:10
$dictionary["vi_vendorissues_documents"] = array (
  'true_relationship_type' => 'many-to-many',
  'relationships' => 
  array (
    'vi_vendorissues_documents' => 
    array (
      'lhs_module' => 'VI_VendorIssues',
      'lhs_table' => 'vi_vendorissues',
      'lhs_key' => 'id',
      'rhs_module' => 'Documents',
      'rhs_table' => 'documents',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'vi_vendorissues_documents_c',
      'join_key_lhs' => 'vi_vendorissues_documentsvi_vendorissues_ida',
      'join_key_rhs' => 'vi_vendorissues_documentsdocuments_idb',
    ),
  ),
  'table' => 'vi_vendorissues_documents_c',
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
      'name' => 'vi_vendorissues_documentsvi_vendorissues_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'vi_vendorissues_documentsdocuments_idb',
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
      'name' => 'vi_vendorissues_documentsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'vi_vendorissues_documents_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'vi_vendorissues_documentsvi_vendorissues_ida',
        1 => 'vi_vendorissues_documentsdocuments_idb',
      ),
    ),
  ),
);