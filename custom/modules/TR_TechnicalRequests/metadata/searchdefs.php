<?php
$module_name = 'TR_TechnicalRequests';
$_object_name = 'tr_technicalrequests';
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
      'open_only' => 
      array (
        'name' => 'open_only',
        'label' => 'LBL_OPEN_ITEMS',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
    ),
    'advanced_search' => 
    array (
      'custom_opportunity_id' => 
      array (
        'type' => 'int',
        'default' => true,
        'label' => 'LBL_CUSTOM_OPPORTUNITY_ID',
        'width' => '10%',
        'name' => 'custom_opportunity_id',
      ),
      'technicalrequests_number_c' => 
      array (
        'type' => 'int',
        'default' => true,
        'label' => 'LBL_TECHNICALREQUESTS_NUMBER',
        'width' => '10%',
        'name' => 'technicalrequests_number_c',
      ),
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'related_technical_request_c' => 
      array (
        'type' => 'relate',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_RELATED_TECHNICAL_REQUEST',
        'id' => 'TR_TECHNICALREQUESTS_ID_C',
        'link' => true,
        'width' => '10%',
        'name' => 'related_technical_request_c',
      ),
      'tr_technicalrequests_accounts_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_TR_TECHNICALREQUESTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
        'id' => 'TR_TECHNICALREQUESTS_ACCOUNTSACCOUNTS_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'tr_technicalrequests_accounts_name',
      ),
      'req_completion_date_c' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_REQ_COMPLETION_DATE',
        'width' => '10%',
        'name' => 'req_completion_date_c',
      ),
      'type' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_TYPE',
        'width' => '10%',
        'default' => true,
        'name' => 'type',
      ),
      'approval_stage' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_APPROVAL_STAGE',
        'width' => '10%',
        'name' => 'approval_stage',
      ),
      'status' => 
      array (
        'name' => 'status',
        'default' => true,
        'width' => '10%',
      ),
      'actual_close_date_c' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_ACTUAL_CLOSE_DATE',
        'width' => '10%',
        'name' => 'actual_close_date_c',
      ),
      'site' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_SITE',
        'width' => '10%',
        'default' => true,
        'name' => 'site',
      ),
      'assigned_user_id' => 
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
      'tr_technicalrequests_opportunities_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_TR_TECHNICALREQUESTS_OPPORTUNITIES_FROM_OPPORTUNITIES_TITLE',
        'id' => 'TR_TECHNICALREQUESTS_OPPORTUNITIESOPPORTUNITIES_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'tr_technicalrequests_opportunities_name',
      ),
      'resin_compound_type_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_RESIN_COMPOUND_TYPE',
        'width' => '10%',
        'name' => 'resin_compound_type_c',
      ),
      'product_category_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_PRODUCT_CATEGORY',
        'width' => '10%',
        'name' => 'product_category_c',
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
