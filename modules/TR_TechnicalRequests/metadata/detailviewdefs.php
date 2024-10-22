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
          0 => 'tr_technicalrequests_number',
          1 => 
          array (
            'name' => 'approval_stage',
            'studio' => 'visible',
            'label' => 'LBL_APPROVAL_STAGE',
          ),
        ),
        1 => 
        array (
          0 => 'name',
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'division',
            'studio' => 'visible',
            'label' => 'LBL_DIVISION',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'updates',
            'studio' => 'visible',
            'label' => 'LBL_UPDATES',
          ),
          1 => 
          array (
            'name' => 'site',
            'studio' => 'visible',
            'label' => 'LBL_SITE',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'salesregion',
            'studio' => 'visible',
            'label' => 'LBL_SALESREGION',
          ),
          1 => 
          array (
            'name' => 'tr_technicalrequests_opportunities_name',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'tr_technicalrequests_project_name',
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
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'customer_specs',
            'studio' => 'visible',
            'label' => 'LBL_CUSTOMER_SPECS',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'stat_and_reg_req',
            'label' => 'LBL_STAT_AND_REG_REQ',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'cust_end_product',
            'label' => 'LBL_CUST_END_PRODUCT',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'cust_disp_equip',
            'label' => 'LBL_CUST_DISP_EQUIP',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'mix_equipment',
            'label' => 'LBL_MIX_EQUIPMENT',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'curing_process',
            'label' => 'LBL_CURING_PROCESS',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'current_supplier',
            'label' => 'LBL_CURRENT_SUPPLIER',
          ),
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
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'prodmgt_rejection_comments',
            'studio' => 'visible',
            'label' => 'LBL_PRODMGT_REJECTION_COMMENTS',
          ),
        ),
        12 => 
        array (
          0 => 
          array (
            'name' => 'lab_results',
            'studio' => 'visible',
            'label' => 'LBL_LAB_RESULTS',
          ),
        ),
      ),
      'lbl_editview_panel2' => 
      array (
        0 => 
        array (
          0 => 'assigned_user_name',
          1 => 
          array (
            'name' => 'created_by_name',
            'label' => 'LBL_CREATED',
          ),
        ),
      ),
    ),
  ),
);
;
?>
