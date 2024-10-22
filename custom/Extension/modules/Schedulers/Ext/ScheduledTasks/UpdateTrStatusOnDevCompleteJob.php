<?php

class UpdateTrStatusOnDevCompleteJob implements RunnableSchedulerJob
{
  public function run($arguments)
  {
    $db = DBManagerFactory::getInstance();
    $sql = " 
      SELECT 
          tr_technicalrequests.id as tr_id
          FROM
          tr_technicalrequests
              LEFT JOIN
          tr_technicalrequests_cstm ON tr_technicalrequests.id = tr_technicalrequests_cstm.id_c
              LEFT JOIN
          tr_technicalrequests_opportunities_c ON tr_technicalrequests.id = tr_technicalrequests_opportunities_c.tr_technicalrequests_opportunitiestr_technicalrequests_idb
              AND tr_technicalrequests_opportunities_c.deleted = 0
              LEFT JOIN
          opportunities ON opportunities.id = tr_technicalrequests_opportunities_c.tr_technicalrequests_opportunitiesopportunities_ida
              AND opportunities.deleted = 0
          WHERE
          tr_technicalrequests.deleted = 0
              AND tr_technicalrequests.type IN ('lab_items')
              AND tr_technicalrequests.status NOT IN ('chip_sample_complete')
              AND tr_technicalrequests.approval_stage NOT IN ('closed_rejected' , 'closed_lost', 'development', 'understanding_requirements')
      ";
    
      $query = $db->query($sql);

      while ($row = $db->fetchByAssoc($query)) {
        $trBean = BeanFactory::getBean('TR_TechnicalRequests', $row['tr_id']);

        if ($trBean && $trBean->id) {
          $_REQUEST['action'] = 'Save'; // Need to change to Save to fit overall business logic requirements}
          
          $trBean->status = 'chip_sample_complete';
          $trBean->approval_stage = 'closed';
          
          $trBean->save();
          $GLOBALS['log']->fatal("TR Record ID: {$trBean->id}");
        }
  
          // echo "<pre>{$row['tr_id']}</pre>";
      }

    return true;
  }

  public function setJob(SchedulersJob $job)
  {
    $this->job = $job;
  }
}