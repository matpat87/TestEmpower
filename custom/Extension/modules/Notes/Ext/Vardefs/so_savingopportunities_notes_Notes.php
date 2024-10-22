<?php
// created: 2020-10-20 06:51:36
$dictionary["Note"]["fields"]["so_savingopportunities_notes"] = array (
  'name' => 'so_savingopportunities_notes',
  'type' => 'link',
  'relationship' => 'so_savingopportunities_notes',
  'source' => 'non-db',
  'module' => 'SO_SavingOpportunities',
  'bean_name' => false,
  'vname' => 'LBL_SO_SAVINGOPPORTUNITIES_NOTES_FROM_SO_SAVINGOPPORTUNITIES_TITLE',
  'id_name' => 'so_savingopportunities_notesso_savingopportunities_ida',
);
$dictionary["Note"]["fields"]["so_savingopportunities_notes_name"] = array (
  'name' => 'so_savingopportunities_notes_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_SO_SAVINGOPPORTUNITIES_NOTES_FROM_SO_SAVINGOPPORTUNITIES_TITLE',
  'save' => true,
  'id_name' => 'so_savingopportunities_notesso_savingopportunities_ida',
  'link' => 'so_savingopportunities_notes',
  'table' => 'so_savingopportunities',
  'module' => 'SO_SavingOpportunities',
  'rname' => 'name',
);
$dictionary["Note"]["fields"]["so_savingopportunities_notesso_savingopportunities_ida"] = array (
  'name' => 'so_savingopportunities_notesso_savingopportunities_ida',
  'type' => 'link',
  'relationship' => 'so_savingopportunities_notes',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_SO_SAVINGOPPORTUNITIES_NOTES_FROM_NOTES_TITLE',
);
