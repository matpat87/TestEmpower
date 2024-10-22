<?php
$module_name = 'PWG_ProjectWorkgroup';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'PARENT_TYPE_NON_DB' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_PARENT_TYPE',
    'width' => '10%',
    'default' => true,
  ),
  'PARENT_NAME_NON_DB' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_FLEX_RELATE',
    'width' => '10%',
    'default' => true,
    'sortable' => false,
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
