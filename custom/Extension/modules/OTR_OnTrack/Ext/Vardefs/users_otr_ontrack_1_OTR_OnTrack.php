<?php
// created: 2020-05-03 11:11:35
$dictionary["OTR_OnTrack"]["fields"]["users_otr_ontrack_1"] = array (
  'name' => 'users_otr_ontrack_1',
  'type' => 'link',
  'relationship' => 'users_otr_ontrack_1',
  'source' => 'non-db',
  'module' => 'Users',
  'bean_name' => 'User',
  'vname' => 'LBL_USERS_OTR_ONTRACK_1_FROM_USERS_TITLE',
  'id_name' => 'users_otr_ontrack_1users_ida',
);
$dictionary["OTR_OnTrack"]["fields"]["users_otr_ontrack_1_name"] = array (
  'name' => 'users_otr_ontrack_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_USERS_OTR_ONTRACK_1_FROM_USERS_TITLE',
  'save' => true,
  'id_name' => 'users_otr_ontrack_1users_ida',
  'link' => 'users_otr_ontrack_1',
  'table' => 'users',
  'module' => 'Users',
  'rname' => 'name',
);
$dictionary["OTR_OnTrack"]["fields"]["users_otr_ontrack_1users_ida"] = array (
  'name' => 'users_otr_ontrack_1users_ida',
  'type' => 'link',
  'relationship' => 'users_otr_ontrack_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_USERS_OTR_ONTRACK_1_FROM_OTR_ONTRACK_TITLE',
);
