<?php
$module_name = 'AAR_AccountActivityReport';
$listViewDefs [$module_name] = 
array (
  'CUSTOM_STATUS' => 
  array (
    'type' => 'text',
    'label' => 'LBL_CUSTOM_STATUS',
    'sortable' => true,
    'width' => '10%',
    'default' => true,
  ),
  'CUSTOM_ASSIGNED_TO' => 
  array (
    'type' => 'text',
    'label' => 'LBL_CUSTOM_ASSIGNED',
    'sortable' => true,
    'width' => '10%',
    'default' => true,
  ),
  'DATE_START_C' => 
  array (
    'type' => 'text',
    'label' => 'LBL_CUSTOM_DATE',
    'sortable' => true,
    'width' => '10%',
    'default' => true,
  ),
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => false,
  ),
  'CUSTOM_ACCOUNT' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_CUSTOM_ACCOUNT',
    'width' => '10%',
    'default' => true,
  ),
  'CUSTOM_RELATED_TO' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_CUSTOM_RELATED_TO',
    'width' => '10%',
    'default' => true,
  ),
);
;
?>
