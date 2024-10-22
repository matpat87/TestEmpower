<?php
// created: 2019-06-05 04:33:02
$dictionary["CI_CustomerItems"]["fields"]["aos_products_ci_customeritems_1"] = array (
  'name' => 'aos_products_ci_customeritems_1',
  'type' => 'link',
  'relationship' => 'aos_products_ci_customeritems_1',
  'source' => 'non-db',
  'module' => 'AOS_Products',
  'bean_name' => 'AOS_Products',
  'vname' => 'LBL_AOS_PRODUCTS_CI_CUSTOMERITEMS_1_FROM_AOS_PRODUCTS_TITLE',
  'id_name' => 'aos_products_ci_customeritems_1aos_products_ida',
);
$dictionary["CI_CustomerItems"]["fields"]["aos_products_ci_customeritems_1_name"] = array (
  'name' => 'aos_products_ci_customeritems_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'required' => false,
  'vname' => 'LBL_AOS_PRODUCTS_CI_CUSTOMERITEMS_1_FROM_AOS_PRODUCTS_TITLE',
  'save' => true,
  'id_name' => 'aos_products_ci_customeritems_1aos_products_ida',
  'link' => 'aos_products_ci_customeritems_1',
  'table' => 'aos_products',
  'module' => 'AOS_Products',
  'rname' => 'name',
);
$dictionary["CI_CustomerItems"]["fields"]["aos_products_ci_customeritems_1aos_products_ida"] = array (
  'name' => 'aos_products_ci_customeritems_1aos_products_ida',
  'type' => 'link',
  'relationship' => 'aos_products_ci_customeritems_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_AOS_PRODUCTS_CI_CUSTOMERITEMS_1_FROM_CI_CUSTOMERITEMS_TITLE',
);
