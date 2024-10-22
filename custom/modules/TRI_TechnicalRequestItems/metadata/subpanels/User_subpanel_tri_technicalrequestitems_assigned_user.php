<?php
// created: 2022-11-23 07:37:30
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '45%',
    'default' => true,
  ),
  'users_tri_technicalrequestsitems_tr_number_non_db' => 
  array (
    'type' => 'varchar',
    'link' => true,
    'vname' => 'LBL_TRI_TECHNICALREQUESTSITEMS_TR_NUMBER',
    'id' => 'TRI_TECHNI0387EQUESTS_IDA',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'TR_TechnicalRequests',
    'target_record_key' => 'tri_techni0387equests_ida',
  ),
  'qty' => 
  array (
    'type' => 'decimal',
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
  'est_completion_date_c' => 
  array (
    'type' => 'date',
    'default' => true,
    'vname' => 'LBL_EST_COMPLETION_DATE',
    'width' => '10%',
  ),
  'completed_date_c' => 
  array (
    'type' => 'datetimecombo',
    'default' => true,
    'vname' => 'LBL_COMPLETED_DATE',
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
    'module' => 'TRI_TechnicalRequestItems',
    'width' => '4%',
    'default' => true,
  ),
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'TRI_TechnicalRequestItems',
    'width' => '5%',
    'default' => true,
  ),
);