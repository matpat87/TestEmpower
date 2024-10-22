<?php
$module_name = 'OTR_OnTrack';
$_object_name = 'otr_ontrack';
$viewdefs [$module_name] = 
array (
  'EditView' => 
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
      'useTabs' => true,
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'custom/modules/OTR_OnTrack/js/custom-edit.js',
        ),
      ),
      'tabDefs' => 
      array (
        'LBL_OVERVIEW' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL2' => 
        array (
          'newTab' => false,
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
          0 => 
          array (
            'name' => 'otr_ontrack_number',
            'type' => 'readonly',
          ),
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
            'customCode' => '<input type="text" name="{$fields.priority_c.name}" value="{$fields.priority_c.value}" style="width: 100px;" />',
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
          0 => 
          array (
            'name' => 'name',
            'displayParams' => 
            array (
              'size' => 60,
            ),
          ),
        ),
        7 => 
        array (
          0 => 'description',
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'steps_to_replicate_the_issue_c',
            'studio' => 'visible',
            'label' => 'LBL_STEPS_TO_REPLICATE_THE_ISSUE',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'status_update_c',
            'studio' => 'visible',
            'label' => 'LBL_STATUS_UPDATE',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'add_time_non_db',
            'label' => 'LBL_ADD_TIME_NON_DB',
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
      'lbl_editview_panel2' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'work_performed_non_db',
            'label' => 'LBL_WORK_PERFORMED_NON_DB',
          ),
          1 => 
          array (
            'name' => 'date_worked_non_db',
            'label' => 'LBL_DATE_WORKED_NON_DB',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'time_non_db',
            'label' => 'LBL_TIME_NON_DB',
          ),
          1 => '',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'work_description_non_db',
            'label' => 'LBL_WORK_DESCRIPTION_NON_DB',
          ),
          1 => '',
        ),
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 'assigned_user_name',
        ),
      ),
    ),
  ),
);
;
?>
