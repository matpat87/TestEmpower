<?php
// created: 2023-03-30 08:57:28
$viewdefs['Cases']['DetailView'] = array (
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
        4 => 
        array (
          'customCode' => '<form action="index.php?entryPoint=CustomerIssueCapaReport" method="POST" name="CustomCaseForm" id="form" target="_blank">
                  <input type="hidden" name="customer_issue_id" id="customer_issue_id" value="{$CUSTOMER_ISSUE_ID}">
                  <input type="submit" name="duplicate" id="duplicate" title="CAPA Report" class="button custom-hide-btn" value="CAPA Report">
                </form>',
        ),
        5 => 
        array (
          'customCode' => '{if $fields.status.value == "Draft"}<form action="index.php?module=Cases&action=EditView&return_module=Cases&return_action=DetailView" method="POST" name="CustomForm" id="form">
                  <input type="hidden" name="record" id="record" value="{$CUSTOMER_ISSUE_ID}">
                  <input type="hidden" name="submit_draft" id="submit_draft" value="true">
                  <input type="submit" name="duplicate" id="duplicate" title="Submit Issue" class="button" value="Submit Issue">
                </form>{/if}',
        ),
        6 => 
        array (
          'customCode' => '{if $SHOW_DISPOSITION_FORM}<form action="index.php?entryPoint=CustomerIssueDispositionFormPDF" method="POST" name="CustomerIssueDispositionFormPDF" id="form" target="_blank">
              <input type="hidden" name="customer_issue_id" id="customer_issue_id" value="{$CUSTOMER_ISSUE_ID}">
              <input type="submit" name="duplicate" id="duplicate" title="Disposition Form" class="button" value="Disposition Form">
            </form>{/if}',
        ),
        7 => 
        array (
          'customCode' => '{if $SHOW_QUALITY_ALERT}<form action="index.php?entryPoint=CustomerIssueQualityAlertPDF" method="POST" name="CustomerIssueQualityAlertPDF" id="form" target="_blank">
              <input type="hidden" name="customer_issue_id" id="customer_issue_id" value="{$CUSTOMER_ISSUE_ID}">
              <input type="submit" name="duplicate" id="duplicate" title="Quality Alert" class="button" value="Quality Alert">
            </form>{/if}',
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
        'file' => 'custom/modules/Cases/js/custom-detail.js',
      ),
    ),
    'useTabs' => true,
    'tabDefs' => 
    array (
      'LBL_CASE_INFORMATION' => 
      array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
      'LBL_DETAILVIEW_PANEL7' => 
      array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
      'LBL_EDITVIEW_PANEL1' => 
      array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
      'LBL_EDITVIEW_PANEL5' => 
      array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
      'LBL_EDITVIEW_PANEL6' => 
      array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
    ),
    'syncDetailEditViews' => true,
  ),
  'panels' => 
  array (
    'lbl_case_information' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'case_number',
          'label' => 'LBL_CASE_NUMBER',
        ),
        1 => 
        array (
          'name' => 'status',
          'label' => 'LBL_STATUS',
          'customCode' => '{$CUSTOM_STATUS_DISPLAY}',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'name',
          'label' => 'LBL_SUBJECT',
        ),
        1 => 
        array (
          'name' => 'created_by_name',
          // 'label' => 'LBL_CREATED',
        ),
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'source_c',
          'studio' => 'visible',
          'label' => 'LBL_SOURCE',
        ),
        1 => 
        array (
          'name' => 'create_date_c',
          'label' => 'LBL_CREATE_DATE',
        ),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'site_c',
          'studio' => 'visible',
          'label' => 'LBL_SITE',
        ),
        1 => 'account_name',
      ),
      4 => 
      array (
        0 => '',
        1 => 
        array (
          'name' => 'contact_created_by_name',
          'label' => 'LBL_CONTACT_CREATED_BY_NAME',
          'studio' => 'visible',
        ),
      ),
      5 => 
      array (
        0 => 'description',
        1 => 
        array (
          'name' => 'status_update_log_c',
          'studio' => 'visible',
          'label' => 'LBL_STATUS_UPDATE_LOG',
        ),
      ),
      6 =>
      array (
        0 => 
        array (
          'name' => 'aos_invoices_cases_1_name',
          'label' => 'LBL_AOS_INVOICES_CASES_1_FROM_AOS_INVOICES_TITLE',
        ),
        1 => 
        array (
          'name' => 'customer_po_c',
          'label' => 'LBL_CUSTOMER_PO',
        ),
      ),
      7 =>
      array (
        0 =>
        array (
          'name' => 'price_c',
          'label' => 'LBL_PRICE',
        ),
        1 => '',
      ),
      8 =>
      array (
        0 => 
        array (
          'name' => 'potential_claim_c',
          'studio' => 'visible',
          'label' => 'LBL_POTENTIAL_CLAIM',
        ),
        1 => 
        array (
          'name' => 'potential_return_c',
          'studio' => 'visible',
          'label' => 'LBL_POTENTIAL_RETURN',
        ),
      ),
      9 =>
      array (
        0 => 
        array (
          'name' => 'images_c',
          'label' => 'LBL_IMAGES',
        ),
      ),
      10 =>
      array (
        0 =>
        array (
          'name' => 'line_items',
          'label' => 'LBL_LINE_ITEMS',
        ),
      ),
    ),
    'lbl_detailview_panel7' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'ci_type_c',
          'studio' => 'visible',
          'label' => 'LBL_CI_TYPE',
        ),
        1 => 'priority',
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'ci_department_c',
          'studio' => 'visible',
          'label' => 'LBL_DEPARTMENT',
        ),
        1 => 'type',
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'due_date_c',
          'label' => 'LBL_DUE_DATE',
        ),
        1 => 
        array (
          'name' => 'return_authorization_number_c',
          'label' => 'LBL_RETURN_AUTHORIZATION_NUMBER',
        ),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'assigned_user_name',
          'label' => 'LBL_ASSIGNED_TO',
        ),
        1 => 
        array (
          'name' => 'close_date_c',
          'label' => 'LBL_CLOSE_DATE',
        ),
      ),
    ),
    'lbl_editview_panel1' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'product_customer_process_non_db',
          'label' => 'Customer Process',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'customer_process_c',
          'studio' => 'visible',
          'label' => 'LBL_CUSTOMER_PROCESS',
        ),
        1 => 
        array (
          'name' => 'process_text_c',
          'label' => 'LBL_PROCESS_TEXT',
        ),
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'zone_temp_c',
          'label' => 'LBL_ZONE_TEMP',
        ),
        1 => 
        array (
          'name' => 'back_pressure_c',
          'label' => 'LBL_BACK_PRESSURE',
        ),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'cycle_time_c',
          'label' => 'LBL_CYCLE_TIME',
        ),
        1 => 
        array (
          'name' => 'residence_time_c',
          'label' => 'LBL_RESIDENCE_TIME',
        ),
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'barrel_capacity_c',
          'label' => 'LBL_BARREL_CAPACITY',
        ),
        1 => 
        array (
          'name' => 'shot_size_c',
          'label' => 'LBL_SHOT_SIZE',
        ),
      ),
      5 => 
      array (
        0 => 
        array (
          'name' => 'number_of_cavities_c',
          'label' => 'LBL_NUMBER_OF_CAVITIES',
        ),
        1 => 
        array (
          'name' => 'hot_runner_tool_c',
          'label' => 'LBL_HOT_RUNNER_TOOL',
        ),
      ),
      6 => 
      array (
        0 => 
        array (
          'name' => 'conventional_tool_c',
          'label' => 'LBL_CONVENTIONAL_TOOL',
        ),
        1 => 
        array (
          'name' => 'resin_type_c',
          'label' => 'LBL_RESIN_TYPE',
        ),
      ),
      7 => 
      array (
        0 => 
        array (
          'name' => 'resin_mfr_c',
          'label' => 'LBL_RESIN_MFR',
        ),
        1 => 
        array (
          'name' => 'grade_c',
          'label' => 'LBL_GRADE',
        ),
      ),
      8 => 
      array (
        0 => 
        array (
          'name' => 'melt_index_c',
          'label' => 'LBL_MELT_INDEX',
        ),
        1 => 
        array (
          'name' => 'regrind_c',
          'label' => 'LBL_REGRIND',
        ),
      ),
      9 => 
      array (
        0 => 
        array (
          'name' => 'drum_tumble_c',
          'label' => 'LBL_DRUM_TUMBLE',
        ),
        1 => 
        array (
          'name' => 'volumetric_c',
          'label' => 'LBL_VOLUMETRIC',
        ),
      ),
      10 => 
      array (
        0 => 
        array (
          'name' => 'gravimetric_c',
          'label' => 'LBL_GRAVIMETRIC',
        ),
        1 => 
        array (
          'name' => 'other_c',
          'label' => 'LBL_OTHER',
        ),
      ),
      11 => 
      array (
        0 => 
        array (
          'name' => 'product_disposition_non_db',
          'label' => 'Disposition',
        ),
      ),
      12 => 
      array (
        0 => 
        array (
          'name' => 'customer_material_dispo_c',
          'studio' => 'visible',
          'label' => 'LBL_CUSTOMER_MATERIAL_DISPO',
        ),
        1 => 
        array (
          'name' => 'internal_material_dispo_c',
          'studio' => 'visible',
          'label' => 'LBL_INTERNAL_MATERIAL_DISPO',
        ),
      ),
      13 => 
      array (
        0 => 
        array (
          'name' => 'lbs_matl_to_return_c',
          'label' => 'LBL_LBS_MATL_TO_RETURN',
        ),
        1 => 
        array (
          'name' => 'lbs_matl_returned_c',
          'label' => 'LBL_LBS_MATL_RETURNED',
        ),
      ),
      14 => 
      array (
        0 => 
        array (
          'name' => 'lbs_matl_to_replace_c',
          'label' => 'LBL_LBS_MATL_TO_REPLACE',
        ),
        1 => 
        array (
          'name' => 'lbs_matl_replaced_c',
          'label' => 'LBL_LBS_MATL_REPLACED',
        ),
      ),
      15 => 
      array (
        0 => 
        array (
          'name' => 'credit_amount_c',
          'label' => 'LBL_CREDIT_AMOUNT',
        ),
      ),
      16 => 
      array (
        0 => 
        array (
          'name' => 'credit_notes_c',
          'studio' => 'visible',
          'label' => 'LBL_CREDIT_NOTES',
        ),
        1 => 
        array (
          'name' => 'material_notes_c',
          'studio' => 'visible',
          'label' => 'LBL_MATERIAL_NOTES',
        ),
      ),
    ),
    'lbl_editview_panel5' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'investigation_results_c',
          'studio' => 'visible',
          'label' => 'LBL_INVESTIGATION_RESULTS',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'root_cause_type_c',
          'studio' => 'visible',
          'label' => 'LBL_ROOT_CAUSE_TYPE',
        ),
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'root_cause_c',
          'studio' => 'visible',
          'label' => 'LBL_ROOT_CAUSE',
        ),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'immediate_action_c',
          'studio' => 'visible',
          'label' => 'LBL_IMMEDIATE_ACTION',
        ),
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'preventative_action_plan_c',
          'studio' => 'visible',
          'label' => 'LBL_PREVENTATIVE_ACTION_PLAN',
        ),
      ),
    ),
    'lbl_editview_panel6' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'internal_audit_results_c',
          'studio' => 'visible',
          'label' => 'LBL_INTERNAL_AUDIT_RESULTS',
        ),
        1 => 
        array (
          'name' => 'verified_status_c',
          'label' => 'LBL_VERIFIED_STATUS',
        ),
      ),
    ),
  ),
);