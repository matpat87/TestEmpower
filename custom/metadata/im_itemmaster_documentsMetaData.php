<?php
// created: 2019-01-14 16:45:34
$dictionary["im_itemmaster_documents"] = array (
  'true_relationship_type' => 'many-to-many',
  'relationships' => 
  array (
    'im_itemmaster_documents' => 
    array (
      'lhs_module' => 'IM_ItemMaster',
      'lhs_table' => 'im_itemmaster',
      'lhs_key' => 'id',
      'rhs_module' => 'Documents',
      'rhs_table' => 'documents',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'im_itemmaster_documents_c',
      'join_key_lhs' => 'im_itemmaster_documentsim_itemmaster_ida',
      'join_key_rhs' => 'im_itemmaster_documentsdocuments_idb',
    ),
  ),
  'table' => 'im_itemmaster_documents_c',
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
      'name' => 'im_itemmaster_documentsim_itemmaster_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'im_itemmaster_documentsdocuments_idb',
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
      'name' => 'im_itemmaster_documentsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'im_itemmaster_documents_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'im_itemmaster_documentsim_itemmaster_ida',
        1 => 'im_itemmaster_documentsdocuments_idb',
      ),
    ),
  ),
);