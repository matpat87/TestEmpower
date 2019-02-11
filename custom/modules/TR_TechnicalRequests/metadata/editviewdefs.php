<?php
$module_name = 'TR_TechnicalRequests';
$_object_name = 'tr_technicalrequests';
$viewdefs [$module_name] = 
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
      'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL1' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL2' => 
        array (
          'newTab' => false,
          'panelDefault' => 'collapsed',
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
            'name' => 'tr_technicalrequests_number',
            'type' => 'readonly',
          ),
          1 => 
          array (
            'name' => 'approval_stage',
            'studio' => 'visible',
            'label' => 'LBL_APPROVAL_STAGE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'displayParams' => 
            array (
              'size' => 60,
            ),
          ),
          1 => '',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'tr_technicalrequests_accounts_name',
            'label' => 'LBL_TR_TECHNICALREQUESTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
          ),
          1 => 
          array (
            'name' => 'tr_technicalrequests_project_name',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'tr_technicalrequests_opportunities_name',
          ),
          1 => 
          array (
            'name' => 'site',
            'studio' => 'visible',
            'label' => 'LBL_SITE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'technical_request_update',
            'studio' => 'visible',
            'label' => 'LBL_TECHNICAL_REQUEST_UPDATE',
          ),
        ),
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'competitive_sample_submitted',
            'studio' => 'visible',
            'label' => 'LBL_COMPETITIVE_SAMPLE_SUBMITTED',
          ),
          1 => 
          array (
            'name' => 'finished_product_submitted',
            'studio' => 'visible',
            'label' => 'LBL_FINISHED_PRODUCT_SUBMITTED',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'customers_specs_submit',
            'studio' => 'visible',
            'label' => 'LBL_CUSTOMERS_SPECS_SUBMIT',
          ),
          1 => '',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'customer_specs',
            'studio' => 'visible',
            'label' => 'LBL_CUSTOMER_SPECS',
          ),
          1 => '',
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'stat_and_reg_req',
            'label' => 'LBL_STAT_AND_REG_REQ',
          ),
          1 => '',
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'cust_end_product',
            'label' => 'LBL_CUST_END_PRODUCT',
          ),
          1 => '',
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'cust_disp_equip',
            'label' => 'LBL_CUST_DISP_EQUIP',
          ),
          1 => '',
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'mix_equipment',
            'label' => 'LBL_MIX_EQUIPMENT',
          ),
          1 => '',
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'curing_process',
            'label' => 'LBL_CURING_PROCESS',
          ),
          1 => '',
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'current_supplier',
            'label' => 'LBL_CURRENT_SUPPLIER',
          ),
          1 => '',
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'required_selling_price',
            'label' => 'LBL_REQUIRED_SELLING_PRICE',
          ),
          1 => 
          array (
            'name' => 'req_sample_size',
            'label' => 'LBL_REQ_SAMPLE_SIZE',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'lab_work_required',
            'studio' => 'visible',
            'label' => 'LBL_LAB_WORK_REQUIRED',
          ),
          1 => '',
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'prodmgt_rejection_comments',
            'studio' => 'visible',
            'label' => 'LBL_PRODMGT_REJECTION_COMMENTS',
          ),
          1 => '',
        ),
        12 => 
        array (
          0 => 
          array (
            'name' => 'lab_results',
            'studio' => 'visible',
            'label' => 'LBL_LAB_RESULTS',
          ),
          1 => '',
        ),
      ),
      'lbl_editview_panel2' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
          ),
        ),
      ),
    ),
  ),
);
;
?>
