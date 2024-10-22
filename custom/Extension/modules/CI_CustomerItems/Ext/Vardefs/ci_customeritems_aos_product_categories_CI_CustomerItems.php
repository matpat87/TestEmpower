<?php
// created: 2019-02-04 16:24:24
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_aos_product_categories"] = array (
  'name' => 'ci_customeritems_aos_product_categories',
  'type' => 'link',
  'relationship' => 'ci_customeritems_aos_product_categories',
  'source' => 'non-db',
  'module' => 'AOS_Product_Categories',
  'bean_name' => 'AOS_Product_Categories',
  'vname' => 'LBL_CI_CUSTOMERITEMS_AOS_PRODUCT_CATEGORIES_FROM_AOS_PRODUCT_CATEGORIES_TITLE',
  'id_name' => 'ci_custome38beegories_ida',
);
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_aos_product_categories_name"] = array (
  'name' => 'ci_customeritems_aos_product_categories_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CI_CUSTOMERITEMS_AOS_PRODUCT_CATEGORIES_FROM_AOS_PRODUCT_CATEGORIES_TITLE',
  'save' => true,
  'id_name' => 'ci_custome38beegories_ida',
  'link' => 'ci_customeritems_aos_product_categories',
  'table' => 'aos_product_categories',
  'module' => 'AOS_Product_Categories',
  'rname' => 'name',
);
$dictionary["CI_CustomerItems"]["fields"]["ci_custome38beegories_ida"] = array (
  'name' => 'ci_custome38beegories_ida',
  'type' => 'link',
  'relationship' => 'ci_customeritems_aos_product_categories',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_CI_CUSTOMERITEMS_AOS_PRODUCT_CATEGORIES_FROM_CI_CUSTOMERITEMS_TITLE',
);
