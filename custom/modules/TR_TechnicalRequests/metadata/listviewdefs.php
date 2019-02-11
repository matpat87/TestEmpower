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
  'TR_TECHNICALREQUESTS_ACCOUNTS_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TR_TECHNICALREQUESTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
    'id' => 'TR_TECHNICALREQUESTS_ACCOUNTSACCOUNTS_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'TR_TECHNICALREQUESTS_OPPORTUNITIES_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TR_TECHNICALREQUESTS_OPPORTUNITIES_FROM_OPPORTUNITIES_TITLE',
    'id' => 'TR_TECHNICALREQUESTS_OPPORTUNITIESOPPORTUNITIES_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'TR_TECHNICALREQUESTS_PROJECT_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TR_TECHNICALREQUESTS_PROJECT_FROM_PROJECT_TITLE',
    'id' => 'TR_TECHNICALREQUESTS_PROJECTPROJECT_IDB',
    'width' => '10%',
    'default' => true,
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
