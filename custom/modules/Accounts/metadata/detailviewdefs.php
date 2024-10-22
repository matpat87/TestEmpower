<?php
$viewdefs ['Accounts'] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'buttons' => 
        array (
          'SEND_CONFIRM_OPT_IN_EMAIL' => 
          array (
            'customCode' => '<input type="submit" class="button hidden" disabled="disabled" title="{$APP.LBL_SEND_CONFIRM_OPT_IN_EMAIL}" onclick="this.form.return_module.value=\'Accounts\'; this.form.return_action.value=\'Accounts\'; this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'sendConfirmOptInEmail\'; this.form.module.value=\'Accounts\'; this.form.module_tab.value=\'Accounts\';" name="send_confirm_opt_in_email" value="{$APP.LBL_SEND_CONFIRM_OPT_IN_EMAIL}"/>',
            'sugar_html' => 
            array (
              'type' => 'submit',
              'value' => '{$APP.LBL_SEND_CONFIRM_OPT_IN_EMAIL}',
              'htmlOptions' => 
              array (
                'class' => 'button hidden',
                'id' => 'send_confirm_opt_in_email',
                'title' => '{$APP.LBL_SEND_CONFIRM_OPT_IN_EMAIL}',
                'onclick' => 'this.form.return_module.value=\'Accounts\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'sendConfirmOptInEmail\'; this.form.module.value=\'Accounts\'; this.form.module_tab.value=\'Accounts\';',
                'name' => 'send_confirm_opt_in_email',
                'disabled' => true,
              ),
            ),
          ),
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
          3 => 'FIND_DUPLICATES',
          'AOS_GENLET' => 
          array (
            'customCode' => '<input type="button" class="button" onClick="showPopup();" value="{$APP.LBL_PRINT_AS_PDF}">',
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
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'modules/Accounts/Account.js',
        ),
      ),
      'useTabs' => true,
      'tabDefs' => 
      array (
        'LBL_ACCOUNT_INFORMATION' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_ADVANCED' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_FORECASTS' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_DETAILVIEW_PANEL1' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'lbl_account_information' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'comment' => 'Name of the Company',
            'label' => 'LBL_NAME',
          ),
          1 => 
          array (
            'name' => 'status_c',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'phone_office',
            'comment' => 'The office phone number',
            'label' => 'LBL_PHONE_OFFICE',
          ),
          1 => 
          array (
            'name' => 'phone_fax',
            'comment' => 'The fax phone number of this company',
            'label' => 'LBL_FAX',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'email1',
            'studio' => 'false',
            'label' => 'LBL_EMAIL',
          ),
          1 => 
          array (
            'name' => 'website',
            'type' => 'link',
            'label' => 'LBL_WEBSITE',
            'displayParams' => 
            array (
              'link_target' => '_blank',
            ),
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'sites_c',
            'studio' => 'visible',
            'label' => 'LBL_SITES',
          ),
          1 => 
          array (
            'name' => 'ship_to_company_c',
            'label' => 'LBL_SHIP_TO_COMPANY',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'billing_address_street',
            'label' => 'LBL_BILLING_ADDRESS',
            'type' => 'DropdownCountryAddress',
            'displayParams' => 
            array (
              'key' => 'billing',
            ),
          ),
          1 => 
          array (
            'name' => 'shipping_address_street',
            'label' => 'LBL_SHIPPING_ADDRESS',
            'type' => 'DropdownCountryAddress',
            'displayParams' => 
            array (
              'key' => 'shipping',
            ),
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'comment' => 'Full text of the note',
            'label' => 'LBL_DESCRIPTION',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'account_type',
            'comment' => 'The Company is of this type',
            'label' => 'LBL_TYPE',
          ),
          1 => 
          array (
            'name' => 'parent_name',
            'label' => 'LBL_RELATED_ACCOUNTS_RELATED_ACCT',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO',
          ),
          1 => 'users_accounts_3_name',
        ),
      ),
      'LBL_PANEL_ADVANCED' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'marketing_information_non_db',
            'label' => 'Marketing Information',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'oem_c',
            'studio' => 'visible',
            'label' => 'LBL_OEM',
          ),
          1 => 
          array (
            'name' => 'client_potential_c',
            'studio' => 'visible',
            'label' => 'LBL_CLIENT_POTENTIAL',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'annual_revenue',
            'comment' => 'Annual revenue for this company',
            'label' => 'LBL_ANNUAL_REVENUE',
            'customCode' => '{$annual_revenue}',
          ),
          1 => 
          array (
            'name' => 'annual_revenue_potential_c',
            'label' => 'LBL_ANNUAL_REVENUE_POTENTIAL',
            'type' => 'varchar',
            'customCode' => '{$annual_revenue_potential_c}',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'manufacturing_type_c',
            'studio' => 'visible',
            'label' => 'LBL_MANUFACTURING_TYPE',
          ),
          1 => 
          array (
            'name' => 'employees',
            'comment' => 'Number of employees, varchar to accomodate for both number (100) or range (50-100)',
            'label' => 'LBL_EMPLOYEES',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'supply_position_c',
            'studio' => 'visible',
            'label' => 'LBL_SUPPLY_POSITION',
          ),
          1 => '',
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'currency_id',
            'studio' => 'visible',
            'label' => 'LBL_CURRENCY',
          ),
          1 => 
          array (
            'name' => 'account_class_c',
            'studio' => 'visible',
            'label' => 'LBL_ACCOUNT_CLASS',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'business_strategy_c',
            'studio' => 'visible',
            'label' => 'LBL_BUSINESS_STRATEGY',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'erp_data_non_db',
            'label' => 'ERP Data',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'terms_c',
            'label' => 'LBL_TERMS',
          ),
          1 => 
          array (
            'name' => 'company_no_c',
            'studio' => 'visible',
            'label' => 'LBL_COMPANY_NO',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'cr_limit_c',
            'label' => 'LBL_CR_LIMIT',
          ),
          1 => 
          array (
            'name' => 'cust_num_c',
            'label' => 'LBL_CUST_NUM',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'cr_hold_c',
            'label' => 'LBL_CR_HOLD',
          ),
          1 => 
          array (
            'name' => 'alt_sys_id_c',
            'label' => 'LBL_ALT_SYS_ID',
          ),
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'balance_c',
            'label' => 'LBL_BALANCE',
          ),
          1 => 
          array (
            'name' => 'order_cycle_c',
            'label' => 'LBL_ORDER_CYCLE',
          ),
        ),
        12 => 
        array (
          0 => 
          array (
            'name' => 'last_sale_amt_c',
            'label' => 'LBL_LAST_SALE_AMT',
          ),
          1 => 
          array (
            'name' => 'last_sold_dt_c',
            'label' => 'LBL_LAST_SOLD_DT',
          ),
        ),
        13 => 
        array (
          0 => 
          array (
            'name' => 'other_non_db',
            'label' => 'Other',
          ),
        ),
        14 => 
        array (
          0 => 
          array (
            'name' => 'integration_date_c',
            'label' => 'LBL_INTEGRATION_DATE',
          ),
        ),
        15 => 
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
        16 => 
        array (
          0 => 
          array (
            'name' => 'date_entered',
            'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
          ),
          1 => 
          array (
            'name' => 'date_modified',
            'label' => 'LBL_DATE_MODIFIED',
            'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
          ),
        ),
      ),
      'LBL_PANEL_FORECASTS' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'margin_forecast_percent_non_db',
            'label' => 'Margin Forecast (%)',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'gross_margin_c',
            'label' => 'LBL_GROSS_MARGIN',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'curr_year_margin_c',
            'label' => 'LBL_CURR_YEAR_MARGIN_C',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'ly_margin_c',
            'label' => 'LBL_LY_MARGIN_C',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'sales_forecast_percent_non_db',
            'label' => 'Sales Forecast ($)',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'sls_ytd_c',
            'label' => 'LBL_SLS_YTD',
            'customCode' => '${$custom_ytd_sales}',
          ),
          1 => 
          array (
            'name' => 'sls_ly_c',
            'label' => 'LBL_SLS_LY',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'ytd_budget_c',
            'label' => 'LBL_YTD_BUDGET',
          ),
          1 => 
          array (
            'name' => 'sls_lytd_c',
            'label' => 'LBL_SLS_LYTD',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'cur_year_month1_c',
            'label' => 'LBL_CUR_YEAR_MONTH1',
          ),
          1 => 
          array (
            'name' => 'cur_year_month2_c',
            'label' => 'LBL_CUR_YEAR_MONTH2',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'cur_year_month3_c',
            'label' => 'LBL_CUR_YEAR_MONTH3',
          ),
          1 => 
          array (
            'name' => 'cur_year_month4_c',
            'label' => 'LBL_CUR_YEAR_MONTH4_C',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'cur_year_month5_c',
            'label' => 'LBL_CUR_YEAR_MONTH5',
          ),
          1 => 
          array (
            'name' => 'cur_year_month6_c',
            'label' => 'LBL_CUR_YEAR_MONTH6',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'cur_year_month7_c',
            'label' => 'LBL_CUR_YEAR_MONTH7',
          ),
          1 => 
          array (
            'name' => 'cur_year_month8_c',
            'label' => 'LBL_CUR_YEAR_MONTH8',
          ),
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'cur_year_month9_c',
            'label' => 'LBL_CUR_YEAR_MONTH9',
          ),
          1 => 
          array (
            'name' => 'cur_year_month10_c',
            'label' => 'LBL_CUR_YEAR_MONTH10',
          ),
        ),
        12 => 
        array (
          0 => 
          array (
            'name' => 'cur_year_month11_c',
            'label' => 'LBL_CUR_YEAR_MONTH11',
          ),
          1 => 
          array (
            'name' => 'cur_year_month12_c',
            'label' => 'LBL_CUR_YEAR_MONTH12',
          ),
        ),
        13 => 
        array (
          0 => 
          array (
            'name' => 'volume_ytd_c',
            'label' => 'LBL_VOLUME_YTD',
          ),
          1 => 
          array (
            'name' => 'volume_ly_c',
            'label' => 'LBL_VOLUME_LY',
          ),
        ),
        14 => 
        array (
          0 => 
          array (
            'name' => 'jan_volume_c',
            'label' => 'LBL_JAN_VOLUME',
          ),
          1 => 
          array (
            'name' => 'feb_volume_c',
            'label' => 'LBL_FEB_VOLUME',
          ),
        ),
        15 => 
        array (
          0 => 
          array (
            'name' => 'mar_volume_c',
            'label' => 'LBL_MAR_VOLUME',
          ),
          1 => 
          array (
            'name' => 'apr_volume_c',
            'label' => 'LBL_APR_VOLUME',
          ),
        ),
        16 => 
        array (
          0 => 
          array (
            'name' => 'may_volume_c',
            'label' => 'LBL_MAY_VOLUME',
          ),
          1 => 
          array (
            'name' => 'jun_volume_c',
            'label' => 'LBL_JUN_VOLUME',
          ),
        ),
        17 => 
        array (
          0 => 
          array (
            'name' => 'jul_volume_c',
            'label' => 'LBL_JUL_VOLUME',
          ),
          1 => 
          array (
            'name' => 'aug_volume_c',
            'label' => 'LBL_AUG_VOLUME',
          ),
        ),
        18 => 
        array (
          0 => 
          array (
            'name' => 'sept_volume_c',
            'label' => 'LBL_SEPT_VOLUME',
          ),
          1 => 
          array (
            'name' => 'oct_volume_c',
            'label' => 'LBL_OCT_VOLUME',
          ),
        ),
        19 => 
        array (
          0 => 
          array (
            'name' => 'nov_volume_c',
            'label' => 'LBL_NOV_VOLUME',
          ),
          1 => 
          array (
            'name' => 'dec_volume_c',
            'label' => 'LBL_DEC_VOLUME_C',
          ),
        ),
        20 => 
        array (
          0 => 
          array (
            'name' => 'annual_budget_c',
            'label' => 'LBL_ANNUAL_BUDGET',
          ),
          1 => '',
        ),
        21 => 
        array (
          0 => 
          array (
            'name' => 'budget_cost_non_db',
            'label' => 'Budget Cost',
          ),
        ),
        22 => 
        array (
          0 => 
          array (
            'name' => 'budget_cost_01_jan_c',
            'label' => 'LBL_BUDGET_COST_01_JAN',
          ),
          1 => 
          array (
            'name' => 'budget_cost_07_jul_c',
            'label' => 'LBL_BUDGET_COST_07_JUL',
          ),
        ),
        23 => 
        array (
          0 => 
          array (
            'name' => 'budget_cost_02_feb_c',
            'label' => 'LBL_BUDGET_COST_02_FEB',
          ),
          1 => 
          array (
            'name' => 'budget_cost_08_aug_c',
            'label' => 'LBL_BUDGET_COST_08_AUG',
          ),
        ),
        24 => 
        array (
          0 => 
          array (
            'name' => 'budget_cost_03_mar_c',
            'label' => 'LBL_BUDGET_COST_03_MAR',
          ),
          1 => 
          array (
            'name' => 'budget_cost_09_sept_c',
            'label' => 'LBL_BUDGET_COST_09_SEPT',
          ),
        ),
        25 => 
        array (
          0 => 
          array (
            'name' => 'budget_cost_04_apr_c',
            'label' => 'LBL_BUDGET_COST_04_APR',
          ),
          1 => 
          array (
            'name' => 'budget_cost_10_oct_c',
            'label' => 'LBL_BUDGET_COST_10_OCT',
          ),
        ),
        26 => 
        array (
          0 => 
          array (
            'name' => 'budget_cost_05_may_c',
            'label' => 'LBL_BUDGET_COST_05_MAY',
          ),
          1 => 
          array (
            'name' => 'budget_cost_11_nov_c',
            'label' => 'LBL_BUDGET_COST_11_NOV',
          ),
        ),
        27 => 
        array (
          0 => 
          array (
            'name' => 'budget_cost_06_jun_c',
            'label' => 'LBL_BUDGET_COST_06_JUN',
          ),
          1 => 
          array (
            'name' => 'budget_cost_12_dec_c',
            'label' => 'LBL_BUDGET_COST_12_DEC',
          ),
        ),
      ),
      'lbl_detailview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'certification_note_c',
            'studio' => 'visible',
            'label' => 'LBL_CERTIFICATION_NOTE',
          ),
          1 => 
          array (
            'name' => 'color_readings_note_c',
            'studio' => 'visible',
            'label' => 'LBL_COLOR_READINGS_NOTE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'spc_note_c',
            'studio' => 'visible',
            'label' => 'LBL_SPC_NOTE',
          ),
          1 => 
          array (
            'name' => 'probe_note_c',
            'studio' => 'visible',
            'label' => 'LBL_PROBE_NOTE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'post_blend_note_c',
            'studio' => 'visible',
            'label' => 'LBL_POST_BLEND_NOTE',
          ),
          1 => 
          array (
            'name' => 'ash_test_note_c',
            'studio' => 'visible',
            'label' => 'LBL_ASH_TEST_NOTE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'melt_flow_note_c',
            'studio' => 'visible',
            'label' => 'LBL_MELT_FLOW_NOTE',
          ),
          1 => 
          array (
            'name' => 'bulk_density_note_c',
            'studio' => 'visible',
            'label' => 'LBL_BULK_DENSITY_NOTE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'chip_note_c',
            'studio' => 'visible',
            'label' => 'LBL_CHIP_NOTE',
          ),
          1 => 
          array (
            'name' => 'other_note_c',
            'studio' => 'visible',
            'label' => 'LBL_OTHER_NOTE',
          ),
        ),
      ),
    ),
  ),
);
;
?>
