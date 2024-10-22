<?php
 // created: 2023-08-31 16:58:52
$layout_defs["APX_Lots"]["subpanel_setup"]['apx_lots_ci_customeritems'] = array (
  'order' => 100,
  'module' => 'CI_CustomerItems',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_APX_LOTS_CI_CUSTOMERITEMS_FROM_CI_CUSTOMERITEMS_TITLE',
  'get_subpanel_data' => 'apx_lots_ci_customeritems',
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
