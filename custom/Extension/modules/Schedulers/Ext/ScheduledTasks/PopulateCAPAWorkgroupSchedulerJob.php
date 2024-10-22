<?php

  require_once('custom/modules/CWG_CAPAWorkingGroup/helpers/CapaWorkingGroupHelper.php');

  class PopulateCAPAWorkgroupSchedulerJob implements RunnableSchedulerJob
  {
    public function run($arguments)
    {
      global $db, $app_list_strings, $log;

      $customerIssueBean = BeanFactory::getBean('Cases');
      $customerIssueBeanList = $customerIssueBean->get_full_list('', 'cases.id IS NOT NULL', false, 0);

      // Generate site-related CAPA Workgroup for issues that are not Draft or New
      foreach($customerIssueBeanList as $customerIssueBean) {
        $sortedList = array_filter($app_list_strings['capa_roles_list'], function($key) use ($customerIssueBean, $log) {
          if ($customerIssueBean->status == 'Draft') {
              return in_array($key, ['SalesPerson', 'SalesManager', 'Creator']); // Ontrack 1971: 'MarketDevelopmentManager' and 'StrategicAccountManager' removed
          } elseif ($customerIssueBean->status == 'Approved') { 
              return $key != ''; // create other capa working groups including site-related roles
          } elseif(! in_array($customerIssueBean->status, ['Cancelled', 'CreatedInError', 'Rejected', 'New'])) {
              return $key != ''; // should not create or update any of the workgroups
          } else {
              return $key  == '';
          }
        }, ARRAY_FILTER_USE_KEY);

        if (($customerIssueBean->status != 'Draft' && $customerIssueBean->status != 'New' && $customerIssueBean->status != '' && isset($customerIssueBean->status)) && (isset($customerIssueBean->site_c) && $customerIssueBean->site_c != '')) {
          foreach ($sortedList as $key => $value) {
            if ($value != '') {
              CapaWorkingGroupHelper::createOrUpdateCapaRole($customerIssueBean, $key);
            }
          }
        }
      }

      return true;
    }

    public function setJob(SchedulersJob $job)
    {
      $this->job = $job;
    }
  }