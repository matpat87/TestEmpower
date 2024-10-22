<?php
$module_name = 'MKT_Markets';
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
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'custom/modules/MKT_Markets/js/custom.js',
        ),
        1 => 
        array (
          'file' => 'custom/modules/MKT_Markets/js/markets.js',
        ),
      ),
      'useTabs' => true,
      'tabDefs' => 
      array (
        'LBL_EDITVIEW_PANEL1' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_DETAILVIEW_PANEL6' => 
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
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL5' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'industry_non_db',
            'label' => 'LBL_NAME'
          ),
          1 => 
          array (
            'name' => 'division',
            'studio' => 'visible',
            'label' => 'LBL_DIVISION',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'region',
            'label' => 'LBL_REGION',
          ),
          1 => 
          array (
            'name' => 'sub_industry_c',
            'label' => 'LBL_SUB_INDUSTRY',
          ),
        ),
        2 => 
        array (
          0 => 'assigned_user_name',
          1 => 
          array (
            'name' => 'macromarket',
            'label' => 'LBL_MACROMARKET',
          ),
        ),
      ),
      'lbl_detailview_panel6' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'market_penetration',
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
            'name' => 'dynamics',
            'studio' => 'visible',
            'label' => 'LBL_DYNAMICS',
          ),
          1 => 
          array (
            'name' => 'value_proposition',
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
            'name' => 'potential_revenue',
            'label' => 'LBL_POTENTIAL_REVENUE',
          ),
          1 => '',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'gross_margin',
            'label' => 'LBL_GROSS_MARGIN',
          ),
          1 => '',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'growth_rate',
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
            'name' => 'revenue',
            'label' => 'LBL_REVENUE',
          ),
          1 => 
          array (
            'name' => 'year_1',
            'label' => 'LBL_YEAR_1',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'year_2',
            'label' => 'LBL_YEAR_2',
          ),
          1 => 
          array (
            'name' => 'year_3',
            'label' => 'LBL_YEAR_3',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'year_4',
            'label' => 'LBL_YEAR_4',
          ),
          1 => 
          array (
            'name' => 'year_5',
            'label' => 'LBL_YEAR_5',
          ),
        ),
      ),
      'lbl_editview_panel4' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'political',
            'studio' => 'visible',
            'label' => 'LBL_POLITICAL',
          ),
          1 => 
          array (
            'name' => 'economic',
            'studio' => 'visible',
            'label' => 'LBL_ECONOMIC',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'social',
            'studio' => 'visible',
            'label' => 'LBL_SOCIAL',
          ),
          1 => 
          array (
            'name' => 'technical',
            'studio' => 'visible',
            'label' => 'LBL_TECHNICAL',
          ),
        ),
      ),
      'lbl_editview_panel5' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'strengths',
            'studio' => 'visible',
            'label' => 'LBL_STRENGTHS',
          ),
          1 => 
          array (
            'name' => 'weaknesses',
            'studio' => 'visible',
            'label' => 'LBL_WEAKNESSES',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'opportunities',
            'studio' => 'visible',
            'label' => 'LBL_OPPORTUNITIES',
          ),
          1 => 
          array (
            'name' => 'threats',
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
