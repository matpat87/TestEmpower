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
          1 => 
          array (
            'customCode' => '<form action="index.php?module=Opportunities&action=EditView&return_module=Opportunities&return_action=DetailView" method="POST" name="CustomForm" id="form">
                <input type="hidden" name="is_duplicate" id="is_duplicate" value="true">
                <input type="hidden" name="record_id" id="record_id" value="{$OPPORTUNITY_ID}">
                <input type="submit" name="duplicate" id="duplicate" title="Copy Opportunity" class="button" value="Copy Opportunity">
              </form>',
          ),
          2 => 'DELETE',
          3 => 'FIND_DUPLICATES',
          4 => 
          array (
            'customCode' => '<form action="index.php?entryPoint=OppSumReportEntryPoint" method="POST" name="CustomForm" id="form" target="_blank">
                <input type="hidden" name="record_id" id="record_id" value="{$OPPORTUNITY_ID}">
                <input type="submit" title="Opportunity Summary Report" class="button" value="Opportunity Summary Report">
              </form>',
          ),
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
      'syncDetailEditViews' => true,
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
            'customCode' => '{$CUSTOM_STATUS_DISPLAY}',
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
          ),
          1 => 'account_name',
        ),
        4 => 
        array (
          0 => 'name',
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
            'type' => 'varchar',
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
            'label' => '{$MOD.LBL_AMOUNT} ({$CURRENCY})',
            'type' => 'varchar',
          ),
          1 => 
          array (
            'name' => 'currency_id',
            'comment' => 'Currency used for display purposes',
            'label' => 'LBL_CURRENCY',
          ),
        ),
        8 => 
        array (
          0 => 'date_closed',
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
            'customCode' => '{$fields.probability_prcnt_c.value}',
          ),
          1 => 
          array (
            'name' => 'amount_weighted_c',
            'label' => 'LBL_AMOUNT_WEIGHTED',
            'type' => 'varchar',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'nl2br' => true,
          ),
        ),
        11 => 
        array (
          0 => 'next_step',
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
          ),
          1 => 
          array (
            'name' => 'sub_industry_c',
            'studio' => 'visible',
            'label' => 'LBL_SUB_INDUSTRY',
            'customCode' => '{$SUB_INDUSTRY_NAME}',
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
            'customCode' => '{$INDUSTRY_NAME}',
          ),
        ),
      ),
      'LBL_PANEL_ASSIGNMENT' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'last_activity_date_c',
            'label' => 'LBL_LAST_ACTIVITY_DATE',
          ),
          1 => 
          array (
            'name' => 'last_activity_type_c',
            'label' => 'LBL_LAST_ACTIVITY_TYPE',
            'customCode' => '<a href={$custom_last_activity_link}>{$fields.last_activity_type_c.value}</a>',
          ),
        ),
        1 => 
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
