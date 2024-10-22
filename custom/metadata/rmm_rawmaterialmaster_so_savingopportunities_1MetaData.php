<?php
// created: 2020-11-16 08:52:23
$dictionary["rmm_rawmaterialmaster_so_savingopportunities_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'rmm_rawmaterialmaster_so_savingopportunities_1' => 
    array (
      'lhs_module' => 'RMM_RawMaterialMaster',
      'lhs_table' => 'rmm_rawmaterialmaster',
      'lhs_key' => 'id',
      'rhs_module' => 'SO_SavingOpportunities',
      'rhs_table' => 'so_savingopportunities',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'rmm_rawmaterialmaster_so_savingopportunities_1_c',
      'join_key_lhs' => 'rmm_rawmat46f2lmaster_ida',
      'join_key_rhs' => 'rmm_rawmatfb01unities_idb',
    ),
  ),
  'table' => 'rmm_rawmaterialmaster_so_savingopportunities_1_c',
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
      'name' => 'rmm_rawmat46f2lmaster_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'rmm_rawmatfb01unities_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'rmm_rawmaterialmaster_so_savingopportunities_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'rmm_rawmaterialmaster_so_savingopportunities_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'rmm_rawmat46f2lmaster_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'rmm_rawmaterialmaster_so_savingopportunities_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'rmm_rawmatfb01unities_idb',
      ),
    ),
  ),
);