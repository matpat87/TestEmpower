<?php
 // created: 2020-07-21 16:20:00
$layout_defs["Accounts"]["subpanel_setup"]['contacts'] = array (
  'order' => 100,
  'module' => 'Contacts',
  'subpanel_name' => 'Account_subpanel_contacts',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_CONTACTS_ACCOUNTS_TITLE',
  'get_subpanel_data' => 'contacts',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubpanelContactsCreateButton',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
