<?php
$module_name = 'CHL_Challenges';
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
          0 => 'name',
          1 => 
          array (
            'name' => 'type_c',
            'studio' => 'visible',
            'label' => 'LBL_TYPE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'related_to_c',
            'studio' => 'visible',
            'label' => 'LBL_RELATED_TO',
          ),
          1 => 
          array (
            'name' => 'accounts_chl_challenges_1_name',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'value_c',
            'label' => 'LBL_VALUE',
          ),
          1 => 
          array (
            'name' => 'status_c',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
        ),
        3 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'priority_c',
            'studio' => 'visible',
            'label' => 'LBL_PRIORITY',
          ),
        ),
        4 => 
        array (
          0 => 'description',
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'possible_solutions_c',
            'studio' => 'visible',
            'label' => 'LBL_POSSIBLE_SOLUTIONS',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'used_by_others_c',
            'studio' => 'visible',
            'label' => 'LBL_USED_BY_OTHERS',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'commercialized_to_others_c',
            'studio' => 'visible',
            'label' => 'LBL_COMMERCIALIZED_TO_OTHERS',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'issue_in_the_market_c',
            'studio' => 'visible',
            'label' => 'LBL_ISSUE_IN_THE_MARKET',
          ),
        ),
        9 => 
        array (
          0 => '',
          1 => '',
        ),
        10 => 
        array (
          0 => 'assigned_user_name',
        ),
      ),
    ),
  ),
);
;
?>
