<?php
$module_name = 'SO_SavingOpportunities';
$_object_name = 'so_savingopportunities';
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
        'LBL_SALE_INFORMATION' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => true,
    ),
    'panels' => 
    array (
      'lbl_sale_information' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'so_id',
            'label' => 'LBL_SO_ID',
          ),
          1 => '',
        ),
        1 => 
        array (
          0 => 'name',
          1 => 'so_savingopportunities_type',
        ),
        2 => 
        array (
          0 => 'amount',
          1 => 
          array (
            'name' => 'so_savingopportunities_vend_vendors_name',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'annual_volume',
            'label' => 'LBL_ANNUAL_VOLUME',
          ),
          1 => 
          array (
            'name' => 'annual_spend',
            'label' => 'LBL_ANNUAL_SPEND',
          ),
        ),
        4 => 
        array (
          0 => 'probability',
          1 => 'date_closed',
        ),
        5 => 
        array (
          0 => 'next_step',
          1 => '',
        ),
      ),
    ),
  ),
);
;
?>
