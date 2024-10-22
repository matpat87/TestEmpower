<?php
$popupMeta = array (
    'moduleMain' => 'APX_Lots',
    'varName' => 'APX_Lots',
    'orderBy' => 'apx_lots.name',
    'whereClauses' => array (
  'name' => 'apx_lots.name',
  'account_name_non_db' => 'apx_lots.account_name_non_db',
  'customer_product_number_non_db' => 'apx_lots.customer_product_number_non_db',
  'invoice_po_number_non_db' => 'apx_lots.invoice_po_number_non_db',
  'invoice_number_non_db' => 'apx_lots.invoice_number_non_db',
  'invoice_line_item_shipped_date_non_db' => 'apx_lots.invoice_line_item_shipped_date_non_db',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'account_name_non_db',
  6 => 'customer_product_number_non_db',
  7 => 'invoice_po_number_non_db',
),
    'searchdefs' => array (
  'account_name_non_db' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ACCOUNT_NAME',
    'width' => '10%',
    'name' => 'account_name_non_db',
  ),
  'invoice_po_number_non_db' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_INVOICE_PO_NUMBER',
    'width' => '10%',
    'name' => 'invoice_po_number_non_db',
  ),
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'customer_product_number_non_db' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CUSTOMER_PRODUCT_NUMBER',
    'width' => '10%',
    'name' => 'customer_product_number_non_db',
  ),
  'invoice_number_non_db' =>
  array (
    'type' => 'varchar',
    'label' => 'LBL_INVOICE_NUMBER',
    'width' => '10%',
    'name' => 'invoice_number_non_db',
  ),
  'invoice_line_item_shipped_date_non_db' =>
  array (
    'type' => 'date',
    'label' => 'LBL_INVOICE_LINE_ITEM_SHIPPED_DATE',
    'width' => '10%',
    'name' => 'invoice_line_item_shipped_date_non_db',
  ),
),
    'listviewdefs' => array (
  'CUSTOMER_PRODUCT_NUMBER_NON_DB' => 
  array (
    'type' => 'varchar',
    'link' => true,
    'label' => 'LBL_CUSTOMER_PRODUCT_NUMBER',
    'width' => '10%',
    'default' => true,
  ),
  'PRODUCT_MASTER_NON_DB' => 
  array (
    'type' => 'varchar',
    'link' => true,
    'label' => 'LBL_PRODUCT_MASTER',
    'width' => '10%',
    'default' => true,
  ),
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
    'name' => 'name',
  ),
),
);
