<?php
$module_name = 'OTR_OnTrack';
$_object_name = 'otr_ontrack';
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
      'useTabs' => true,
      'tabDefs' => 
      array (
        'LBL_OVERVIEW' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL1' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'lbl_overview' => 
      array (
        0 => 
        array (
          0 => 'otr_ontrack_number',
          1 => 'status',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'application_c',
            'studio' => 'visible',
            'label' => 'LBL_APPLICATION',
          ),
          1 => 
          array (
            'name' => 'phase_c',
            'studio' => 'visible',
            'label' => 'LBL_PHASE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'module_c',
            'studio' => 'visible',
            'label' => 'LBL_MODULE',
          ),
          1 => 
          array (
            'name' => 'type',
            'comment' => 'The type of issue (ex: issue, feature)',
            'label' => 'LBL_TYPE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'severity_c',
            'studio' => 'visible',
            'label' => 'LBL_SEVERITY',
          ),
          1 => 
          array (
            'name' => 'priority_c',
            'label' => 'LBL_PRIORITY_C',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'users_otr_ontrack_1_name',
            'label' => 'LBL_USERS_OTR_ONTRACK_1_FROM_USERS_TITLE',
          ),
          1 => 
          array (
            'name' => 'division_c',
            'studio' => 'visible',
            'label' => 'LBL_DIVISION',
          ),
        ),
        5 => 
        array (
          0 => '',
          1 => '',
        ),
        6 => 
        array (
          0 => 'name',
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'type' => 'html',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'steps_to_replicate_the_issue_c',
            'type' => 'html',
          ),
        ),
        9 => 
        array (
          0 => 'work_log',
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'actual_hours_worked_c',
            'label' => 'LBL_ACTUAL_HOURS_WORKED',
          ),
          1 => 
          array (
            'name' => 'closed_date_c',
            'label' => 'LBL_CLOSED_DATE',
          ),
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'otr_document_c',
            'studio' => 'visible',
            'label' => 'LBL_OTR_DOCUMENT',
          ),
          1 => '',
        ),
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 'assigned_user_name',
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
