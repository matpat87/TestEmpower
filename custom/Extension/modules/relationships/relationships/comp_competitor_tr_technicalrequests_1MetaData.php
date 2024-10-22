<?php
// created: 2022-05-25 06:33:51
$dictionary["comp_competitor_tr_technicalrequests_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'comp_competitor_tr_technicalrequests_1' => 
    array (
      'lhs_module' => 'COMP_Competitor',
      'lhs_table' => 'comp_competitor',
      'lhs_key' => 'id',
      'rhs_module' => 'TR_TechnicalRequests',
      'rhs_table' => 'tr_technicalrequests',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'comp_competitor_tr_technicalrequests_1_c',
      'join_key_lhs' => 'comp_competitor_tr_technicalrequests_1comp_competitor_ida',
      'join_key_rhs' => 'comp_competitor_tr_technicalrequests_1tr_technicalrequests_idb',
    ),
  ),
  'table' => 'comp_competitor_tr_technicalrequests_1_c',
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
      'name' => 'comp_competitor_tr_technicalrequests_1comp_competitor_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'comp_competitor_tr_technicalrequests_1tr_technicalrequests_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'comp_competitor_tr_technicalrequests_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'comp_competitor_tr_technicalrequests_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'comp_competitor_tr_technicalrequests_1comp_competitor_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'comp_competitor_tr_technicalrequests_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'comp_competitor_tr_technicalrequests_1tr_technicalrequests_idb',
      ),
    ),
  ),
);