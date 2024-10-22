<?php
$module_name = 'DSBTN_Distribution';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'custom_opportunity_number_non_db' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_OPPORTUNITY_NUMBER',
        'width' => '10%',
        'default' => true,
        'name' => 'custom_opportunity_number_non_db',
      ),
      'distribution_number_c' => 
      array (
        'type' => 'int',
        'default' => true,
        'label' => 'LBL_DISTRIBUTION_NUMBER',
        'width' => '10%',
        'name' => 'distribution_number_c',
      ),
      'custom_technical_request_product_name_non_db' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_TECHNICAL_REQUEST_PRODUCT_NAME',
        'width' => '10%',
        'default' => true,
        'name' => 'custom_technical_request_product_name_non_db',
      ),
      'custom_technical_request_number_non_db' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_TECHNICAL_REQUEST_NUMBER',
        'width' => '10%',
        'default' => true,
        'name' => 'custom_technical_request_number_non_db',
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
      'custom_opportunity_number_non_db' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_OPPORTUNITY_NUMBER',
        'width' => '10%',
        'default' => true,
        'name' => 'custom_opportunity_number_non_db',
      ),
      'distribution_number_c' => 
      array (
        'type' => 'int',
        'default' => true,
        'label' => 'LBL_DISTRIBUTION_NUMBER',
        'width' => '10%',
        'name' => 'distribution_number_c',
      ),
      'custom_technical_request_number_non_db' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_TECHNICAL_REQUEST_NUMBER',
        'width' => '10%',
        'default' => true,
        'name' => 'custom_technical_request_number_non_db',
      ),
      'custom_technical_request_product_name_non_db' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_TECHNICAL_REQUEST_PRODUCT_NAME',
        'width' => '10%',
        'default' => true,
        'name' => 'custom_technical_request_product_name_non_db',
      ),
      'account_c' => 
      array (
        'type' => 'relate',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_ACCOUNT',
        'id' => 'ACCOUNT_ID_C',
        'link' => true,
        'width' => '10%',
        'name' => 'account_c',
      ),
      'contact_c' => 
      array (
        'type' => 'relate',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_CONTACT',
        'id' => 'CONTACT_ID_C',
        'link' => true,
        'width' => '10%',
        'name' => 'contact_c',
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
      'distro_item_non_db' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_DISTRO_ITEM',
        'width' => '10%',
        'default' => true,
        'name' => 'distro_item_non_db',
      ),
      'distro_item_status_non_db' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_DISTRO_ITEM_STATUS',
        'width' => '10%',
        'default' => true,
        'name' => 'distro_item_status_non_db',
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
