<?php
// created: 2023-07-24 15:12:35
$subpanel_layout['list_fields'] = array (
  'id_num_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'vname' => 'LBL_ID_NUM',
    'width' => '10%',
    'widget_class' => 'SubPanelDetailViewLink',
  ),
  'status_c' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_STATUS',
    'width' => '10%',
  ),
  'req_date_c' => 
  array (
    'type' => 'date',
    'default' => true,
    'vname' => 'LBL_REQ_DATE',
    'width' => '10%',
  ),
  'accounts_rrq_regulatoryrequests_1_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_ACCOUNTS_RRQ_REGULATORYREQUESTS_1_FROM_ACCOUNTS_TITLE',
    'id' => 'ACCOUNTS_RRQ_REGULATORYREQUESTS_1ACCOUNTS_IDA',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Accounts',
    'target_record_key' => 'accounts_rrq_regulatoryrequests_1accounts_ida',
  ),
  'contacts_rrq_regulatoryrequests_1_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_CONTACTS_RRQ_REGULATORYREQUESTS_1_FROM_CONTACTS_TITLE',
    'id' => 'CONTACTS_RRQ_REGULATORYREQUESTS_1CONTACTS_IDA',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Contacts',
    'target_record_key' => 'contacts_rrq_regulatoryrequests_1contacts_ida',
  ),
  'total_requests_c' => 
  array (
    'type' => 'int',
    'default' => true,
    'vname' => 'LBL_TOTAL_REQUESTS',
    'width' => '10%',
    'widget_class' => 'SubPanelDetailViewLink',
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
  'date_entered' => 
  array (
    'type' => 'datetime',
    'vname' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
  ),
  'edit_button' => 
  array (
    'vname' => 'LBL_EDIT_BUTTON',
    'widget_class' => 'SubPanelEditButton',
    'module' => 'RRQ_RegulatoryRequests',
    'width' => '4%',
    'default' => true,
  ),
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'RRQ_RegulatoryRequests',
    'width' => '5%',
    'default' => true,
  ),
);