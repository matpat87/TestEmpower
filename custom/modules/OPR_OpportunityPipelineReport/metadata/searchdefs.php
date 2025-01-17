<?php
$module_name = 'OPR_OpportunityPipelineReport';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'sales_representative_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_SALES_REPRESENTATIVE',
        'width' => '10%',
        'name' => 'sales_representative_c',
      ),
      'account_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_ACCOUNT',
        'width' => '10%',
        'name' => 'account_c',
      ),
      'sales_stage_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_SALES_STAGE',
        'width' => '10%',
        'name' => 'sales_stage_c',
      ),
      'division_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_DIVISION',
        'width' => '10%',
        'name' => 'division_c',
      ),
      'amount_c' => 
      array (
        'type' => 'decimal',
        'default' => true,
        'label' => 'LBL_AMOUNT',
        'width' => '10%',
        'name' => 'amount_c',
      ),
      'probability_c' => 
      array (
        'type' => 'float',
        'default' => true,
        'label' => 'LBL_PROBABILITY',
        'width' => '10%',
        'name' => 'probability_c',
      ),
      'date_from_c' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_CLOSED_DATE_FROM',
        'width' => '10%',
        'name' => 'date_from_c',
      ),
      'date_to_c' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_CLOSED_DATE_TO',
        'width' => '10%',
        'name' => 'date_to_c',
      ),
      'created_date_from' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_CREATED_DATE_FROM',
        'width' => '10%',
        'name' => 'created_date_from',
      ),
      'created_date_to' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_CREATED_DATE_TO',
        'width' => '10%',
        'name' => 'created_date_to',
      ),
      'market_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_MARKET',
        'width' => '10%',
        'name' => 'market_c',
      ),
      'type_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_TYPE',
        'width' => '10%',
        'name' => 'type_c',
      ),
    ),
    'advanced_search' => 
    array (
      'sales_representative_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_SALES_REPRESENTATIVE',
        'width' => '10%',
        'name' => 'sales_representative_c',
      ),
      'account_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_ACCOUNT',
        'width' => '10%',
        'name' => 'account_c',
      ),
      'sales_stage_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_SALES_STAGE',
        'width' => '10%',
        'name' => 'sales_stage_c',
      ),
      'division_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_DIVISION',
        'width' => '10%',
        'name' => 'division_c',
      ),
      'amount_c' => 
      array (
        'type' => 'decimal',
        'default' => true,
        'label' => 'LBL_AMOUNT',
        'width' => '10%',
        'name' => 'amount_c',
      ),
      'probability_c' => 
      array (
        'type' => 'float',
        'default' => true,
        'label' => 'LBL_PROBABILITY',
        'width' => '10%',
        'name' => 'probability_c',
      ),
      'date_from_c' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_CLOSED_DATE_FROM',
        'width' => '10%',
        'name' => 'date_from_c',
      ),
      'date_to_c' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_CLOSED_DATE_TO',
        'width' => '10%',
        'name' => 'date_to_c',
      ),
      'created_date_from' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_CREATED_DATE_FROM',
        'width' => '10%',
        'name' => 'created_date_from',
      ),
      'created_date_to' => 
      array (
        'type' => 'date',
        'default' => true,
        'label' => 'LBL_CREATED_DATE_TO',
        'width' => '10%',
        'name' => 'created_date_to',
      ),
      'market_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_MARKET',
        'width' => '10%',
        'name' => 'market_c',
      ),
      'type_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_TYPE',
        'width' => '10%',
        'name' => 'type_c',
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'maxColumnsBasic' => '4',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
;
?>
