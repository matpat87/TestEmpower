<?php
  class PopulateTRItemEstCompletionDateJob implements RunnableSchedulerJob
  {
    public function run($arguments)
    {
      global $db;

      $db = DBManagerFactory::getInstance();
      $sql = "SELECT tri_technicalrequestitems.id 
              FROM tri_technicalrequestitems
              LEFT JOIN tri_technicalrequestitems_cstm
                ON tri_technicalrequestitems.id = tri_technicalrequestitems_cstm.id_c
              WHERE tri_technicalrequestitems.deleted = 0
              ORDER BY tri_technicalrequestitems.date_entered ASC
              ";

      $result = $db->query($sql);

      while ($row = $db->fetchByAssoc($result)) {
        $trItemBean = BeanFactory::getBean('TRI_TechnicalRequestItems', $row['id']);
        
        if (! $trItemBean->id) {
          continue;
        }

        $estCompletionDate = $trItemBean->est_completion_date_c;
        
        // If TR Item is Complete/Rejected, Populate Est Completion Date with TR Item Completed Date
        // Else if TR Item NOT Complete/Rejected, Populate Est Completion Date witn TR Est Completion Date (NULL or Not)
        if (in_array($trItemBean->status, ['complete', 'rejected'])) {
          if (! $trItemBean->est_completion_date_c) {
            if (! $trItemBean->completed_date_c) {
              $estCompletionDate = NULL;
            } else {
              $estCompletionDate = new DateTime($trItemBean->completed_date_c);
              $formattedEstCompletionDate = $estCompletionDate->format('Y-m-d');
            }
          }
        } else {
          $trBean = BeanFactory::getBean('TR_TechnicalRequests', $trItemBean->tri_techni0387equests_ida);

          if (! $trBean->id) {
            continue;
          }

          // TR Est Completion Date can be blank or not
          if (! $trBean->est_completion_date_c) {
            $estCompletionDate = NULL;
          } else {
            $estCompletionDate = new DateTime($trBean->est_completion_date_c);
            $formattedEstCompletionDate = $estCompletionDate->format('Y-m-d');
          }
        }
        
        $finalEstCompletionDate = isset($formattedEstCompletionDate) ? "'{$formattedEstCompletionDate}'" : 'NULL';

        $trItemBean->est_completion_date_c = $finalEstCompletionDate;
        $trItemBean->auditBean(true);

        $db->query("UPDATE tri_technicalrequestitems_cstm SET tri_technicalrequestitems_cstm.est_completion_date_c = {$finalEstCompletionDate} WHERE tri_technicalrequestitems_cstm.id_c = '{$trItemBean->id}'");
      }

      return true;
    }

    public function setJob(SchedulersJob $job)
    {
      $this->job = $job;
    }
  }