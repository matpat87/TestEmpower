<?php
$module_name = 'COMP_Competitor';
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
            'name' => 'competitor',
            'studio' => 'visible',
            'label' => 'LBL_COMPETITOR',
          ),
          1 => 'assigned_user_name',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'sales_position',
            'label' => 'LBL_SALES_POSITION',
          ),
          1 => 
          array (
            'name' => 'percent_of_business',
            'label' => 'LBL_PERCENT_OF_BUSINESS',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'accounts_comp_competitor_1_name',
            'label' => 'LBL_ACCOUNT_NAME',
          ),
          1 => '',
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'comment' => 'Full text of the note',
            'label' => 'LBL_DESCRIPTION',
          ),
          1 => '',
        ),
      ),
    ),
  ),
);
;
?>
