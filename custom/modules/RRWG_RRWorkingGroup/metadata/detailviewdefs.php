<?php
$module_name = 'RRWG_RRWorkingGroup';
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
          1 => 'DUPLICATE',
          2 => 'DELETE',
          3 => 'FIND_DUPLICATES',
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
            'name' => 'rrq_regulatoryrequests_rrwg_rrworkinggroup_1_name',
          ),
          1 => '',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'rr_roles',
            'studio' => 'visible',
            'label' => 'LBL_RR_ROLES',
          ),
          1 => 
          array (
            'name' => 'parent_name',
            'studio' => 'visible',
            'label' => 'LBL_FLEX_RELATE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'first_name_non_db',
            'label' => 'LBL_FIRST_NAME_NON_DB',
          ),
          1 => 
          array (
            'name' => 'last_name_non_db',
            'label' => 'LBL_LAST_NAME_NON_DB',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'company_non_db',
            'label' => 'LBL_COMPANY_NON_DB',
          ),
          1 => 
          array (
            'name' => 'phone_work_non_db',
            'label' => 'LBL_WORK_PHONE_NON_DB',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'email_address_non_db',
            'label' => 'LBL_EMAIL_NON_DB',
          ),
          1 => 
          array (
            'name' => 'phone_mobile_non_db',
            'label' => 'LBL_MOBILE_PHONE_NON_DB',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'notification_type',
            'studio' => 'visible',
            'label' => 'LBL_NOTIFICATION_TYPE',
          ),
          1 => '',
        ),
        6 => 
        array (
          0 => '',
          1 => '',
        ),
        7 => 
        array (
          0 => 'date_modified',
          1 => 
          array (
            'name' => 'modified_by_name',
            'label' => 'LBL_MODIFIED_NAME',
          ),
        ),
        8 => 
        array (
          0 => 'date_entered',
          1 => 
          array (
            'name' => 'created_by_name',
            'label' => 'LBL_CREATED',
          ),
        ),
      ),
    ),
  ),
);
;
?>
