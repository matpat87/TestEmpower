<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=OTR_OnTrack&action=UpdateActualHrsWorked
updateOntrackActualHrsWorked();

function updateOntrackActualHrsWorked() {

    global $log, $db;
    $ontrackBean = BeanFactory::getBean('OTR_OnTrack')->get_full_list('date_entered',"", false, 0);

    $count = 0;
    foreach ($ontrackBean as $ticket) {
        $totalHrs = retrieveActualHours($ticket->id, "OTR_OnTrack");
        $updateSql = "UPDATE otr_ontrack_cstm SET actual_hours_worked_c = '{$totalHrs}' WHERE id_c = '{$ticket->id}'";
        $db->query($updateSql);
        $count++;
        echo "<pre>";
        echo $updateSql;
        echo "</pre>";
    }

    echo "<pre>";
    echo "{$count} Records updated";
    echo "</pre>";
    
}
