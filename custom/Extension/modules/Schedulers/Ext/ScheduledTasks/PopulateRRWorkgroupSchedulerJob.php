<?php

  require_once('custom/modules/RRWG_RRWorkingGroup/helpers/RRWorkingGroupHelper.php');
  
  class PopulateRRWorkgroupSchedulerJob implements RunnableSchedulerJob
  {
    public function run($arguments)
    {
      global $db;

      $db = DBManagerFactory::getInstance();
      $sql = "SELECT rrq_regulatoryrequests.id FROM rrq_regulatoryrequests WHERE rrq_regulatoryrequests.deleted = 0 ORDER BY rrq_regulatoryrequests.name ASC";
      $result = $db->query($sql);

      $_REQUEST['skip_hook'] = true;
      
      while($row = $db->fetchByAssoc($result) ) {
        $rrBean = BeanFactory::getBean('RRQ_RegulatoryRequests', $row['id']);

        if ($rrBean && $rrBean->id) {                
          $sortedList = [];
          $sortedList['Creator'] = 'Creator';
          $sortedList['RegulatoryManager'] = 'Regulatory Manager';
          $sortedList['SalesPerson'] = 'Sales Person';
          
          // Only generate Requestor if Requested By is not empty
          if ($rrBean->user_id_c) {
            $sortedList['Requestor'] = 'Requestor';
          }

          // If status is Assigned onwards but not yet complete, add Regulatory Analyst in array
          if (in_array($rrBean->status_c, ['assigned', 'in_process'])) {
            $sortedList['RegulatoryAnalyst'] = 'Regulatory Analyst';
          }

          if (count($sortedList) > 0) {
              foreach ($sortedList as $rr_role_key => $rr_role) {
                  if ($rr_role != '') {
                      RRWorkingGroupHelper::createOrUpdateRRRole($rrBean, $rr_role_key);
                  }
              }
          }

          // Need to create custom logic for generating Regulatory Analyst for Records that are complete
          if ($rrBean->status_c == 'complete') {
            // Regulatory Manager Bean
            $regulatoryManagerUserBean = RRWorkingGroupHelper::handleRetrieveWorkgroupUserBean($rrBean, 'RegulatoryManager');

            if (! $regulatoryManagerUserBean->id) {
              continue;
            }

            $_REQUEST['custom_regulatory_analyst_id'] = $regulatoryManagerUserBean->id;
            RRWorkingGroupHelper::createOrUpdateRRRole($rrBean, 'RegulatoryAnalyst');
            unset($_REQUEST['custom_regulatory_analyst_id']);
          }
        }
      }

      return true;
    }

    public function setJob(SchedulersJob $job)
    {
      $this->job = $job;
    }
  }