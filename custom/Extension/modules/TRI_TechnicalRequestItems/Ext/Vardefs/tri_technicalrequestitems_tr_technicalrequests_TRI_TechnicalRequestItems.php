<?php
// created: 2021-02-03 12:14:45
$dictionary["TRI_TechnicalRequestItems"]["fields"]["tri_technicalrequestitems_tr_technicalrequests"] = array (
  'name' => 'tri_technicalrequestitems_tr_technicalrequests',
  'type' => 'link',
  'relationship' => 'tri_technicalrequestitems_tr_technicalrequests',
  'source' => 'non-db',
  'module' => 'TR_TechnicalRequests',
  'bean_name' => 'TR_TechnicalRequests',
  'vname' => 'LBL_TRI_TECHNICALREQUESTITEMS_TR_TECHNICALREQUESTS_FROM_TR_TECHNICALREQUESTS_TITLE',
  'id_name' => 'tri_techni0387equests_ida',
);
$dictionary["TRI_TechnicalRequestItems"]["fields"]["tri_technicalrequestitems_tr_technicalrequests_name"] = array (
  'name' => 'tri_technicalrequestitems_tr_technicalrequests_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TRI_TECHNICALREQUESTITEMS_TR_TECHNICALREQUESTS_FROM_TR_TECHNICALREQUESTS_TITLE',
  'save' => true,
  'id_name' => 'tri_techni0387equests_ida',
  'link' => 'tri_technicalrequestitems_tr_technicalrequests',
  'table' => 'tr_technicalrequests',
  'module' => 'TR_TechnicalRequests',
  'rname' => 'name',
);
$dictionary["TRI_TechnicalRequestItems"]["fields"]["tri_techni0387equests_ida"] = array (
  'name' => 'tri_techni0387equests_ida',
  'type' => 'link',
  'relationship' => 'tri_technicalrequestitems_tr_technicalrequests',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TRI_TECHNICALREQUESTITEMS_TR_TECHNICALREQUESTS_FROM_TRI_TECHNICALREQUESTITEMS_TITLE',
);
