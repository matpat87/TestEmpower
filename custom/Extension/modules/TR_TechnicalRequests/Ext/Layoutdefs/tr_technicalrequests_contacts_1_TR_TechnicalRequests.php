<?php
 // created: 2019-10-14 13:24:30
$layout_defs["TR_TechnicalRequests"]["subpanel_setup"]['tr_technicalrequests_contacts_1'] = array (
  'order' => 100,
  'module' => 'Contacts',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_TR_TECHNICALREQUESTS_CONTACTS_1_FROM_CONTACTS_TITLE',
  'get_subpanel_data' => 'tr_technicalrequests_contacts_1',
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
