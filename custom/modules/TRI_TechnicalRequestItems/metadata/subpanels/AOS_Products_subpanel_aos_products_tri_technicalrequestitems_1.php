<?php
// created: 2021-03-11 06:26:12
$subpanel_layout['list_fields'] = array (
  'technical_request_number_non_db' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_TECHNICAL_REQUEST_NUMBER_NON_DB',
    'id' => 'TRI_TECHNI0387EQUESTS_IDA',
    'width' => '10%',
    'default' => true,
    'sortable' => false,
  ),
  'technical_request_version_non_db' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_TECHNICAL_REQUEST_VERSION_NON_DB',
    'width' => '10%',
    'default' => true,
    'sortable' => false,
  ),
  'product_number' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_PRODUCT_NUMBER',
    'width' => '10%',
    'default' => true,
  ),
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '45%',
    'default' => true,
  ),
  'qty' => 
  array (
    'type' => 'int',
    'vname' => 'LBL_QTY',
    'width' => '10%',
    'default' => true,
  ),
  'uom' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_UOM',
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
  'assigned_user_name' => 
  array (
    'link' => true,
    'type' => 'relate',
    'vname' => 'LBL_ASSIGNED_TO_NAME',
    'id' => 'ASSIGNED_USER_ID',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Users',
    'target_record_key' => 'assigned_user_id',
  ),
  'status' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'vname' => 'LBL_STATUS',
    'width' => '10%',
    'default' => true,
  ),
);