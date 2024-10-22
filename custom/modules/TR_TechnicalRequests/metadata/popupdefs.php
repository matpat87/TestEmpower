<?php
$popupMeta = array (
    'moduleMain' => 'TR_TechnicalRequests',
    'varName' => 'TR_TechnicalRequests',
    'orderBy' => 'tr_technicalrequests.name',
    'whereClauses' => array (
  'name' => 'tr_technicalrequests.name',
  'tr_technicalrequests_accounts_name' => 'tr_technicalrequests.tr_technicalrequests_accounts_name',
  'technicalrequests_number_c' => 'tr_technicalrequests_cstm.technicalrequests_number_c',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'tr_technicalrequests_accounts_name',
  11 => 'technicalrequests_number_c',
),
    'searchdefs' => array (
  'technicalrequests_number_c' => 
  array (
    'type' => 'int',
    'label' => 'LBL_TECHNICALREQUESTS_NUMBER',
    'width' => '10%',
    'name' => 'technicalrequests_number_c',
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
),
);
