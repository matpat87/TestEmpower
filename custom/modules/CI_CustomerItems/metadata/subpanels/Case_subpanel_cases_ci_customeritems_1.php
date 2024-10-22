<?php
// created: 2021-10-28 09:18:20
$subpanel_layout['list_fields'] = array (
  'product_number_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_PRODUCT_NUMBER',
    'width' => '10%',
  ),
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '45%',
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