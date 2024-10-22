<?php
    $job_strings[] = 'updateTechnicalRequestLastActivityDateScheduler';

    function updateTechnicalRequestLastActivityDateScheduler()
    {
        global $db, $log;
    
        $log->fatal("Technical Request Last Activity Date Update Scheduler - START");
    
        $sql = "SELECT * 
                    FROM tr_technicalrequests
                LEFT JOIN tr_technicalrequests_cstm
                    ON tr_technicalrequests.id = tr_technicalrequests_cstm.id_c
                WHERE tr_technicalrequests.deleted = 0";
    
        $result = $db->query($sql);
    
        $activityModules = ['calls', 'tasks', 'meetings', 'emails'];
        $moduleTrigger = '';
    
        while ($row = $db->fetchByAssoc($result) ) {
    
          $lastActivityDate = $row['last_activity_date_c'];
    
          foreach ($activityModules as $activityKey => $activityValue) {
            $activitySQL = "SELECT * 
                            FROM {$activityValue}
                            WHERE deleted = 0 
                            AND parent_id = '{$row['id']}'";
    
            $activityResult = $db->query($activitySQL);
            
            while ($activityRow = $db->fetchByAssoc($activityResult)) {
    
              if (! $lastActivityDate || $activityRow['date_entered'] > $lastActivityDate) {
                $moduleTrigger = "tr_technicalrequests - {$activityValue}";
                $lastActivityID = $activityRow['id'];
                $lastActivityDate = $activityRow['date_entered'];
                $lastActivityType = ucwords($activityValue);
              }
    
              if (($activityValue == 'calls' || $activityValue == 'meetings') && $activityRow['date_modified'] > $lastActivityDate) {
                $moduleTrigger = "tr_technicalrequests - {$activityValue}";
                $lastActivityID = $activityRow['id'];
                $lastActivityDate = $activityRow['date_modified'];
                $lastActivityType = ucwords($activityValue);
              }
            }
          }
          
          if ($lastActivityDate && $row['last_activity_date_c'] != $lastActivityDate) {
            $updateSQL = "UPDATE tr_technicalrequests 
                                LEFT JOIN tr_technicalrequests_cstm 
                                  ON tr_technicalrequests.id = tr_technicalrequests_cstm.id_c 
                                SET 
                                  tr_technicalrequests_cstm.last_activity_id_c = '{$lastActivityID}',
                                  tr_technicalrequests_cstm.last_activity_date_c = '{$lastActivityDate}',
                                  tr_technicalrequests_cstm.last_activity_type_c = '{$lastActivityType}'
                                WHERE tr_technicalrequests.id = '{$row['id']}'";
    
            $db->query($updateSQL);
    
            $log->fatal("Technical Request: [{$row['id']}] {$row['name']}");
            $log->fatal("Module Trigger: {$moduleTrigger}");
            $log->fatal("Old Activity ID: {$row['last_activity_id_c']}");
            $log->fatal("Old Activity Date: {$row['last_activity_date_c']}");
            $log->fatal("Old Activity Type: {$row['last_activity_type_c']}");
            $log->fatal("New Activity ID: {$lastActivityID}");
            $log->fatal("New Activity Date: {$lastActivityDate}");
            $log->fatal("New Activity Type: {$lastActivityType}");
          }
        }
        $log->fatal("Technical Request Last Activity Date Update Scheduler - END");
        
        return true;
    }
?>