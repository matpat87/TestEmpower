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
          1 => 
          array (
            'name' => 'phase_c',
            'studio' => 'visible',
            'label' => 'LBL_PHASE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'application_c',
            'studio' => 'visible',
            'label' => 'LBL_APPLICATION',
          ),
          1 => 'status',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'type',
            'comment' => 'The type of issue (ex: issue, feature)',
            'label' => 'LBL_TYPE',
          ),
          1 => 
          array (
            'name' => 'module_c',
            'studio' => 'visible',
            'label' => 'LBL_MODULE',
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
          0 => 'name',
          1 => 
          array (
            'name' => 'site_c',
            'studio' => 'visible',
            'label' => 'LBL_SITE',
          ),
        ),
        5 => 
        array (
          0 => 'description',
        ),
        6 => 
        array (
          0 => 'work_log',
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
