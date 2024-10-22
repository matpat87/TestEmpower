<?php
// created: 2020-07-01 06:16:28
$subpanel_layout['list_fields'] = array (
  'technicalrequests_number_c' => 
  array (
    'type' => 'int',
    'studio' => 
    array (
      'quickcreate' => false,
    ),
    'vname' => 'LBL_TECHNICALREQUESTS_NUMBER',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '10%',
    'default' => true,
  ),
  'version_c' => 
  array (
    'width' => '10%',
    'vname' => 'LBL_VERSION',
    'default' => true,
  ),
  'name' => 
  array (
    'vname' => 'LBL_SUBJECT',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '45%',
    'default' => true,
  ),
  'type' => 
  array (
    'type' => 'enum',
    'vname' => 'LBL_TYPE',
    'width' => '10%',
    'default' => true,
  ),
  'approval_stage' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_APPROVAL_STAGE',
    'width' => '10%',
  ),
  'priority_level_c' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_PRIORITY_LEVEL',
    'width' => '10%',
  ),
  'annual_volume_c' => 
  array (
    'type' => 'decimal',
    'default' => true,
    'vname' => 'LBL_ANNUAL_VOLUME',
    'width' => '10%',
  ),
  'annual_amount_c' => 
  array (
    'type' => 'currency',
    'default' => true,
    'vname' => 'LBL_ANNUAL_AMOUNT',
    'currency_format' => true,
    'width' => '10%',
  ),
  'assigned_user_name' => 
  array (
    'name' => 'assigned_user_name',
    'vname' => 'LBL_ASSIGNED_TO_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'target_record_key' => 'assigned_user_id',
    'target_module' => 'Employees',
    'width' => '10%',
    'default' => true,
  ),
  'edit_button' => 
  array (
    'vname' => 'LBL_EDIT_BUTTON',
    'widget_class' => 'SubPanelEditButton',
    'module' => 'TR_TechnicalRequests',
    'width' => '4%',
    'default' => true,
  ),
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'TR_TechnicalRequests',
    'width' => '5%',
    'default' => true,
  ),
);