<?php
$module_name = 'CWG_CAPAWorkingGroup';
$listViewDefs [$module_name] = 
array (
  'FULL_NAME_NON_DB' => 
  array (
    'type' => 'name',
    'label' => 'LBL_NAME',
    'width' => '10%',
    'default' => true,
  ),
  'CAPA_ROLES' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_CAPA_ROLES',
    'width' => '10%',
    'default' => true,
  ),
  'CASES_CWG_CAPAWORKINGGROUP_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CASES_CWG_CAPAWORKINGGROUP_1_FROM_CASES_TITLE',
    'id' => 'CASES_CWG_CAPAWORKINGGROUP_1CASES_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => false,
  ),
);
;
?>
