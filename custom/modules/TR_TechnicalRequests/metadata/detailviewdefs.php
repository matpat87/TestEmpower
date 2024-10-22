<?php
$module_name = 'TR_TechnicalRequests';
$_object_name = 'tr_technicalrequests';
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
            'customCode' => '{$BTN_SUBMIT_TO_DEV_HTML}',
          ),
          2 => 
          array (
            'customCode' => '
              {if $SHOW_OR_HIDE_COPY_FULL_BUTTON}
                <form action="index.php?module=TR_TechnicalRequests&action=EditView&return_module=TR_TechnicalRequests&return_action=DetailView" method="POST" name="CustomForm" id="form">
                  <input type="hidden" name="is_copy_full" id="is_copy_full" value="true">
                  <input type="hidden" name="technical_request_id" id="technical_request_id" value="{$TECHNICAL_REQUEST_ID}">
                  <input type="submit" name="duplicate" id="duplicate" title="Copy Full" class="button" value="Copy Full">
                </form>
            {/if}',
          ),
          3 => 
          array (
            'customCode' => '
              {if 1 == 0} {* OnTrack 1933: Removed Copy Partial action item - Ref: $SHOW_OR_HIDE_COPY_FULL_BUTTON *}
                <form action="index.php?module=TR_TechnicalRequests&action=EditView&return_module=TR_TechnicalRequests&return_action=DetailView" method="POST" name="CustomForm" id="form">
                  <input type="hidden" name="is_copy_partial" id="is_copy_partial" value="true">
                  <input type="hidden" name="technical_request_id" id="technical_request_id" value="{$TECHNICAL_REQUEST_ID}">
                  <input type="submit" name="duplicate" id="duplicate" title="Duplicate" class="button" value="Copy Partial">
                </form>
              {/if}',
          ),
          4 => 
          array (
            'customCode' => '
                {if $SHOW_OR_HIDE_REMATCH_VERSION }
                <form action="index.php?module=TR_TechnicalRequests&action=EditView&return_module=TR_TechnicalRequests&return_action=DetailView" method="POST" name="CustomForm" id="form">
                    <input type="hidden" name="is_rematch_version" id="is_rematch_version" value="true">
                    <input type="hidden" name="technical_request_id" id="technical_request_id" value="{$TECHNICAL_REQUEST_ID}">
                    <input type="submit" name="duplicate" id="duplicate" title="Bracket Match" class="button" value="Bracket Match">
                </form>
                {/if}',
          ),
          5 => 
          array (
            'customCode' => '{if $SHOW_OR_HIDE_REMATCH_REJECTED_CMR}<form action="index.php?module=TR_TechnicalRequests&action=EditView&return_module=TR_TechnicalRequests&return_action=DetailView" method="POST" name="CustomForm" id="form">
                    <input type="hidden" name="is_rematch_rejected" id="is_rematch_rejected" value="true">
                    <input type="hidden" name="technical_request_id" id="technical_request_id" value="{$TECHNICAL_REQUEST_ID}">
                    <input type="submit" name="duplicate" id="duplicate" title="Rematch Lost CMR" class="button" value="Rematch Lost CMR">
                </form>{/if}',
          ),
          6 => 
          array (
            'customCode' => '{if $SHOW_OR_HIDE_TR_PRINTOUT_ACTION_BTN}
                <form action="index.php?entryPoint=TRPrint" method="POST" name="CustomTRPrintForm" id="form" target="_blank">
                    <input type="hidden" name="technical_request_id" id="technical_request_id" value="{$TECHNICAL_REQUEST_ID}">
                    <input type="submit" name="duplicate" id="duplicate" title="TR Printout" class="button" value="TR Printout">
                </form>
              {/if}',
          ),
          7 => 
          array (
            'customCode' => '<input title="Delete" accesskey="d" class="button" onclick="var _form = document.getElementById(\'formDetailView\'); _form.return_module.value=\'TR_TechnicalRequests\'; _form.return_action.value=\'ListView\'; _form.action.value=\'Delete\'; if(confirm(\'Are you sure you want to delete this record?\')) SUGAR.ajaxUI.submitForm(_form); return false;" type="submit" name="Delete" value="Delete" id="delete_button">',
          ),
          8 => 
          array (
            'customCode' => '
                {if $SHOW_CREATE_COVER_LETTER}
                <form action="index.php?entryPoint=TRCoverLetter" method="POST" name="CustomTRCoverLetter" id="form" target="_blank">
                    <input type="hidden" name="technical_request_id" id="technical_request_id" value="{$TECHNICAL_REQUEST_ID}">
                    <input type="submit" name="create_cover_letter" id="duplicate" title="Create Cover Letter" class="button" value="Create Cover Letter">
                </form>
                {/if}
              ',
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
        'LBL_GENERAL' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL1' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL2' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => true,
    ),
    'panels' => 
    array (
      'lbl_general' => 
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
            'name' => 'approval_stage',
            'studio' => 'visible',
            'label' => 'LBL_APPROVAL_STAGE',
          ),
          1 => 
          array (
            'name' => 'status',
            'comment' => 'The status of the issue',
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
            'name' => 'technicalrequests_number_c',
            'type' => 'varchar',
          ),
          1 => 
          array (
            'name' => 'version_c',
            'label' => 'LBL_VERSION',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'type',
            'comment' => 'The type of issue (ex: issue, feature)',
            'label' => 'LBL_TYPE',
          ),
          1 => 
          array (
            'name' => 'colormatch_type_c',
            'studio' => 'visible',
            'label' => 'LBL_COLORMATCH_TYPE',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'customCode' => '{$CUSTOM_NAME}',
          ),
          1 => 
          array (
            'name' => 'color_c',
            'studio' => 'visible',
            'label' => 'LBL_COLOR',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'tr_technicalrequests_opportunities_name',
          ),
          1 => 
          array (
            'name' => 'tr_technicalrequests_accounts_name',
            'label' => 'LBL_TR_TECHNICALREQUESTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'order_cycle_c',
            'studio' => 'visible',
            'label' => 'LBL_ORDER_CYCLE',
          ),
          1 => 
          array (
            'name' => 'contact_c',
            'studio' => 'visible',
            'label' => 'LBL_CONTACT',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'avg_sell_price_c',
            'label' => 'LBL_AVG_SELL_PRICE',
            'type' => 'varchar',
          ),
          1 => 
          array (
            'name' => 'annual_volume_c',
            'label' => 'LBL_ANNUAL_VOLUME',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'annual_amount_c',
            'label' => 'LBL_ANNUAL_AMOUNT',
            'type' => 'varchar',
          ),
          1 => 
          array (
            'name' => 'site',
            'studio' => 'visible',
            'label' => 'LBL_SITE',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'probability_c',
            'label' => 'LBL_PROBABILITY',
          ),
          1 => 
          array (
            'name' => 'annual_amount_weighted_c',
            'label' => 'LBL_ANNUAL_AMOUNT_WEIGHTED',
            'type' => 'varchar',
          ),
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'req_completion_date_c',
            'label' => 'LBL_REQ_COMPLETION_DATE',
          ),
          1 => 
          array (
            'name' => 'est_completion_date_c',
            'label' => 'LBL_EST_COMPLETION_DATE',
          ),
        ),
        12 => 
        array (
          0 => 
          array (
            'name' => 'special_instructions_c',
            'studio' => 'visible',
            'label' => 'LBL_SPECIAL_INSTRUCTIONS',
          ),
        ),
        13 => 
        array (
          0 => 
          array (
            'name' => 'updates',
            'studio' => 'visible',
            'label' => 'LBL_TECHNICAL_REQUEST_UPDATE',
          ),
        ),
        14 => 
        array (
          0 => 
          array (
            'name' => 'distro_type_c',
            'studio' => 'visible',
            'label' => 'LBL_DISTRO_TYPE',
          ),
          1 => 
          array (
            'name' => 'related_technical_request_c',
            'studio' => 'visible',
            'label' => 'LBL_RELATED_TECHNICAL_REQUEST',
          ),
        ),
        15 => 
        array (
          0 => 
          array (
            'name' => 'created_by_name',
            'label' => 'LBL_SUBMITTED_BY',
          ),
          1 => 
          array (
            'name' => 'date_entered',
            'comment' => 'Date record created',
            'label' => 'LBL_SUBMITTED_DATE',
            'customCode' => '{$DATE_ENTERED}',
          ),
        ),
        16 => 
        array (
          0 => 'assigned_user_name',
          1 => 
          array (
            'name' => 'actual_close_date_c',
            'label' => 'LBL_ACTUAL_CLOSE_DATE',
          ),
        ),
        17 => 
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
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'product_information_non_db',
            'customCode' => '<div id="product_information_non_db" class="custom-panel">Product Information</div>',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'cm_product_form_c',
            'studio' => 'visible',
            'label' => 'LBL_CM_PRODUCT_FORM',
          ),
          1 => 
          array (
            'name' => 'target_letdown_c',
            'studio' => 'visible',
            'label' => 'LBL_TARGET_LETDOWN',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'product_category_c',
            'customCode' => '<a href="index.php?module=AOS_Product_Categories&action=DetailView&record={$PRODUCT_CATEGORY_ID}">{$PRODUCT_CATEGORY_NAME}</a>',
          ),
          1 => 
          array (
            'name' => 'is_improve_letdown_c',
            'label' => 'LBL_IS_IMPROVE_LETDOWN',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'cm_customer_process_c',
            'studio' => 'visible',
            'label' => 'LBL_CM_CUSTOMER_PROCESS',
          ),
          1 => 
          array (
            'name' => 'application_c',
            'label' => 'LBL_APPLICATION',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'cm_customer_number_c',
            'label' => 'LBL_CM_CUSTOMER_NUMBER',
          ),
          1 => 
          array (
            'name' => 'customer_part_name_c',
            'label' => 'LBL_CUSTOMER_PART_NAME',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'industry_spec_c',
            'studio' => 'visible',
            'label' => 'LBL_INDUSTRY_SPEC',
          ),
          1 => 
          array (
            'name' => 'industry_note_c',
            'label' => 'LBL_INDUSTRY_NOTE',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'is_return_customer_part_c',
            'label' => 'LBL_IS_RETURN_CUSTOMER_PART',
          ),
          1 => '',
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'special_effects_c',
            'studio' => 'visible',
            'label' => 'LBL_SPECIAL_EFFECTS',
          ),
          1 => '',
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'custom_competitor_information_label_non_db',
            'customCode' => '<div id="custom_competitor_information_label_non_db" class="custom-panel">Competitor Information</div>',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'competitor_c',
            'studio' => 'visible',
            'label' => 'LBL_COMPETITOR',
          ),
          1 => 
          array (
            'name' => 'ci_competitor_c',
            'studio' => 'visible',
            'label' => 'LBL_CI_COMPETITOR',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'match_article_c',
            'label' => 'LBL_MATCH_ARTICLE',
          ),
          1 => 
          array (
            'name' => 'ci_product_form_c',
            'studio' => 'visible',
            'label' => 'LBL_CI_PRODUCT_FORM',
          ),
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'price_c',
            'label' => 'LBL_PRICE',
            'type' => 'varchar',
          ),
        ),
        12 => 
        array (
          0 => 
          array (
            'name' => 'custom_customer_base_label_non_db',
            'customCode' => '<div id="custom_customer_base_label_non_db" class="custom-panel">Customer Base</div>',
          ),
        ),
        13 => 
        array (
          0 => 
          array (
            'name' => 'resin_compound_type_c',
            'studio' => 'visible',
            'label' => 'LBL_RESIN_COMPOUND_TYPE',
          ),
        ),
        14 => 
        array (
          0 => 
          array (
            'name' => 'match_in_customers_resin_c',
            'studio' => 'visible',
            'label' => 'LBL_MATCH_IN_CUSTOMERS_RESIN',
          ),
          1 => 
          array (
            'name' => 'mfg_c',
            'label' => 'LBL_MFG',
          ),
        ),
        15 => 
        array (
          0 => 
          array (
            'name' => 'grade_id_number_c',
            'label' => 'LBL_GRADE_ID_NUMBER',
          ),
          1 => 
          array (
            'name' => 'melt_index_c',
            'label' => 'LBL_MELT_INDEX',
          ),
        ),
        16 => 
        array (
          0 => 
          array (
            'name' => 'customer_provided_c',
            'label' => 'LBL_CUSTOMER_PROVIDED',
          ),
          1 => '',
        ),
        17 => 
        array (
          0 => 
          array (
            'name' => 'safety_data_sheet_new_c',
            'studio' => 'visible',
            'label' => 'LBL_SAFETY_DATA_SHEET_NEW',
          ),
          1 => 
          array (
            'name' => 'technical_data_sheet_c',
            'studio' => 'visible',
            'label' => 'LBL_TECHNICAL_DATA_SHEET',
          ),
        ),
        18 => 
        array (
          0 => 
          array (
            'name' => 'custom_stability_label_non_db',
            'customCode' => '<div id="custom_stability_label_non_db" class="custom-panel">Stability</div>',
          ),
        ),
        19 => 
        array (
          0 => 
          array (
            'name' => 'light_c',
            'studio' => 'visible',
            'label' => 'LBL_LIGHT',
          ),
        ),
        20 => 
        array (
          0 => 
          array (
            'name' => 'stability_comments_c',
            'studio' => 'visible',
            'label' => 'LBL_STABILITY_COMMENTS',
          ),
        ),
        21 => 
        array (
          0 => 
          array (
            'name' => 'heat_in_f_c',
            'studio' => 'visible',
            'label' => 'LBL_HEAT_IN_F',
          ),
        ),
        22 => 
        array (
          0 => 
          array (
            'name' => 'custom_additives_label_non_db',
            'customCode' => '<div id="custom_additives_label_non_db" class="custom-panel">Additives</div>',
          ),
        ),
        23 => 
        array (
          0 => 
          array (
            'name' => 'ad_type_1_c',
            'studio' => 'visible',
            'label' => 'LBL_AD_TYPE_1',
          ),
          1 => 
          array (
            'name' => 'ad_percent_1_c',
            'label' => 'LBL_AD_PERCENT_1',
          ),
        ),
        24 => 
        array (
          0 => 
          array (
            'name' => 'ad_type_2_c',
            'studio' => 'visible',
            'label' => 'LBL_AD_TYPE_2',
          ),
          1 => 
          array (
            'name' => 'ad_percent_2_c',
            'label' => 'LBL_AD_PERCENT_2',
          ),
        ),
        25 => 
        array (
          0 => 
          array (
            'name' => 'ad_type_3_c',
            'studio' => 'visible',
            'label' => 'LBL_AD_TYPE_3',
          ),
          1 => 
          array (
            'name' => 'ad_percent_3_c',
            'label' => 'LBL_AD_PERCENT_3',
          ),
        ),
        26 => 
        array (
          0 => 
          array (
            'name' => 'ad_comment_c',
            'studio' => 'visible',
            'label' => 'LBL_AD_COMMENT',
          ),
        ),
        27 => 
        array (
          0 => 
          array (
            'name' => 'part_decoration_c',
            'studio' => 'visible',
            'label' => 'LBL_PART_DECORATION',
          ),
        ),
        28 => 
        array (
          0 => 
          array (
            'name' => 'custom_opacity_texture_label_non_db',
            'customCode' => '<div id="custom_opacity_texture_label_non_db" class="custom-panel">Special Testing</div>',
          ),
        ),
        29 => 
        array (
          0 => 
          array (
            'name' => 'opacity_level_c',
            'studio' => 'visible',
            'label' => 'LBL_OPACITY_LEVEL',
          ),
          1 => 
          array (
            'name' => 'thickness_c',
            'label' => 'LBL_THICKNESS',
          ),
        ),
        30 => 
        array (
          0 => 
          array (
            'name' => 'ot_comments_c',
            'studio' => 'visible',
            'label' => 'LBL_OT_COMMENTS',
          ),
          1 => 
          array (
            'name' => 'finished_part_texture_c',
            'studio' => 'visible',
            'label' => 'LBL_FINISHED_PART_TEXTURE',
          ),
        ),
        31 => 
        array (
          0 => 
          array (
            'name' => 'custom_tolerance_label_non_db',
            'customCode' => '<div id="custom_tolerance_label_non_db" class="custom-panel">Tolerance</div>',
          ),
        ),
        32 => 
        array (
          0 => 
          array (
            'name' => 'visual_match_c',
            'label' => 'LBL_VISUAL_MATCH',
          ),
          1 => 
          array (
            'name' => 'visual_type_c',
            'studio' => 'visible',
            'label' => 'LBL_VISUAL_TYPE',
          ),
        ),
        33 => 
        array (
          0 => 
          array (
            'name' => 'instrumental_match_c',
            'label' => 'LBL_INSTRUMENTAL_MATCH',
          ),
          1 => 
          array (
            'name' => 'de_max_c',
            'studio' => 'visible',
            'label' => 'LBL_DE_MAX',
          ),
        ),
        34 => 
        array (
          0 => 
          array (
            'name' => 'lab_or_cmc_c',
            'label' => 'LBL_LAB_OR_CMC',
          ),
          1 => 
          array (
            'name' => 'delta_l_a_b_max_c',
            'label' => 'LBL_DELTA_L_A_B_MAX',
          ),
        ),
        35 => 
        array (
          0 => 
          array (
            'name' => 'light_source_c',
            'studio' => 'visible',
            'label' => 'LBL_LIGHT_SOURCE',
          ),
        ),
      ),
      'lbl_editview_panel2' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'product_information_panel_non_db',
            'label' => 'LBL_PRODUCT_INFORMATION_PANEL_NON_DB',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'fda_food_contact_c',
            'studio' => 'visible',
            'label' => 'LBL_FDA_FOOD_CONTACT',
          ),
          1 => 
          array (
            'name' => 'raw_material_substitutions_c',
            'studio' => 'visible',
            'label' => 'LBL_RAW_MATERIAL_SUBSTITUTIONS',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'temperature_and_conditions_c',
            'label' => 'LBL_TEMPERATURE_AND_CONDITIONS',
          ),
          1 => 
          array (
            'name' => 'mmp_medical_c',
            'studio' => 'visible',
            'label' => 'LBL_MMP_MEDICAL',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'reach_svhc_c',
            'studio' => 'visible',
            'label' => 'LBL_REACH_SVHC',
          ),
          1 => '',
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'is_rohs_c',
            'label' => 'LBL_IS_ROHS',
          ),
          1 => 
          array (
            'name' => 'is_toys_c',
            'label' => 'LBL_IS_TOYS',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'prop_65_c',
            'studio' => 'visible',
            'label' => 'LBL_PROP_65',
          ),
          1 => 
          array (
            'name' => 'is_housewares_c',
            'label' => 'LBL_IS_HOUSEWARES',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'is_heavy_metal_free_c',
            'label' => 'LBL_IS_HEAVY_METAL_FREE',
          ),
          1 => '',
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'physical_material_properties_panel_non_db',
            'label' => 'LBL_PHYSICAL_MATERIAL_PROPERTIES_PANEL_NON_DB',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'is_diarylide_free_c',
            'label' => 'LBL_IS_DIARYLIDE_FREE',
          ),
          1 => 
          array (
            'name' => 'is_acid_resistant_pigment_c',
            'label' => 'LBL_IS_ACID_RESISTANT_PIGMENT',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'is_iron_oxide_pigment_ok_c',
            'label' => 'LBL_IS_IRON_OXIDE_PIGMENT_OK',
          ),
          1 => 
          array (
            'name' => 'sterilization_required_c',
            'studio' => 'visible',
            'label' => 'LBL_STERILIZATION_REQUIRED',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'other_material_restriction_c',
            'label' => 'LBL_OTHER_MATERIAL_RESTRICTION',
          ),
          1 => '',
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'customer_certifications_panel_non_db',
            'label' => 'LBL_CUSTOMER_CERTIFICATIONS_PANEL_NON_DB',
          ),
        ),
        12 => 
        array (
          0 => 
          array (
            'name' => 'ul_cert_c',
            'studio' => 'visible',
            'label' => 'LBL_UL_CERT',
          ),
          1 => 
          array (
            'name' => 'nsf_cert_c',
            'studio' => 'visible',
            'label' => 'LBL_NSF_CERT',
          ),
        ),
        13 => 
        array (
          0 => 
          array (
            'name' => 'is_cpsia_c',
            'label' => 'LBL_IS_CPSIA',
          ),
          1 => 
          array (
            'name' => 'r_other_cert_c',
            'label' => 'LBL_R_OTHER_CERT',
          ),
        ),
      ),
    ),
  ),
);
;
?>
