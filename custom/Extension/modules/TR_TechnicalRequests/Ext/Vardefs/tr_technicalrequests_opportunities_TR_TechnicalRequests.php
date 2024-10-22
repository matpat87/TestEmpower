<?php
// created: 2019-02-11 17:33:49
$dictionary["TR_TechnicalRequests"]["fields"]["tr_technicalrequests_opportunities"] = array (
  'name' => 'tr_technicalrequests_opportunities',
  'type' => 'link',
  'relationship' => 'tr_technicalrequests_opportunities',
  'source' => 'non-db',
  'module' => 'Opportunities',
  'bean_name' => 'Opportunity',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_OPPORTUNITIES_FROM_OPPORTUNITIES_TITLE',
  'id_name' => 'tr_technicalrequests_opportunitiesopportunities_ida',
);
$dictionary["TR_TechnicalRequests"]["fields"]["tr_technicalrequests_opportunities_name"] = array (
  'name' => 'tr_technicalrequests_opportunities_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_OPPORTUNITIES_FROM_OPPORTUNITIES_TITLE',
  'save' => true,
  'id_name' => 'tr_technicalrequests_opportunitiesopportunities_ida',
  'link' => 'tr_technicalrequests_opportunities',
  'table' => 'opportunities',
  'module' => 'Opportunities',
  'rname' => 'name',
  'required' => true,
  'audited' => true,
);
$dictionary["TR_TechnicalRequests"]["fields"]["tr_technicalrequests_opportunitiesopportunities_ida"] = array (
  'name' => 'tr_technicalrequests_opportunitiesopportunities_ida',
  'type' => 'link',
  'relationship' => 'tr_technicalrequests_opportunities',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TR_TECHNICALREQUESTS_OPPORTUNITIES_FROM_TR_TECHNICALREQUESTS_TITLE',
);
