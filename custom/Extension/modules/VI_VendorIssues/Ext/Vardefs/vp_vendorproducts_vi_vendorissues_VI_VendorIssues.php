<?php
// created: 2020-11-26 08:36:39
$dictionary["VI_VendorIssues"]["fields"]["vp_vendorproducts_vi_vendorissues"] = array (
  'name' => 'vp_vendorproducts_vi_vendorissues',
  'type' => 'link',
  'relationship' => 'vp_vendorproducts_vi_vendorissues',
  'source' => 'non-db',
  'module' => 'VP_VendorProducts',
  'bean_name' => false,
  'vname' => 'LBL_VP_VENDORPRODUCTS_VI_VENDORISSUES_FROM_VP_VENDORPRODUCTS_TITLE',
  'id_name' => 'vp_vendorproducts_vi_vendorissuesvp_vendorproducts_ida',
);
$dictionary["VI_VendorIssues"]["fields"]["vp_vendorproducts_vi_vendorissues_name"] = array (
  'name' => 'vp_vendorproducts_vi_vendorissues_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_VP_VENDORPRODUCTS_VI_VENDORISSUES_FROM_VP_VENDORPRODUCTS_TITLE',
  'save' => true,
  'id_name' => 'vp_vendorproducts_vi_vendorissuesvp_vendorproducts_ida',
  'link' => 'vp_vendorproducts_vi_vendorissues',
  'table' => 'vp_vendorproducts',
  'module' => 'VP_VendorProducts',
  'rname' => 'name',
);
$dictionary["VI_VendorIssues"]["fields"]["vp_vendorproducts_vi_vendorissuesvp_vendorproducts_ida"] = array (
  'name' => 'vp_vendorproducts_vi_vendorissuesvp_vendorproducts_ida',
  'type' => 'link',
  'relationship' => 'vp_vendorproducts_vi_vendorissues',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_VP_VENDORPRODUCTS_VI_VENDORISSUES_FROM_VI_VENDORISSUES_TITLE',
);
