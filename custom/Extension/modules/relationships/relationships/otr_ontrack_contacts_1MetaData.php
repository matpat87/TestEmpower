<?php
// created: 2018-08-11 09:33:42
$dictionary["otr_ontrack_contacts_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'otr_ontrack_contacts_1' => 
    array (
      'lhs_module' => 'OTR_OnTrack',
      'lhs_table' => 'otr_ontrack',
      'lhs_key' => 'id',
      'rhs_module' => 'Contacts',
      'rhs_table' => 'contacts',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'otr_ontrack_contacts_1_c',
      'join_key_lhs' => 'otr_ontrack_contacts_1otr_ontrack_ida',
      'join_key_rhs' => 'otr_ontrack_contacts_1contacts_idb',
    ),
  ),
  'table' => 'otr_ontrack_contacts_1_c',
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
      'name' => 'otr_ontrack_contacts_1otr_ontrack_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'otr_ontrack_contacts_1contacts_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'otr_ontrack_contacts_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'otr_ontrack_contacts_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'otr_ontrack_contacts_1otr_ontrack_ida',
        1 => 'otr_ontrack_contacts_1contacts_idb',
      ),
    ),
  ),
);