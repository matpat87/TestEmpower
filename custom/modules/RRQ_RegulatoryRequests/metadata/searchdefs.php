<?php
$module_name = 'RRQ_RegulatoryRequests';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'id_num_c' => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_ID_NUM',
        'width' => '10%',
        'name' => 'id_num_c',
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
      'id_num_c' => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_ID_NUM',
        'width' => '10%',
        'name' => 'id_num_c',
      ),
      'status_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'name' => 'status_c',
      ),
      'accounts_rrq_regulatoryrequests_1_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_ACCOUNTS_RRQ_REGULATORYREQUESTS_1_FROM_ACCOUNTS_TITLE',
        'id' => 'ACCOUNTS_RRQ_REGULATORYREQUESTS_1ACCOUNTS_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'accounts_rrq_regulatoryrequests_1_name',
      ),
      'contacts_rrq_regulatoryrequests_1_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_CONTACTS_RRQ_REGULATORYREQUESTS_1_FROM_CONTACTS_TITLE',
        'id' => 'CONTACTS_RRQ_REGULATORYREQUESTS_1CONTACTS_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'contacts_rrq_regulatoryrequests_1_name',
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