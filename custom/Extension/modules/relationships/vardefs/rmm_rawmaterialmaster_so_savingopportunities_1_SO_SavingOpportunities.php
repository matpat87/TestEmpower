<?php
// created: 2020-11-16 08:52:24
$dictionary["SO_SavingOpportunities"]["fields"]["rmm_rawmaterialmaster_so_savingopportunities_1"] = array (
  'name' => 'rmm_rawmaterialmaster_so_savingopportunities_1',
  'type' => 'link',
  'relationship' => 'rmm_rawmaterialmaster_so_savingopportunities_1',
  'source' => 'non-db',
  'module' => 'RMM_RawMaterialMaster',
  'bean_name' => 'RMM_RawMaterialMaster',
  'vname' => 'LBL_RMM_RAWMATERIALMASTER_SO_SAVINGOPPORTUNITIES_1_FROM_RMM_RAWMATERIALMASTER_TITLE',
  'id_name' => 'rmm_rawmat46f2lmaster_ida',
);
$dictionary["SO_SavingOpportunities"]["fields"]["rmm_rawmaterialmaster_so_savingopportunities_1_name"] = array (
  'name' => 'rmm_rawmaterialmaster_so_savingopportunities_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_RMM_RAWMATERIALMASTER_SO_SAVINGOPPORTUNITIES_1_FROM_RMM_RAWMATERIALMASTER_TITLE',
  'save' => true,
  'id_name' => 'rmm_rawmat46f2lmaster_ida',
  'link' => 'rmm_rawmaterialmaster_so_savingopportunities_1',
  'table' => 'rmm_rawmaterialmaster',
  'module' => 'RMM_RawMaterialMaster',
  'rname' => 'name',
);
$dictionary["SO_SavingOpportunities"]["fields"]["rmm_rawmat46f2lmaster_ida"] = array (
  'name' => 'rmm_rawmat46f2lmaster_ida',
  'type' => 'link',
  'relationship' => 'rmm_rawmaterialmaster_so_savingopportunities_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_RMM_RAWMATERIALMASTER_SO_SAVINGOPPORTUNITIES_1_FROM_SO_SAVINGOPPORTUNITIES_TITLE',
);
