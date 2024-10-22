<?php
$popupMeta = array (
    'moduleMain' => 'CI_CustomerItems',
    'varName' => 'CI_CustomerItems',
    'orderBy' => 'ci_customeritems.name',
    'whereClauses' => array (
  'name' => 'ci_customeritems.name',
  'part_number' => 'ci_customeritems.part_number',
  'cost' => 'ci_customeritems.cost',
  'price' => 'ci_customeritems.price',
  'created_by_name' => 'ci_customeritems.created_by_name',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'part_number',
  5 => 'cost',
  6 => 'price',
  7 => 'created_by_name',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'part_number' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_PART_NUMBER',
    'width' => '10%',
    'name' => 'part_number',
  ),
  'cost' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_COST',
    'currency_format' => true,
    'width' => '10%',
    'name' => 'cost',
  ),
  'price' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_PRICE',
    'currency_format' => true,
    'width' => '10%',
    'name' => 'price',
  ),
  'created_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'name' => 'created_by_name',
  ),
),
    'listviewdefs' => array (
  'PART_NUMBER' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_PART_NUMBER',
    'width' => '10%',
    'default' => true,
    'name' => 'part_number',
  ),
  'NAME' => 
  array (
    'width' => '15%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
    'name' => 'name',
  ),
  'COST' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_COST',
    'currency_format' => true,
    'width' => '10%',
    'default' => true,
    'name' => 'cost',
  ),
  'PRICE' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_PRICE',
    'currency_format' => true,
    'width' => '10%',
    'default' => true,
    'name' => 'price',
  ),
),
);
