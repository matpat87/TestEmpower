<?php
$module_name = 'AOS_Products';
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
          1 => 
          array (
            'customCode' => '{if $SHOW_OR_HIDE_TR_PRINTOUT_ACTION_BTN}
                <form action="index.php?entryPoint=TRPrint" method="POST" name="CustomTRPrintForm" id="form" target="_blank">
                    <input type="hidden" name="technical_request_id" id="technical_request_id" value="{$TECHNICAL_REQUEST_ID}">
                    <input type="hidden" name="product_id" id="product_id" value="{$PRODUCT_ID}">
                    <input type="submit" name="duplicate" id="duplicate" title="TR Printout" class="button" value="TR Printout">
                </form>
              {/if}',
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
        'LBL_DETAILVIEW_PANEL5' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_DETAILVIEW_PANEL7' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_DETAILVIEW_PANEL4' => 
        array (
          'newTab' => true,
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
            'name' => 'workflow_section_non_db',
            'label' => 'Workflow Section',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'type',
            'label' => 'LBL_TYPE',
          ),
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
            'name' => 'product_number_c',
            'label' => 'LBL_PRODUCT_NUMBER',
          ),
          1 => '',
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'version_c',
            'label' => 'LBL_VERSION',
          ),
          1 => 
          array (
            'name' => 'name',
            'label' => 'LBL_NAME',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'site_c',
            'studio' => 'visible',
            'label' => 'LBL_SITE',
          ),
          1 => 
          array (
            'name' => 'related_product_c',
            'studio' => 'visible',
            'label' => 'LBL_RELATED_PRODUCT',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'user_lab_manager_c',
            'studio' => 'visible',
            'label' => 'LBL_USER_LAB_MANAGER',
          ),
          1 => '',
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'cost',
            'label' => 'LBL_COST',
          ),
          1 => 
          array (
            'name' => 'scheduling_code_c',
            'label' => 'LBL_SCHEDULING_CODE',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'priority_level_c',
            'studio' => 'visible',
            'label' => 'LBL_PRIORITY_LEVEL',
          ),
          1 => 
          array (
            'name' => 'complexity_c',
            'studio' => 'visible',
            'label' => 'LBL_COMPLEXITY',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'label' => 'LBL_DESCRIPTION',
          ),
          1 => 
          array (
            'name' => 'product_image_pic_c',
            'studio' => 'visible',
            'label' => 'LBL_PRODUCT_IMAGE_PIC',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'number_of_attempts_c',
            'label' => 'LBL_NUMBER_OF_ATTEMPTS',
          ),
          1 => 
          array (
            'name' => 'number_of_hours_c',
            'label' => 'LBL_NUMBER_OF_HOURS',
          ),
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'created_by_name',
            'label' => 'LBL_CREATED',
          ),
          1 => 
          array (
            'name' => 'date_entered',
            'comment' => 'Date record created',
            'label' => 'LBL_DATE_ENTERED',
            'customCode' => '{$fields.date_entered.value}',
          ),
        ),
        12 => 
        array (
          0 => 
          array (
            'name' => 'due_date_c',
            'label' => 'LBL_DUE_DATE',
          ),
          1 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
          ),
        ),
      ),
      'lbl_detailview_panel5' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'base_resin_c',
            'label' => 'LBL_BASE_RESIN',
          ),
          1 => 
          array (
            'name' => 'color_c',
            'label' => 'LBL_COLOR',
          ),
        ),
      ),
      'lbl_detailview_panel7' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'product_category_c',
            'customCode' => '<a href="index.php?module=AOS_Product_Categories&action=DetailView&record={$PRODUCT_CATEGORY_ID}">{$PRODUCT_CATEGORY_NAME}</a>',
          ),
          1 => '',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'resin_type_c',
            'studio' => 'visible',
            'label' => 'LBL_RESIN_TYPE',
          ),
          1 => 
          array (
            'name' => 'resin_grade_c',
            'label' => 'LBL_RESIN_GRADE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'geometry_c',
            'label' => 'LBL_GEOMETRY',
          ),
          1 => 
          array (
            'name' => 'fda_eu_food_contract_c',
            'label' => 'LBL_FDA_EU_FOOD_CONTRACT',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'comments_c',
            'studio' => 'visible',
            'label' => 'LBL_COMMENTS',
          ),
        ),
      ),
      'lbl_detailview_panel4' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'sales_panel_label_non_db',
            'label' => 'LBL_SALES_PANEL',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'total_sales_c',
            'label' => 'LBL_TOTAL_SALES',
            'customCode' => '{$TOTAL_SALES_C}',
          ),
          1 => 
          array (
            'name' => 'sales_last_year_c',
            'label' => 'LBL_SALES_LAST_YEAR',
            'customCode' => '{$SALES_LAST_YEAR_C}',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'sales_pytd_c',
            'label' => 'LBL_SALES_PYTD',
            'customCode' => '{$SALES_PYTD_C}',
          ),
          1 => 
          array (
            'name' => 'sales_cytd_c',
            'label' => 'LBL_SALES_CYTD',
            'customCode' => '{$SALES_CYTD_C}',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'material_margin_py_c',
            'label' => 'LBL_MATERIAL_MARGIN_PY',
            'customCode' => '{$MATERIAL_MARGIN_PY_C}',
          ),
          1 => 
          array (
            'name' => 'material_margin_cy_c',
            'label' => 'LBL_MATERIAL_MARGIN_CY',
            'customCode' => '{$MATERIAL_MARGIN_CY_C}',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'sales_forecast_panel_label_non_db',
            'label' => 'LBL_SALES_FORECAST_PANEL',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'budget_jan_c',
            'label' => 'LBL_BUDGET_JAN',
            'customCode' => '{$BUDGET_JAN_C}',
          ),
          1 => 
          array (
            'name' => 'budget_feb_c',
            'label' => 'LBL_BUDGET_FEB',
            'customCode' => '{$BUDGET_FEB_C}',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'budget_mar_c',
            'label' => 'LBL_BUDGET_MAR',
            'customCode' => '{$BUDGET_MAR_C}',
          ),
          1 => 
          array (
            'name' => 'budget_apr_c',
            'label' => 'LBL_BUDGET_APR',
            'customCode' => '{$BUDGET_APR_C}',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'budget_may_c',
            'label' => 'LBL_BUDGET_MAY',
            'customCode' => '{$BUDGET_MAY_C}',
          ),
          1 => 
          array (
            'name' => 'budget_jun_c',
            'label' => 'LBL_BUDGET_JUN',
            'customCode' => '{$BUDGET_JUN_C}',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'budget_jul_c',
            'label' => 'LBL_BUDGET_JUL',
            'customCode' => '{$BUDGET_JUL_C}',
          ),
          1 => 
          array (
            'name' => 'budget_aug_c',
            'label' => 'LBL_BUDGET_AUG',
            'customCode' => '{$BUDGET_AUG_C}',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'budget_sep_c',
            'label' => 'LBL_BUDGET_SEP',
            'customCode' => '{$BUDGET_SEP_C}',
          ),
          1 => 
          array (
            'name' => 'budget_oct_c',
            'label' => 'LBL_BUDGET_OCT',
            'customCode' => '{$BUDGET_OCT_C}',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'budget_nov_c',
            'label' => 'LBL_BUDGET_NOV',
            'customCode' => '{$BUDGET_NOV_C}',
          ),
          1 => 
          array (
            'name' => 'budget_dec_c',
            'label' => 'LBL_BUDGET_DEC',
            'customCode' => '{$BUDGET_DEC_C}',
          ),
        ),
        11 => 
        array (
          0 => '',
          1 => '',
        ),
        12 => 
        array (
          0 => 
          array (
            'name' => 'ytd_forecast_c',
            'label' => 'LBL_YTD_FORECAST',
            'customCode' => '{$YTD_FORECAST_C}',
          ),
          1 => 
          array (
            'name' => 'annual_forecast_c',
            'label' => 'LBL_ANNUAL_FORECAST',
            'customCode' => '{$ANNUAL_FORECAST_C}',
          ),
        ),
        13 => 
        array (
          0 => 
          array (
            'name' => 'sales_margin_panel_label_non_db',
            'label' => 'LBL_SALES_MARGIN_PANEL',
          ),
        ),
        14 => 
        array (
          0 => 
          array (
            'name' => 'margin_c',
            'label' => 'LBL_MARGIN',
            'customCode' => '{$MARGIN_C}',
          ),
          1 => '',
        ),
        15 => 
        array (
          0 => 
          array (
            'name' => 'margin_prior_year_c',
            'label' => 'LBL_MARGIN_PRIOR_YEAR',
            'customCode' => '{$MARGIN_PRIOR_YEAR_C}',
          ),
          1 => 
          array (
            'name' => 'margin_current_year_c',
            'label' => 'LBL_MARGIN_CURRENT_YEAR',
            'customCode' => '{$MARGIN_CURRENT_YEAR_C}',
          ),
        ),
      ),
    ),
  ),
);
;
?>
