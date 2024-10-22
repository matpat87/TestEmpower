<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('custom/include/Carbon/src/Carbon/Carbon.php');
use Carbon\Carbon;

// Call function in browser: <url>/index.php?module=TR_TechnicalRequests&action=PopulateActualCloseDates
populateActualCloseDates();

function populateActualCloseDates()
{
  global $db;

  $db = DBManagerFactory::getInstance();
  $sql = "SELECT tr_technicalrequests.id 
          FROM tr_technicalrequests
          LEFT JOIN tr_technicalrequests_cstm 
              ON tr_technicalrequests.id = tr_technicalrequests_cstm.id_c
          WHERE tr_technicalrequests.deleted = 0 AND tr_technicalrequests.approval_stage IN ('closed', 'closed_lost', 'closed_rejected')
                AND tr_technicalrequests_cstm.actual_close_date_c IS NULL OR tr_technicalrequests_cstm.actual_close_date_c = ''";
  $result = $db->query($sql);

  while($row = $db->fetchByAssoc($result) ) {
    $trBean = BeanFactory::getBean('TR_TechnicalRequests', $row['id']);

    if ($trBean && $trBean->id) {
        $auditSql = "SELECT tr_technicalrequests_audit.date_created FROM tr_technicalrequests_audit WHERE tr_technicalrequests_audit.parent_id = '{$row['id']}' AND tr_technicalrequests_audit.after_value_string IN ('closed', 'closed_lost', 'closed_rejected') ORDER BY tr_technicalrequests_audit.date_created DESC LIMIT 1";

        $auditDateCreated = $db->getOne($auditSql);

        // If audit exists, fetch date modified and date completed and set value based on earliest of the two
        // Actual Close Date should not be earlier than Dev Completed Date
        if (! $auditDateCreated) {
            $dateModified = Carbon::parse($trBean->date_modified);
            $dateCompleted = Carbon::parse($trBean->development_completed_date_c);
            $auditDateCreated = $dateModified->min($dateCompleted);
        }

        if ($auditDateCreated) {
            $formattedAuditDateCreated = date_format(date_create($auditDateCreated), 'Y-m-d');

            if ($trBean->development_completed_date_c !== $formattedAuditDateCreated) {
                $updateQuery = "
                    UPDATE tr_technicalrequests 
                    LEFT JOIN tr_technicalrequests_cstm 
                        ON tr_technicalrequests.id = tr_technicalrequests_cstm.id_c 
                    SET tr_technicalrequests_cstm.actual_close_date_c = '{$formattedAuditDateCreated}' 
                    WHERE tr_technicalrequests.id = '{$trBean->id}'
                ";

                $db->query($updateQuery);

                echo '<pre>';
                    print_r($updateQuery);
                echo '</pre>';
            }
        }
    }
  }
}