<?php
// created: 2021-04-22 14:21:14
$subpanel_layout['list_fields'] = array (
  'number' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_NUMBER',
    'width' => '10%',
    'default' => true,
  ),
  'status' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'vname' => 'LBL_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'accounts_odr_salesorders_1_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_ACCOUNTS_ODR_SALESORDERS_1_FROM_ACCOUNTS_TITLE',
    'id' => 'ACCOUNTS_ODR_SALESORDERS_1ACCOUNTS_IDA',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Accounts',
    'target_record_key' => 'accounts_odr_salesorders_1accounts_ida',
  ),
  'total_amount' => 
  array (
    'type' => 'currency',
    'vname' => 'LBL_TOTAL_AMOUNT',
    'currency_format' => true,
    'width' => '10%',
    'default' => true,
  ),
  'due_date' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_DUE_DATE',
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