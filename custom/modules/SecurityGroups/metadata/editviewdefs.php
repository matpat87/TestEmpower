<?php
// created: 2023-03-30 08:57:28
$viewdefs['SecurityGroups']['EditView'] = array (
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
          'name' => 'name',
          'displayParams' =>
          array (
            'required' => true,
          ),
        ),
        1 => 'assigned_user_name',
      ),
      1 =>
      array (
        0 => 'noninheritable',
        1 =>
        array (
          'name' => 'type_c',
          'studio' => 'visible',
          'label' => 'LBL_TYPE',
        ),
      ),
      2 =>
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
      3 =>
      array (
        0 => 'description',
      ),
    ),
  ),
);
;
?>
