<?php
 // created: 2021-04-08 09:56:31
$layout_defs["Contacts"]["subpanel_setup"]['pa_preventiveactions_contacts_1'] = array (
  'order' => 100,
  'module' => 'PA_PreventiveActions',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_PA_PREVENTIVEACTIONS_CONTACTS_1_FROM_PA_PREVENTIVEACTIONS_TITLE',
  'get_subpanel_data' => 'pa_preventiveactions_contacts_1',
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
