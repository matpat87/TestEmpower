<?php
// created: 2020-11-26 08:36:39
$dictionary["Note"]["fields"]["vp_vendorproducts_notes"] = array (
  'name' => 'vp_vendorproducts_notes',
  'type' => 'link',
  'relationship' => 'vp_vendorproducts_notes',
  'source' => 'non-db',
  'module' => 'VP_VendorProducts',
  'bean_name' => false,
  'vname' => 'LBL_VP_VENDORPRODUCTS_NOTES_FROM_VP_VENDORPRODUCTS_TITLE',
  'id_name' => 'vp_vendorproducts_notesvp_vendorproducts_ida',
);
$dictionary["Note"]["fields"]["vp_vendorproducts_notes_name"] = array (
  'name' => 'vp_vendorproducts_notes_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_VP_VENDORPRODUCTS_NOTES_FROM_VP_VENDORPRODUCTS_TITLE',
  'save' => true,
  'id_name' => 'vp_vendorproducts_notesvp_vendorproducts_ida',
  'link' => 'vp_vendorproducts_notes',
  'table' => 'vp_vendorproducts',
  'module' => 'VP_VendorProducts',
  'rname' => 'name',
);
$dictionary["Note"]["fields"]["vp_vendorproducts_notesvp_vendorproducts_ida"] = array (
  'name' => 'vp_vendorproducts_notesvp_vendorproducts_ida',
  'type' => 'link',
  'relationship' => 'vp_vendorproducts_notes',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_VP_VENDORPRODUCTS_NOTES_FROM_NOTES_TITLE',
);
