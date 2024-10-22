<?php
  $job_strings[] = 'updateERPClosedTechnicalRequestsScheduler';

  function updateERPClosedTechnicalRequestsScheduler()
  {
    global $db, $app_list_strings;
    $GLOBALS['log']->fatal("Update ERP Closed Technical Requests Scheduler - START");

    $db = DBManagerFactory::getInstance();

    $integrationUserBean = BeanFactory::getBean('Users')->retrieve_by_string_fields(
      array(
          "user_name" => 'INTEGRATION',
      ), false, true
    );

    $query = "  SELECT  tr_technicalrequests.id, tr_technicalrequests.status, 
                        tr_technicalrequests.approval_stage, tr_technicalrequests_audit.before_value_string
                FROM tr_technicalrequests
                LEFT JOIN tr_technicalrequests_cstm
                  ON tr_technicalrequests.id = tr_technicalrequests_cstm.id_c
                LEFT JOIN tr_technicalrequests_audit
                  ON tr_technicalrequests.id = tr_technicalrequests_audit.parent_id
                WHERE tr_technicalrequests.deleted = 0
                  AND tr_technicalrequests_audit.created_by = '{$integrationUserBean->id}'
                  AND tr_technicalrequests_audit.field_name = 'approval_stage'
                  AND (
                    tr_technicalrequests_audit.before_value_string = 'award_eminent' OR tr_technicalrequests_audit.before_value_string = 'closed_lost'
                  )
                  AND tr_technicalrequests_audit.after_value_string = 'closed_won'
                  AND tr_technicalrequests.approval_stage = tr_technicalrequests_audit.after_value_string
                  AND tr_technicalrequests.status = 'order_received'
                  AND tr_technicalrequests_cstm.erp_closed_record_c = '1'
                GROUP BY tr_technicalrequests.id
           ";

    $result = $db->query($query);

    while ($row = $db->fetchByAssoc($result)) {
      $trBean = BeanFactory::getBean('TR_TechnicalRequests', $row['id']);

      if ($trBean && $trBean->id) {
        $_REQUEST['action'] = 'Save'; // Need to change to Save to fit overall business logic requirements

        // No longer needed as INTEGRATION inserts audit log so we only need to just set erp_closed_record_c = 0 and run bean save to trigger workflow logic (Ex. update probability values)
        // Force assign fetched_row values to trick system into initiating changed approval stage values
        // $trBean->fetched_row['approval_stage'] = $row['before_value_string'];

        // If Previous Stage is not Closed - Lost, set Previous Status to Awaiting Award else set to Inactive
        // $trBean->fetched_row['status'] = ($row['before_value_string'] !== 'closed_lost') 
        //   ? 'awaiting_award'
        //   : 'inactive';
        
        // $trBean->approval_stage = $row['approval_stage']; 
        // $trBean->status = $row['status'];
        $trBean->erp_closed_record_c = 0;
        $trBean->save();

        $GLOBALS['log']->fatal("TR Record ID: {$trBean->id}");
        $GLOBALS['log']->fatal("TR #: {$trBean->technicalrequests_number_c}");
        $GLOBALS['log']->fatal("TR Prev Sales Stage: {$app_list_strings['approval_stage_list'][$trBean->fetched_row['approval_stage']]}");
        $GLOBALS['log']->fatal("TR Prev Status: {$app_list_strings['approval_stage_list'][$trBean->fetched_row['status']]}");
        $GLOBALS['log']->fatal("TR New Sales Stage: {$app_list_strings['approval_stage_list'][$trBean->approval_stage]}");
        $GLOBALS['log']->fatal("TR New Status: {$app_list_strings['approval_stage_list'][$trBean->status]}");
        $GLOBALS['log']->fatal("TR ERP Closed Record: {$trBean->erp_closed_record_c}");
      }
    }

    $GLOBALS['log']->fatal("Update ERP Closed Technical Requests Scheduler - END");
    return true;
  }