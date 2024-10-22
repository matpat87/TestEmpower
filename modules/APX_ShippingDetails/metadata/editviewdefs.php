<?php
$module_name = 'APX_ShippingDetails';
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
      ),
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 
          array (
            'name' => 'carrier',
            'label' => 'LBL_CARRIER',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'delivered_date',
            'label' => 'LBL_DELIVERED_DATE',
          ),
          1 => 
          array (
            'name' => 'packing_list_number',
            'label' => 'LBL_PACKING_LIST_NUMBER',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'pl_line_number',
            'label' => 'LBL_PL_LINE_NUMBER',
          ),
          1 => 
          array (
            'name' => 'qty_shipped',
            'label' => 'LBL_QTY_SHIPPED',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'total_number_of_skids',
            'label' => 'LBL_TOTAL_NUMBER_OF_SKIDS',
          ),
          1 => 'assigned_user_name',
        ),
      ),
    ),
  ),
);
;
?>
