<?php
  class TimeAfterDeleteHook
  {
    public function deductOnTrackActualHours($bean, $event, $arguments)
    {
        global $log, $db;
        
        if ($bean->parent_type == 'OTR_OnTrack') {
          $currentHrs = retrieveActualHours($arguments['related_bean']->id, $bean->parent_type);
           
          $sqlString = "UPDATE otr_ontrack_cstm SET actual_hours_worked_c = {$currentHrs} WHERE id_c='{$arguments['related_bean']->id}'";
          $db->query($sqlString);
          
           
        }
        
    }
  }
?>