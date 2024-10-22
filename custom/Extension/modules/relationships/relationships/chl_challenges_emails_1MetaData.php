<?php
// created: 2021-08-15 14:29:05
$dictionary["chl_challenges_emails_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'chl_challenges_emails_1' => 
    array (
      'lhs_module' => 'CHL_Challenges',
      'lhs_table' => 'chl_challenges',
      'lhs_key' => 'id',
      'rhs_module' => 'Emails',
      'rhs_table' => 'emails',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'chl_challenges_emails_1_c',
      'join_key_lhs' => 'chl_challenges_emails_1chl_challenges_ida',
      'join_key_rhs' => 'chl_challenges_emails_1emails_idb',
    ),
  ),
  'table' => 'chl_challenges_emails_1_c',
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
      'name' => 'chl_challenges_emails_1chl_challenges_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'chl_challenges_emails_1emails_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'chl_challenges_emails_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'chl_challenges_emails_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'chl_challenges_emails_1chl_challenges_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'chl_challenges_emails_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'chl_challenges_emails_1emails_idb',
      ),
    ),
  ),
);