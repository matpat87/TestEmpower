<?php
$module_name = 'TRI_TechnicalRequestItems';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      0 => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
        'type' => 'enum',
        'options' => 'distro_item_list',
      ),
      1 => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
      ),
    ),
    'advanced_search' => 
    array (
      'technical_request_opportunity_number_non_db' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_TECHNICAL_REQUEST_OPPORTUNITY_NUMBER_NON_DB',
        'width' => '10%',
        'default' => true,
        'name' => 'technical_request_opportunity_number_non_db',
      ),
      'technical_request_number_non_db' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_TECHNICAL_REQUEST_NUMBER_NON_DB',
        'width' => '10%',
        'default' => true,
        'name' => 'technical_request_number_non_db',
      ),
      'product_number' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_PRODUCT_NUMBER',
        'width' => '10%',
        'default' => true,
        'name' => 'product_number',
      ),
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
        'type' => 'enum',
        'options' => 'distro_item_list',
      ),
      'technical_request_site_non_db' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_TECHNICAL_REQUEST_SITE_NON_DB',
        'width' => '10%',
        'default' => true,
        'name' => 'technical_request_site_non_db',
      ),
      'status' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
        'name' => 'status',
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
      'distro_generated_c' => 
      array (
        'type' => 'bool',
        'default' => true,
        'label' => 'LBL_DISTRO_GENERATED',
        'width' => '10%',
        'name' => 'distro_generated_c',
      ),
      'due_date' => 
      array (
        'type' => 'date',
        'label' => 'LBL_DUE_DATE',
        'width' => '10%',
        'default' => true,
        'name' => 'due_date',
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
