<?php
// created: 2020-12-14 08:40:12
$dictionary["CI_CustomerItems"]["fields"]["mkt_markets_ci_customeritems_1"] = array (
  'name' => 'mkt_markets_ci_customeritems_1',
  'type' => 'link',
  'relationship' => 'mkt_markets_ci_customeritems_1',
  'source' => 'non-db',
  'module' => 'MKT_Markets',
  'bean_name' => 'MKT_Markets',
  'vname' => 'LBL_MKT_MARKETS_CI_CUSTOMERITEMS_1_FROM_MKT_MARKETS_TITLE',
  'id_name' => 'mkt_markets_ci_customeritems_1mkt_markets_ida',
);
$dictionary["CI_CustomerItems"]["fields"]["mkt_markets_ci_customeritems_1_name"] = array (
  'name' => 'mkt_markets_ci_customeritems_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_MKT_MARKETS_CI_CUSTOMERITEMS_1_FROM_MKT_MARKETS_TITLE',
  'save' => true,
  'id_name' => 'mkt_markets_ci_customeritems_1mkt_markets_ida',
  'link' => 'mkt_markets_ci_customeritems_1',
  'table' => 'mkt_markets',
  'module' => 'MKT_Markets',
  'rname' => 'name',
);
$dictionary["CI_CustomerItems"]["fields"]["mkt_markets_ci_customeritems_1mkt_markets_ida"] = array (
  'name' => 'mkt_markets_ci_customeritems_1mkt_markets_ida',
  'type' => 'link',
  'relationship' => 'mkt_markets_ci_customeritems_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_MKT_MARKETS_CI_CUSTOMERITEMS_1_FROM_CI_CUSTOMERITEMS_TITLE',
);
