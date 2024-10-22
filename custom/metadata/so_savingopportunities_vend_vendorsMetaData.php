<?php
// created: 2020-10-20 06:51:36
// $dictionary["so_savingopportunities_vend_vendors"] = array (
//   'true_relationship_type' => 'one-to-many',
//   'relationships' => 
//   array (
//     'so_savingopportunities_vend_vendors' => 
//     array (
//       'lhs_module' => 'VEND_Vendors',
//       'lhs_table' => 'vend_vendors',
//       'lhs_key' => 'id',
//       'rhs_module' => 'SO_SavingOpportunities',
//       'rhs_table' => 'so_savingopportunities',
//       'rhs_key' => 'id',
//       'relationship_type' => 'many-to-many',
//       'join_table' => 'so_savingopportunities_vend_vendors_c',
//       'join_key_lhs' => 'so_savingopportunities_vend_vendorsvend_vendors_ida',
//       'join_key_rhs' => 'so_savingopportunities_vend_vendorsso_savingopportunities_idb',
//     ),
//   ),
//   'table' => 'so_savingopportunities_vend_vendors_c',
//   'fields' => 
//   array (
//     0 => 
//     array (
//       'name' => 'id',
//       'type' => 'varchar',
//       'len' => 36,
//     ),
//     1 => 
//     array (
//       'name' => 'date_modified',
//       'type' => 'datetime',
//     ),
//     2 => 
//     array (
//       'name' => 'deleted',
//       'type' => 'bool',
//       'len' => '1',
//       'default' => '0',
//       'required' => true,
//     ),
//     3 => 
//     array (
//       'name' => 'so_savingopportunities_vend_vendorsvend_vendors_ida',
//       'type' => 'varchar',
//       'len' => 36,
//     ),
//     4 => 
//     array (
//       'name' => 'so_savingopportunities_vend_vendorsso_savingopportunities_idb',
//       'type' => 'varchar',
//       'len' => 36,
//     ),
//   ),
//   'indices' => 
//   array (
//     0 => 
//     array (
//       'name' => 'so_savingopportunities_vend_vendorsspk',
//       'type' => 'primary',
//       'fields' => 
//       array (
//         0 => 'id',
//       ),
//     ),
//     1 => 
//     array (
//       'name' => 'so_savingopportunities_vend_vendors_ida1',
//       'type' => 'index',
//       'fields' => 
//       array (
//         0 => 'so_savingopportunities_vend_vendorsvend_vendors_ida',
//       ),
//     ),
//     2 => 
//     array (
//       'name' => 'so_savingopportunities_vend_vendors_alt',
//       'type' => 'alternate_key',
//       'fields' => 
//       array (
//         0 => 'so_savingopportunities_vend_vendorsso_savingopportunities_idb',
//       ),
//     ),
//   ),
// );