<?php
 // created: 2020-11-16 08:52:23
$layout_defs["RMM_RawMaterialMaster"]["subpanel_setup"]['rmm_rawmaterialmaster_so_savingopportunities_1'] = array (
  'order' => 100,
  'module' => 'SO_SavingOpportunities',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_RMM_RAWMATERIALMASTER_SO_SAVINGOPPORTUNITIES_1_FROM_SO_SAVINGOPPORTUNITIES_TITLE',
  'get_subpanel_data' => 'rmm_rawmaterialmaster_so_savingopportunities_1',
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
