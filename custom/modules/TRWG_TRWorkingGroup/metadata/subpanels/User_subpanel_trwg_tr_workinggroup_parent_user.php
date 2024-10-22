<?php
// created: 2022-11-23 16:01:04
$subpanel_layout['list_fields'] = array (
  'tr_number_c_nondb' => 
  array (
    'type' => 'varchar',
    'link' => true,
    'vname' => 'LBL_TR_NUMBER_NON_DB',
    'id' => 'TR_TECHNIC9742EQUESTS_IDA',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'TR_TechnicalRequests',
    'target_record_key' => 'tr_technic9742equests_ida',
  ),
  'tr_roles' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'vname' => 'LBL_TR_ROLES',
    'id' => 'ID',
    'link' => true,
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'TRWG_TRWorkingGroup',
    'target_record_key' => 'id',
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
  'edit_button' => 
  array (
    'vname' => 'LBL_EDIT_BUTTON',
    'widget_class' => 'SubPanelEditButton',
    'module' => 'TRWG_TRWorkingGroup',
    'width' => '4%',
    'default' => true,
  ),
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'TRWG_TRWorkingGroup',
    'width' => '5%',
    'default' => true,
  ),
);