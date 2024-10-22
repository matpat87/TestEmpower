<?php
// created: 2023-01-27 10:12:46
$dictionary["RD_RegulatoryDocuments"]["fields"]["rd_regulatorydocuments_rd_regulatorydocuments_1"]=array (
  'name' => 'rd_regulatorydocuments_rd_regulatorydocuments_1',
  'type' => 'link',
  'relationship' => 'rd_regulatorydocuments_rd_regulatorydocuments_1',
  'source' => 'non-db',
  'module' => 'RD_RegulatoryDocuments',
  'bean_name' => 'RD_RegulatoryDocuments',
  'vname' => 'LBL_RD_REGULATORYDOCUMENTS_RD_REGULATORYDOCUMENTS_1_FROM_RD_REGULATORYDOCUMENTS_L_TITLE',
  'id_name' => 'rd_regulat73ffcuments_ida',
  'side' => 'left',
);
$dictionary["RD_RegulatoryDocuments"]["fields"]["rd_regulatorydocuments_rd_regulatorydocuments_1_name"] = array (
  'name' => 'rd_regulatorydocuments_rd_regulatorydocuments_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_RD_REGULATORYDOCUMENTS_RD_REGULATORYDOCUMENTS_1_FROM_RD_REGULATORYDOCUMENTS_L_TITLE',
  'save' => true,
  'id_name' => 'rd_regulat73ffcuments_ida',
  'link' => 'rd_regulatorydocuments_rd_regulatorydocuments_1',
  'table' => 'rd_regulatorydocuments',
  'module' => 'RD_RegulatoryDocuments',
  'rname' => 'document_name',
);
$dictionary["RD_RegulatoryDocuments"]["fields"]["rd_regulat73ffcuments_ida"] = array (
  'name' => 'rd_regulat73ffcuments_ida',
  'type' => 'link',
  'relationship' => 'rd_regulatorydocuments_rd_regulatorydocuments_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_RD_REGULATORYDOCUMENTS_RD_REGULATORYDOCUMENTS_1_FROM_RD_REGULATORYDOCUMENTS_R_TITLE',
);
