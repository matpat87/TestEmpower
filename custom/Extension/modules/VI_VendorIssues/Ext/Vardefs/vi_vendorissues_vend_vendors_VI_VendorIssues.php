<?php
// created: 2020-09-09 10:30:10
$dictionary["VI_VendorIssues"]["fields"]["vi_vendorissues_vend_vendors"] = array (
  'name' => 'vi_vendorissues_vend_vendors',
  'type' => 'link',
  'relationship' => 'vi_vendorissues_vend_vendors',
  'source' => 'non-db',
  'module' => 'VEND_Vendors',
  'bean_name' => 'VEND_Vendors',
  'vname' => 'LBL_VI_VENDORISSUES_VEND_VENDORS_FROM_VEND_VENDORS_TITLE',
  'id_name' => 'vi_vendorissues_vend_vendorsvend_vendors_ida',
);
$dictionary["VI_VendorIssues"]["fields"]["vi_vendorissues_vend_vendors_name"] = array (
  'name' => 'vi_vendorissues_vend_vendors_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_VI_VENDORISSUES_VEND_VENDORS_FROM_VEND_VENDORS_TITLE',
  'save' => true,
  'id_name' => 'vi_vendorissues_vend_vendorsvend_vendors_ida',
  'link' => 'vi_vendorissues_vend_vendors',
  'table' => 'vend_vendors',
  'module' => 'VEND_Vendors',
  'rname' => 'name',
);
$dictionary["VI_VendorIssues"]["fields"]["vi_vendorissues_vend_vendorsvend_vendors_ida"] = array (
  'name' => 'vi_vendorissues_vend_vendorsvend_vendors_ida',
  'type' => 'link',
  'relationship' => 'vi_vendorissues_vend_vendors',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_VI_VENDORISSUES_VEND_VENDORS_FROM_VI_VENDORISSUES_TITLE',
);
