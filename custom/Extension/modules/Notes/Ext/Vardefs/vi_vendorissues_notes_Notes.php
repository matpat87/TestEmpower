<?php
// created: 2020-09-09 10:30:10
$dictionary["Note"]["fields"]["vi_vendorissues_notes"] = array (
  'name' => 'vi_vendorissues_notes',
  'type' => 'link',
  'relationship' => 'vi_vendorissues_notes',
  'source' => 'non-db',
  'module' => 'VI_VendorIssues',
  'bean_name' => 'VI_VendorIssues',
  'vname' => 'LBL_VI_VENDORISSUES_NOTES_FROM_VI_VENDORISSUES_TITLE',
  'id_name' => 'vi_vendorissues_notesvi_vendorissues_ida',
);
$dictionary["Note"]["fields"]["vi_vendorissues_notes_name"] = array (
  'name' => 'vi_vendorissues_notes_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_VI_VENDORISSUES_NOTES_FROM_VI_VENDORISSUES_TITLE',
  'save' => true,
  'id_name' => 'vi_vendorissues_notesvi_vendorissues_ida',
  'link' => 'vi_vendorissues_notes',
  'table' => 'vi_vendorissues',
  'module' => 'VI_VendorIssues',
  'rname' => 'name',
);
$dictionary["Note"]["fields"]["vi_vendorissues_notesvi_vendorissues_ida"] = array (
  'name' => 'vi_vendorissues_notesvi_vendorissues_ida',
  'type' => 'link',
  'relationship' => 'vi_vendorissues_notes',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_VI_VENDORISSUES_NOTES_FROM_NOTES_TITLE',
);
