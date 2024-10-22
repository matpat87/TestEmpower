<?php
$module_name = 'RRQ_RegulatoryRequests';
$listViewDefs [$module_name] = 
array (
  'ID_NUM_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_ID_NUM',
    'width' => '10%',
    'link' => true,
  ),
  'STATUS_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_STATUS',
    'width' => '10%',
  ),
  'REQ_DATE_C' => 
  array (
    'type' => 'date',
    'default' => true,
    'label' => 'LBL_REQ_DATE',
    'width' => '10%',
  ),
  
  'ACCOUNTS_RRQ_REGULATORYREQUESTS_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_ACCOUNTS_RRQ_REGULATORYREQUESTS_1_FROM_ACCOUNTS_TITLE',
    'id' => 'ACCOUNTS_RRQ_REGULATORYREQUESTS_1ACCOUNTS_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'CONTACTS_RRQ_REGULATORYREQUESTS_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CONTACTS_RRQ_REGULATORYREQUESTS_1_FROM_CONTACTS_TITLE',
    'id' => 'CONTACTS_RRQ_REGULATORYREQUESTS_1CONTACTS_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'TOTAL_REQUESTS_C' => 
  array (
    'type' => 'varchar',
    'link' => true,
    'label' => 'LBL_TOTAL_REQUESTS',
    'width' => '10%',
    'default' => true,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
  ),
);
;
?>
