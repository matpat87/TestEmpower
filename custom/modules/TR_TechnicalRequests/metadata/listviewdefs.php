<?php
$module_name = 'TR_TechnicalRequests';
$OBJECT_NAME = 'TR_TECHNICALREQUESTS';
$listViewDefs [$module_name] = 
array (
  'CUSTOM_OPPORTUNITY_ID' => 
  array (
    'type' => 'varchar',
    'width' => '5%',
    'label' => 'LBL_CUSTOM_OPPORTUNITY_ID',
    'link' => false,
    'id' => 'TR_TECHNICALREQUESTS_OPPORTUNITIESOPPORTUNITIES_IDA',
    'module' => 'Opportunities',
    'default' => true,
  ),
  'TECHNICALREQUESTS_NUMBER_C' => 
  array (
    'type' => 'varchar',
    'width' => '5%',
    'label' => 'LBL_TECHNICALREQUESTS_NUMBER',
    'link' => true,
    'default' => true,
  ),
  'PRODUCT_MASTER_NON_DB' => 
  array (
    'type' => 'varchar',
    'width' => '5%',
    'label' => 'LBL_PRODUCT_MASTER_NON_DB',
    'link' => false,
    'default' => true,
  ),
  'VERSION_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_VERSION',
    'width' => '10%',
  ),
  'NAME' => 
  array (
    'width' => '20%',
    'label' => 'LBL_SUBJECT',
    'default' => true,
    'link' => true,
  ),
  'TR_TECHNICALREQUESTS_ACCOUNTS_NAME' => 
  array (
    'type' => 'relate',
    'link' => false,
    'label' => 'LBL_TR_TECHNICALREQUESTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
    'id' => 'TR_TECHNICALREQUESTS_ACCOUNTSACCOUNTS_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'TYPE' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_TYPE',
    'width' => '10%',
    'default' => true,
  ),
  'APPROVAL_STAGE' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_APPROVAL_STAGE',
    'width' => '10%',
  ),
  'STATUS' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_STATUS',
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
  'SITE' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_SITE',
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
  'RELATED_TECHNICAL_REQUEST_C' => 
  array (
    'type' => 'relate',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_RELATED_TECHNICAL_REQUEST',
    'id' => 'TR_TECHNICALREQUESTS_ID_C',
    'link' => true,
    'width' => '10%',
  ),
  'ACTUAL_CLOSE_DATE_C' => 
  array (
    'type' => 'date',
    'default' => true,
    'label' => 'LBL_ACTUAL_CLOSE_DATE',
    'width' => '10%',
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
  ),
  'CREATED_BY_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'default' => true,
  ),
  'LAST_ACTIVITY_DATE_C' =>
  array (
    'type' => 'datetimecombo',
    'default' => true,
    'label' => 'LBL_LAST_ACTIVITY_DATE',
    'width' => '10%',
  ),
);
;
?>
