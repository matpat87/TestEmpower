<?php
// created: 2021-01-28 12:15:35
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
  'oem_account_c' => 
  array (
    'type' => 'relate',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_OEM_ACCOUNT',
    'id' => 'ACCOUNT_ID_C',
    'link' => true,
    'width' => '10%',
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Accounts',
    'target_record_key' => 'account_id_c',
  ),
  'mkt_markets_ci_customeritems_1_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_MKT_MARKETS_CI_CUSTOMERITEMS_1_FROM_MKT_MARKETS_TITLE',
    'id' => 'MKT_MARKETS_CI_CUSTOMERITEMS_1MKT_MARKETS_IDA',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'MKT_Markets',
    'target_record_key' => 'mkt_markets_ci_customeritems_1mkt_markets_ida',
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