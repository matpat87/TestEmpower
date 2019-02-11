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
      'tr_technicalrequests_number' => 
      array (
        'name' => 'tr_technicalrequests_number',
        'default' => true,
        'width' => '10%',
      ),
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'resolution' => 
      array (
        'name' => 'resolution',
        'default' => true,
        'width' => '10%',
      ),
      'status' => 
      array (
        'name' => 'status',
        'default' => true,
        'width' => '10%',
      ),
      'priority' => 
      array (
        'name' => 'priority',
        'default' => true,
        'width' => '10%',
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
      'division' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_DIVISION',
        'width' => '10%',
        'default' => true,
        'name' => 'division',
      ),
      'salesregion' => 
      array (
        'type' => 'multienum',
        'studio' => 'visible',
        'label' => 'LBL_SALESREGION',
        'width' => '10%',
        'default' => true,
        'name' => 'salesregion',
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
      'date_entered' => 
      array (
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => true,
        'name' => 'date_entered',
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
