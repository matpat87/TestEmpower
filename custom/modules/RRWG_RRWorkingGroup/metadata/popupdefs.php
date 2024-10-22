<?php
$popupMeta = array (
    'moduleMain' => 'RRWG_RRWorkingGroup',
    'varName' => 'RRWG_RRWorkingGroup',
    'orderBy' => 'rrwg_rrworkinggroup.name',
    'whereClauses' => array (
  'full_name_non_db' => 'rrwg_rrworkinggroup.full_name_non_db',
  'rr_roles' => 'rrwg_rrworkinggroup.rr_roles',
  'regulatory_request_status_non_db' => 'rrwg_rrworkinggroup.regulatory_request_status_non_db',
  'assigned_user_id' => 'rrwg_rrworkinggroup.assigned_user_id',
),
    'searchInputs' => array (
  4 => 'full_name_non_db',
  5 => 'rr_roles',
  6 => 'regulatory_request_status_non_db',
  7 => 'assigned_user_id',
),
    'searchdefs' => array (
  'full_name_non_db' => 
  array (
    'type' => 'name',
    'label' => 'LBL_NAME',
    'width' => '10%',
    'name' => 'full_name_non_db',
  ),
  'rr_roles' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_RR_ROLES',
    'width' => '10%',
    'name' => 'rr_roles',
  ),
  'regulatory_request_status_non_db' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_REGULATORY_REQUEST_STATUS_NON_DB',
    'width' => '10%',
    'name' => 'regulatory_request_status_non_db',
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
