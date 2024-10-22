<?php
  $job_strings[] = 'updateTRAssignmentAndWorkgroupScheduler';

  function updateTRAssignmentAndWorkgroupScheduler()
  {
    global $db, $log;

    $db = DBManagerFactory::getInstance();
    
    $sql = "SELECT accounts.id AS account_id, tr_technicalrequests.id AS tr_id, trwg_trworkinggroup.id AS tr_workgroup_id,
              tr_technicalrequests.assigned_user_id AS tr_assigned_user_id, accounts.assigned_user_id AS accounts_assigned_user_id 
            FROM tr_technicalrequests
            LEFT JOIN tr_technicalrequests_trwg_trworkinggroup_1_c
              ON tr_technicalrequests.id = tr_technicalrequests_trwg_trworkinggroup_1_c.tr_technic9742equests_ida
              AND tr_technicalrequests_trwg_trworkinggroup_1_c.deleted = 0
            LEFT JOIN trwg_trworkinggroup
              ON trwg_trworkinggroup.id = tr_technicalrequests_trwg_trworkinggroup_1_c.tr_technic7dfcnggroup_idb
              AND trwg_trworkinggroup.deleted = 0
              AND trwg_trworkinggroup.tr_roles = 'SalesPerson'
            LEFT JOIN tr_technicalrequests_accounts_c
              ON tr_technicalrequests.id = tr_technicalrequests_accounts_c.tr_technicalrequests_accountstr_technicalrequests_idb
              AND tr_technicalrequests_accounts_c.deleted = 0
            LEFT JOIN accounts
              ON accounts.id = tr_technicalrequests_accounts_c.tr_technicalrequests_accountsaccounts_ida
              AND accounts.deleted = 0
            WHERE tr_technicalrequests.deleted = 0
              AND tr_technicalrequests.assigned_user_id = trwg_trworkinggroup.parent_id
              AND tr_technicalrequests.approval_stage NOT IN ('closed', 'closed_won', 'closed_lost', 'closed_rejected')
              AND tr_technicalrequests.assigned_user_id <> accounts.assigned_user_id";
    $result = $db->query($sql);
    
    $log->fatal("Update TR Assignment And Workgroup Scheduler - START");

    while($row = $db->fetchByAssoc($result) ) {
      $trBean = BeanFactory::getBean('TR_TechnicalRequests', $row['tr_id']);
      $accountBean = BeanFactory::getBean('Accounts', $row['account_id']);
      $trSalesRepWorkGroupBean = BeanFactory::getBean('TRWG_TRWorkingGroup', $row['tr_workgroup_id']);
      $salesRepBean = BeanFactory::getBean('Users', $accountBean->assigned_user_id);
      $reportsToBean = BeanFactory::getBean('Users', $salesRepBean->reports_to_id);

      if (! $trBean->id || ! $accountBean->id) {
        continue;
      }

      $_REQUEST['skip_hook'] = true; // Used to fix issue where it double saves or causes white screen error on SAM/MDM change on Account before save hook

      $log->fatal("TR Record ID: {$trBean->id}");
      $log->fatal("Account Record ID: {$accountBean->id}");

      if ($trSalesRepWorkGroupBean && $trSalesRepWorkGroupBean->id) {
        $log->fatal("New TR Workgroup Sales Rep ID: {$salesRepBean->id}");

        $trSalesRepWorkGroupBean->parent_id = $salesRepBean->id;
        $trSalesRepWorkGroupBean->parent_type = 'Users';
        $trSalesRepWorkGroupBean->save();

        $updateQuery = "UPDATE tr_technicalrequests SET assigned_user_id = '{$salesRepBean->id}' WHERE id = '{$trBean->id}'";
        $db->query($updateQuery);
      }
      
      $trSalesManagerWorkGroupBeanList = $trBean->get_linked_beans(
        'tr_technicalrequests_trwg_trworkinggroup_1',
        'TRWG_TRWorkingGroup',
        'trwg_trworkinggroup.date_entered DESC',
        0,
        -1,
        0,
        "trwg_trworkinggroup.tr_roles = 'SalesManager' AND parent_type = 'Users'"
      );
      
      $trSalesManagerWorkGroupBean = (isset($trSalesManagerWorkGroupBeanList) && count($trSalesManagerWorkGroupBeanList) > 0)
        ? $trSalesManagerWorkGroupBeanList[0]
        : BeanFactory::newBean('TRWG_TRWorkingGroup');

      if ($trSalesManagerWorkGroupBean && $trSalesManagerWorkGroupBean->id) {
        $log->fatal("New TR Workgroup Sales Manager ID: {$trSalesManagerWorkGroupBean->id}");

        $trSalesManagerWorkGroupBean->parent_id = $reportsToBean->id;
        $trSalesManagerWorkGroupBean->parent_type = 'Users';
        $trSalesManagerWorkGroupBean->save();
      }
    }

    $log->fatal("Update TR Assignment And Workgroup Scheduler - END");

    return true;
  }