<?php
// created: 2023-03-30 08:57:28
$viewdefs['SecurityGroups']['DetailView'] = array (
  'templateMeta' =>
  array (
    'form' =>
    array (
      'buttons' =>
      array (
        0 => 'EDIT',
        1 => 'DUPLICATE',
        2 => 'DELETE',
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
      'DEFAULT' =>
      array (
        'newTab' => true,
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
        1 => 'assigned_user_name',
      ),
      1 =>
      array (
        0 => 'date_entered',
        1 => 'date_modified',
      ),
      2 =>
      array (
        0 => 'noninheritable',
        1 =>
        array (
          'name' => 'type_c',
          'studio' => 'visible',
          'label' => 'LBL_TYPE',
        ),
      ),
      3 =>
      array (
        0 =>
        array (
          'name' => 'division_c',
          'studio' => 'visible',
          'label' => 'LBL_DIVISION',
        ),
        1 =>
        array (
          'name' => 'site_c',
          'studio' => 'visible',
          'label' => 'LBL_SITE',
        ),
      ),
      4 =>
      array (
        0 => 'description',
      ),
    ),
  ),
);
;
?>
