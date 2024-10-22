<?php
// created: 2021-11-19 10:00:49
$dictionary["comp_competitor_comp_competition"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'comp_competitor_comp_competition' => 
    array (
      'lhs_module' => 'COMP_Competition',
      'lhs_table' => 'comp_competition',
      'lhs_key' => 'id',
      'rhs_module' => 'COMP_Competitor',
      'rhs_table' => 'comp_competitor',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'comp_competitor_comp_competition_c',
      'join_key_lhs' => 'comp_competitor_comp_competitioncomp_competition_ida',
      'join_key_rhs' => 'comp_competitor_comp_competitioncomp_competitor_idb',
    ),
  ),
  'table' => 'comp_competitor_comp_competition_c',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'comp_competitor_comp_competitioncomp_competition_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'comp_competitor_comp_competitioncomp_competitor_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'comp_competitor_comp_competitionspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'comp_competitor_comp_competition_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'comp_competitor_comp_competitioncomp_competition_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'comp_competitor_comp_competition_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'comp_competitor_comp_competitioncomp_competitor_idb',
      ),
    ),
  ),
);