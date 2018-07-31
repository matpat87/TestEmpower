<?php
$popupMeta = array (
    'moduleMain' => 'SAR_SalesActivityReport',
    'varName' => 'SAR_SalesActivityReport',
    'orderBy' => 'sar_salesactivityreport.name',
    'whereClauses' => array (
  'related_to_c' => 'sar_salesactivityreport_cstm.related_to_c',
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