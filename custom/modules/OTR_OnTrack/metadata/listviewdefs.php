<?php
$module_name = 'OTR_OnTrack';
$OBJECT_NAME = 'OTR_ONTRACK';
$listViewDefs [$module_name] = 
array (
  'OTR_ONTRACK_NUMBER' => 
  array (
    'width' => '5%',
    'label' => 'LBL_NUMBER',
    'link' => true,
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
  'STATUS' => 
  array (
    'width' => '10%',
    'label' => 'LBL_STATUS',
    'default' => true,
  ),
  'PHASE_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_PHASE',
    'width' => '10%',
  ),
  'MODULE_C' => 
  array (
    'type' => 'dynamicenum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_MODULE',
    'width' => '10%',
  ),
  'NAME' => 
  array (
    'width' => '28%',
    'label' => 'LBL_SUBJECT',
    'default' => true,
    'link' => true,
  ),
  'TYPE' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_TYPE',
    'width' => '10%',
    'default' => true,
  ),
  'SEVERITY_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_SEVERITY',
    'width' => '10%',
  ),
  'PRIORITY_C' => 
  array (
    'type' => 'int',
    'default' => true,
    'label' => 'LBL_PRIORITY_C',
    'width' => '10%',
  ),
  'CLOSED_DATE_C' => 
  array (
    'type' => 'date',
    'default' => true,
    'label' => 'LBL_CLOSED_DATE',
    'width' => '10%',
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_USER',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'ACTUAL_HOURS_WORKED_C' => 
  array (
    'type' => 'float',
    'default' => true,
    'label' => 'LBL_ACTUAL_HOURS_WORKED',
    'width' => '10%',
  ),
);

?>
