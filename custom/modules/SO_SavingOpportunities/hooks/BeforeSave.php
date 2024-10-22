<?php

require_once('custom/modules/SO_SavingOpportunities/helpers/SavingOpportunitiesHelper.php');

class SavingOpportunitiesBeforeSaveHook{

    function opp_id_checker(&$bean, $event, $arguments) 
    {
        $bean->so_id = SavingOpportunitiesHelper::assign_opportunity_id($bean->id);
    }
}

?>