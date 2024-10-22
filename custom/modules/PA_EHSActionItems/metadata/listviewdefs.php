<?php
$module_name = 'PA_EHSActionItems';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'EHS_EHS_PA_EHSACTIONITEMS_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_EHS_EHS_PA_EHSACTIONITEMS_1_FROM_EHS_EHS_TITLE',
    'id' => 'EHS_EHS_PA_EHSACTIONITEMS_1EHS_EHS_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'SEVERITY' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_SEVERITY',
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
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
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
