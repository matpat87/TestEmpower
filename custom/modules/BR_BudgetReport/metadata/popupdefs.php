<?php
$popupMeta = array (
    'moduleMain' => 'BR_BudgetReport',
    'varName' => 'BR_BudgetReport',
    'orderBy' => 'br_budgetreport.name',
    'whereClauses' => array (
    'related_to_c' => 'br_budgetreport_cstm.related_to_c',
),
    'searchInputs' => array (
  5 => 'related_to_c',
),
    'searchdefs' => array (
  'related_to_c' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_RELATED_TO',
    'width' => '10%',
    'name' => 'related_to_c',
  ),
),
);
