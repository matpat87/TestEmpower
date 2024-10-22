<?php
$module_name = 'PA_PreventiveActions';
$viewdefs [$module_name] = 
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
          0 => 'name',
          1 => 
          array (
            'name' => 'cases_pa_preventiveactions_1_name',
            'label' => 'LBL_CASES_PA_PREVENTIVEACTIONS_1_FROM_CASES_TITLE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'severity',
            'studio' => 'visible',
            'label' => 'LBL_SEVERITY',
          ),
          1 => 
          array (
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'start_date',
            'label' => 'LBL_START_DATE',
          ),
          1 => 
          array (
            'name' => 'end_date',
            'label' => 'LBL_END_DATE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'site_c',
            'studio' => 'visible',
            'label' => 'LBL_SITE',
          ),
          1 => 
          array (
            'name' => 'department_c',
            'studio' => 'visible',
            'label' => 'LBL_DEPARTMENT',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'notes',
            'studio' => 'visible',
            'label' => 'LBL_NOTES',
          ),
          1 => '',
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'status_update',
            'studio' => 'visible',
            'label' => 'LBL_STATUS_UPDATE',
          ),
          1 => '',
        ),
        6 => 
        array (
          0 => 'assigned_user_name',
          1 => '',
        ),
      ),
    ),
  ),
);
;
?>