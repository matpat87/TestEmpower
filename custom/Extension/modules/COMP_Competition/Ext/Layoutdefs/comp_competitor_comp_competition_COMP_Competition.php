<?php
 // created: 2021-11-19 10:00:49
$layout_defs["COMP_Competition"]["subpanel_setup"]['comp_competitor_comp_competition'] = array (
  'order' => 100,
  'module' => 'COMP_Competitor',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_COMP_COMPETITOR_COMP_COMPETITION_FROM_COMP_COMPETITOR_TITLE',
  'get_subpanel_data' => 'comp_competitor_comp_competition',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
