<?php
 // created: 2020-10-20 06:51:36
$layout_defs["SO_SavingOpportunities"]["subpanel_setup"]['so_savingopportunities_documents'] = array (
  'order' => 100,
  'module' => 'Documents',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SO_SAVINGOPPORTUNITIES_DOCUMENTS_FROM_DOCUMENTS_TITLE',
  'get_subpanel_data' => 'so_savingopportunities_documents',
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
