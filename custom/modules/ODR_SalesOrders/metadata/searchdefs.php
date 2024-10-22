<?php
$module_name = 'ODR_SalesOrders';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'current_user_only' => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
    ),
    'advanced_search' => 
    array (
      'status' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
        'name' => 'status',
      ),
      'order_type_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_ORDER_TYPE',
        'width' => '10%',
        'name' => 'order_type_c',
      ),
      'site_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_SITE',
        'width' => '10%',
        'name' => 'site_c',
      ),
      'accounts_odr_salesorders_1_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_ACCOUNTS_ODR_SALESORDERS_1_FROM_ACCOUNTS_TITLE',
        'id' => 'ACCOUNTS_ODR_SALESORDERS_1ACCOUNTS_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'accounts_odr_salesorders_1_name',
      ),
      'number' => 
      array (
        'type' => 'int',
        'label' => 'LBL_NUMBER',
        'width' => '10%',
        'default' => true,
        'name' => 'number',
      ),
      'salesperson_c' => 
      array (
        'type' => 'relate',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_SALESPERSON',
        'id' => 'USER_ID_C',
        'link' => true,
        'width' => '10%',
        'name' => 'salesperson_c',
      ),
      'custom_item_number' => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_ITEM_NUMBER',
        'width' => '10%',
        'name' => 'custom_item_number',
      ),
      'custom_item_name' => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_ITEM_NAME',
        'width' => '10%',
        'name' => 'custom_item_name',
      ),
      'po_number_c' => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_PO_NUMBER',
        'width' => '10%',
        'name' => 'po_number_c',
      ),
      'custom_req_ship_date' => 
      array (
        'type' => 'datetime',
        'default' => true,
        'label' => 'LBL_REQ_SHIP_DATE',
        'width' => '10%',
        'name' => 'custom_req_ship_date',
      ),
      'custom_promised_date' => 
      array (
        'type' => 'datetime',
        'default' => true,
        'label' => 'LBL_PROMISED_DATE',
        'width' => '10%',
        'name' => 'custom_promised_date',
      ),
      'order_date_c' => 
      array (
        'type' => 'datetime',
        'default' => true,
        'label' => 'LBL_ORDER_DATE',
        'width' => '10%',
        'name' => 'order_date_c',
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'maxColumnsBasic' => '4',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
;
?>
