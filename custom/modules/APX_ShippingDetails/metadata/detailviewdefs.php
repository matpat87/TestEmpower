<?php
$module_name = 'APX_ShippingDetails';
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
            'name' => 'ship_tracker',
            'label' => 'LBL_SHIP_TRACKER',
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
        4 => 
        array (
          0 => 
          array (
            'name' => 'date_entered',
            'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
            'label' => 'LBL_DATE_ENTERED',
          ),
          1 => 
          array (
            'name' => 'date_modified',
            'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
            'label' => 'LBL_DATE_MODIFIED',
          ),
        ),
      ),
    ),
  ),
);
;
?>
