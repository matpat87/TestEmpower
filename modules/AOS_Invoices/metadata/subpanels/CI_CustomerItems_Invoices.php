<?php
// created: 2021-04-22 14:21:14
$subpanel_layout['list_fields'] = array (
  'number' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_INVOICE_NUMBER',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'AOS_Invoices',
    'target_record_key' => 'id',
  ),
  'status' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'vname' => 'LBL_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'billing_account' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_BILLING_ACCOUNT',
    'id' => 'billing_account_id',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Accounts',
    'target_record_key' => 'billing_account_id',
  ),
  'total_amt' => 
  array (
    'type' => 'currency',
    'vname' => 'LBL_TOTAL_AMT',
    'currency_format' => true,
    'width' => '10%',
    'default' => true,
  ),
  'requested_date_c' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_REQUESTED_DATE',
    'width' => '10%',
    'default' => true,
  ),
  'date_entered' => 
  array (
    'type' => 'datetime',
    'vname' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
  ),
  'date_modified' => 
  array (
    'vname' => 'LBL_DATE_MODIFIED',
    'width' => '45%',
    'default' => true,
  ),
);