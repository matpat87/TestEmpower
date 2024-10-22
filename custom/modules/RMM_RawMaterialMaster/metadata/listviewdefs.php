<?php
$module_name = 'RMM_RawMaterialMaster';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'COLOR_INDEX_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_COLOR_INDEX_NAME',
    'width' => '10%',
    'default' => true,
  ),
  'CHEMICAL_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CHEMICAL_NAME',
    'width' => '10%',
    'default' => true,
  ),
  'CAS_NUMBER' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CAS_NUMBER',
    'width' => '10%',
    'default' => true,
  ),
  'TYPE_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_TYPE',
    'width' => '10%',
  ),
  'GRADE_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_GRADE',
    'width' => '10%',
  ),
  'COLOR_FAMILY_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_COLOR_FAMILY',
    'width' => '10%',
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => false,
  ),
  'PRODUCT_NUMBER' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_PRODUCT_NUMBER',
    'width' => '10%',
    'default' => false,
  ),
);
;
?>
