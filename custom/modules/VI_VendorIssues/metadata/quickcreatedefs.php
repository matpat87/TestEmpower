<?php
$module_name = 'VI_VendorIssues';
$_object_name = 'vi_vendorissues';
$viewdefs [$module_name] = 
array (
  'QuickCreate' => 
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
      'useTabs' => true,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL1' => 
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
            'name' => 'vi_vendorissues_number',
            'type' => 'readonly',
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
            'name' => 'type',
            'comment' => 'The type of issue (ex: issue, feature)',
            'studio' => 'visible',
            'label' => 'LBL_TYPE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'vi_vendorissues_vend_vendors_name',
            'label' => 'LBL_VI_VENDORISSUES_VEND_VENDORS_FROM_VEND_VENDORS_TITLE',
          ),
          1 => 
          array (
            'name' => 'product_number',
            'label' => 'LBL_PRODUCT_NUMBER',
          ),
        ),
        3 => 
        array (
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'department',
            'label' => 'LBL_DEPARTMENT',
          ),
          1 => 
          array (
            'name' => 'quantity',
            'label' => 'LBL_QUANTITY',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'finalized',
            'label' => 'LBL_FINALIZED',
          ),
          1 => 
          array (
            'name' => 'lot_number',
            'label' => 'LBL_LOT_NUMBER',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'credit_issued',
            'label' => 'LBL_CREDIT_ISSUED',
          ),
          1 => 
          array (
            'name' => 'ra_number',
            'label' => 'LBL_RA_NUMBER',
          ),
        ),
        7 => 
        array (
          0 => 'description',
          1 => 
          array (
            'name' => 'root_cause',
            'studio' => 'visible',
            'label' => 'LBL_ROOT_CAUSE',
          ),
        ),
        8 => 
        array (
          0 => 'assigned_user_name',
          1 => 
          array (
            'name' => 'date_entered',
            'comment' => 'Date record created',
            'label' => 'LBL_DATE_ENTERED',
          ),
        ),
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'due_date_c',
            'label' => 'LBL_DUE_DATE',
          ),
          1 => 
          array (
            'name' => 'actual_closed_date_c',
            'label' => 'LBL_ACTUAL_CLOSED_DATE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'contact_c',
            'label' => 'LBL_CONTACT',
          ),
          1 => 
          array (
            'name' => 'sign_off_c',
            'studio' => 'visible',
            'label' => 'LBL_SIGN_OFF',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'comments_c',
            'studio' => 'visible',
            'label' => 'LBL_COMMENTS',
          ),
          1 => 
          array (
            'name' => 'filename',
            'comment' => 'The filename of the document attachment',
            'label' => 'LBL_CORRECTIVE_ACTIONS_FILE',
          ),
        ),
      ),
    ),
  ),
);
;
?>
