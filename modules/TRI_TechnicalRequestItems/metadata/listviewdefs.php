<?php
$module_name = 'TRI_TechnicalRequestItems';
$listViewDefs [$module_name] = 
array (
  'TRI_TECHNICALREQUESTITEMS_TR_TECHNICALREQUESTS_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TRI_TECHNICALREQUESTITEMS_TR_TECHNICALREQUESTS_FROM_TR_TECHNICALREQUESTS_TITLE',
    'id' => 'TRI_TECHNI0387EQUESTS_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'PRODUCT_NUMBER' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_PRODUCT_NUMBER',
    'width' => '10%',
    'default' => true,
  ),
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'QTY' => 
  array (
    'type' => 'int',
    'label' => 'LBL_QTY',
    'width' => '10%',
    'default' => true,
  ),
  'UOM' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_UOM',
    'width' => '10%',
    'default' => true,
  ),
  'STATUS' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'DUE_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_DUE_DATE',
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
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
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
);
;
?>
