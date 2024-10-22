<?php
$dashletData['TR_TechnicalRequestsDashlet']['searchFields'] = array (
  'approval_stage' => 
  array (
    'default' => '',
  ),
  'status' => 
  array (
    'default' => '',
  ),
  'req_completion_date_c' => 
  array (
    'default' => '',
  ),
);
$dashletData['TR_TechnicalRequestsDashlet']['columns'] = array (
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
  'req_completion_date_c' => 
  array (
    'type' => 'date',
    'studio' => 'visible',
    'default' => true,
    'label' => 'LBL_REQ_COMPLETION_DATE_SHORT',
    'width' => '10%',
    'name' => 'req_completion_date_c',
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
  'status' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_STATUS',
    'studio' => 'visible',
    'width' => '10%',
    'default' => true,
    'name' => 'status',
  ),
);
