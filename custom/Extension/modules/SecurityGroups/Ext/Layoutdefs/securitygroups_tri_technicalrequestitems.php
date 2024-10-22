<?php
$layout_defs["SecurityGroups"]["subpanel_setup"]['securitygroups_tri_technicalrequestitems'] = array (
  'order' => 100,
  'module' => 'TRI_TechnicalRequestItems',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SECURITYGROUPS_TRI_TECHNICALREQUESTITEMS_FROM_TRI_TECHNICALREQUESTITEMS_TITLE',
  'get_subpanel_data' => 'securitygroups_tri_technicalrequestitems',
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
