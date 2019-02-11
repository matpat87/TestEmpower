<?php
// created: 2019-02-11 17:33:49
$dictionary["Project"]["fields"]["tr_technicalrequests_project"] = array (
  'name' => 'tr_technicalrequests_project',
  'type' => 'link',
  'relationship' => 'tr_technicalrequests_project',
  'source' => 'non-db',
  'module' => 'TR_TechnicalRequests',
  'bean_name' => 'TR_TechnicalRequests',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_PROJECT_FROM_TR_TECHNICALREQUESTS_TITLE',
  'id_name' => 'tr_technicalrequests_projecttr_technicalrequests_ida',
);
$dictionary["Project"]["fields"]["tr_technicalrequests_project_name"] = array (
  'name' => 'tr_technicalrequests_project_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_PROJECT_FROM_TR_TECHNICALREQUESTS_TITLE',
  'save' => true,
  'id_name' => 'tr_technicalrequests_projecttr_technicalrequests_ida',
  'link' => 'tr_technicalrequests_project',
  'table' => 'tr_technicalrequests',
  'module' => 'TR_TechnicalRequests',
  'rname' => 'name',
);
$dictionary["Project"]["fields"]["tr_technicalrequests_projecttr_technicalrequests_ida"] = array (
  'name' => 'tr_technicalrequests_projecttr_technicalrequests_ida',
  'type' => 'link',
  'relationship' => 'tr_technicalrequests_project',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'left',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_PROJECT_FROM_TR_TECHNICALREQUESTS_TITLE',
);
