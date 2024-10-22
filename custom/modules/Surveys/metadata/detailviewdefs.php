<?php
$module_name = 'Surveys';
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
          4 =>
          array (
            'customCode' => '{$PREVIEW_SURVEY_BTN}',
          ),
          5 =>
          array (
            'customCode' => '<input type="submit" class="button" onClick="var _form = document.getElementById(\'formDetailView\');_form.action.value=\'reports\';SUGAR.ajaxUI.submitForm(_form);" value="{$MOD.LBL_VIEW_SURVEY_REPORTS}">',
          ),
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
      'syncDetailEditViews' => true,
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
          ),
          1 => 'name',
        ),
        1 => 
        array (
          0 => 'survey_url_display',
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
          0 => 
          array (
            'name' => 'submit_text',
            'label' => 'LBL_SUBMIT_TEXT',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'satisfied_text',
            'label' => 'LBL_SATISFIED_TEXT',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'neither_text',
            'label' => 'LBL_NEITHER_TEXT',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'dissatisfied_text',
            'label' => 'LBL_DISSATISFIED_TEXT',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'enable_response_notification_c',
            'label' => 'LBL_ENABLE_RESPONSE_NOTIFICATION',
          ),
          1 => '',
        ),
      ),
    ),
  ),
);
;
?>
