<?php
$module_name = 'Surveys';
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
      'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => false,
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'survey_id_number_c',
            'label' => 'LBL_SURVEY_ID_NUMBER',
            'type' => 'varchar',
            'customCode' => '<span class="sugar_field" id="{$fields.survey_id_number_c.name}">{$fields.survey_id_number_c.value}</span><input type="hidden" name="survey_id_number_c" value="{$fields.survey_id_number_c.value}" /><input type="hidden" name="{$fields.id.name}" value="{$fields.id.value}" />',
          ),
          1 => 'name',
        ),
        1 => 
        array (
          0 => '',
          1 => '',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
          1 => 'assigned_user_name',
        ),
        3 => 
        array (
          0 => 'description',
        ),
        4 => 
        array (
          0 => 'survey_questions_display',
        ),
        5 => 
        array (
          0 => 'submit_text',
        ),
        6 => 
        array (
          0 => 'satisfied_text',
        ),
        7 => 
        array (
          0 => 'neither_text',
        ),
        8 => 
        array (
          0 => 'dissatisfied_text',
        ),
      ),
    ),
  ),
);
;
?>
