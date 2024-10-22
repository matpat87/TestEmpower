<?php
// created: 2022-10-09 09:16:28
$dictionary["Document"]["fields"]["rrq_regulatoryrequests_documents_1"] = array (
  'name' => 'rrq_regulatoryrequests_documents_1',
  'type' => 'link',
  'relationship' => 'rrq_regulatoryrequests_documents_1',
  'source' => 'non-db',
  'module' => 'RRQ_RegulatoryRequests',
  'bean_name' => 'RRQ_RegulatoryRequests',
  'vname' => 'LBL_RRQ_REGULATORYREQUESTS_DOCUMENTS_1_FROM_RRQ_REGULATORYREQUESTS_TITLE',
  'id_name' => 'rrq_regulatoryrequests_documents_1rrq_regulatoryrequests_ida',
);
$dictionary["Document"]["fields"]["rrq_regulatoryrequests_documents_1_name"] = array (
  'name' => 'rrq_regulatoryrequests_documents_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_RRQ_REGULATORYREQUESTS_DOCUMENTS_1_FROM_RRQ_REGULATORYREQUESTS_TITLE',
  'save' => true,
  'id_name' => 'rrq_regulatoryrequests_documents_1rrq_regulatoryrequests_ida',
  'link' => 'rrq_regulatoryrequests_documents_1',
  'table' => 'rrq_regulatoryrequests',
  'module' => 'RRQ_RegulatoryRequests',
  'rname' => 'name',
);
$dictionary["Document"]["fields"]["rrq_regulatoryrequests_documents_1rrq_regulatoryrequests_ida"] = array (
  'name' => 'rrq_regulatoryrequests_documents_1rrq_regulatoryrequests_ida',
  'type' => 'link',
  'relationship' => 'rrq_regulatoryrequests_documents_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_RRQ_REGULATORYREQUESTS_DOCUMENTS_1_FROM_DOCUMENTS_TITLE',
);
