<?php
$module_name = 'SO_SavingOpportunities';
$_object_name = 'so_savingopportunities';
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
      'javascript' => '{$PROBABILITY_SCRIPT}',
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
            'customCode' => '<span class="sugar_field" id="{$fields.so_id.name}">{$fields.so_id.value}</span><input type="hidden" name="so_id" value="{$fields.oppid_c.value}" /><input type="hidden" name="{$fields.id.name}" value="{$fields.id.value}" />',
          ),
          1 => 'so_savingopportunities_type',
        ),
        1 => 
        array (
          0 => 'name',
          1 => 
          array (
            'name' => 'rmm_rawmaterialmaster_so_savingopportunities_1_name',
            'label' => 'LBL_RMM_RAWMATERIALMASTER_SO_SAVINGOPPORTUNITIES_1_FROM_RMM_RAWMATERIALMASTER_TITLE',
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
          0 => 'amount',
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
          ),
          1 => 
          array (
            'name' => 'current_price_c',
            'label' => 'LBL_CURRENT_PRICE',
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
