<?php
$module_name = 'SO_SavingOpportunities';
$_object_name = 'so_savingopportunities';
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
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'custom/modules/SO_SavingOpportunities/js/edit.js',
        ),
      ),
      'syncDetailEditViews' => false,
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
            'customCode' => '<input type="text" name="{$fields.amount.name}" id="{$fields.amount.name}" value="{$fields.amount.value}" maxlength="{$fields.amount.len}" class="custom-currency" />',
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
            'customCode' => '<input type="text" name="{$fields.annual_spend.name}" id="{$fields.annual_spend.name}" value="{$fields.annual_spend.value}" maxlength="{$fields.annual_spend.len}" class="custom-currency" />',
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
            'customCode' => '<input type="text" name="{$fields.previous_price_c.name}" id="{$fields.previous_price_c.name}" value="{$fields.previous_price_c.value}" maxlength="{$fields.previous_price_c.len}" class="custom-currency" />',
          ),
          1 => 
          array (
            'name' => 'current_price_c',
            'label' => 'LBL_CURRENT_PRICE',
            'customCode' => '<input type="text" name="{$fields.current_price_c.name}" id="{$fields.current_price_c.name}" value="{$fields.current_price_c.value}" maxlength="{$fields.current_price_c.len}" class="custom-currency" />',
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
