<?php
$module_name = 'RRWG_RRWorkingGroup';
$listViewDefs [$module_name] = 
array (
  'FULL_NAME_NON_DB' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'RR_ROLES' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_RR_ROLES',
    'width' => '10%',
    'default' => true,
  ),
  'RRQ_REGULATORYREQUESTS_RRWG_RRWORKINGGROUP_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_RRQ_REGULATORYREQUESTS_RRWG_RRWORKINGGROUP_1_FROM_RRQ_REGULATORYREQUESTS_TITLE',
    'id' => 'RRQ_REGULA2443EQUESTS_IDA',
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
