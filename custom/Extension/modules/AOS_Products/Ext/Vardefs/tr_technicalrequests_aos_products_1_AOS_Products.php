<?php
// created: 2019-12-09 13:18:39
$dictionary["AOS_Products"]["fields"]["tr_technicalrequests_aos_products_1"] = array (
  'name' => 'tr_technicalrequests_aos_products_1',
  'type' => 'link',
  'relationship' => 'tr_technicalrequests_aos_products_1',
  'source' => 'non-db',
  'module' => 'TR_TechnicalRequests',
  'bean_name' => 'TR_TechnicalRequests',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_AOS_PRODUCTS_1_FROM_TR_TECHNICALREQUESTS_TITLE',
  'id_name' => 'tr_technicalrequests_aos_products_1tr_technicalrequests_ida',
);
$dictionary["AOS_Products"]["fields"]["tr_technicalrequests_aos_products_1_name"] = array (
  'name' => 'tr_technicalrequests_aos_products_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_AOS_PRODUCTS_1_FROM_TR_TECHNICALREQUESTS_TITLE',
  'save' => true,
  'id_name' => 'tr_technicalrequests_aos_products_1tr_technicalrequests_ida',
  'link' => 'tr_technicalrequests_aos_products_1',
  'table' => 'tr_technicalrequests',
  'module' => 'TR_TechnicalRequests',
  'rname' => 'name',
  'inline_edit' => '',
  'required' => true,
);
$dictionary["AOS_Products"]["fields"]["tr_technicalrequests_aos_products_1tr_technicalrequests_ida"] = array (
  'name' => 'tr_technicalrequests_aos_products_1tr_technicalrequests_ida',
  'type' => 'link',
  'relationship' => 'tr_technicalrequests_aos_products_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_AOS_PRODUCTS_1_FROM_AOS_PRODUCTS_TITLE',
);
