<?php
 // created: 2022-09-16 08:31:16
$layout_defs["Contacts"]["subpanel_setup"]['contacts_contacts_1contacts_ida'] = array (
  'order' => 100,
  'module' => 'Contacts',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_CONTACTS_CONTACTS_1_FROM_CONTACTS_R_TITLE',
  'get_subpanel_data' => 'contacts_contacts_1contacts_ida',
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
