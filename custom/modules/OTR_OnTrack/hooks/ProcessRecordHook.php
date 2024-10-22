<?php

class OTR_OnTrackProcessRecordHook
{


    function actualHoursWorkedColumn(&$bean, $event, $arguments)
    {
        global $current_user, $log;
        
        $hours = retrieveActualHours($bean->id, "OTR_OnTrack");
        $bean->actual_hours_non_db = "<span>{$hours}</span>";
    }
  
}

?>