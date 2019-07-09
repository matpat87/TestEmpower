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
  'assigned_user_name' => 'ci_customeritems.assigned_user_name',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'part_number',
  5 => 'cost',
  6 => 'price',
  8 => 'assigned_user_name',
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
  'assigned_user_name' => 
  array (
    'link' => true,
    'type' => 'relate',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'id' => 'ASSIGNED_USER_ID',
    'width' => '10%',
    'name' => 'assigned_user_name',
    'ACLTag' => 'USER',
    'related_fields' => 
    array (
      0 => 'assigned_user_id',
    ),
    'value' => $_REQUEST['assigned_user_name'],
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
