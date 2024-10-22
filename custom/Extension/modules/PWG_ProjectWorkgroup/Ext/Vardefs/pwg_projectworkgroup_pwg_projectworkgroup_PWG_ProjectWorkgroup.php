<?php
// created: 2020-09-24 06:50:52
$dictionary["PWG_ProjectWorkgroup"]["fields"]["pwg_projectworkgroup_pwg_projectworkgroup"]=array (
  'name' => 'pwg_projectworkgroup_pwg_projectworkgroup',
  'type' => 'link',
  'relationship' => 'pwg_projectworkgroup_pwg_projectworkgroup',
  'source' => 'non-db',
  'module' => 'PWG_ProjectWorkgroup',
  'bean_name' => 'PWG_ProjectWorkgroup',
  'vname' => 'LBL_PWG_PROJECTWORKGROUP_PWG_PROJECTWORKGROUP_FROM_PWG_PROJECTWORKGROUP_L_TITLE',
  'id_name' => 'pwg_projeccf54rkgroup_ida',
  'side' => 'left',
);
$dictionary["PWG_ProjectWorkgroup"]["fields"]["pwg_projectworkgroup_pwg_projectworkgroup_name"] = array (
  'name' => 'pwg_projectworkgroup_pwg_projectworkgroup_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_PWG_PROJECTWORKGROUP_PWG_PROJECTWORKGROUP_FROM_PWG_PROJECTWORKGROUP_L_TITLE',
  'save' => true,
  'id_name' => 'pwg_projeccf54rkgroup_ida',
  'link' => 'pwg_projectworkgroup_pwg_projectworkgroup',
  'table' => 'pwg_projectworkgroup',
  'module' => 'PWG_ProjectWorkgroup',
  'rname' => 'name',
);
$dictionary["PWG_ProjectWorkgroup"]["fields"]["pwg_projeccf54rkgroup_ida"] = array (
  'name' => 'pwg_projeccf54rkgroup_ida',
  'type' => 'link',
  'relationship' => 'pwg_projectworkgroup_pwg_projectworkgroup',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_PWG_PROJECTWORKGROUP_PWG_PROJECTWORKGROUP_FROM_PWG_PROJECTWORKGROUP_R_TITLE',
);
