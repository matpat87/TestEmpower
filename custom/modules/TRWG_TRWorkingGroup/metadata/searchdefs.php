<?php
$module_name = 'TRWG_TRWorkingGroup';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'full_name_non_db' => 
      array (
        'type' => 'name',
        'label' => 'LBL_NAME',
        'width' => '10%',
        'default' => true,
        'name' => 'full_name_non_db',
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
      'full_name_non_db' => 
      array (
        'type' => 'name',
        'label' => 'LBL_NAME',
        'width' => '10%',
        'default' => true,
        'name' => 'full_name_non_db',
      ),
      'tr_roles' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_TR_ROLES',
        'width' => '10%',
        'default' => true,
        'name' => 'tr_roles',
      ),
      'technical_request_sales_stage_non_db' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_TECHNICAL_REQUEST_SALES_STAGE_NON_DB',
        'width' => '10%',
        'default' => true,
        'name' => 'technical_request_sales_stage_non_db',
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
        'default' => true,
        'width' => '10%',
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
