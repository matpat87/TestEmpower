<?php
$viewdefs ['Project'] = 
array (
  'QuickCreate' => 
  array (
    'templateMeta' => 
    array (
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
        'LBL_PROJECT_INFORMATION' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'lbl_project_information' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 'status',
        ),
        1 => 
        array (
          0 => 'estimated_start_date',
          1 => 'priority',
        ),
        2 => 
        array (
          0 => 'estimated_end_date',
          1 => 
          array (
            'name' => 'override_business_hours',
            'comment' => '',
            'label' => 'LBL_OVERRIDE_BUSINESS_HOURS',
          ),
        ),
        3 => 
        array (
          0 => 'assigned_user_name',
          1 => 
          array (
            'name' => 'am_projecttemplates_project_1_name',
            'label' => 'LBL_AM_PROJECTTEMPLATES_PROJECT_1_FROM_AM_PROJECTTEMPLATES_TITLE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'financial_type_c',
            'studio' => 'visible',
            'label' => 'LBL_FINANCIAL_TYPE',
          ),
          1 => '',
        ),
      ),
    ),
  ),
);
;
?>
