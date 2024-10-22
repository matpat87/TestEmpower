<?php
$module_name = 'TRI_TechnicalRequestItems';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      0 => 'name',
      1 => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
      ),
    ),
    'advanced_search' => 
    array (
      'tri_technicalrequestitems_tr_technicalrequests_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_TRI_TECHNICALREQUESTITEMS_TR_TECHNICALREQUESTS_FROM_TR_TECHNICALREQUESTS_TITLE',
        'id' => 'TRI_TECHNI0387EQUESTS_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'tri_technicalrequestitems_tr_technicalrequests_name',
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
      'due_date' => 
      array (
        'type' => 'date',
        'label' => 'LBL_DUE_DATE',
        'width' => '10%',
        'default' => true,
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
        'default' => true,
        'width' => '10%',
      ),
      'date_entered' => 
      array (
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => true,
        'name' => 'date_entered',
      ),
      'date_modified' => 
      array (
        'type' => 'datetime',
        'label' => 'LBL_DATE_MODIFIED',
        'width' => '10%',
        'default' => true,
        'name' => 'date_modified',
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
