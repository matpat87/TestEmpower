<?php
$module_name = 'Time';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'TIME' => 
  array (
    'type' => 'float',
    'label' => 'LBL_TIME',
    'width' => '10%',
    'default' => true,
  ),
  'PARENT_NAME_NON_DB' => 
  array (
    'type' => 'varchar',
    'studio' => 'visible',
    'label' => 'LBL_FLEX_RELATE',
    'sortable' => false,
    'width' => '10%',
    'default' => true,
  ),
  'DATE_WORKED' => 
  array (
    'type' => 'date',
    'label' => 'LBL_DATE_WORKED',
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
