<?php
$module_name = 'TR_TechnicalRequests';
$OBJECT_NAME = 'TR_TECHNICALREQUESTS';
$listViewDefs [$module_name] = 
array (
  'TR_TECHNICALREQUESTS_NUMBER' => 
  array (
    'width' => '5%',
    'label' => 'LBL_NUMBER',
    'link' => true,
    'default' => true,
  ),
  'NAME' => 
  array (
    'width' => '20%',
    'label' => 'LBL_SUBJECT',
    'default' => true,
    'link' => true,
  ),
  'APPROVAL_STAGE' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_APPROVAL_STAGE',
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
);
;
?>
