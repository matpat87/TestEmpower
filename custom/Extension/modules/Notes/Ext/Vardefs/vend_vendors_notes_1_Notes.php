<?php
// created: 2020-09-08 08:10:24
$dictionary["Note"]["fields"]["vend_vendors_notes_1"] = array (
  'name' => 'vend_vendors_notes_1',
  'type' => 'link',
  'relationship' => 'vend_vendors_notes_1',
  'source' => 'non-db',
  'module' => 'VEND_Vendors',
  'bean_name' => 'VEND_Vendors',
  'vname' => 'LBL_VEND_VENDORS_NOTES_1_FROM_VEND_VENDORS_TITLE',
  'id_name' => 'vend_vendors_notes_1vend_vendors_ida',
);
$dictionary["Note"]["fields"]["vend_vendors_notes_1_name"] = array (
  'name' => 'vend_vendors_notes_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_VEND_VENDORS_NOTES_1_FROM_VEND_VENDORS_TITLE',
  'save' => true,
  'id_name' => 'vend_vendors_notes_1vend_vendors_ida',
  'link' => 'vend_vendors_notes_1',
  'table' => 'vend_vendors',
  'module' => 'VEND_Vendors',
  'rname' => 'name',
);
$dictionary["Note"]["fields"]["vend_vendors_notes_1vend_vendors_ida"] = array (
  'name' => 'vend_vendors_notes_1vend_vendors_ida',
  'type' => 'link',
  'relationship' => 'vend_vendors_notes_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_VEND_VENDORS_NOTES_1_FROM_NOTES_TITLE',
);
