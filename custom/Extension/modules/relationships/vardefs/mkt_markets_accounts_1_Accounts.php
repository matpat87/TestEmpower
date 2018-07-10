<?php
// created: 2018-07-10 16:55:07
$dictionary["Account"]["fields"]["mkt_markets_accounts_1"] = array (
  'name' => 'mkt_markets_accounts_1',
  'type' => 'link',
  'relationship' => 'mkt_markets_accounts_1',
  'source' => 'non-db',
  'module' => 'MKT_Markets',
  'bean_name' => 'MKT_Markets',
  'vname' => 'LBL_MKT_MARKETS_ACCOUNTS_1_FROM_MKT_MARKETS_TITLE',
  'id_name' => 'mkt_markets_accounts_1mkt_markets_ida',
);
$dictionary["Account"]["fields"]["mkt_markets_accounts_1_name"] = array (
  'name' => 'mkt_markets_accounts_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_MKT_MARKETS_ACCOUNTS_1_FROM_MKT_MARKETS_TITLE',
  'save' => true,
  'id_name' => 'mkt_markets_accounts_1mkt_markets_ida',
  'link' => 'mkt_markets_accounts_1',
  'table' => 'mkt_markets',
  'module' => 'MKT_Markets',
  'rname' => 'name',
);
$dictionary["Account"]["fields"]["mkt_markets_accounts_1mkt_markets_ida"] = array (
  'name' => 'mkt_markets_accounts_1mkt_markets_ida',
  'type' => 'link',
  'relationship' => 'mkt_markets_accounts_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_MKT_MARKETS_ACCOUNTS_1_FROM_ACCOUNTS_TITLE',
);