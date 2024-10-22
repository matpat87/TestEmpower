<?php
// created: 2022-11-23 08:40:10
$subpanel_layout['list_fields'] = array (
  'custom_distribution_number_c' => 
  array (
    'type' => 'int',
    'default' => true,
    'vname' => 'LBL_DISTRIBUTION_NUMBER',
    'width' => '5%',
    'sortable' => true,
    'link' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'DSBTN_Distribution',
    'target_record_key' => 'dsbtn_distribution_id_c',
    'id' => 'DSBTN_DISTRIBUTION_ID_C',

  ),
  'custom_account_c' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_ACCOUNT_NAME',
    'id' => 'CUSTOM_ACCOUNT_ID_C',
    'width' => '20%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Accounts',
    'target_record_key' => 'custom_account_id_c',
  ),
  'distribution_c' => 
  array (
    'type' => 'relate',
    'default' => true,
    'sortable' => true,
    'studio' => 'visible',
    'vname' => 'LBL_NAME',
    'id' => 'DSBTN_DISTRIBUTION_ID_C',
    'width' => '10%',
  ),
  'distribution_item_c' => 
  array (
    'type' => 'enum',
    'default' => true,
    'sortable' => true,
    'studio' => 'visible',
    'vname' => 'LBL_DISTRIBUTION_ITEM',
    'width' => '10%',
  ),
  'qty_c' => 
  array (
    'type' => 'decimal',
    'default' => true,
    'vname' => 'LBL_QTY',
    'width' => '10%',
  ),
  'uom_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'vname' => 'LBL_UOM',
    'width' => '10%',
  ),
  'shipping_method_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'vname' => 'LBL_SHIPPING_METHOD',
    'width' => '10%',
  ),
  'account_information_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'vname' => 'LBL_ACCOUNT_INFORMATION',
    'width' => '10%',
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
  'status_c' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_STATUS',
    'width' => '10%',
  ),
  'date_completed_c' => 
  array (
    'type' => 'datetimecombo',
    'default' => true,
    'vname' => 'LBL_DATE_COMPLETED',
    'width' => '10%',
  ),
);