<?php
// created: 2019-02-04 16:24:24
$dictionary["AOS_Products_Quotes"]["fields"]["ci_customeritems_aos_products_quotes"] = array (
  'name' => 'ci_customeritems_aos_products_quotes',
  'type' => 'link',
  'relationship' => 'ci_customeritems_aos_products_quotes',
  'source' => 'non-db',
  'module' => 'CI_CustomerItems',
  'bean_name' => false,
  'vname' => 'LBL_CI_CUSTOMERITEMS_AOS_PRODUCTS_QUOTES_FROM_CI_CUSTOMERITEMS_TITLE',
  'id_name' => 'ci_customeritems_aos_products_quotesci_customeritems_ida',
);
$dictionary["AOS_Products_Quotes"]["fields"]["ci_customeritems_aos_products_quotes_name"] = array (
  'name' => 'ci_customeritems_aos_products_quotes_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CI_CUSTOMERITEMS_AOS_PRODUCTS_QUOTES_FROM_CI_CUSTOMERITEMS_TITLE',
  'save' => true,
  'id_name' => 'ci_customeritems_aos_products_quotesci_customeritems_ida',
  'link' => 'ci_customeritems_aos_products_quotes',
  'table' => 'ci_customeritems',
  'module' => 'CI_CustomerItems',
  'rname' => 'name',
);
$dictionary["AOS_Products_Quotes"]["fields"]["ci_customeritems_aos_products_quotesci_customeritems_ida"] = array (
  'name' => 'ci_customeritems_aos_products_quotesci_customeritems_ida',
  'type' => 'link',
  'relationship' => 'ci_customeritems_aos_products_quotes',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_CI_CUSTOMERITEMS_AOS_PRODUCTS_QUOTES_FROM_AOS_PRODUCTS_QUOTES_TITLE',
);
