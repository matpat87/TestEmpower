<?php
// created: 2019-02-04 16:24:24
$dictionary["Note"]["fields"]["ci_customeritems_notes"] = array (
  'name' => 'ci_customeritems_notes',
  'type' => 'link',
  'relationship' => 'ci_customeritems_notes',
  'source' => 'non-db',
  'module' => 'CI_CustomerItems',
  'bean_name' => false,
  'vname' => 'LBL_CI_CUSTOMERITEMS_NOTES_FROM_CI_CUSTOMERITEMS_TITLE',
  'id_name' => 'ci_customeritems_notesci_customeritems_ida',
);
$dictionary["Note"]["fields"]["ci_customeritems_notes_name"] = array (
  'name' => 'ci_customeritems_notes_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CI_CUSTOMERITEMS_NOTES_FROM_CI_CUSTOMERITEMS_TITLE',
  'save' => true,
  'id_name' => 'ci_customeritems_notesci_customeritems_ida',
  'link' => 'ci_customeritems_notes',
  'table' => 'ci_customeritems',
  'module' => 'CI_CustomerItems',
  'rname' => 'name',
);
$dictionary["Note"]["fields"]["ci_customeritems_notesci_customeritems_ida"] = array (
  'name' => 'ci_customeritems_notesci_customeritems_ida',
  'type' => 'link',
  'relationship' => 'ci_customeritems_notes',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_CI_CUSTOMERITEMS_NOTES_FROM_NOTES_TITLE',
);
