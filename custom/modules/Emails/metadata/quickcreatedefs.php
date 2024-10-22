<?php
// created: 2023-03-30 08:57:28
$viewdefs['Emails']['QuickCreate'] = array (
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
        0 => 
        array (
          'name' => 'highlights_c',
          'label' => 'LBL_HIGHLIGHTS',
        ),
        1 => '',
      ),
      1 => 
      array (
        0 => 'name',
        1 => 'assigned_user_name',
      ),
      2 => 
      array (
        0 => 'category_id',
      ),
    ),
  ),
);