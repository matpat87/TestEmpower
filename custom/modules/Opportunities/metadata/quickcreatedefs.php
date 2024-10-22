<?php
// created: 2023-03-30 08:57:28
$viewdefs['Opportunities']['QuickCreate'] = array (
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
          'displayParams' => 
          array (
            'required' => true,
          ),
        ),
        1 => 
        array (
          'name' => 'account_name',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'opportunity_type',
        ),
        1 => 
        array (
          'name' => 'mkt_markets_opportunities_1_name',
          'label' => 'LBL_MKT_MARKETS_OPPORTUNITIES_1_FROM_MKT_MARKETS_TITLE',
        ),
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'avg_sell_price_c',
          'label' => 'LBL_AVG_SELL_PRICE',
          'customCode' => '<input type="text" name="{$fields.avg_sell_price_c.name}" id="{$fields.avg_sell_price_c.name}" value="{$fields.avg_sell_price_c.value}" maxlength="{$fields.avg_sell_price_c.len}" class="custom-currency" />',
        ),
        1 => 
        array (
          'name' => 'annual_volume_lbs_c',
          'label' => 'LBL_ANNUAL_VOLUME_LBS',
        ),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'amount',
          'customCode' => '<input type="text" name="{$fields.amount.name}" id="{$fields.amount.name}" value="{$fields.amount.value}" maxlength="{$fields.amount.len}" class="custom-currency" />',
        ),
        1 => 
        array (
          'name' => 'currency_id',
        ),
      ),
      4 => 
      array (
        0 => 'date_closed',
        1 => 
        array (
          'name' => 'closed_date_c',
          'label' => 'LBL_CLOSED_DATE',
        ),
      ),
      5 => 
      array (
        0 => 'sales_stage',
        1 => 
        array (
          'name' => 'status_c',
          'studio' => 'visible',
          'label' => 'LBL_STATUS',
        ),
      ),
      6 => 
      array (
        0 => 'probability',
      ),
      7 => 
      array (
        0 => 
        array (
          'name' => 'description',
          'comment' => 'Full text of the note',
          'label' => 'LBL_DESCRIPTION',
        ),
      ),
      8 => 
      array (
        0 => 
        array (
          'name' => 'next_step_temp_c',
          'label' => 'LBL_NEXT_STEP_TEMP',
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
        ),
      ),
    ),
  ),
);