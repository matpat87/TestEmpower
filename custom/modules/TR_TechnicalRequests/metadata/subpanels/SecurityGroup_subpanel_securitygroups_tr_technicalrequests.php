<?php
// created: 2020-12-03 14:06:29
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
  'status' => 
  array (
    'vname' => 'LBL_STATUS',
    'width' => '15%',
    'default' => true,
  ),
  'resolution' => 
  array (
    'vname' => 'LBL_RESOLUTION',
    'width' => '15%',
    'default' => true,
  ),
  'priority' => 
  array (
    'vname' => 'LBL_PRIORITY',
    'width' => '11%',
    'default' => true,
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