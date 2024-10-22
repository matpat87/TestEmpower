<?php
  $job_strings[] = 'updateCustomerIssuesAssignmentAndWorkgroupScheduler';

  function updateCustomerIssuesAssignmentAndWorkgroupScheduler()
  {
    global $db, $log;

    $db = DBManagerFactory::getInstance();
    
    $sql = "SELECT accounts.id AS account_id, cases.id AS customer_issue_id, cwg_capaworkinggroup.id AS capa_workgroup_id,
                cases.assigned_user_id AS customer_issue_assigned_user_id, accounts.assigned_user_id AS accounts_assigned_user_id 
            FROM cases
            LEFT JOIN cases_cwg_capaworkinggroup_1_c
                ON cases.id = cases_cwg_capaworkinggroup_1_c.cases_cwg_capaworkinggroup_1cases_ida
                AND cases_cwg_capaworkinggroup_1_c.deleted = 0
            LEFT JOIN cwg_capaworkinggroup
                ON cwg_capaworkinggroup.id = cases_cwg_capaworkinggroup_1_c.cases_cwg_capaworkinggroup_1cwg_capaworkinggroup_idb
                AND cwg_capaworkinggroup.deleted = 0
                AND cwg_capaworkinggroup.capa_roles = 'SalesPerson'
            LEFT JOIN accounts
                ON accounts.id = cases.account_id
                AND accounts.deleted = 0
            WHERE cases.deleted = 0
                AND cases.assigned_user_id = cwg_capaworkinggroup.parent_id
                AND cases.status != 'Closed'
                AND cases.assigned_user_id <> accounts.assigned_user_id";
    $result = $db->query($sql);
    
    $log->fatal("Update Customer Issues Assignment And Workgroup Scheduler - START");

    while($row = $db->fetchByAssoc($result) ) {
      $customerIssueBean = BeanFactory::getBean('Cases', $row['customer_issue_id']);
      $accountBean = BeanFactory::getBean('Accounts', $row['account_id']);
      $capaSalesRepWorkGroupBean = BeanFactory::getBean('CWG_CAPAWorkingGroup', $row['capa_workgroup_id']);
      $salesRepBean = BeanFactory::getBean('Users', $accountBean->assigned_user_id);
      $reportsToBean = BeanFactory::getBean('Users', $salesRepBean->reports_to_id);

      if (! $customerIssueBean->id || ! $accountBean->id) {
        continue;
      }

      $log->fatal("Customer Issue Record ID: {$customerIssueBean->id}");
      $log->fatal("Account Record ID: {$accountBean->id}");

      if ($capaSalesRepWorkGroupBean && $capaSalesRepWorkGroupBean->id) {
        $log->fatal("New CAPA Workgroup Sales Rep ID: {$salesRepBean->id}");

        $capaSalesRepWorkGroupBean->parent_id = $salesRepBean->id;
        $capaSalesRepWorkGroupBean->parent_type = 'Users';
        $capaSalesRepWorkGroupBean->save();

        $updateQuery = "UPDATE cases SET assigned_user_id = '{$salesRepBean->id}' WHERE id = '{$customerIssueBean->id}'";
        $db->query($updateQuery);
      }
      
      $capaSalesManagerWorkGroupBeanList = $customerIssueBean->get_linked_beans(
        'cases_cwg_capaworkinggroup_1',
        'CWG_CAPAWorkingGroup',
        'cwg_capaworkinggroup.date_entered DESC',
        0,
        -1,
        0,
        "cwg_capaworkinggroup.capa_roles = 'SalesManager' AND parent_type = 'Users'"
      );
      
      $capaSalesManagerWorkGroupBean = (isset($capaSalesManagerWorkGroupBeanList) && count($capaSalesManagerWorkGroupBeanList) > 0)
        ? $capaSalesManagerWorkGroupBeanList[0]
        : BeanFactory::newBean('CWG_CAPAWorkingGroup');

      if ($capaSalesManagerWorkGroupBean && $capaSalesManagerWorkGroupBean->id) {
        $log->fatal("New CAPA Workgroup Sales Manager ID: {$capaSalesManagerWorkGroupBean->id}");

        $capaSalesManagerWorkGroupBean->parent_id = $reportsToBean->id;
        $capaSalesManagerWorkGroupBean->parent_type = 'Users';
        $capaSalesManagerWorkGroupBean->save();
      }
    }

    $log->fatal("Update Customer Issues Assignment And Workgroup Scheduler - END");

    return true;
  }