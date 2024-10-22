<?php
// created: 2020-10-19 11:04:27
$dictionary["Note"]["fields"]["vc_vendorcontacts_notes"] = array (
  'name' => 'vc_vendorcontacts_notes',
  'type' => 'link',
  'relationship' => 'vc_vendorcontacts_notes',
  'source' => 'non-db',
  'module' => 'VC_VendorContacts',
  'bean_name' => false,
  'vname' => 'LBL_VC_VENDORCONTACTS_NOTES_FROM_VC_VENDORCONTACTS_TITLE',
  'id_name' => 'vc_vendorcontacts_notesvc_vendorcontacts_ida',
);
$dictionary["Note"]["fields"]["vc_vendorcontacts_notes_name"] = array (
  'name' => 'vc_vendorcontacts_notes_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_VC_VENDORCONTACTS_NOTES_FROM_VC_VENDORCONTACTS_TITLE',
  'save' => true,
  'id_name' => 'vc_vendorcontacts_notesvc_vendorcontacts_ida',
  'link' => 'vc_vendorcontacts_notes',
  'table' => 'vc_vendorcontacts',
  'module' => 'VC_VendorContacts',
  'rname' => 'name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["Note"]["fields"]["vc_vendorcontacts_notesvc_vendorcontacts_ida"] = array (
  'name' => 'vc_vendorcontacts_notesvc_vendorcontacts_ida',
  'type' => 'link',
  'relationship' => 'vc_vendorcontacts_notes',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_VC_VENDORCONTACTS_NOTES_FROM_NOTES_TITLE',
);
