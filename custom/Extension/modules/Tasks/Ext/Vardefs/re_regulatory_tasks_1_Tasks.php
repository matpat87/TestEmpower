<?php
// created: 2018-06-23 09:03:50
$dictionary["Task"]["fields"]["re_regulatory_tasks_1"] = array (
  'name' => 're_regulatory_tasks_1',
  'type' => 'link',
  'relationship' => 're_regulatory_tasks_1',
  'source' => 'non-db',
  'module' => 'RE_Regulatory',
  'bean_name' => 'RE_Regulatory',
  'vname' => 'LBL_RE_REGULATORY_TASKS_1_FROM_RE_REGULATORY_TITLE',
  'id_name' => 're_regulatory_tasks_1re_regulatory_ida',
);
$dictionary["Task"]["fields"]["re_regulatory_tasks_1_name"] = array (
  'name' => 're_regulatory_tasks_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_RE_REGULATORY_TASKS_1_FROM_RE_REGULATORY_TITLE',
  'save' => true,
  'id_name' => 're_regulatory_tasks_1re_regulatory_ida',
  'link' => 're_regulatory_tasks_1',
  'table' => 're_regulatory',
  'module' => 'RE_Regulatory',
  'rname' => 'name',
);
$dictionary["Task"]["fields"]["re_regulatory_tasks_1re_regulatory_ida"] = array (
  'name' => 're_regulatory_tasks_1re_regulatory_ida',
  'type' => 'link',
  'relationship' => 're_regulatory_tasks_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_RE_REGULATORY_TASKS_1_FROM_TASKS_TITLE',
);
