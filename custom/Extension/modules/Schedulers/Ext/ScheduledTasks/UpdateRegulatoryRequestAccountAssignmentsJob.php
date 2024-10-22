<?php

class UpdateRegulatoryRequestAccountAssignmentsJob implements RunnableSchedulerJob
{
  public function run($arguments)
  {
    global $db, $log;

    $db = DBManagerFactory::getInstance();
    $sql = "SELECT rrq_regulatoryrequests.id FROM rrq_regulatoryrequests WHERE rrq_regulatoryrequests.deleted = 0";
    $result = $db->query($sql);

    $log->fatal("Update Regulatory Request Account Assignments Job - START");

    while ($row = $db->fetchByAssoc($result)) {
      $rrBean = BeanFactory::getBean('RRQ_RegulatoryRequests', $row['id']);
      
      if (! $rrBean->id) continue;

      $accountBean = BeanFactory::getBean('Accounts', $rrBean->accounts_rrq_regulatoryrequests_1accounts_ida);

      if (! $accountBean->id) continue;

      $accountParentBean = BeanFactory::getBean('Accounts', $accountBean->parent_id);

      if (! $accountParentBean->id) continue;
      
      if ($accountBean->id <> $accountParentBean->id) {
        $log->fatal("Regulatory Request ID {$rrBean->id}");
        $log->fatal("Regulatory Request # {$rrBean->id_num_c}");
        $log->fatal("Current Account ID {$accountBean->id}");
        $log->fatal("New Account ID {$accountParentBean->id}");

        // Load Relationship with Accounts Module
        $rrBean->load_relationship('accounts_rrq_regulatoryrequests_1');
        
        // Link New Relationship
        $rrBean->accounts_rrq_regulatoryrequests_1->add($accountParentBean);
        
        // Unlink Previous Relationship
        $rrBean->accounts_rrq_regulatoryrequests_1->delete($rrBean->id, $accountBean);
      }
    }

    $log->fatal("Update Regulatory Request Account Assignments Job - END");

    return true;
  }

  public function setJob(SchedulersJob $job)
  {
    $this->job = $job;
  }
}