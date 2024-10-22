<?php  
  $job_strings[] = 'updateAccountLastActivityDateScheduler';

  //OnTrack #1494 - sync Outlook integration email
  function get_contact_emails_by_acc_id($account_id){
    $db = DBManagerFactory::getInstance();
    $result = array();

    if(!empty($account_id)){
      $sql = " SELECT DISTINCT eb.email_id,
                    em.name,
                    em.date_entered
              FROM   emails_beans eb
              INNER JOIN accounts_contacts ac
                ON ac.account_id = '{$account_id}'
                  AND ac.deleted = 0
              INNER JOIN contacts c
                ON c.id = ac.contact_id
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

  function updateAccountLastActivityDateScheduler() {
    global $db;
    
    $GLOBALS['log']->fatal("Account Last Activity Date Update Scheduler - START");

    $db = DBManagerFactory::getInstance();

    $accountSQL = "SELECT * 
                    FROM accounts
                  LEFT JOIN accounts_cstm
                    ON accounts.id = accounts_cstm.id_c
                  WHERE accounts.deleted = 0";

    $accountResult = $db->query($accountSQL);

    $activityModules = ['calls', 'tasks', 'meetings', 'emails'];
    $relatedModules = ['contacts', 'opportunities', 'cases', 'tr_technicalrequests']; //OnTrack #1281
    $moduleTrigger = '';

    while ($accountRow = $db->fetchByAssoc($accountResult) ) {

      $lastActivityDate = $accountRow['last_activity_date_c'];
      
      $last_contact_email = get_contact_emails_by_acc_id($accountRow['id']);  //OnTrack #1494 - sync Outlook integration email

      if(!empty($last_contact_email) && (date($lastActivityDate) < date($last_contact_email['date_entered']) ) ){
        $lastActivityDate = $last_contact_email['date_entered'];
        $lastActivityID = $last_contact_email['email_id'];
        $lastActivityType = 'Emails';
      }

      foreach ($activityModules as $activityKey => $activityValue) {

        $activitySQL = "SELECT * 
                        FROM {$activityValue}
                        WHERE deleted = 0 
                        AND parent_id = '{$accountRow['id']}'";

        $activityResult = $db->query($activitySQL);
        
        while ($activityRow = $db->fetchByAssoc($activityResult)) {

          if (! $lastActivityDate || $activityRow['date_entered'] > $lastActivityDate) {
            $moduleTrigger = "accounts - {$activityValue}";
            $lastActivityID = $activityRow['id'];
            $lastActivityDate = $activityRow['date_entered'];
            $lastActivityType = ucwords($activityValue);
          }

          if (($activityValue == 'calls' || $activityValue == 'meetings') && $activityRow['date_modified'] > $lastActivityDate) {
            $moduleTrigger = "accounts - {$activityValue}";
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
          case 'cases':
            $singularLabel = 'case';
            break;
          case 'opportunities':
            $singularLabel = 'opportunity';
            break;
          default:
            break;
        }
        
        //OnTrack #1281 - added TR activities
        if($relatedValue == 'tr_technicalrequests'){
            $relatedSQL = "SELECT tt.*
                            FROM tr_technicalrequests tt
                            INNER JOIN tr_technicalrequests_accounts_c ttac
                                ON ttac.tr_technicalrequests_accountstr_technicalrequests_idb = tt.id
                            WHERE ttac.tr_technicalrequests_accountsaccounts_ida = '{$accountRow['id']}'";
        }
        else if($relatedValue == 'cases'){
            $relatedSQL = "select c.*
                            from cases c
                            inner join accounts a
                                ON a.id = c.account_id
                                    and a.deleted = 0
                            WHERE c.deleted = 0
                                and a.id = '{$accountRow['id']}' ";
        }
        else if ($relatedValue !== 'cases') {
          $relatedSQL = "SELECT {$relatedValue}.* 
                          FROM {$relatedValue} 
                        LEFT JOIN accounts_{$relatedValue}
                          ON {$relatedValue}.id = accounts_{$relatedValue}.{$singularLabel}_id
                        WHERE {$relatedValue}.deleted = 0
                          AND accounts_{$relatedValue}.account_id = '{$accountRow['id']}'";
        } else {
          $relatedSQL = "SELECT {$relatedValue}.*
                          FROM {$relatedValue}
                        WHERE {$relatedValue}.deleted = 0
                          AND {$relatedValue}.account_id = '{$accountRow['id']}'";
        }

        $relatedResult = $db->query($relatedSQL);

        while ($relatedRow = $db->fetchByAssoc($relatedResult)) {

          if (! $lastActivityDate || $relatedRow['date_entered'] > $lastActivityDate) {
            $moduleTrigger = "accounts - {$relatedValue}";
            $lastActivityID = $relatedRow['id'];
            $lastActivityDate = $relatedRow['date_entered'];

            if ($relatedValue == 'cases') {
              $lastActivityType = 'Customer Issues';
            } else if ($relatedValue == 'tr_technicalrequests') {
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
                $moduleTrigger = "accounts - {$relatedValue} - {$activityValue}";
                $lastActivityID = $activityRow['id'];
                $lastActivityDate = $activityRow['date_entered'];
                $lastActivityType = ucwords($activityValue);
              }

              if (($activityValue == 'calls' || $activityValue == 'meetings') && $activityRow['date_modified'] > $lastActivityDate) {
                $moduleTrigger = "accounts - {$relatedValue} - {$activityValue}";
                $lastActivityID = $activityRow['id'];
                $lastActivityDate = $activityRow['date_modified'];
                $lastActivityType = ucwords($activityValue);
              }
            }

          }

        }

      }
      
      if ($lastActivityDate && $accountRow['last_activity_date_c'] != $lastActivityDate) {
        $updateAccountSQL = "UPDATE accounts 
                            LEFT JOIN accounts_cstm 
                              ON accounts.id = accounts_cstm.id_c 
                            SET 
                              accounts_cstm.last_activity_id_c = '{$lastActivityID}',
                              accounts_cstm.last_activity_date_c = '{$lastActivityDate}',
                              accounts_cstm.last_activity_type_c = '{$lastActivityType}'
                            WHERE accounts.id = '{$accountRow['id']}'";

        $db->query($updateAccountSQL);

        $GLOBALS['log']->fatal("Account: [{$accountRow['id']}] {$accountRow['name']}");
        $GLOBALS['log']->fatal("Module Trigger: {$moduleTrigger}");
        $GLOBALS['log']->fatal("Old Activity ID: {$accountRow['last_activity_id_c']}");
        $GLOBALS['log']->fatal("Old Activity Date: {$accountRow['last_activity_date_c']}");
        $GLOBALS['log']->fatal("Old Activity Type: {$accountRow['last_activity_type_c']}");
        $GLOBALS['log']->fatal("New Activity ID: {$lastActivityID}");
        $GLOBALS['log']->fatal("New Activity Date: {$lastActivityDate}");
        $GLOBALS['log']->fatal("New Activity Type: {$lastActivityType}");
      }

    }
    $GLOBALS['log']->fatal("Account Last Activity Date Update Scheduler - END");
    
    return true;
    
  }