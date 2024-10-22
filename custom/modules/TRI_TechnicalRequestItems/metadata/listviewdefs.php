<?php
$module_name = 'TRI_TechnicalRequestItems';
$listViewDefs [$module_name] = 
array (
  'TECHNICAL_REQUEST_OPPORTUNITY_NUMBER_NON_DB' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_TECHNICAL_REQUEST_OPPORTUNITY_NUMBER_NON_DB',
    'width' => '10%',
    'default' => true,
  ),
  'TECHNICAL_REQUEST_NUMBER_NON_DB' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_TECHNICAL_REQUEST_NUMBER_NON_DB',
    'width' => '5%',
    'default' => true,
  ),
  'TECHNICAL_REQUEST_VERSION_NON_DB' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_TECHNICAL_REQUEST_VERSION_NON_DB',
    'width' => '5%',
    'default' => true,
  ),
  'TECHNICAL_REQUEST_PRODUCT_NAME_NON_DB' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_TECHNICAL_REQUEST_PRODUCT_NAME_NON_DB',
    'width' => '10%',
    'default' => true,
  ),
  'TECHNICAL_REQUEST_ACCOUNT_NAME_NON_DB' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_TECHNICAL_REQUEST_ACCOUNT_NAME_NON_DB',
    'width' => '10%',
    'default' => true,
  ),
  'PRODUCT_NUMBER' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_PRODUCT_NUMBER',
    'width' => '5%',
    'default' => true,
  ),
  'NAME' => 
  array (
    'width' => '10%',
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
  'STATUS' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'DISTRO_GENERATED_C' => 
  array (
    'type' => 'bool',
    'default' => true,
    'label' => 'LBL_DISTRO_GENERATED',
    'width' => '5%',
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
