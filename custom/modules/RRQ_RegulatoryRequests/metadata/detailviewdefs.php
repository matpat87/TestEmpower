<?php
$module_name = 'RRQ_RegulatoryRequests';
$viewdefs [$module_name] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'buttons' => 
        array (
          0 => 'EDIT',
          1 => 
          array (
            'customCode' => '{$BTN_SUBMIT_FOR_REVIEW_HTML}',
          ),
          2 => 'DUPLICATE',
          3 => 'DELETE',
          4 => 'FIND_DUPLICATES',
        ),
      ),
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'id_num_c',
            'label' => 'LBL_ID_NUM',
          ),
          1 => 
          array (
            'name' => 'status_c',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'req_type_c',
            'studio' => 'visible',
            'label' => 'LBL_REQ_TYPE',
          ),
          1 => 
          array (
            'name' => 'accounts_rrq_regulatoryrequests_1_name',
          ),
        ),
        2 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'contacts_rrq_regulatoryrequests_1_name',
          ),
        ),
        3 => 
        array (
          0 => 'description',
          1 => 
          array (
            'name' => 'status_update_log_c',
            'studio' => 'visible',
            'label' => 'LBL_STATUS_UPDATE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'req_date_c',
            'label' => 'LBL_REQ_DATE',
          ),
          1 => 
          array (
            'name' => 'req_by_c',
            'studio' => 'visible',
            'label' => 'LBL_REQ_BY',
          ),
        ),
        5 => 
        array (
          0 => 'assigned_user_name',
          1 => 
          array (
            'name' => 'submit_by_c',
            'studio' => 'visible',
            'label' => 'LBL_SUBMIT_BY',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'total_requests_c',
            'label' => 'LBL_TOTAL_REQUESTS',
          ),
          1 => '',
        ),
      ),
    ),
  ),
);
;
?>
