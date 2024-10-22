<?php
$popupMeta = array (
    'moduleMain' => 'MKT_Markets',
    'varName' => 'MKT_Markets',
    'orderBy' => 'mkt_markets.name',
    'whereClauses' => array (
  'region' => 'mkt_markets.region',
  'industry' => 'mkt_markets.industry',
  'sub_industry_c' => 'mkt_markets_cstm.sub_industry_c',
),
    'searchInputs' => array (
  4 => 'region',
  6 => 'industry',
  7 => 'sub_industry_c',
),
    'searchdefs' => array (
  'industry' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_INDUSTRY',
    'width' => '10%',
    'name' => 'industry',
  ),
  'sub_industry_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SUB_INDUSTRY',
    'width' => '10%',
    'name' => 'sub_industry_c',
  ),
  'region' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_REGION',
    'width' => '10%',
    'name' => 'region',
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'type' => 'varchar',
    'studio' => 'visible',
    'label' => 'LBL_INDUSTRY',
    'width' => '10%',
    'default' => true,
    'name' => 'name',
  ),
  'SUB_INDUSTRY_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_SUB_INDUSTRY',
    'width' => '10%',
  ),
  'DESCRIPTION' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => true,
    'name' => 'description',
  ),
),
);
