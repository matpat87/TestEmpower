<?php
$popupMeta = array (
    'moduleMain' => 'APX_ShippingDetails',
    'varName' => 'APX_ShippingDetails',
    'orderBy' => 'apx_shippingdetails.name',
    'whereClauses' => array (
  'name' => 'apx_shippingdetails.name',
  'delivered_date' => 'apx_shippingdetails.delivered_date',
  'ship_tracker' => 'apx_shippingdetails.ship_tracker',
  'pl_line_number' => 'apx_shippingdetails.pl_line_number',
  'assigned_user_id' => 'apx_shippingdetails.assigned_user_id',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'delivered_date',
  5 => 'ship_tracker',
  6 => 'pl_line_number',
  7 => 'assigned_user_id',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'delivered_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_DELIVERED_DATE',
    'width' => '10%',
    'name' => 'delivered_date',
  ),
  'ship_tracker' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SHIP_TRACKER',
    'width' => '10%',
    'name' => 'ship_tracker',
  ),
  'pl_line_number' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_PL_LINE_NUMBER',
    'width' => '10%',
    'name' => 'pl_line_number',
  ),
  'assigned_user_id' => 
  array (
    'name' => 'assigned_user_id',
    'label' => 'LBL_ASSIGNED_TO',
    'type' => 'enum',
    'function' => 
    array (
      'name' => 'get_user_array',
      'params' => 
      array (
        0 => false,
      ),
    ),
    'width' => '10%',
  ),
),
);
