<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=TR_TechnicalRequests&action=PopulateDevelopmentCompleteDates
populateDevelopmentCompleteDates();

function populateDevelopmentCompleteDates()
{
  global $db, $timedate, $current_user;

  $db = DBManagerFactory::getInstance();
  $sql = "SELECT tr_technicalrequests.id FROM tr_technicalrequests WHERE tr_technicalrequests.deleted = 0 ORDER BY tr_technicalrequests.name ASC";
  $result = $db->query($sql);

  while($row = $db->fetchByAssoc($result) ) {
    $trBean = BeanFactory::getBean('TR_TechnicalRequests', $row['id']);

    if ($trBean && $trBean->id) {
        $auditSql = "SELECT date_created FROM tr_technicalrequests_audit WHERE parent_id = '{$row['id']}' AND before_value_string = 'development' AND after_value_string IN ('closed', 'quoting_or_proposing', 'sampling') ORDER BY date_created DESC";
        $auditDateCreated = $db->getOne($auditSql);

        if ($auditDateCreated) {
            $newId = create_guid();
            $timeDateNow = $timedate->getNow()->asDb();
            $formattedAuditDateCreated = date_format(date_create($auditDateCreated), 'Y-m-d');

            if ($trBean->development_completed_date_c !== $formattedAuditDateCreated) {
                $updateQuery = "
                    UPDATE tr_technicalrequests 
                    LEFT JOIN tr_technicalrequests_cstm 
                        ON tr_technicalrequests.id = tr_technicalrequests_cstm.id_c 
                    SET tr_technicalrequests_cstm.development_completed_date_c = '{$formattedAuditDateCreated}' 
                    WHERE tr_technicalrequests.id = '{$trBean->id}'
                ";

                $db->query($updateQuery);

                $insertAuditQuery = "
                    INSERT INTO tr_technicalrequests_audit (
                        `id`,
                        `parent_id`,
                        `date_created`,
                        `created_by`,
                        `field_name`,
                        `data_type`,
                        `before_value_string`,
                        `after_value_string`
                    )
                        
                    VALUES (
                        '{$newId}',
                        '{$trBean->id}',
                        '{$timeDateNow}',
                        '{$current_user->id}',
                        'development_completed_date_c',
                        'date',
                        '{$trBean->development_completed_date_c}',
                        '{$formattedAuditDateCreated}' 
                    );
                ";

                $db->query($insertAuditQuery);

                echo '<pre>';
                    print_r($updateQuery);
                    echo '<br>';
                    print_r($insertAuditQuery);
                echo '</pre>';
            }
        }
    }
  }
}