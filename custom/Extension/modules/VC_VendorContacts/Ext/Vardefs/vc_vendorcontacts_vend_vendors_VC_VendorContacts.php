<?php
// created: 2020-10-19 11:04:27
$dictionary["VC_VendorContacts"]["fields"]["vc_vendorcontacts_vend_vendors"] = array (
  'name' => 'vc_vendorcontacts_vend_vendors',
  'type' => 'link',
  'relationship' => 'vc_vendorcontacts_vend_vendors',
  'source' => 'non-db',
  'module' => 'VEND_Vendors',
  'bean_name' => 'VEND_Vendors',
  'vname' => 'LBL_VC_VENDORCONTACTS_VEND_VENDORS_FROM_VEND_VENDORS_TITLE',
  'id_name' => 'vc_vendorcontacts_vend_vendorsvend_vendors_ida',
);
$dictionary["VC_VendorContacts"]["fields"]["vc_vendorcontacts_vend_vendors_name"] = array (
  'name' => 'vc_vendorcontacts_vend_vendors_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_VC_VENDORCONTACTS_VEND_VENDORS_FROM_VEND_VENDORS_TITLE',
  'save' => true,
  'id_name' => 'vc_vendorcontacts_vend_vendorsvend_vendors_ida',
  'link' => 'vc_vendorcontacts_vend_vendors',
  'table' => 'vend_vendors',
  'module' => 'VEND_Vendors',
  'rname' => 'name',
);
$dictionary["VC_VendorContacts"]["fields"]["vc_vendorcontacts_vend_vendorsvend_vendors_ida"] = array (
  'name' => 'vc_vendorcontacts_vend_vendorsvend_vendors_ida',
  'type' => 'link',
  'relationship' => 'vc_vendorcontacts_vend_vendors',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_VC_VENDORCONTACTS_VEND_VENDORS_FROM_VC_VENDORCONTACTS_TITLE',
);
