<?php
$viewdefs ['ProjectTask'] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'enctype' => 'multipart/form-data',
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
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'custom/modules/ProjectTask/js/custom-edit.js',
        ),
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'LBL_EDITVIEW_PANEL2' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => true,
    ),
    'panels' => 
    array (
      'lbl_editview_panel2' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'prj_number_c',
            'label' => 'LBL_PRJ_NUMBER',
            'type' => 'readonly',
          ),
          1 => 
          array (
            'name' => 'prj_status_c',
            'studio' => 'visible',
            'label' => 'LBL_PRJ_STATUS',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'prj_application_c',
            'studio' => 'visible',
            'label' => 'LBL_PRJ_APPLICATION',
          ),
          1 => 
          array (
            'name' => 'prj_phase_c',
            'studio' => 'visible',
            'label' => 'LBL_PRJ_PHASE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'prj_module_c',
            'studio' => 'visible',
            'label' => 'LBL_PRJ_MODULE',
          ),
          1 => 
          array (
            'name' => 'prj_type_c',
            'studio' => 'visible',
            'label' => 'LBL_PRJ_TYPE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'prj_severity_c',
            'studio' => 'visible',
            'label' => 'LBL_PRJ_SEVERITY',
          ),
          1 => 
          array (
            'name' => 'prj_priority_c',
            'label' => 'LBL_PRJ_PRIORITY',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'users_projecttask_1_name',
            'label' => 'LBL_USERS_PROJECTTASK_1_FROM_USERS_TITLE',
          ),
          1 => 
          array (
            'name' => 'prj_division_c',
            'studio' => 'visible',
            'label' => 'LBL_PRJ_DIVISION',
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
            'label' => 'LBL_NAME',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'description',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'prj_status_update_c',
            'studio' => 'visible',
            'label' => 'LBL_PRJ_STATUS_UPDATE',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'custom_add_time_non_db',
            'studio' => 'visible',
            'label' => 'LBL_ADD_TIME_NON_DB',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'prj_document_c',
            'studio' => 'visible',
            'label' => 'LBL_PRJ_DOCUMENT',
          ),
          1 => '',
        ),
      ),
      'lbl_editview_panel3' => 
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
          1 => ''
         
        ),
      ),
    ),
  ),
);