<?php
	global $app_list_strings;

	$salesStages = $app_list_strings['sales_stage_dom'];
	
	if (isset($_REQUEST['opportunity_by_value_sales_stages'])) {
		$explodedSalesStage = explode(',', $_REQUEST['opportunity_by_value_sales_stages']);
	}

	$newSalesStageArray = [];
	$ctr = 1;

	foreach ($salesStages as $key => $value) {
		if (isset($explodedSalesStage) && ! in_array($key, $explodedSalesStage)) {
			continue;
		}
		
		$newSalesStageArray["sales_stage_{$ctr}"] = $value;
		$ctr++;
	}

	echo json_encode($newSalesStageArray);
?>