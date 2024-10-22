<?php
$dashletData['TR_TechnicalRequestsUpdateDashlet']['searchFields'] = array (
    'tr_update_date_c' => array('default' => 'TP_last_7_days') //Colormatch #314
);
$dashletData['TR_TechnicalRequestsUpdateDashlet']['columns'] = array (
  'technicalrequests_number_c' => 
  array (
    'type' => 'int',
    'default' => true,
    'label' => 'LBL_TECHNICALREQUESTS_NUMBER',
    'width' => '10%',
    'name' => 'technicalrequests_number_c',
  ),
  'name' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'opportunity_c' => 
  array (
    'type' => 'relate',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_OPPORTUNITY',
    'id' => 'OPPORTUNITY_ID_C',
    'link' => true,
    'width' => '10%',
    'name' => 'opportunity_c',
  ),
  'tr_technicalrequests_accounts_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TR_TECHNICALREQUESTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
    'id' => 'TR_TECHNICALREQUESTS_ACCOUNTSACCOUNTS_IDA',
    'width' => '10%',
    'default' => true,
    'name' => 'tr_technicalrequests_accounts_name',
  ),
  'technical_request_update' => 
  array (
    'type' => 'text',
    'label' => 'LBL_UPDATES_SHORT',
    'studio' => 'visible',
    'width' => '10%',
    'default' => true,
    'name' => 'technical_request_update',
  ),
  'tr_update_date_c' => 
  array (
    'type' => 'date',
    'studio' => 'visible',
    'default' => true,
    'label' => 'LBL_TR_UPDATE_DATE',
    'width' => '10%',
    'name' => 'tr_update_date_c',
  ),
);
