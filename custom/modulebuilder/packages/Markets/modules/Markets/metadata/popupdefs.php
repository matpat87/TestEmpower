<?php
$popupMeta = array (
    'moduleMain' => 'MKT_Markets',
    'varName' => 'MKT_Markets',
    'orderBy' => 'mkt_markets.name',
    'whereClauses' => array (
  'name' => 'mkt_markets.name',
  'region' => 'mkt_markets.region',
  'division' => 'mkt_markets.division',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'region',
  5 => 'division',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'region' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_REGION',
    'width' => '10%',
    'name' => 'region',
  ),
  'division' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_DIVISION',
    'width' => '10%',
    'name' => 'division',
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
    'name' => 'name',
  ),
  'DIVISION' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_DIVISION',
    'width' => '10%',
    'default' => true,
    'name' => 'division',
  ),
  'POTENTIAL_REVENUE' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_POTENTIAL_REVENUE',
    'currency_format' => true,
    'width' => '10%',
    'default' => true,
    'name' => 'potential_revenue',
  ),
  'DESCRIPTION' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => true,
  ),
),
);
