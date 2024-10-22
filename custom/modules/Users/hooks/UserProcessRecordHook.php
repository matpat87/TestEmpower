<?php
  class UserProcessRecordHook
  {
    public function processCustomColumn(&$bean, $event, $arguments)
    {
      global $app_list_strings;
      
      $salesGroupOptions = getSalesGroupForReports();
      $bean->sales_group_c = $salesGroupOptions[$bean->sales_group_c] ?? $app_list_strings['sales_group_list'][$bean->sales_group_c];
    }
  }
?>