<?php
//OnTrack #981
$layout_defs["SecurityGroups"]["subpanel_setup"]['securitygroups_odr_salesorders'] = array (
  'order' => 100,
  'module' => 'ODR_SalesOrders',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SECUIRTYGROUPS_ODR_SALESORDERS_FROM_DOCUMENTS_TITLE',
  'get_subpanel_data' => 'securitygroups_odr_salesorders',
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
