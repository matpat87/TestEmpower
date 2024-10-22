<?php

$dictionary['ODR_SalesOrders']['fields']['custom_req_ship_date'] = 
  array (
    'required' => false,
    'name' => 'custom_req_ship_date',
    'vname' => 'LBL_REQ_SHIP_DATE',
    'type' => 'date',
    'source' => 'non-db',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => false,
    'reportable' => false,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'size' => '20',
    'enable_range_search' => true,
    'options' => 'odr_date_range_search', //OnTrack #1262 - Required Ship Date 365 days
  );

?>