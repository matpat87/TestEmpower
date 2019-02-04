<?php
// created: 2019-02-04 16:24:24
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_opportunities"] = array (
  'name' => 'ci_customeritems_opportunities',
  'type' => 'link',
  'relationship' => 'ci_customeritems_opportunities',
  'source' => 'non-db',
  'module' => 'Opportunities',
  'bean_name' => 'Opportunity',
  'vname' => 'LBL_CI_CUSTOMERITEMS_OPPORTUNITIES_FROM_OPPORTUNITIES_TITLE',
  'id_name' => 'ci_customeritems_opportunitiesopportunities_ida',
);
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_opportunities_name"] = array (
  'name' => 'ci_customeritems_opportunities_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CI_CUSTOMERITEMS_OPPORTUNITIES_FROM_OPPORTUNITIES_TITLE',
  'save' => true,
  'id_name' => 'ci_customeritems_opportunitiesopportunities_ida',
  'link' => 'ci_customeritems_opportunities',
  'table' => 'opportunities',
  'module' => 'Opportunities',
  'rname' => 'name',
);
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_opportunitiesopportunities_ida"] = array (
  'name' => 'ci_customeritems_opportunitiesopportunities_ida',
  'type' => 'link',
  'relationship' => 'ci_customeritems_opportunities',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_CI_CUSTOMERITEMS_OPPORTUNITIES_FROM_CI_CUSTOMERITEMS_TITLE',
);
