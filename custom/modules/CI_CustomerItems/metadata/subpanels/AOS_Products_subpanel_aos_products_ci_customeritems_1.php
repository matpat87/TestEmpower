<?php
// created: 2020-09-08 08:17:45
$subpanel_layout['list_fields'] = array (
  'product_number_c' => 
  array (
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_PRODUCT_NUMBER',
    'width' => '10%',
    'module' => 'CI_CustomerItems',
    'widget_class' => 'SubPanelDetailViewLink',
  ),
  'version_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'vname' => 'LBL_VERSION',
    'width' => '10%',
  ),
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'width' => '45%',
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
  'price' => 
  array (
    'type' => 'currency',
    'vname' => 'LBL_PRICE',
    'currency_format' => true,
    'width' => '10%',
    'default' => true,
  ),
  'ci_customeritems_accounts_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_CI_CUSTOMERITEMS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
    'id' => 'CI_CUSTOMERITEMS_ACCOUNTSACCOUNTS_IDA',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Accounts',
    'target_record_key' => 'ci_customeritems_accountsaccounts_ida',
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
  'edit_button' => 
  array (
    'vname' => 'LBL_EDIT_BUTTON',
    'widget_class' => 'SubPanelEditButton',
    'module' => 'CI_CustomerItems',
    'width' => '4%',
    'default' => true,
  ),
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'CI_CustomerItems',
    'width' => '5%',
    'default' => true,
  ),
);