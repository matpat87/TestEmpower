<?php

require_once('custom/modules/Opportunities/helpers/OpportunitiesHelper.php');
require_once('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');

class OpportunitiesBeforeSaveHook{

    /**
     * This will fix on task in Ontrack #5 - OPPORTUNITY - SCREEN CHANGES - Next Step
     * @author Steven O Kyamko
    **/
    function next_step_edited_before_save(&$bean, $event, $arguments)
    {
        global $current_user, $log;
        $next_step = "";
        $time_and_date = new TimeAndDateCustom();
        $current_datetime_timestamp = $time_and_date->get_timestamp($time_and_date->new_york_format);

        $bean->oppid_c = OpportunitiesHelper::assign_opportunity_id($bean->id);

        // echo $this->bean->oppid_c;
        // die;

        if ($bean->next_step_temp_c != "") {
            $conjunction = "<br/>";

            $next_step = '<div style="font-size: 8pt;">('. $current_user->user_name . ' - '.  $current_datetime_timestamp .')</div>';
            $next_step .= '<div style="font-size: 12pt; line-height: 1">'. nl2br($bean->next_step_temp_c) .'</div>';

            if ($bean->next_step != "") {
                $next_step .= "$conjunction " . $bean->next_step;
            }

            $bean->next_step = $next_step;
            // $bean->next_step_temp_c = "";
        } else {
            // On edit, the field becomes blank by default and triggers an audit change when saved as empty if it previously had a value
            // Need to set it on the backend to set value based on fetched_row to prevent incorrect audit log
            $bean->next_step_temp_c = $bean->fetched_row['next_step_temp_c'];
        }
    }

    function calculateOpportunityAmount(&$bean, $event, $arguments) {
        //$bean->amount = $bean->annual_volume_lbs_c * $bean->avg_sell_price_c;
    }

    // If sales stage is changed and value is either closed won, lost, or rejected, update closed_date_c value
    function set_closed_date(&$bean, $event, $arguments) {
        if ($bean->fetched_row['sales_stage'] != $bean->sales_stage) {
            if (in_array($bean->sales_stage, ['ClosedWon', 'ClosedLost', 'ClosedRejected'])) {
                $bean->closed_date_c = (! $bean->closed_date_c) ? date('Y-m-d') : $bean->closed_date_c;
            } else {
                $bean->closed_date_c = '';
            }
        }
    }

    function set_amount_weighted(&$bean, $event, $arguments) {
        $opportunityTechnicalRequestsBeanList = TechnicalRequestHelper::get_opportunity_trs($bean->id);

        if (count($opportunityTechnicalRequestsBeanList) > 0) {
            TechnicalRequestHelper::opportunity_calculate_probability($bean->id);
        } else {
            $bean->amount_weighted_c = $bean->amount * ($bean->probability_prcnt_c / 100);
        }
    }

    function opp_id_checker(&$bean, $event, $arguments) 
    {
        if (! $bean->fetched_row['id']) {
            $bean->oppid_c = OpportunitiesHelper::assign_opportunity_id($bean->id);
        }
    }

    function handleIndustryDbValues(&$bean, $event, $arguments)
    {
        global $log, $app_list_strings, $db;

        // Retrieve Industry Bean with id $bean->industry_c
        $industryQuery = $db->query("
                SELECT * from mkt_markets WHERE id = '{$bean->industry_c}'
            ");
        
        while ($row = $db->fetchByAssoc($industryQuery)) {

            // Set the $bean->sub_industry_c = $industryBean->id -- to inline data saved from prev implementation
            $bean->sub_industry_c = $row['id'];
            // Set the $bean->industry = with value from $app_list_strings['industry_dom][$industryBean->name]
            $bean->industry_c = $row['name'];
        }
        
    }
}

?>