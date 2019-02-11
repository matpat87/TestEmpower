<?php
$dashletData['TR_TechnicalRequestsDashlet']['searchFields'] = array (
  'date_entered' => 
  array (
    'default' => '',
  ),
  'date_modified' => 
  array (
    'default' => '',
  ),
  'assigned_user_id' => 
  array (
    'type' => 'assigned_user_name',
    'default' => 'Ralph Siasat',
  ),
);
$dashletData['TR_TechnicalRequestsDashlet']['columns'] = array (
  'tr_technicalrequests_accounts_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TR_TECHNICALREQUESTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
    'id' => 'TR_TECHNICALREQUESTS_ACCOUNTSACCOUNTS_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'name' => 
  array (
    'width' => '40%',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'approval_stage' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_APPROVAL_STAGE',
    'width' => '10%',
    'name' => 'approval_stage',
  ),
  'tr_technicalrequests_project_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TR_TECHNICALREQUESTS_PROJECT_FROM_PROJECT_TITLE',
    'id' => 'TR_TECHNICALREQUESTS_PROJECTPROJECT_IDB',
    'width' => '10%',
    'default' => true,
  ),
  'date_modified' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_MODIFIED',
    'name' => 'date_modified',
    'default' => true,
  ),
  'date_entered' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => true,
    'name' => 'date_entered',
  ),
  'created_by' => 
  array (
    'width' => '8%',
    'label' => 'LBL_CREATED',
    'name' => 'created_by',
    'default' => false,
  ),
  'assigned_user_name' => 
  array (
    'width' => '8%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'name' => 'assigned_user_name',
    'default' => false,
  ),
);
