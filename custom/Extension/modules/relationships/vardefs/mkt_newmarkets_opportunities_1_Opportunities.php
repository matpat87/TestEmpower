<?php
// created: 2021-05-04 10:15:22
$dictionary["Opportunity"]["fields"]["mkt_newmarkets_opportunities_1"] = array (
  'name' => 'mkt_newmarkets_opportunities_1',
  'type' => 'link',
  'relationship' => 'mkt_newmarkets_opportunities_1',
  'source' => 'non-db',
  'module' => 'MKT_NewMarkets',
  'bean_name' => 'MKT_NewMarkets',
  'vname' => 'LBL_MKT_NEWMARKETS_OPPORTUNITIES_1_FROM_MKT_NEWMARKETS_TITLE',
  'id_name' => 'mkt_newmarkets_opportunities_1mkt_newmarkets_ida',
);
$dictionary["Opportunity"]["fields"]["mkt_newmarkets_opportunities_1_name"] = array (
  'name' => 'mkt_newmarkets_opportunities_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_MKT_NEWMARKETS_OPPORTUNITIES_1_FROM_MKT_NEWMARKETS_TITLE',
  'save' => true,
  'id_name' => 'mkt_newmarkets_opportunities_1mkt_newmarkets_ida',
  'link' => 'mkt_newmarkets_opportunities_1',
  'table' => 'mkt_newmarkets',
  'module' => 'MKT_NewMarkets',
  'rname' => 'name',
);
$dictionary["Opportunity"]["fields"]["mkt_newmarkets_opportunities_1mkt_newmarkets_ida"] = array (
  'name' => 'mkt_newmarkets_opportunities_1mkt_newmarkets_ida',
  'type' => 'link',
  'relationship' => 'mkt_newmarkets_opportunities_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_MKT_NEWMARKETS_OPPORTUNITIES_1_FROM_OPPORTUNITIES_TITLE',
);
