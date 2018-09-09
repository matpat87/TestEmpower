<?php
$module_name = 'BR_BudgetReport';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'assigned_user_id' =>
      array(
          'name' => 'assigned_user_id',
          'type' => 'enum',
          'label' => 'LBL_ASSIGNED_TO',
          'function' =>
              array(
                  'name' => 'BudgetReportQuery::retrieve_sales_group_user_list',
                  'params' =>
                      array(
                          0 => false,
                      ),
              ),
          'default' => true,
          'width' => '10%',
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'maxColumnsBasic' => '4',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
;
?>
