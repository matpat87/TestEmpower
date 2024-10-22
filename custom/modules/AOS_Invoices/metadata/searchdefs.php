<?php
// created: 2023-03-30 08:57:28
$searchdefs['AOS_Invoices'] = array (
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
    'maxColumnsBasic' => '3',
  ),
  'layout' => 
  array (
    'basic_search' => 
    array (
      0 => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      1 => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
      2 => 
      array (
        'name' => 'favorites_only',
        'label' => 'LBL_FAVORITES_FILTER',
        'type' => 'bool',
      ),
    ),
    'advanced_search' => 
    array (
      0 => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      1 => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_CUSTOM_ITEM_NUMBER',
        'width' => '10%',
        'default' => true,
        'name' => 'custom_item_number',
      ),
      2 => 
      array (
        'name' => 'billing_account',
        'default' => true,
        'width' => '10%',
      ),
      3 => 
      array (
        'name' => 'number',
        'default' => true,
        'width' => '10%',
      ),
      4 => 
      array (
        'type' => 'varchar',
        'studio' => 'visible',
        'default' => true,
        'label' => 'LBL_ORDER_NUMBER',
        'width' => '10%',
        'name' => 'order_number_c',
      ),
      5 => 
      array (
        'type' => 'date',
        'label' => 'LBL_CUSTOM_SHIPPED_DATE',
        'default' => true,
        'width' => '10%',
        'name' => 'custom_shipped_date',
      ),
      6 => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_PO_NUMBER',
        'width' => '10%',
        'name' => 'po_number_c',
      ),
      7 => 
      array (
        'name' => 'status',
        'default' => true,
        'width' => '10%',
      ),
      8 => 
      array (
        'name' => 'assigned_user_id',
        'type' => 'enum',
        'label' => 'LBL_ASSIGNED_TO',
        'function' => 
        array (
          'name' => 'get_user_array',
          'params' => 
          array (
            0 => false,
          ),
        ),
        'default' => true,
        'width' => '10%',
      ),
    ),
  ),
);