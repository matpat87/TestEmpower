<?php
$module_name = 'MKT_NewMarkets';
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
        'LBL_EDITVIEW_PANEL1' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL2' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL3' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL4' => 
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
          1 => 
          array (
            'name' => 'division_c',
            'studio' => 'visible',
            'label' => 'LBL_DIVISION',
          ),
        ),
        1 => 
        array (
          0 => 'assigned_user_name',
          1 => '',
        ),
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'market_penetration_c',
            'label' => 'LBL_MARKET_PENETRATION',
          ),
          1 => 
          array (
            'name' => 'sales_revenue_c',
            'label' => 'LBL_SALES_REVENUE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'dynamics_c',
            'studio' => 'visible',
            'label' => 'LBL_DYNAMICS',
          ),
          1 => 
          array (
            'name' => 'value_proposition_c',
            'studio' => 'visible',
            'label' => 'LBL_VALUE_PROPOSITION',
          ),
        ),
      ),
      'lbl_editview_panel2' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'potential_revenue_c',
            'label' => 'LBL_POTENTIAL_REVENUE',
          ),
          1 => '',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'gross_margin_c',
            'label' => 'LBL_GROSS_MARGIN',
          ),
          1 => '',
        ),
        2 => 
        array (
          0 => '',
          1 => '',
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'growth_rate_c',
            'label' => 'LBL_GROWTH_RATE',
          ),
          1 => '',
        ),
      ),
      'lbl_editview_panel3' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'political_c',
            'studio' => 'visible',
            'label' => 'LBL_POLITICAL',
          ),
          1 => 
          array (
            'name' => 'economic_c',
            'studio' => 'visible',
            'label' => 'LBL_ECONOMIC',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'social_c',
            'studio' => 'visible',
            'label' => 'LBL_SOCIAL',
          ),
          1 => 
          array (
            'name' => 'technical_c',
            'studio' => 'visible',
            'label' => 'LBL_TECHNICAL',
          ),
        ),
      ),
      'lbl_editview_panel4' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'strengths_c',
            'studio' => 'visible',
            'label' => 'LBL_STRENGTHS',
          ),
          1 => 
          array (
            'name' => 'weaknesses_c',
            'studio' => 'visible',
            'label' => 'LBL_WEAKNESSES',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'opportunities_c',
            'studio' => 'visible',
            'label' => 'LBL_OPPORTUNITIES',
          ),
          1 => 
          array (
            'name' => 'threats_c',
            'studio' => 'visible',
            'label' => 'LBL_THREATS',
          ),
        ),
      ),
    ),
  ),
);
;
?>
