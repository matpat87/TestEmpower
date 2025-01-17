<?php
// created: 2021-06-30 13:55:22
$dictionary["pa_ehsactionitems_contacts_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'pa_ehsactionitems_contacts_1' => 
    array (
      'lhs_module' => 'PA_EHSActionItems',
      'lhs_table' => 'pa_ehsactionitems',
      'lhs_key' => 'id',
      'rhs_module' => 'Contacts',
      'rhs_table' => 'contacts',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'pa_ehsactionitems_contacts_1_c',
      'join_key_lhs' => 'pa_ehsactionitems_contacts_1pa_ehsactionitems_ida',
      'join_key_rhs' => 'pa_ehsactionitems_contacts_1contacts_idb',
    ),
  ),
  'table' => 'pa_ehsactionitems_contacts_1_c',
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
      'name' => 'pa_ehsactionitems_contacts_1pa_ehsactionitems_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'pa_ehsactionitems_contacts_1contacts_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'pa_ehsactionitems_contacts_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'pa_ehsactionitems_contacts_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'pa_ehsactionitems_contacts_1pa_ehsactionitems_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'pa_ehsactionitems_contacts_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'pa_ehsactionitems_contacts_1contacts_idb',
      ),
    ),
  ),
);