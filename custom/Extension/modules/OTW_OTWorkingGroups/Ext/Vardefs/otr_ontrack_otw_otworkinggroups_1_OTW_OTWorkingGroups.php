<?php
// created: 2021-07-26 14:08:25
$dictionary["OTW_OTWorkingGroups"]["fields"]["otr_ontrack_otw_otworkinggroups_1"] = array (
  'name' => 'otr_ontrack_otw_otworkinggroups_1',
  'type' => 'link',
  'relationship' => 'otr_ontrack_otw_otworkinggroups_1',
  'source' => 'non-db',
  'module' => 'OTR_OnTrack',
  'bean_name' => 'OTR_OnTrack',
  'vname' => 'LBL_OTR_ONTRACK_OTW_OTWORKINGGROUPS_1_FROM_OTR_ONTRACK_TITLE',
  'id_name' => 'otr_ontrack_otw_otworkinggroups_1otr_ontrack_ida',
);
$dictionary["OTW_OTWorkingGroups"]["fields"]["otr_ontrack_otw_otworkinggroups_1_name"] = array (
  'name' => 'otr_ontrack_otw_otworkinggroups_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_OTR_ONTRACK_OTW_OTWORKINGGROUPS_1_FROM_OTR_ONTRACK_TITLE',
  'save' => true,
  'id_name' => 'otr_ontrack_otw_otworkinggroups_1otr_ontrack_ida',
  'link' => 'otr_ontrack_otw_otworkinggroups_1',
  'table' => 'otr_ontrack',
  'module' => 'OTR_OnTrack',
  'rname' => 'name',
);
$dictionary["OTW_OTWorkingGroups"]["fields"]["otr_ontrack_otw_otworkinggroups_1otr_ontrack_ida"] = array (
  'name' => 'otr_ontrack_otw_otworkinggroups_1otr_ontrack_ida',
  'type' => 'link',
  'relationship' => 'otr_ontrack_otw_otworkinggroups_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_OTR_ONTRACK_OTW_OTWORKINGGROUPS_1_FROM_OTW_OTWORKINGGROUPS_TITLE',
);
