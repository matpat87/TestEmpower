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
        'LBL_EDITVIEW_PANEL1' => 
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
          1 => 'so_savingopportunities_type',
        ),
        1 => 
        array (
          0 => 'name',
          1 => 
          array (
            'name' => 'rmm_rawmaterialmaster_so_savingopportunities_1_name',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'sales_stage',
            'comment' => 'Indication of progression towards closure',
            'label' => 'LBL_SALES_STAGE',
          ),
          1 => 
          array (
            'name' => 'status_c',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'amount',
            'type' => 'varchar',
          ),
          1 => 
          array (
            'name' => 'site_c',
            'studio' => 'visible',
            'label' => 'LBL_SITE',
          ),
        ),
        4 => 
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
            'type' => 'varchar',
          ),
        ),
        5 => 
        array (
          0 => 'probability',
          1 => 'date_closed',
        ),
        6 => 
        array (
          0 => 'next_step',
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'previous_price_c',
            'label' => 'LBL_PREVIOUS_PRICE',
            'type' => 'varchar',
          ),
          1 => 
          array (
            'name' => 'current_price_c',
            'label' => 'LBL_CURRENT_PRICE',
            'type' => 'varchar',
          ),
        ),
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
          ),
          1 => '',
        ),
      ),
    ),
  ),
);
;
?>
