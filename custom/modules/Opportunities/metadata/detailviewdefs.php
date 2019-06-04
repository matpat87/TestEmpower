<?php
$viewdefs ['Opportunities'] = 
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
      'useTabs' => true,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_ASSIGNMENT' => 
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
          1 => 'account_name',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'annual_volume_lbs_c',
            'label' => 'LBL_ANNUAL_VOLUME_LBS',
          ),
          1 => 'date_closed',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'amount',
            'label' => '{$MOD.LBL_AMOUNT} ({$CURRENCY})',
            'customCode' => '{$AMOUNT}',
          ),
          1 => 
          array (
            'name' => 'avg_sell_price_c',
            'label' => '{$MOD.LBL_AVG_SELL_PRICE} ({$CURRENCY})',
            'customCode' => '{$AVG_SELL_PRICE}',
          ),
        ),
        3 => 
        array (
          0 => 'sales_stage',
          1 => 'opportunity_type',
        ),
        4 => 
        array (
          0 => 'probability',
          1 => 'lead_source',
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'next_step',
            'label' => 'LBL_NEXT_STEP_TEMP',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'nl2br' => true,
          ),
          1 => 
          array (
            'name' => 'mkt_markets_opportunities_1_name',
          ),
        ),
      ),
      'LBL_PANEL_ASSIGNMENT' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO',
          ),
        ),
      ),
    ),
  ),
);
;
?>
