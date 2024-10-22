<?php
// created: 2022-05-25 06:33:51
$dictionary["TR_TechnicalRequests"]["fields"]["comp_competitor_tr_technicalrequests_1"] = array (
  'name' => 'comp_competitor_tr_technicalrequests_1',
  'type' => 'link',
  'relationship' => 'comp_competitor_tr_technicalrequests_1',
  'source' => 'non-db',
  'module' => 'COMP_Competitor',
  'bean_name' => 'COMP_Competitor',
  'vname' => 'LBL_COMP_COMPETITOR_TR_TECHNICALREQUESTS_1_FROM_COMP_COMPETITOR_TITLE',
  'id_name' => 'comp_competitor_tr_technicalrequests_1comp_competitor_ida',
);
$dictionary["TR_TechnicalRequests"]["fields"]["comp_competitor_tr_technicalrequests_1_name"] = array (
  'name' => 'comp_competitor_tr_technicalrequests_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_COMP_COMPETITOR_TR_TECHNICALREQUESTS_1_FROM_COMP_COMPETITOR_TITLE',
  'save' => true,
  'id_name' => 'comp_competitor_tr_technicalrequests_1comp_competitor_ida',
  'link' => 'comp_competitor_tr_technicalrequests_1',
  'table' => 'comp_competitor',
  'module' => 'COMP_Competitor',
  'rname' => 'name',
);
$dictionary["TR_TechnicalRequests"]["fields"]["comp_competitor_tr_technicalrequests_1comp_competitor_ida"] = array (
  'name' => 'comp_competitor_tr_technicalrequests_1comp_competitor_ida',
  'type' => 'link',
  'relationship' => 'comp_competitor_tr_technicalrequests_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_COMP_COMPETITOR_TR_TECHNICALREQUESTS_1_FROM_TR_TECHNICALREQUESTS_TITLE',
);
