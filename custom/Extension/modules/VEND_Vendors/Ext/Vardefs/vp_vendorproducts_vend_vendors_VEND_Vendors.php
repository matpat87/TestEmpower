<?php
// created: 2020-11-26 08:36:39
$dictionary["VEND_Vendors"]["fields"]["vp_vendorproducts_vend_vendors"] = array (
  'name' => 'vp_vendorproducts_vend_vendors',
  'type' => 'link',
  'relationship' => 'vp_vendorproducts_vend_vendors',
  'source' => 'non-db',
  'module' => 'VP_VendorProducts',
  'bean_name' => false,
  'vname' => 'LBL_VP_VENDORPRODUCTS_VEND_VENDORS_FROM_VP_VENDORPRODUCTS_TITLE',
  'id_name' => 'vp_vendorproducts_vend_vendorsvp_vendorproducts_ida',
);
$dictionary["VEND_Vendors"]["fields"]["vp_vendorproducts_vend_vendors_name"] = array (
  'name' => 'vp_vendorproducts_vend_vendors_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_VP_VENDORPRODUCTS_VEND_VENDORS_FROM_VP_VENDORPRODUCTS_TITLE',
  'save' => true,
  'id_name' => 'vp_vendorproducts_vend_vendorsvp_vendorproducts_ida',
  'link' => 'vp_vendorproducts_vend_vendors',
  'table' => 'vp_vendorproducts',
  'module' => 'VP_VendorProducts',
  'rname' => 'name',
);
$dictionary["VEND_Vendors"]["fields"]["vp_vendorproducts_vend_vendorsvp_vendorproducts_ida"] = array (
  'name' => 'vp_vendorproducts_vend_vendorsvp_vendorproducts_ida',
  'type' => 'link',
  'relationship' => 'vp_vendorproducts_vend_vendors',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_VP_VENDORPRODUCTS_VEND_VENDORS_FROM_VEND_VENDORS_TITLE',
);
