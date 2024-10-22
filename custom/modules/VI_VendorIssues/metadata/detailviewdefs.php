<?php
$module_name = 'VI_VendorIssues';
$_object_name = 'vi_vendorissues';
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
      'useTabs' => true,
      'tabDefs' => 
      array (
        'LBL_EDITVIEW_PANEL3' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL4' => 
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
      'lbl_editview_panel3' => 
      array (
        0 => 
        array (
          0 => 'vi_vendorissues_number',
          1 => 
          array (
            'name' => 'status',
            'comment' => 'The status of the issue',
            'label' => 'LBL_STATUS',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'comment' => 'The short description of the bug',
            'label' => 'LBL_SUBJECT',
          ),
          1 => 
          array (
            'name' => 'site_c',
            'studio' => 'visible',
            'label' => 'LBL_SITE',
          ),
        ),
        2 => 
        array (
          0 => 'description',
          1 => 
          array (
            'name' => 'date_entered',
            'comment' => 'Date record created',
            'label' => 'LBL_DATE_ENTERED',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'created_by_name',
            'label' => 'LBL_CREATED',
          ),
          1 => '',
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'product_details_non_db',
            'label' => 'LBL_PRODUCT_DETAILS',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'purchase_order_num_c',
            'label' => 'LBL_PURCHASE_ORDER_NUM',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'raw_material_num_c',
            'studio' => 'visible',
            'label' => 'LBL_RAW_MATERIAL_NUM',
          ),
          1 => 
          array (
            'name' => 'vendor_name_c',
            'studio' => 'visible',
            'label' => 'LBL_VENDOR_NAME',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'po_value_c',
            'label' => 'LBL_PO_VALUE',
          ),
          1 => 
          array (
            'name' => 'po_date_c',
            'label' => 'LBL_PO_DATE',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'po_vendor_lot_num_c',
            'label' => 'LBL_VENDOR_LOT_NUM',
          ),
          1 => 
          array (
            'name' => 'po_quantity_c',
            'label' => 'LBL_PO_QUANTITY',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'product_details_gallery_c',
            'label' => 'LBL_PRODUCT_DETAILS_GALLERY',
          ),
        ),
      ),
      'lbl_editview_panel4' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'type',
            'comment' => 'The type of issue (ex: issue, feature)',
            'studio' => 'visible',
            'label' => 'LBL_TYPE',
          ),
          1 => 
          array (
            'name' => 'contact_c',
            'studio' => 'visible',
            'label' => 'LBL_CONTACT',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'severity_c',
            'studio' => 'visible',
            'label' => 'LBL_SEVERITY',
          ),
          1 => 
          array (
            'name' => 'due_date_c',
            'label' => 'LBL_DUE_DATE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
          ),
        ),
      ),
      'lbl_editview_panel5' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'resolution',
            'comment' => 'An indication of how the issue was resolved',
            'label' => 'LBL_RESOLUTION',
          ),
          1 => 
          array (
            'name' => 'return_authorization_num_c',
            'label' => 'LBL_RETURN_AUTHORIZATION_NUM',
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
            'name' => 'root_cause_type_c',
            'studio' => 'visible',
            'label' => 'LBL_ROOT_CAUSE_TYPE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'root_cause',
            'studio' => 'visible',
            'label' => 'LBL_ROOT_CAUSE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'corrective_action_c',
            'studio' => 'visible',
            'label' => 'LBL_CORRECTIVE_ACTION',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'resolution_details_c',
            'studio' => 'visible',
            'label' => 'LBL_RESOLUTION_DETAILS',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'closed_date_c',
            'label' => 'LBL_CLOSED_DATE',
          ),
        ),
      ),
    ),
  ),
);
;
?>
