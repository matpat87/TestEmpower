<?php
// created: 2019-02-04 16:24:24
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_project"] = array (
  'name' => 'ci_customeritems_project',
  'type' => 'link',
  'relationship' => 'ci_customeritems_project',
  'source' => 'non-db',
  'module' => 'Project',
  'bean_name' => 'Project',
  'vname' => 'LBL_CI_CUSTOMERITEMS_PROJECT_FROM_PROJECT_TITLE',
  'id_name' => 'ci_customeritems_projectproject_ida',
);
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_project_name"] = array (
  'name' => 'ci_customeritems_project_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CI_CUSTOMERITEMS_PROJECT_FROM_PROJECT_TITLE',
  'save' => true,
  'id_name' => 'ci_customeritems_projectproject_ida',
  'link' => 'ci_customeritems_project',
  'table' => 'project',
  'module' => 'Project',
  'rname' => 'name',
);
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_projectproject_ida"] = array (
  'name' => 'ci_customeritems_projectproject_ida',
  'type' => 'link',
  'relationship' => 'ci_customeritems_project',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_CI_CUSTOMERITEMS_PROJECT_FROM_CI_CUSTOMERITEMS_TITLE',
);
