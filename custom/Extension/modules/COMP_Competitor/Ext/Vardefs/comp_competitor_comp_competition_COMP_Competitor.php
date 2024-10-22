<?php
// created: 2021-11-19 10:00:49
$dictionary["COMP_Competitor"]["fields"]["comp_competitor_comp_competition"] = array (
  'name' => 'comp_competitor_comp_competition',
  'type' => 'link',
  'relationship' => 'comp_competitor_comp_competition',
  'source' => 'non-db',
  'module' => 'COMP_Competition',
  'bean_name' => 'COMP_Competition',
  'vname' => 'LBL_COMP_COMPETITOR_COMP_COMPETITION_FROM_COMP_COMPETITION_TITLE',
  'id_name' => 'comp_competitor_comp_competitioncomp_competition_ida',
);
$dictionary["COMP_Competitor"]["fields"]["comp_competitor_comp_competition_name"] = array (
  'name' => 'comp_competitor_comp_competition_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_COMP_COMPETITOR_COMP_COMPETITION_FROM_COMP_COMPETITION_TITLE',
  'save' => true,
  'id_name' => 'comp_competitor_comp_competitioncomp_competition_ida',
  'link' => 'comp_competitor_comp_competition',
  'table' => 'comp_competition',
  'module' => 'COMP_Competition',
  'rname' => 'name',
);
$dictionary["COMP_Competitor"]["fields"]["comp_competitor_comp_competitioncomp_competition_ida"] = array (
  'name' => 'comp_competitor_comp_competitioncomp_competition_ida',
  'type' => 'link',
  'relationship' => 'comp_competitor_comp_competition',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_COMP_COMPETITOR_COMP_COMPETITION_FROM_COMP_COMPETITOR_TITLE',
);
