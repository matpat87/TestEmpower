<?php
$module_name = 'SAR_SalesActivityReport';
$listViewDefs [$module_name] = 
array (
  'STATUS_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_STATUS',
    'width' => '10%',
  ),
  'ASSIGNED_TO_NAME_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'width' => '10%',
  ),
  'DATE_START_C' => 
  array (
    'type' => 'date',
    'default' => true,
    'label' => 'LBL_DATE_START',
    'width' => '10%',
  ),
  'NAME' => 
  array (
    'width' => '25%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => false,
  ),
  'ACCOUNT_NAME_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_ACCOUNT_NAME',
    'width' => '10%',
  ),
  'SHIPPING_ADDRESS_CITY_C' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SHIPPING_ADDRESS_CITY',
    'width' => '10%',
    'default' => true,
  ),
  'SHIPPING_ADDRESS_STATE_C' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SHIPPING_ADDRESS_STATE',
    'width' => '10%',
    'default' => true,
  ),
  'RELATED_TO_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_RELATED_TO',
    'width' => '10%',
  ),
);
;
?>
