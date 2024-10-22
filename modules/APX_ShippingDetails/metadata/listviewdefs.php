<?php
$module_name = 'APX_ShippingDetails';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'CARRIER' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CARRIER',
    'width' => '10%',
    'default' => true,
  ),
  'DELIVERED_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_DELIVERED_DATE',
    'width' => '10%',
    'default' => true,
  ),
  'PACKING_LIST_NUMBER' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_PACKING_LIST_NUMBER',
    'width' => '10%',
    'default' => true,
  ),
  'PL_LINE_NUMBER' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_PL_LINE_NUMBER',
    'width' => '10%',
    'default' => true,
  ),
  'QTY_SHIPPED' => 
  array (
    'type' => 'int',
    'label' => 'LBL_QTY_SHIPPED',
    'width' => '10%',
    'default' => true,
  ),
  'TOTAL_NUMBER_OF_SKIDS' => 
  array (
    'type' => 'int',
    'label' => 'LBL_TOTAL_NUMBER_OF_SKIDS',
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
  'CREATED_BY_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'default' => true,
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
  ),
);
;
?>
