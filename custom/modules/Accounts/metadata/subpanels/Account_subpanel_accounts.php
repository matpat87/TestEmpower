<?php
// created: 2020-02-26 14:02:28
$subpanel_layout['list_fields'] = array (
  'status_c' => 
  array (
    'vname' => 'LBL_RELATED_ACCOUNTS_STATUS',
    'width' => '45%',
    'default' => true,
  ),
  'name' => 
  array (
    'type' => 'name',
    'vname' => 'LBL_RELATED_ACCOUNTS_CUSTOMER_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '10%',
    'default' => true,
  ),
  'account_type' => 
  array (
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_RELATED_ACCOUNTS_CUSTOMER_TYPE',
    'width' => '10%',
  ),
  'cust_num_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'vname' => 'LBL_RELATED_ACCOUNTS_CUSTOMER_NUMBER',
    'width' => '10%',
  ),
  'billing_address_street' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_RELATED_ACCOUNTS_STREET_ADDRESS',
    'width' => '10%',
    'default' => true,
  ),
  'billing_address_city' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_RELATED_ACCOUNTS_CITY',
    'width' => '10%',
    'default' => true,
  ),
  'billing_address_state' => 
  array (
    'type' => 'enum',
    'vname' => 'LBL_RELATED_ACCOUNTS_STATE',
    'width' => '10%',
    'default' => true,
  ),
  'billing_address_country' => 
  array (
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_RELATED_ACCOUNTS_COUNTRY',
    'width' => '10%',
  ),
  'edit_button' => 
  array (
    'vname' => 'LBL_EDIT_BUTTON',
    'widget_class' => 'SubPanelEditButton',
    'width' => '4%',
    'default' => true,
  ),
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButtonAccount',
    'width' => '4%',
    'default' => true,
  ),
  'parent_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_RELATED_ACCOUNTS_RELATED_ACCT',
    'id' => 'PARENT_ID',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Accounts',
    'target_record_key' => 'parent_id',
  ),
  'assigned_user_name' => 
  array (
    'link' => true,
    'type' => 'relate',
    'vname' => 'LBL_RELATED_ACCOUNTS_ASSIGNED_TO',
    'id' => 'ASSIGNED_USER_ID',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Users',
    'target_record_key' => 'assigned_user_id',
  ),
  
);