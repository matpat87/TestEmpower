<?php
// created: 2019-02-11 17:33:49
$dictionary["Document"]["fields"]["tr_technicalrequests_documents"] = array (
  'name' => 'tr_technicalrequests_documents',
  'type' => 'link',
  'relationship' => 'tr_technicalrequests_documents',
  'source' => 'non-db',
  'module' => 'TR_TechnicalRequests',
  'bean_name' => 'TR_TechnicalRequests',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_DOCUMENTS_FROM_TR_TECHNICALREQUESTS_TITLE',
  'id_name' => 'tr_technicalrequests_documentstr_technicalrequests_ida',
);
$dictionary["Document"]["fields"]["tr_technicalrequests_documents_name"] = array (
  'name' => 'tr_technicalrequests_documents_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_DOCUMENTS_FROM_TR_TECHNICALREQUESTS_TITLE',
  'save' => true,
  'id_name' => 'tr_technicalrequests_documentstr_technicalrequests_ida',
  'link' => 'tr_technicalrequests_documents',
  'table' => 'tr_technicalrequests',
  'module' => 'TR_TechnicalRequests',
  'rname' => 'name',
);
$dictionary["Document"]["fields"]["tr_technicalrequests_documentstr_technicalrequests_ida"] = array (
  'name' => 'tr_technicalrequests_documentstr_technicalrequests_ida',
  'type' => 'link',
  'relationship' => 'tr_technicalrequests_documents',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_DOCUMENTS_FROM_DOCUMENTS_TITLE',
);
