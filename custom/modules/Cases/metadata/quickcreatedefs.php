<?php
// created: 2023-03-30 08:57:28
$viewdefs['Cases']['QuickCreate'] = array (
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
    'includes' => 
    array (
      0 => 
      array (
        'file' => 'include/javascript/bindWithDelay.js',
      ),
      1 => 
      array (
        'file' => 'modules/AOK_KnowledgeBase/AOK_KnowledgeBase_SuggestionBox.js',
      ),
      2 => 
      array (
        'file' => 'include/javascript/qtip/jquery.qtip.min.js',
      ),
      3 => 
      array (
        'file' => 'custom/modules/Cases/js/custom-edit.js',
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
        1 => 'priority',
      ),
      1 => 
      array (
        0 => 'status',
        1 => 'account_name',
      ),
      2 => 
      array (
        0 => 'description',
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
          'name' => 'source_c',
          'studio' => 'visible',
          'label' => 'LBL_SOURCE',
        ),
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'users_cases_1_name',
          'label' => 'LBL_USERS_CASES_1_FROM_USERS_TITLE',
        ),
        1 => '',
      ),
    ),
  ),
);