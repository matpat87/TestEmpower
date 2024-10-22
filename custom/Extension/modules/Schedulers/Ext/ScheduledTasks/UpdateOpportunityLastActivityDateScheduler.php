<?php
    $job_strings[] = 'updateOpportunityLastActivityDateScheduler';

    //OnTrack #1494 - sync Outlook integration email
    function retrieveContactEmailByOpportunityId($opportunityId){
        global $db;

        $result = array();

        if(!empty($opportunityId)){
            $sql = " SELECT DISTINCT eb.email_id,
                        em.name,
                        em.date_entered
                    FROM   emails_beans eb
                    INNER JOIN opportunities_contacts oc
                        ON oc.opportunity_id = '{$opportunityId}'
                        AND oc.deleted = 0
                    INNER JOIN contacts c
                        ON c.id = oc.contact_id
                        AND c.deleted = 0
                        AND c.id = eb.bean_id
                    INNER JOIN emails em
                        ON em.id = eb.email_id
                        AND em.deleted = 0
                    WHERE  eb.bean_module = 'Contacts'
                        AND eb.deleted = 0
                    ORDER BY em.date_entered DESC
                    LIMIT 1";

            $result_db = $db->query($sql);

            $row = $db->fetchByAssoc($result_db);
            if(!empty($row)){
                $result = $row;
            }
        }

        return $result;
    }
    
    function updateOpportunityLastActivityDateScheduler(){
        global $db, $log;
    
        $log->fatal("Opportunity Last Activity Date Update Scheduler - START");
    
        $sql = "SELECT * 
                    FROM opportunities
                LEFT JOIN opportunities_cstm
                    ON opportunities.id = opportunities_cstm.id_c
                WHERE opportunities.deleted = 0";
    
        $result = $db->query($sql);
    
        $activityModules = ['calls', 'tasks', 'meetings', 'emails'];
        $relatedModules = ['contacts', 'tr_technicalrequests'];
        $moduleTrigger = '';
    
        while ($row = $db->fetchByAssoc($result) ) {
    
          $lastActivityDate = $row['last_activity_date_c'];
          
          $last_contact_email = retrieveContactEmailByOpportunityId($row['id']);  //OnTrack #1494 - sync Outlook integration email
    
          if(!empty($last_contact_email) && (date($lastActivityDate) < date($last_contact_email['date_entered']) ) ){
            $lastActivityDate = $last_contact_email['date_entered'];
            $lastActivityID = $last_contact_email['email_id'];
            $lastActivityType = 'Emails';
          }
    
          foreach ($activityModules as $activityKey => $activityValue) {
    
            $activitySQL = "SELECT * 
                            FROM {$activityValue}
                            WHERE deleted = 0 
                            AND parent_id = '{$row['id']}'";
    
            $activityResult = $db->query($activitySQL);
            
            while ($activityRow = $db->fetchByAssoc($activityResult)) {
    
              if (! $lastActivityDate || $activityRow['date_entered'] > $lastActivityDate) {
                $moduleTrigger = "opportunities - {$activityValue}";
                $lastActivityID = $activityRow['id'];
                $lastActivityDate = $activityRow['date_entered'];
                $lastActivityType = ucwords($activityValue);
              }
    
              if (($activityValue == 'calls' || $activityValue == 'meetings') && $activityRow['date_modified'] > $lastActivityDate) {
                $moduleTrigger = "opportunities - {$activityValue}";
                $lastActivityID = $activityRow['id'];
                $lastActivityDate = $activityRow['date_modified'];
                $lastActivityType = ucwords($activityValue);
              }
            }
          }
    
          foreach ($relatedModules as $relatedKey => $relatedValue) {
    
            switch ($relatedValue) {
              case 'contacts':
                $singularLabel = 'contact';
                break;
              default:
                break;
            }
            
            switch ($relatedValue) {
                case 'tr_technicalrequests':
                    $relatedSQL = "SELECT  tr_technicalrequests.* 
                    FROM tr_technicalrequests
                    INNER JOIN tr_technicalrequests_opportunities_c 
                        ON tr_technicalrequests.id = tr_technicalrequests_opportunities_c.tr_technicalrequests_opportunitiestr_technicalrequests_idb
                    WHERE tr_technicalrequests_opportunities_c.tr_technicalrequests_opportunitiesopportunities_ida = '{$row['id']}'";
                    break;
                default:
                    $relatedSQL = "SELECT {$relatedValue}.* 
                    FROM {$relatedValue} 
                    LEFT JOIN opportunities_{$relatedValue}
                        ON {$relatedValue}.id = opportunities_{$relatedValue}.{$singularLabel}_id
                    WHERE {$relatedValue}.deleted = 0
                        AND opportunities_{$relatedValue}.opportunity_id = '{$row['id']}'";
                    break;
            }
    
            $relatedResult = $db->query($relatedSQL);
    
            while ($relatedRow = $db->fetchByAssoc($relatedResult)) {
    
              if (! $lastActivityDate || $relatedRow['date_entered'] > $lastActivityDate) {
                $moduleTrigger = "opportunities - {$relatedValue}";
                $lastActivityID = $relatedRow['id'];
                $lastActivityDate = $relatedRow['date_entered'];

                if ($relatedValue == 'tr_technicalrequests') {
                    $lastActivityType = 'Technical Requests';
                } else {
                    $lastActivityType = ucwords($relatedValue);
                }
              }
    
              foreach ($activityModules as $activityKey => $activityValue) {
    
                $activitySQL = "SELECT * FROM {$activityValue} WHERE deleted = 0 AND parent_id = '{$relatedRow['id']}'";
    
                $activityResult = $db->query($activitySQL);
          
                while ($activityRow = $db->fetchByAssoc($activityResult)) {
    
                  if (! $lastActivityDate || $activityRow['date_entered'] > $lastActivityDate) {
                    $moduleTrigger = "opportunities - {$relatedValue} - {$activityValue}";
                    $lastActivityID = $activityRow['id'];
                    $lastActivityDate = $activityRow['date_entered'];
                    $lastActivityType = ucwords($activityValue);
                  }
    
                  if (($activityValue == 'calls' || $activityValue == 'meetings') && $activityRow['date_modified'] > $lastActivityDate) {
                    $moduleTrigger = "opportunities - {$relatedValue} - {$activityValue}";
                    $lastActivityID = $activityRow['id'];
                    $lastActivityDate = $activityRow['date_modified'];
                    $lastActivityType = ucwords($activityValue);
                  }
                }
    
              }
    
            }
    
          }
          
          if ($lastActivityDate && $row['last_activity_date_c'] != $lastActivityDate) {
            $updateSQL = "UPDATE opportunities 
                                LEFT JOIN opportunities_cstm 
                                  ON opportunities.id = opportunities_cstm.id_c 
                                SET 
                                  opportunities_cstm.last_activity_id_c = '{$lastActivityID}',
                                  opportunities_cstm.last_activity_date_c = '{$lastActivityDate}',
                                  opportunities_cstm.last_activity_type_c = '{$lastActivityType}'
                                WHERE opportunities.id = '{$row['id']}'";
    
            $db->query($updateSQL);
    
            $log->fatal("Opportunity: [{$row['id']}] {$row['name']}");
            $log->fatal("Module Trigger: {$moduleTrigger}");
            $log->fatal("Old Activity ID: {$row['last_activity_id_c']}");
            $log->fatal("Old Activity Date: {$row['last_activity_date_c']}");
            $log->fatal("Old Activity Type: {$row['last_activity_type_c']}");
            $log->fatal("New Activity ID: {$lastActivityID}");
            $log->fatal("New Activity Date: {$lastActivityDate}");
            $log->fatal("New Activity Type: {$lastActivityType}");
          }
    
        }
        $log->fatal("Opportunity Last Activity Date Update Scheduler - END");
        
        return true;
    }
?>