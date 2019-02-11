<?php
$popupMeta = array (
    'moduleMain' => 'TR_TechnicalRequests',
    'varName' => 'TR_TechnicalRequests',
    'orderBy' => 'tr_technicalrequests.name',
    'whereClauses' => array (
  'name' => 'tr_technicalrequests.name',
  'tr_technicalrequests_number' => 'tr_technicalrequests.tr_technicalrequests_number',
  'tr_technicalrequests_accounts_name' => 'tr_technicalrequests.tr_technicalrequests_accounts_name',
  'resolution' => 'tr_technicalrequests.resolution',
  'status' => 'tr_technicalrequests.status',
  'priority' => 'tr_technicalrequests.priority',
  'assigned_user_id' => 'tr_technicalrequests.assigned_user_id',
  'division' => 'tr_technicalrequests.division',
  'salesregion' => 'tr_technicalrequests.salesregion',
  'approval_stage' => 'tr_technicalrequests.approval_stage',
  'date_entered' => 'tr_technicalrequests.date_entered',
),
    'searchInputs' => array (
  0 => 'tr_technicalrequests_number',
  1 => 'name',
  2 => 'priority',
  3 => 'status',
  4 => 'tr_technicalrequests_accounts_name',
  5 => 'resolution',
  6 => 'assigned_user_id',
  7 => 'division',
  8 => 'salesregion',
  9 => 'approval_stage',
  10 => 'date_entered',
),
    'searchdefs' => array (
  'tr_technicalrequests_number' => 
  array (
    'name' => 'tr_technicalrequests_number',
    'width' => '10%',
  ),
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'tr_technicalrequests_accounts_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TR_TECHNICALREQUESTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
    'id' => 'TR_TECHNICALREQUESTS_ACCOUNTSACCOUNTS_IDA',
    'width' => '10%',
    'name' => 'tr_technicalrequests_accounts_name',
  ),
  'resolution' => 
  array (
    'name' => 'resolution',
    'width' => '10%',
  ),
  'status' => 
  array (
    'name' => 'status',
    'width' => '10%',
  ),
  'priority' => 
  array (
    'name' => 'priority',
    'width' => '10%',
  ),
  'assigned_user_id' => 
  array (
    'name' => 'assigned_user_id',
    'type' => 'enum',
    'label' => 'LBL_ASSIGNED_TO',
    'function' => 
    array (
      'name' => 'get_user_array',
      'params' => 
      array (
        0 => false,
      ),
    ),
    'width' => '10%',
  ),
  'division' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_DIVISION',
    'width' => '10%',
    'name' => 'division',
  ),
  'salesregion' => 
  array (
    'type' => 'multienum',
    'studio' => 'visible',
    'label' => 'LBL_SALESREGION',
    'width' => '10%',
    'name' => 'salesregion',
  ),
  'approval_stage' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_APPROVAL_STAGE',
    'width' => '10%',
    'name' => 'approval_stage',
  ),
  'date_entered' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'name' => 'date_entered',
  ),
),
);
