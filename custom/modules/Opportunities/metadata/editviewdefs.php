<?php
// created: 2023-03-30 08:57:28
$viewdefs['Opportunities']['EditView'] = array (
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
    'syncDetailEditViews' => false,
  ),
  'panels' => 
  array (
    'default' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'workflow_section_non_db',
          'label' => 'Workflow Section',
        ),
      ),
      1 => 
      array (
        0 => 'sales_stage',
        1 => 
        array (
          'name' => 'status_c',
          'studio' => 'visible',
          'label' => 'LBL_STATUS',
        ),
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'overview_section_non_db',
          'label' => 'Overview Section',
        ),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'oppid_c',
          'label' => 'LBL_OPPID',
          'type' => 'varchar',
          'customCode' => '<span class="sugar_field" id="{$fields.oppid_c.name}">{$fields.oppid_c.value}</span><input type="hidden" name="oppid_c" value="{$fields.oppid_c.value}" /><input type="hidden" name="{$fields.id.name}" value="{$fields.id.value}" />',
        ),
        1 => 'account_name',
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'name',
          'customCode' => '<input type="text" name="{$fields.name.name}" id="{$fields.name.name}" size="30" maxlength="50" value="{$fields.name.value}" title="" /> 
              <input type="hidden" name="opportunity_id" id="opportunity_id" value="{$fields.id.value}" />
              <input type="hidden" name="{$fields.date_modified.name}" id="{$fields.date_modified.name}" size="30" maxlength="50" value="{$fields.custom_date_modified_str.value}" title="" />',
        ),
        1 => 
        array (
          'name' => 'contact_c',
          'studio' => 'visible',
          'label' => 'LBL_CONTACT',
        ),
      ),
      5 => 
      array (
        0 => 'opportunity_type',
        1 => '',
      ),
      6 => 
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
      7 => 
      array (
        0 => 
        array (
          'name' => 'amount',
          'customCode' => '<input type="text" name="{$fields.amount.name}" id="{$fields.amount.name}" value="{$fields.amount.value}" maxlength="{$fields.amount.len}" class="custom-currency" />',
        ),
        1 => 
        array (
          'name' => 'currency_id',
          'label' => 'LBL_CURRENCY',
        ),
      ),
      8 => 
      array (
        0 => 
        array (
          'name' => 'date_closed',
        ),
        1 => 
        array (
          'name' => 'closed_date_c',
          'label' => 'LBL_CLOSED_DATE',
        ),
      ),
      9 => 
      array (
        0 => 
        array (
          'name' => 'probability_prcnt_c',
          'label' => 'LBL_PROBABILITY_PRCNT',
          'customCode' => '<input type="text" name="{$fields.probability_prcnt_c.name}" id="{$fields.probability_prcnt_c.name}" size="30" maxlength="{$fields.probability_prcnt_c.len}" 
              class="custom-readonly" readonly="readonly" value="{$fields.probability_prcnt_c.value}" title="" tabindex="0" style="width: 50px;">',
        ),
        1 => 
        array (
          'name' => 'amount_weighted_c',
          'label' => 'LBL_AMOUNT_WEIGHTED',
          'customCode' => '<input type="text" name="{$fields.amount_weighted_c.name}" id="{$fields.amount_weighted_c.name}" size="30" maxlength="{$fields.amount_weighted_c.len}" value="{$fields.amount_weighted_c.value}" title="" tabindex="0" class="custom-currency">',
        ),
      ),
      10 => 
      array (
        0 => 'description',
      ),
      11 => 
      array (
        0 => 'next_step_temp_c',
      ),
      12 => 
      array (
        0 => 
        array (
          'name' => 'marketing_information_non_db',
          'label' => 'LBL_MARKETING_INFORMATION_NON_DB',
        ),
      ),
      13 => 
      array (
        0 => 
        array (
          'name' => 'oem_account_c',
          'studio' => 'visible',
          'label' => 'LBL_OEM_ACCOUNT',
          'displayParams' => 
          array (
            'initial_filter' => '&oem_c_advanced=Yes&disable_security_groups_filter=true',
          ),
        ),
        1 => 
        array (
          'name' => 'sub_industry_c',
          'studio' => 'visible',
          'label' => 'LBL_SUB_INDUSTRY',
        ),
      ),
      14 => 
      array (
        0 => 
        array (
          'name' => 'market_c',
          'studio' => 'visible',
          'label' => 'LBL_MARKET',
        ),
        1 => 
        array (
          'name' => 'industry_c',
          'studio' => 'visible',
          'label' => 'LBL_INDUSTRY',
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
);