<?php
$module_name = 'TRWG_TRWorkingGroup';
$viewdefs [$module_name] = 
array (
  'QuickCreate' => 
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
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'tr_technicalrequests_trwg_trworkinggroup_1_name',
            'label' => 'LBL_TR_TECHNICALREQUESTS_TRWG_TRWORKINGGROUP_1_FROM_TR_TECHNICALREQUESTS_TITLE',
          ),
          1 => '',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'tr_roles',
            'studio' => 'visible',
            'label' => 'LBL_TR_ROLES',
          ),
          1 => 
          array (
            'name' => 'parent_name',
            'studio' => 'visible',
            'label' => 'LBL_FLEX_RELATE',
          ),
        ),
      ),
    ),
  ),
);
;
?>
