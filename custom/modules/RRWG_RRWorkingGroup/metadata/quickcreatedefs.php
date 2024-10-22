<?php
$module_name = 'RRWG_RRWorkingGroup';
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
            'name' => 'rrq_regulatoryrequests_rrwg_rrworkinggroup_1_name',
            'label' => 'LBL_RRQ_REGULATORYREQUESTS_RRWG_RRWORKINGGROUP_1_FROM_RRQ_REGULATORYREQUESTS_TITLE',
          ),
          1 => '',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'rr_roles',
            'studio' => 'visible',
            'label' => 'LBL_RR_ROLES',
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
