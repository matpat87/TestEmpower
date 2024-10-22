<?php
$module_name = 'MKT_Markets';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'REGION' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_REGION',
    'width' => '10%',
    'default' => true,
  ),
  'DIVISION' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_DIVISION',
    'width' => '10%',
    'default' => true,
  ),
  'SUB_INDUSTRY_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_SUB_INDUSTRY',
    'width' => '10%',
  ),
  'MACROMARKET' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_MACROMARKET',
    'width' => '10%',
    'default' => true,
  ),
  'POTENTIAL_REVENUE' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_POTENTIAL_REVENUE',
    'currency_format' => true,
    'width' => '10%',
    'default' => true,
  ),
  'GROSS_MARGIN' => 
  array (
    'type' => 'decimal',
    'label' => 'LBL_GROSS_MARGIN',
    'width' => '10%',
    'default' => true,
  ),
  'MARKET_PENETRATION' => 
  array (
    'type' => 'decimal',
    'label' => 'LBL_MARKET_PENETRATION',
    'width' => '10%',
    'default' => true,
  ),
  'DATE_MODIFIED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_MODIFIED',
    'width' => '10%',
    'default' => true,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'REVENUE' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_REVENUE',
    'currency_format' => true,
    'width' => '10%',
    'default' => false,
  ),
);
;
?>
