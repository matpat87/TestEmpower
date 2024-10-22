<?php
// created: 2019-12-13 12:39:54
// $dictionary["tr_technicalrequests_dsbtn_distribution_1"] = array (
//   'true_relationship_type' => 'many-to-many',
//   'from_studio' => true,
//   'relationships' => 
//   array (
//     'tr_technicalrequests_dsbtn_distribution_1' => 
//     array (
//       'lhs_module' => 'TR_TechnicalRequests',
//       'lhs_table' => 'tr_technicalrequests',
//       'lhs_key' => 'id',
//       'rhs_module' => 'DSBTN_Distribution',
//       'rhs_table' => 'dsbtn_distribution',
//       'rhs_key' => 'id',
//       'relationship_type' => 'many-to-many',
//       'join_table' => 'tr_technicalrequests_dsbtn_distribution_1_c',
//       'join_key_lhs' => 'tr_technic69eeequests_ida',
//       'join_key_rhs' => 'tr_technicalrequests_dsbtn_distribution_1dsbtn_distribution_idb',
//     ),
//   ),
//   'table' => 'tr_technicalrequests_dsbtn_distribution_1_c',
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
//       'name' => 'tr_technic69eeequests_ida',
//       'type' => 'varchar',
//       'len' => 36,
//     ),
//     4 => 
//     array (
//       'name' => 'tr_technicalrequests_dsbtn_distribution_1dsbtn_distribution_idb',
//       'type' => 'varchar',
//       'len' => 36,
//     ),
//   ),
//   'indices' => 
//   array (
//     0 => 
//     array (
//       'name' => 'tr_technicalrequests_dsbtn_distribution_1spk',
//       'type' => 'primary',
//       'fields' => 
//       array (
//         0 => 'id',
//       ),
//     ),
//     1 => 
//     array (
//       'name' => 'tr_technicalrequests_dsbtn_distribution_1_alt',
//       'type' => 'alternate_key',
//       'fields' => 
//       array (
//         0 => 'tr_technic69eeequests_ida',
//         1 => 'tr_technicalrequests_dsbtn_distribution_1dsbtn_distribution_idb',
//       ),
//     ),
//   ),
// );