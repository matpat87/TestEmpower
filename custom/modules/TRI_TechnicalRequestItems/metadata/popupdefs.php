<?php
$popupMeta = array (
    'moduleMain' => 'TRI_TechnicalRequestItems',
    'varName' => 'TRI_TechnicalRequestItems',
    'orderBy' => 'tri_technicalrequestitems.name',
    'whereClauses' => array (
  'name' => 'tri_technicalrequestitems.name',
  'tri_technicalrequestitems_tr_technicalrequests_name' => 'tri_technicalrequestitems.tri_technicalrequestitems_tr_technicalrequests_name',
  'product_number' => 'tri_technicalrequestitems.product_number',
  'due_date' => 'tri_technicalrequestitems.due_date',
  'assigned_user_id' => 'tri_technicalrequestitems.assigned_user_id',
  'status' => 'tri_technicalrequestitems.status',
  'date_entered' => 'tri_technicalrequestitems.date_entered',
  'date_modified' => 'tri_technicalrequestitems.date_modified',
),
    'searchInputs' => array (
  1 => 'name',
  3 => 'status',
  4 => 'tri_technicalrequestitems_tr_technicalrequests_name',
  5 => 'product_number',
  6 => 'due_date',
  7 => 'assigned_user_id',
  8 => 'date_entered',
  9 => 'date_modified',
),
    'searchdefs' => array (
  'tri_technicalrequestitems_tr_technicalrequests_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_TRI_TECHNICALREQUESTITEMS_TR_TECHNICALREQUESTS_FROM_TR_TECHNICALREQUESTS_TITLE',
    'id' => 'TRI_TECHNI0387EQUESTS_IDA',
    'width' => '10%',
    'name' => 'tri_technicalrequestitems_tr_technicalrequests_name',
  ),
  'product_number' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_PRODUCT_NUMBER',
    'width' => '10%',
    'name' => 'product_number',
  ),
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'due_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_DUE_DATE',
    'width' => '10%',
    'name' => 'due_date',
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
  'status' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'name' => 'status',
  ),
  'date_entered' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'name' => 'date_entered',
  ),
  'date_modified' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_MODIFIED',
    'width' => '10%',
    'name' => 'date_modified',
  ),
),
);
