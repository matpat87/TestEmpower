<?php
$viewdefs ['Cases'] = 
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
        'LBL_CASE_INFORMATION' => 
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
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'label' => 'LBL_SUBJECT',
          ),
          1 => 'status',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'create_date_c',
            'label' => 'LBL_CREATE_DATE',
          ),
          1 => 'account_name',
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'due_date_c',
            'label' => 'LBL_DUE_DATE',
          ),
          1 => 
          array (
            'name' => 'customer_name_c',
            'label' => 'LBL_CUSTOMER_NAME',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'close_date_c',
            'label' => 'LBL_CLOSE_DATE',
          ),
          1 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO',
          ),
        ),
        5 => 
        array (
          0 => 'description',
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'site_c',
            'studio' => 'visible',
            'label' => 'LBL_SITE',
          ),
          1 => 
          array (
            'name' => 'source_c',
            'studio' => 'visible',
            'label' => 'LBL_SOURCE',
          ),
        ),
        7 => 
        array (
          0 => 'type',
          1 => 
          array (
            'name' => 'quality_issue_c',
            'label' => 'LBL_QUALITY_ISSUE',
          ),
        ),
        8 => 
        array (
          0 => 'priority',
          1 => 
          array (
            'name' => 'department_c',
            'studio' => 'visible',
            'label' => 'LBL_DEPARTMENT',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'users_cases_1_name',
          ),
          1 => 
          array (
            'name' => 'assigned_to_phone_c',
            'label' => 'LBL_ASSIGNED_TO_PHONE',
          ),
        ),
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'product_header_non_db',
            'label' => 'Header',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'item_number_c',
            'label' => 'LBL_ITEM_NUMBER',
          ),
          1 => 
          array (
            'name' => 'customer_po_c',
            'label' => 'LBL_CUSTOMER_PO',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'invoice_number_c',
            'label' => 'LBL_INVOICE_NUMBER',
          ),
          1 => 
          array (
            'name' => 'lot_number_c',
            'label' => 'LBL_LOT_NUMBER',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'qty_c',
            'label' => 'LBL_QTY',
          ),
          1 => 
          array (
            'name' => 'price_c',
            'label' => 'LBL_PRICE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'product_customer_process_non_db',
            'label' => 'Customer Process',
          ),
        ),
        5 => 
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
        6 => 
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
        7 => 
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
        8 => 
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
        9 => 
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
        10 => 
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
        11 => 
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
        12 => 
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
        13 => 
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
        14 => 
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
        15 => 
        array (
          0 => 
          array (
            'name' => 'product_disposition_non_db',
            'label' => 'Disposition',
          ),
        ),
        16 => 
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
        17 => 
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
        18 => 
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
        19 => 
        array (
          0 => 
          array (
            'name' => 'credit_amount_c',
            'label' => 'LBL_CREDIT_AMOUNT',
          ),
        ),
        20 => 
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
            'name' => 'immediate_action_c',
            'studio' => 'visible',
            'label' => 'LBL_IMMEDIATE_ACTION',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'investigation_results_c',
            'studio' => 'visible',
            'label' => 'LBL_INVESTIGATION_RESULTS',
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
            'name' => 'preventative_action_plan_c',
            'studio' => 'visible',
            'label' => 'LBL_PREVENTATIVE_ACTION_PLAN',
          ),
        ),
      ),
    ),
  ),
);
;
?>
