<?php
// created: 2023-06-20 16:43:35
$subpanel_layout['list_fields'] = array (
  'rr_number_non_db' => 
  array (
    'type' => 'varchar',
    'link' => true,
    'vname' => 'LBL_RR_NUMBER_NON_DB',
    'id' => 'RRQ_REGULA2443EQUESTS_IDA',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'RRQ_RegulatoryRequests',
    'target_record_key' => 'rrq_regula2443equests_ida',
  ),
  'rr_roles' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'vname' => 'LBL_RR_ROLES',
    'id' => 'ID',
    'link' => true,
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'RRWG_RRWorkingGroup',
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
    'module' => 'RRWG_RRWorkingGroup',
    'width' => '4%',
    'default' => true,
  ),
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'RRWG_RRWorkingGroup',
    'width' => '5%',
    'default' => true,
  ),
);