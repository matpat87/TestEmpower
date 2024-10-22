<?php

class CompetitorProcessRecordHook 
{
    public function handleCompetitorNameColumn($bean, $event, $arguments)
    {
       global $log;
       $log->fatal(print_r($_REQUEST, true));

       if ($_REQUEST['module'] == 'COMP_Competitor' && $_REQUEST['action'] == 'Popup') {
            $bean->comp_competitor_comp_competition_name = "<a href='javascript:void(0)' onclick='send_back('COMP_Competitor','{$bean->id}');'>{$bean->comp_competitor_comp_competition_name}</a>";
       } else {
           $bean->comp_competitor_comp_competition_name = "
            <a href='index.php?module=COMP_Competitor&action=DetailView&record={$bean->id}'>
                <span class='sugar_field'>{$bean->comp_competitor_comp_competition_name}</span>
            </a>";

       }
    } // end of handleCompetitorNameColumn
}

?>