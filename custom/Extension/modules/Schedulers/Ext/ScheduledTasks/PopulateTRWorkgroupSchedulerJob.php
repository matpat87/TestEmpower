<?php

  require_once('custom/modules/TRWG_TRWorkingGroup/helpers/TRWorkingGroupHelper.php');
  
  class PopulateTRWorkgroupSchedulerJob implements RunnableSchedulerJob
  {
    public function run($arguments)
    {
      global $db;

      $db = DBManagerFactory::getInstance();
      $sql = "SELECT tr_technicalrequests.id FROM tr_technicalrequests WHERE tr_technicalrequests.deleted = 0 ORDER BY tr_technicalrequests.name ASC";
      $result = $db->query($sql);

      $_REQUEST['skip_hook'] = true;
      
      while($row = $db->fetchByAssoc($result) ) {
        $trBean = BeanFactory::getBean('TR_TechnicalRequests', $row['id']);

        if ($trBean && $trBean->id) {
          $sortedList = [];
                
          // Always monitor changes for Sales Person, Manager, SAM, and MDM on save to make sure it matches what's currently on the Account level
          $sortedList['SalesPerson'] = 'Sales Person';
          $sortedList['SalesManager'] = 'Sales Manager';
          // Ontrack 1971: Removed SAM and MDM TR Role creation
         /* $sortedList['MarketDevelopmentManager'] = 'Market Development Manager';
          $sortedList['StrategicAccountManager'] = 'Strategic Account Manager';*/

          if ($trBean->approval_stage == 'development') {
              switch ($trBean->status) {
                  case 'new':
                      $sortedList['ColorMatcher'] = 'Color Matcher';
                      break;
                  case 'approved':
                      $sortedList['RDManager'] = 'R&D Manager';
                      $sortedList['QuoteManager'] = 'Quote Manager';
                      $sortedList['ColorMatchCoordinator'] = 'Color Match Coordinator';
                      $sortedList['RegulatoryManager'] = 'Regulatory Manager';
                      break;
                  case 'awaiting_target_resin':
                      $sortedList['RDManager'] = 'R&D Manager';
                  default:
                      break;
              }
          }

          if (count($sortedList) > 0) {
              $sortedList['Creator'] = 'Creator';
              
              // sort TR Role array, transfer CREATOR role to end of Arrays
              foreach ($sortedList as $tr_role_key => $tr_role) {
                  if ($tr_role != '') {
                      TRWorkingGroupHelper::createOrUpdateTRRole($trBean, $tr_role_key);
                  }
              }
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