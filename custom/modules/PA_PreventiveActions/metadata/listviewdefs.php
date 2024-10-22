<?php
$module_name = 'PA_PreventiveActions';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'CASES_PA_PREVENTIVEACTIONS_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CASES_PA_PREVENTIVEACTIONS_1_FROM_CASES_TITLE',
    'id' => 'CASES_PA_PREVENTIVEACTIONS_1CASES_IDA',
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
  'SITE_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_SITE',
    'width' => '10%',
  ),
  'DEPARTMENT_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_DEPARTMENT',
    'width' => '10%',
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
);
;
?>
