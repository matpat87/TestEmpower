<?php
 // created: 2020-11-08 09:34:45
$layout_defs["SO_SavingOpportunities"]["subpanel_setup"]['so_savingopportunities_vend_vendors_1'] = array (
  'order' => 100,
  'module' => 'VEND_Vendors',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SO_SAVINGOPPORTUNITIES_VEND_VENDORS_1_FROM_VEND_VENDORS_TITLE',
  'get_subpanel_data' => 'so_savingopportunities_vend_vendors_1',
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
