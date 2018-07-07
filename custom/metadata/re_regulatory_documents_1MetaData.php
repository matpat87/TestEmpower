<?php
// created: 2018-06-23 09:09:53
$dictionary["re_regulatory_documents_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    're_regulatory_documents_1' => 
    array (
      'lhs_module' => 'RE_Regulatory',
      'lhs_table' => 're_regulatory',
      'lhs_key' => 'id',
      'rhs_module' => 'Documents',
      'rhs_table' => 'documents',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 're_regulatory_documents_1_c',
      'join_key_lhs' => 're_regulatory_documents_1re_regulatory_ida',
      'join_key_rhs' => 're_regulatory_documents_1documents_idb',
    ),
  ),
  'table' => 're_regulatory_documents_1_c',
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
      'name' => 're_regulatory_documents_1re_regulatory_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 're_regulatory_documents_1documents_idb',
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
      'name' => 're_regulatory_documents_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 're_regulatory_documents_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 're_regulatory_documents_1re_regulatory_ida',
        1 => 're_regulatory_documents_1documents_idb',
      ),
    ),
  ),
);