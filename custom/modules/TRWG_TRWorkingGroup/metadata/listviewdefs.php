<?php
$module_name = 'TRWG_TRWorkingGroup';
$listViewDefs [$module_name] = 
array (
  'FULL_NAME_NON_DB' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'TR_ROLES' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_TR_ROLES',
    'width' => '10%',
    'default' => true,
  ),
  'TR_TECHNICALREQUESTS_TRWG_TRWORKINGGROUP_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TR_TECHNICALREQUESTS_TRWG_TRWORKINGGROUP_1_FROM_TR_TECHNICALREQUESTS_TITLE',
    'id' => 'TR_TECHNIC9742EQUESTS_IDA',
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
