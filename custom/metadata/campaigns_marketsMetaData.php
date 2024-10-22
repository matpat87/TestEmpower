<?php
$dictionary["campaigns_markets"] = array ( //The table name
  'true_relationship_type' => 'many-to-many', //Relationship type
  'relationships' => 
  array (
    'campaigns_markets' =>  //table name
    array (
      'lhs_module' => 'Campaigns', //Module name as per directory
      'lhs_table' => 'campaigns', //Table Name
      'lhs_key' => 'id', //should be id
      'rhs_module' => 'MKT_Markets', //Module name as per directory
      'rhs_table' => 'mkt_markets', //Table Name
      'rhs_key' => 'id', //should be id
      'relationship_type' => 'many-to-many', //Relationship type
      'join_table' => 'campaigns_markets',//Table name
      'join_key_lhs' => 'campaign_id', //ID reference of the left side module 
      'join_key_rhs' => 'market_id', //ID reference of the right side module
    ),
  ),
  'table' => 'campaigns_markets', //table name
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id', //ID is needed as a unique id
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified', //Required
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted', //Required
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'campaign_id', //Referenced as the above left key
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'market_id', //Referenced as the above right key
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'campaigns_markets_spk', //Index for the primary key
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'campaigns_markets_alt', //Index for the foreign keys
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'campaign_id', //Change this to the left side key
        1 => 'market_id', //Change this to the right side key
      ),
    ),
  ),
);