<?php
// created: 2023-03-30 08:57:28
$listViewDefs['Emails'] = array (
  'SUBJECT' => 
  array (
    'width' => '32',
    'label' => 'LBL_LIST_SUBJECT',
    'default' => true,
    'link' => false,
    'customCode' => '',
    'sortable' => false,
  ),
  'HAS_ATTACHMENT' => 
  array (
    'width' => '32',
    'label' => 'LBL_HAS_ATTACHMENT_INDICATOR',
    'default' => true,
    'sortable' => false,
    'hide_header_label' => true,
  ),
  'FROM_ADDR_NAME' => 
  array (
    'width' => '32',
    'label' => 'LBL_LIST_FROM_ADDR',
    'default' => true,
    'sortable' => false,
  ),
  'INDICATOR' => 
  array (
    'width' => '32%',
    'label' => 'LBL_INDICATOR',
    'default' => true,
    'sortable' => false,
    'hide_header_label' => true,
  ),
  'DATE_ENTERED' => 
  array (
    'width' => '32',
    'label' => 'LBL_DATE_ENTERED',
    'default' => true,
    'sortable' => false,
  ),
  'PARENT_TYPE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_PARENT_TYPE',
    'width' => '10%',
    'default' => true,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
    'sortable' => false,
  ),
  'CATEGORY_ID' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_CATEGORY',
    'default' => false,
    'sortable' => false,
  ),
  'TO_ADDRS_NAMES' => 
  array (
    'width' => '32',
    'label' => 'LBL_LIST_TO_ADDR',
    'default' => false,
    'sortable' => false,
  ),
  'DATE_SENT_RECEIVED' => 
  array (
    'width' => '32',
    'label' => 'LBL_LIST_DATE_SENT_RECEIVED',
    'default' => false,
    'sortable' => false,
    'force_show_sort_direction' => true,
  ),
);