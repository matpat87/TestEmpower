<?php
 // created: 2021-06-30 13:55:22
$layout_defs["PA_EHSActionItems"]["subpanel_setup"]['pa_ehsactionitems_contacts_1'] = array (
  'order' => 100,
  'module' => 'Contacts',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_PA_EHSACTIONITEMS_CONTACTS_1_FROM_CONTACTS_TITLE',
  'get_subpanel_data' => 'pa_ehsactionitems_contacts_1',
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
