<?php
 //OnTrack #982
$layout_defs["AOS_Invoices"]["subpanel_setup"]['securitygroups_aos_invoices'] = array (
  'order' => 100,
  'module' => 'SecurityGroups',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SECUIRTYGROUPS_AOS_INVOICES_TITLE',
  'get_subpanel_data' => 'SecurityGroups',
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
