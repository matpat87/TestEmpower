<?php
$module_name = 'COMP_Competitor';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_COMPETITOR',
    'default' => true,
    'link' => true,
  ),
  'SALES_POSITION' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SALES_POSITION',
    'width' => '10%',
    'default' => true,
  ),
  'PERCENT_OF_BUSINESS' => 
  array (
    'type' => 'decimal',
    'label' => 'LBL_PERCENT_OF_BUSINESS',
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
);
;
?>
