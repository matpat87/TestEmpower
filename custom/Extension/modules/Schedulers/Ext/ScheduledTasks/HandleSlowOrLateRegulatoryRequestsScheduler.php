<?php 
    handleVerifyBeforeRequire('custom/modules/RRQ_RegulatoryRequests/ManageTimelyNotif.php');

    $job_strings[] = 'handleSlowOrLateRegulatoryRequestsScheduler';

  function handleSlowOrLateRegulatoryRequestsScheduler() {
    global $db;
    
    $GLOBALS['log']->fatal("Handle Slow or Late Regulatory Requests Scheduler - START");

    // Get all Regulatory Requests where status is [awaiting_more_info, new, assigned, in_process]
    // Loop thru the list:
    // Get audit data where field = status_c ang new value is [awaiting_more_info, new, assigned, in_process]
    // Compare audit date and current date
    // if status = awaiting_more_info and date diff > 30: send mail
    // if status = [new, assigned, in_process] and date diff >= 8days: send mail
    $db = DBManagerFactory::getInstance();
    $regulatoryRequestsQuery = $db->query("
        SELECT 
            rrq_regulatoryrequests.id AS regulatory_request_id,
            rrq_regulatoryrequests_cstm.status_c AS regulatory_request_status
        FROM
            rrq_regulatoryrequests
                LEFT JOIN
            rrq_regulatoryrequests_cstm ON rrq_regulatoryrequests_cstm.id_c = rrq_regulatoryrequests.id
        WHERE
            rrq_regulatoryrequests.deleted = 0
                AND rrq_regulatoryrequests_cstm.status_c IN ('awaiting_more_info' , 'new', 'in_process', 'assigned')
    ");
    
    while ($row = $db->fetchByAssoc($regulatoryRequestsQuery)) {
       
        $auditDb = DBManagerFactory::getInstance();
        // get $row audit changes
        $auditDataQuery = $auditDb->query("
                SELECT 
                    *
                FROM
                    rrq_regulatoryrequests_audit
                WHERE
                    parent_id = '{$row['regulatory_request_id']}'
                        AND field_name = 'status_c'
                        AND after_value_string = '{$row['regulatory_request_status']}'
                ORDER BY date_created DESC
                LIMIT 1
        ");

        $auditRow = $auditDb->fetchRow($auditDataQuery);
       
        // Get Date diff: Current date and Audit Date
        $currentDate = Carbon::now();
        $auditDate = Carbon::parse($auditRow['date_created']);
        $dateDiffInDays = $auditDate->diffInDays($currentDate);
       
        if (in_array($row['regulatory_request_status'], ['awaiting_more_info', 'waiting_on_supplier']) && $dateDiffInDays > 30) {
            $manageTimelyNotif = new ManageTimelyNotif($row['regulatory_request_id'], $dateDiffInDays);
            $manageTimelyNotif->process();
            
        }

        if (in_array($row['regulatory_request_status'], ['new', 'in_process', 'assigned']) && $dateDiffInDays >= 8) {
            $manageTimelyNotif = new ManageTimelyNotif($row['regulatory_request_id'], $dateDiffInDays);
            $manageTimelyNotif->process();
        }
    
    } // end of while loop

    $GLOBALS['log']->fatal("Handle Slow or Late Regulatory Requests Scheduler - END");
    
    return true;
    
}