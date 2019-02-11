<?php
// created: 2019-02-11 17:33:49
$dictionary["TR_TechnicalRequests"]["fields"]["tr_technicalrequests_project"] = array (
  'name' => 'tr_technicalrequests_project',
  'type' => 'link',
  'relationship' => 'tr_technicalrequests_project',
  'source' => 'non-db',
  'module' => 'Project',
  'bean_name' => 'Project',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_PROJECT_FROM_PROJECT_TITLE',
  'id_name' => 'tr_technicalrequests_projectproject_idb',
);
$dictionary["TR_TechnicalRequests"]["fields"]["tr_technicalrequests_project_name"] = array (
  'name' => 'tr_technicalrequests_project_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_PROJECT_FROM_PROJECT_TITLE',
  'save' => true,
  'id_name' => 'tr_technicalrequests_projectproject_idb',
  'link' => 'tr_technicalrequests_project',
  'table' => 'project',
  'module' => 'Project',
  'rname' => 'name',
);
$dictionary["TR_TechnicalRequests"]["fields"]["tr_technicalrequests_projectproject_idb"] = array (
  'name' => 'tr_technicalrequests_projectproject_idb',
  'type' => 'link',
  'relationship' => 'tr_technicalrequests_project',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'left',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_PROJECT_FROM_PROJECT_TITLE',
);
