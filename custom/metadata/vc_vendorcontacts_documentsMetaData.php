<?php
// created: 2020-10-19 11:04:27
$dictionary["vc_vendorcontacts_documents"] = array (
  'true_relationship_type' => 'many-to-many',
  'relationships' => 
  array (
    'vc_vendorcontacts_documents' => 
    array (
      'lhs_module' => 'VC_VendorContacts',
      'lhs_table' => 'vc_vendorcontacts',
      'lhs_key' => 'id',
      'rhs_module' => 'Documents',
      'rhs_table' => 'documents',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'vc_vendorcontacts_documents_c',
      'join_key_lhs' => 'vc_vendorcontacts_documentsvc_vendorcontacts_ida',
      'join_key_rhs' => 'vc_vendorcontacts_documentsdocuments_idb',
    ),
  ),
  'table' => 'vc_vendorcontacts_documents_c',
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
      'name' => 'vc_vendorcontacts_documentsvc_vendorcontacts_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'vc_vendorcontacts_documentsdocuments_idb',
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
      'name' => 'vc_vendorcontacts_documentsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'vc_vendorcontacts_documents_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'vc_vendorcontacts_documentsvc_vendorcontacts_ida',
        1 => 'vc_vendorcontacts_documentsdocuments_idb',
      ),
    ),
  ),
);