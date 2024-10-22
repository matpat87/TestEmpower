<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Opportunities&action=UpdateSalesStageStatus
updateSalesStageStatus();

var_dump('Updating Opportunities which is empty or null');
$opp_bean = BeanFactory::getBean('Opportunities');
$opp_beans = $opp_bean->get_full_list('name', "opportunities.deleted = 0 and (opportunities_cstm.status_c = '' or opportunities_cstm.status_c = NULL)", false, 0);

var_dump(count($opp_beans));

foreach($opp_beans as $bean)
{
    var_dump('$bean->sales_stage: ' . $bean->sales_stage);
    if($bean->sales_stage == 'ClosedLost')
    {
        $bean->status_c = 'rejected_price';
    }
    else if($bean->sales_stage  == 'ClosedRejected')
    {
        $bean->status_c = 'business_decision';
    }
    else if($bean->sales_stage  == 'ClosedWon')
    {
        $bean->status_c = 'order_received';
    }
    else if($bean->sales_stage  == 'ProductionTrialOrder')
    {
        $bean->status_c = 'in_process';
    }
    else if($bean->sales_stage  == 'QuotingProposing')
    {
        $bean->status_c = 'in_process';
    }
    else if($bean->sales_stage  == 'SolutionDevelopment')
    {
        $bean->status_c = 'in_process';
    }
    else if($bean->sales_stage  == 'IdentifyingOpportunity')
    {
        $bean->status_c = 'in_process';
    }
    else if($bean->sales_stage  == 'UnderstandingRequirements')
    {
        $bean->status_c = 'in_process';
    }
    var_dump('$bean->status_c: ' . $bean->status_c);

    $bean->save();
}


function updateSalesStageStatus() {
	global $db;

	$db = DBManagerFactory::getInstance();

    /*
    •	Closed Lost | Rejected Price – The status should be Price - DONE
    •	Closed Lost | NULL – Should be set to Price - DONE
    •	Closed - Rejected | NULL – Set to Business decision - DONE
    •	Closed – Won | NULL – Set to Order Received - DONE
    •	Production Trial Order | NULL – Set to In Process - DONE
    •	Quoting Proposing | NULL – Set to In Process - DONE
    •	Solution Development | NULL – Set to In Process - DONE
    •	Identifying Opportunity | NULL – Should at least be In Process - DONE
    •	Understanding Requirements | NULL 0 Set to In Process - DONE
    */
    
    $statusArray = array(
        'QualifyingOpportunity_InProgress' => 'in_process', //   'QualifyingOpportunity_InProgress' => 'In Progress', 	'in_process' => 'In Process',
        'UnderstandingRequirements_InProgress' => 'in_process', //  'UnderstandingRequirements_InProgress' => 'In Progress',	'in_process' => 'In Process',
        'SolutionDevelopment_InProgress' => 'in_process',   //'SolutionDevelopment_InProgress' => 'In Progress',	'in_process' => 'In Process',
        'Sampling_InProgress' => 'in_process', //  'Sampling_InProgress' => 'In Progress',	'in_process' => 'In Process',
        'QuotingProposing_InProgress' => 'in_process', //  'QuotingProposing_InProgress' => 'In Progress',	'in_process' => 'In Process',
        'ProductionTrialOrder_InProgress' => 'in_process', //  'ProductionTrialOrder_InProgress' => 'In Progress',	 'in_process' => 'In Process',
        'Sampling_SampleFailed' => 'rejected_color', //  'Sampling_SampleFailed' => 'Sample Failed',	Rejected_color
        'ProductionTrialOrder_ProductionTrialFailed' => 'rejected_color', //  'ProductionTrialOrder_ProductionTrialFailed' => 'Production Trial Failed',	Rejected_color
        'Closed Won_ClosedWonOrderReceived' => 'order_received', //  'Closed Won_ClosedWonOrderReceived' => 'Closed Won - Order Received',	'order_received' => 'Order Received',
        'Closed Won_ClosedWon2ndOrder' => 'order_received',
        'Closed Lost_Price' => 'rejected_price', //  'Closed Lost_Price' => 'Price',	'rejected_price' => 'Rejected - Price',
        'Closed Lost_ProductPerformance' => 'rejected_performance', //  'Closed Lost_ProductPerformance' => 'Product Performance', -	rejected_performance' => 'Rejected - Performance',
        'Lost_Quality' => 'quality', //  'Closed Lost_Quality' => 'Quality',	quality' => 'Quality',
        'Closed Lost_Service' => 'service', //  'Closed Lost_Service' => 'Service',	 'service' => 'Service',
        'Closed Lost_Credit' => 'credit_risk', //  'Closed Lost_Credit' => 'Credit',	Credit Risk  'credit_risk' => 'Credit Risk',
        'Closed Lost_Competition' => 'competition',   //'Closed Lost_Competition' => 'Competition',	 'competition' => 'Competition',
        'Closed Lost_BusinessDecision' => 'business_decision', //  'Closed Lost_BusinessDecision' => 'Business Decision', 	business_decision' => 'Business Decision',
        'ClosedRejected_TechnicalCapabilities' => 'capability', //  'ClosedRejected_TechnicalCapabilities' => 'Technical Capabilities',	 'capability' => 'Capability',
        'ClosedRejected_OperationalCapacity' => 'capacity', //  'ClosedRejected_OperationalCapacity' => 'Operational Capacity',	'capacity' => 'Capacity',
        'ClosedRejected_CreditRisk' => 'credit_risk', //  'ClosedRejected_CreditRisk' => 'Credit Risk',	 'credit_risk' => 'Credit Risk',
        'AwardEminent_InProgress' => 'awaiting_award',
    );
	
	foreach($statusArray as $key => $status) {
			//$implodedStatus = sprintf("'%s'", implode("','", $status ));
			
			$sql = "UPDATE opportunities
			LEFT JOIN opportunities_cstm
				ON opportunities.id = opportunities_cstm.id_c
			SET status_c = '{$status}'
				WHERE status_c = '{$key}' ";

			echo '<pre>';
				print_r($sql);
			echo '</pre>';

			$db->query($sql);
	}
}