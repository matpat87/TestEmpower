<?php
// created: 2021-05-04 11:58:48
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
  'application_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'vname' => 'LBL_APPLICATION',
    'width' => '10%',
  ),
  'sales_cytd_c' => 
  array (
    'type' => 'currency',
    'default' => true,
    'vname' => 'LBL_SALES_CYTD',
    'currency_format' => true,
    'width' => '10%',
  ),
  'sales_pytd_c' => 
  array (
    'type' => 'currency',
    'default' => true,
    'vname' => 'LBL_SALES_PYTD',
    'currency_format' => true,
    'width' => '10%',
  ),
  'date_modified' => 
  array (
    'vname' => 'LBL_DATE_MODIFIED',
    'width' => '45%',
    'default' => true,
  ),
  'account_relate_type' => 
  array (
    'vname' => 'LBL_ACCOUNT_RELATE_TYPE',
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