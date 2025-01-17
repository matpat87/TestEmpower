<?php
// created: 2021-07-26 14:08:25
$dictionary["otr_ontrack_otw_otworkinggroups_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'otr_ontrack_otw_otworkinggroups_1' => 
    array (
      'lhs_module' => 'OTR_OnTrack',
      'lhs_table' => 'otr_ontrack',
      'lhs_key' => 'id',
      'rhs_module' => 'OTW_OTWorkingGroups',
      'rhs_table' => 'otw_otworkinggroups',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'otr_ontrack_otw_otworkinggroups_1_c',
      'join_key_lhs' => 'otr_ontrack_otw_otworkinggroups_1otr_ontrack_ida',
      'join_key_rhs' => 'otr_ontrack_otw_otworkinggroups_1otw_otworkinggroups_idb',
    ),
  ),
  'table' => 'otr_ontrack_otw_otworkinggroups_1_c',
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
      'name' => 'otr_ontrack_otw_otworkinggroups_1otr_ontrack_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'otr_ontrack_otw_otworkinggroups_1otw_otworkinggroups_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'otr_ontrack_otw_otworkinggroups_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'otr_ontrack_otw_otworkinggroups_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'otr_ontrack_otw_otworkinggroups_1otr_ontrack_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'otr_ontrack_otw_otworkinggroups_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'otr_ontrack_otw_otworkinggroups_1otw_otworkinggroups_idb',
      ),
    ),
  ),
);