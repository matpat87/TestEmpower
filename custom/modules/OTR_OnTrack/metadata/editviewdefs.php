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
          0 => 
          array (
            'name' => 'otr_ontrack_number',
            'type' => 'readonly',
          ),
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
            'customCode' => '<input type="text" name="{$fields.priority_c.name}" value="{$fields.priority_c.value}" style="width: 100px;" />',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'displayParams' => 
            array (
              'size' => 60,
            ),
          ),
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
          0 => 
          array (
            'name' => 'work_log',
            'label' => 'LBL_WORK_LOG',
            'customCode' => '<textarea name="{$fields.work_log.name}" style="width: 120%; height: 165px;" >{$fields.work_log.value}</textarea>',
          ),
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
