<?php
$viewdefs ['Opportunities'] = 
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
      'javascript' => '{$PROBABILITY_SCRIPT}',
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
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'custom/modules/Opportunities/js/custom-edit.js',
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
          ),
          1 => 'account_name',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'currency_id',
            'label' => 'LBL_CURRENCY',
          ),
          1 => 
          array (
            'name' => 'date_closed',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'amount',
            'customCode' => '<input type="text" name="{$fields.amount.name}" id="{$fields.amount.name}" value="{$fields.amount.value}" maxlength="{$fields.amount.len}" class="custom-currency" />',
          ),
          1 => 
          array (
            'name' => 'avg_sell_price_c',
            'label' => 'LBL_AVG_SELL_PRICE',
            'customCode' => '<input type="text" name="{$fields.avg_sell_price_c.name}" id="{$fields.avg_sell_price_c.name}" value="{$fields.avg_sell_price_c.value}" maxlength="{$fields.avg_sell_price_c.len}" class="custom-currency" />',
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
          0 => 'next_step_temp_c',
        ),
        6 => 
        array (
          0 => 'description',
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
          0 => 'assigned_user_name',
        ),
      ),
    ),
  ),
);
;
?>
