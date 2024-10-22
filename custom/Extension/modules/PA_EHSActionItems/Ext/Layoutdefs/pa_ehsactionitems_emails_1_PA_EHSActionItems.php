<?php
 // created: 2021-06-30 13:43:16
$layout_defs["PA_EHSActionItems"]["subpanel_setup"]['pa_ehsactionitems_emails_1'] = array (
  'order' => 100,
  'module' => 'Emails',
  'subpanel_name' => 'ForQueues',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_PA_EHSACTIONITEMS_EMAILS_1_FROM_EMAILS_TITLE',
  'get_subpanel_data' => 'pa_ehsactionitems_emails_1',
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
