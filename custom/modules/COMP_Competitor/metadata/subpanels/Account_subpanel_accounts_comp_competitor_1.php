<?php
// created: 2021-11-29 07:52:41
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '45%',
    'default' => true,
  ),
  'sales_position' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_SALES_POSITION',
    'width' => '10%',
    'default' => true,
  ),
  'percent_of_business' => 
  array (
    'type' => 'int',
    'default' => true,
    'vname' => 'LBL_PERCENT_OF_BUSINESS',
    'width' => '10%',
  ),
  'edit_button' => 
  array (
    'vname' => 'LBL_EDIT_BUTTON',
    'widget_class' => 'SubPanelEditButton',
    'module' => 'COMP_Competitor',
    'width' => '4%',
    'default' => true,
  ),
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'COMP_Competitor',
    'width' => '5%',
    'default' => true,
  ),
);