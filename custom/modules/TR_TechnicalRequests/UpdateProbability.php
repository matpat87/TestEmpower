<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');

// Call function in browser: <url>/index.php?module=TR_TechnicalRequests&action=UpdateProbability
updateProbability();

function updateProbability()
{
	$trBean = BeanFactory::getBean('TR_TechnicalRequests');
    $trBeanList = $trBean->get_full_list("", "", false, 0);

    if($trBeanList != null && count($trBeanList) > 0) {
        foreach($trBeanList as $trBean) {
            $newProbability = TechnicalRequestHelper::get_tr_probability_percentage($trBean->approval_stage);

            if ($trBean->probability_c != $newProbability) {
                $trBean->technicalrequests_number_c = $trBean->fetched_row['technicalrequests_number_c'];
                $trBean->version_c = $trBean->fetched_row['version_c'];
                $trBean->status = $trBean->fetched_row['status'];

                echo '<br>';
                echo "TR ID: {$trBean->id}";
                echo '<br>';
                echo "TR#: {$trBean->technicalrequests_number_c}";
                echo '<br>';
                echo "Version: {$trBean->version_c}";
                echo '<br>';
                echo "Name: {$trBean->name}";
                echo '<br>';
                echo "Stage: {$trBean->approval_stage}";
                echo '<br>';
                echo "Current Probability: {$trBean->probability_c}";
                echo '<br>';
                echo "New Probability: {$newProbability}";
                echo '<br>';

                $trBean->probability_c = $newProbability;
                $trBean->save();
            }
        }
    }
}
