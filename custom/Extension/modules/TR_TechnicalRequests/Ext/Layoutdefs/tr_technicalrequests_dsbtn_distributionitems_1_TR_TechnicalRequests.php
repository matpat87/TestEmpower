
<?php
 // created: 2019-11-01 11:28:22
$layout_defs["TR_TechnicalRequests"]["subpanel_setup"]['tr_technicalrequests_dsbtn_distributionitems_1'] = array (
  'order' => 3,
  'module' => 'DSBTN_DistributionItems',
  'subpanel_name' => 'TR_TechnicalRequests_subpanel_tr_technicalrequests_dsbtn_distributionitems_1',
  'sort_order' => 'asc',
  'sort_by' => 'custom_distribution_number_c',
  'title_key' => 'LBL_TR_TECHNICALREQUESTS_DSBTN_DISTRIBUTIONITEMS_1_FROM_DSBTN_DISTRIBUTIONITEMS_TITLE',
  'get_subpanel_data' => 'function:get_distributions',
  'function_parameters' => array(
    'import_function_file' => 'custom/modules/DSBTN_DistributionItems/func/get_distributions.php',
  ),
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
  ),
);
