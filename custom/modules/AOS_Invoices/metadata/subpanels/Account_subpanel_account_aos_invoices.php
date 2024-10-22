<?php
// created: 2022-05-01 15:15:56
$subpanel_layout['list_fields'] = array (
  'number' => 
  array (
    'width' => '5%',
    'vname' => 'LBL_LIST_NUM',
    'default' => true,
  ),
  'custom_item_number' => 
  array (
    'width' => '5%',
    'vname' => 'LBL_CUSTOM_ITEM_NUMBER',
    'default' => true,
  ),
  'status' => 
  array (
    'width' => '10%',
    'vname' => 'LBL_STATUS',
    'default' => true,
  ),
  'billing_contact' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'vname' => 'LBL_BILLING_CONTACT',
    'id' => 'BILLING_CONTACT_ID',
    'link' => true,
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Contacts',
    'target_record_key' => 'billing_contact_id',
  ),
  'total_amount' => 
  array (
    'width' => '10%',
    'vname' => 'LBL_GRAND_TOTAL',
    'default' => true,
    'currency_format' => true,
  ),
  'order_date_c' => 
  array (
    'type' => 'date',
    'default' => true,
    'vname' => 'LBL_ORDER_DATE',
    'width' => '10%',
  ),
  'custom_shipped_date' => 
  array (
    'type' => 'date',
    'default' => true,
    'vname' => 'LBL_CUSTOM_SHIPPED_DATE',
    'width' => '10%',
  ),
  'po_number_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'vname' => 'LBL_PO_NUMBER',
    'width' => '10%',
  ),
  'edit_button' => 
  array (
    'widget_class' => 'SubPanelEditButton',
    'module' => 'AOS_Invoices',
    'width' => '4%',
    'default' => true,
  ),
  'remove_button' => 
  array (
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'AOS_Invoices',
    'width' => '5%',
    'default' => true,
  ),
);