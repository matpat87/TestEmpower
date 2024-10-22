<?php
// created: 2023-08-31 16:58:52
$dictionary["apx_lots_aos_invoices"] = array (
  'true_relationship_type' => 'many-to-many',
  'relationships' => 
  array (
    'apx_lots_aos_invoices' => 
    array (
      'lhs_module' => 'APX_Lots',
      'lhs_table' => 'apx_lots',
      'lhs_key' => 'id',
      'rhs_module' => 'AOS_Invoices',
      'rhs_table' => 'aos_invoices',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'apx_lots_aos_invoices_c',
      'join_key_lhs' => 'apx_lots_aos_invoicesapx_lots_ida',
      'join_key_rhs' => 'apx_lots_aos_invoicesaos_invoices_idb',
    ),
  ),
  'table' => 'apx_lots_aos_invoices_c',
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
      'name' => 'apx_lots_aos_invoicesapx_lots_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'apx_lots_aos_invoicesaos_invoices_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'apx_lots_aos_invoicesspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'apx_lots_aos_invoices_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'apx_lots_aos_invoicesapx_lots_ida',
        1 => 'apx_lots_aos_invoicesaos_invoices_idb',
      ),
    ),
  ),
);