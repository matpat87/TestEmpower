<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('custom/modules/OAR_OpportunityAgingReport/CustomOAR_OpportunityAgingReport.php');

class OAR_OpportunityAgingReportController extends SugarController
{
    public function action_listview() {
        $this->bean = new CustomOAR_OpportunityAgingReport();
        parent::action_listview();
    }
}