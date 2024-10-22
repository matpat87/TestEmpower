<?php
// created: 2020-07-27 08:00:28
$dictionary["ProjectTask"]["fields"]["users_projecttask_1"] = array (
  'name' => 'users_projecttask_1',
  'type' => 'link',
  'relationship' => 'users_projecttask_1',
  'source' => 'non-db',
  'module' => 'Users',
  'bean_name' => 'User',
  'vname' => 'LBL_USERS_PROJECTTASK_1_FROM_USERS_TITLE',
  'id_name' => 'users_projecttask_1users_ida',
);
$dictionary["ProjectTask"]["fields"]["users_projecttask_1_name"] = array (
  'name' => 'users_projecttask_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_USERS_PROJECTTASK_1_FROM_USERS_TITLE',
  'save' => true,
  'id_name' => 'users_projecttask_1users_ida',
  'link' => 'users_projecttask_1',
  'table' => 'users',
  'module' => 'Users',
  'rname' => 'name',
);
$dictionary["ProjectTask"]["fields"]["users_projecttask_1users_ida"] = array (
  'name' => 'users_projecttask_1users_ida',
  'type' => 'link',
  'relationship' => 'users_projecttask_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_USERS_PROJECTTASK_1_FROM_PROJECTTASK_TITLE',
);
