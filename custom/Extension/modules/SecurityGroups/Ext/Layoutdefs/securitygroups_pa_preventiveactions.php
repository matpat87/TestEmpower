<?php
$layout_defs["SecurityGroups"]["subpanel_setup"]['securitygroups_pa_preventiveactions'] = array (
  'order' => 100,
  'module' => 'PA_PreventiveActions',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SECURITYGROUPS_PA_PREVENTIVE_ACTIONS_FROM_DOCUMENTS_TITLE',
  'get_subpanel_data' => 'securitygroups_pa_preventiveactions',
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