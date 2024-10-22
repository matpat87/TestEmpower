<?php
  $job_strings[] = 'updateRRAssignmentAndWorkgroupScheduler';

  function updateRRAssignmentAndWorkgroupScheduler()
  {
    global $db, $log;

    $db = DBManagerFactory::getInstance();
    
    $sql = "SELECT accounts.id AS account_id, rrq_regulatoryrequests.id AS rr_id, rrwg_rrworkinggroup.id AS rr_workgroup_id,
              rrq_regulatoryrequests.assigned_user_id AS rr_assigned_user_id, accounts.assigned_user_id AS accounts_assigned_user_id 
            FROM rrq_regulatoryrequests
            LEFT JOIN rrq_regulatoryrequests_cstm
              ON rrq_regulatoryrequests.id = rrq_regulatoryrequests_cstm.id_c
            LEFT JOIN rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c
              ON rrq_regulatoryrequests.id = rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c.rrq_regula2443equests_ida
              AND rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c.deleted = 0
            LEFT JOIN rrwg_rrworkinggroup
              ON rrwg_rrworkinggroup.id = rrq_regulatoryrequests_rrwg_rrworkinggroup_1_c.rrq_regulaffdanggroup_idb
              AND rrwg_rrworkinggroup.deleted = 0
              AND rrwg_rrworkinggroup.rr_roles = 'SalesPerson'
            LEFT JOIN accounts_rrq_regulatoryrequests_1_c
              ON rrq_regulatoryrequests.id = accounts_rrq_regulatoryrequests_1_c.accounts_rrq_regulatoryrequests_1rrq_regulatoryrequests_idb
              AND accounts_rrq_regulatoryrequests_1_c.deleted = 0
            LEFT JOIN accounts
              ON accounts.id = accounts_rrq_regulatoryrequests_1_c.accounts_rrq_regulatoryrequests_1accounts_ida
              AND accounts.deleted = 0
            WHERE rrq_regulatoryrequests.deleted = 0
              AND rrq_regulatoryrequests_cstm.status_c NOT IN ('complete', 'rejected', 'created_in_error')
              AND rrwg_rrworkinggroup.parent_id <> accounts.assigned_user_id";
    $result = $db->query($sql);
    
    $log->fatal("Update RR Assignment And Workgroup Scheduler - START");

    while($row = $db->fetchByAssoc($result) ) {
      $rrBean = BeanFactory::getBean('RRQ_RegulatoryRequests', $row['rr_id']);
      $accountBean = BeanFactory::getBean('Accounts', $row['account_id']);
      $rrSalesRepWorkGroupBean = BeanFactory::getBean('RRWG_RRWorkingGroup', $row['rr_workgroup_id']);
      $salesRepBean = BeanFactory::getBean('Users', $accountBean->assigned_user_id);

      if (! $rrBean->id || ! $accountBean->id) {
        continue;
      }

      $_REQUEST['skip_hook'] = true; // Used to fix issue where it double saves or causes white screen error on SAM/MDM change on Account before save hook

      $log->fatal("RR Record ID: {$rrBean->id}");
      $log->fatal("Account Record ID: {$accountBean->id}");

      if ($rrSalesRepWorkGroupBean && $rrSalesRepWorkGroupBean->id) {
        $log->fatal("New RR Workgroup Sales Rep ID: {$salesRepBean->id}");

        $rrSalesRepWorkGroupBean->parent_id = $salesRepBean->id;
        $rrSalesRepWorkGroupBean->parent_type = 'Users';
        $rrSalesRepWorkGroupBean->save();
      }
    }

    $log->fatal("Update RR Assignment And Workgroup Scheduler - END");

    return true;
  }