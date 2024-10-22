<?php
$module_name = 'TRI_TechnicalRequestItems';
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
            'name' => 'tri_technicalrequestitems_tr_technicalrequests_name',
          ),
          1 => 
          array (
            'name' => 'product_number',
            'label' => 'LBL_PRODUCT_NUMBER',
          ),
        ),
        1 => 
        array (
          0 => 'name',
          1 => 
          array (
            'name' => 'qty',
            'label' => 'LBL_QTY',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'uom',
            'label' => 'LBL_UOM',
          ),
          1 => 
          array (
            'name' => 'due_date',
            'label' => 'LBL_DUE_DATE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
          1 => 'assigned_user_name',
        ),
      ),
    ),
  ),
);
;
?>
