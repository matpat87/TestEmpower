<?php
	global $db, $app_list_strings, $current_user, $log;
	
	$filters = [
		'my_opportunities' => $_REQUEST['opportunity_by_velocity_my_opportunities'] ?? [],
		'sales_stage' => $_REQUEST['opportunity_by_velocity_sales_stages'] ?? [],
		'assigned_to' => $_REQUEST['opportunity_by_velocity_sales_group_user_ids'] ?? [],
		'amount' => $_REQUEST['opportunity_by_velocity_amount'] ?? '',
		'date_from' => $_REQUEST['opportunity_by_velocity_date_from'] ?? '',
		'date_to' => $_REQUEST['opportunity_by_velocity_date_to'] ?? '',
	];

	if (! $current_user->is_admin) {
		$securityGroupQuery = " AND ( ( opportunities.assigned_user_id ='{$current_user->id}' OR EXISTS (SELECT  1
			FROM securitygroups secg
			INNER JOIN securitygroups_users secu
				ON secg.id = secu.securitygroup_id
				AND secu.deleted = 0
				AND secu.user_id = '{$current_user->id}'
			INNER JOIN securitygroups_records secr
				ON secg.id = secr.securitygroup_id
				AND secr.deleted = 0
				AND secr.module = 'Opportunities'
			WHERE secr.record_id = opportunities.id
				AND secg.deleted = 0) ) ) ";
	} else {
		$securityGroupQuery = '';
	}
	
	$salesStages = $app_list_strings['sales_stage_dom'];
	$openSalesStages = array_filter($salesStages, function ($key) {
		return (! in_array($key, ['Closed', 'ClosedWon', 'ClosedLost', 'ClosedRejected']));
	}, ARRAY_FILTER_USE_KEY);

	$retrieveSalesGroupUsers = retrieveSalesGroupUsers();

	if ($filters['sales_stage']) {
		$openSalesStages = array_intersect_key($openSalesStages , array_flip(explode(',', $filters['sales_stage'])));
	}

	if ($filters['assigned_to']) {
		$retrieveSalesGroupUsers = array_intersect_key($retrieveSalesGroupUsers , array_flip(explode(',', $filters['assigned_to'])));
	}

	if ($filters['my_opportunities']) {
		$myOpportunitiesWhereIn = formatDataArrayForWhereInQuery($filters['my_opportunities']);
	}

	if ($filters['date_from']) {
		$formattedDateFrom = date('Y-m-d', strtotime($filters['date_from']));
	}

	if ($filters['date_to']) {
		$formattedDateTo = date('Y-m-d', strtotime($filters['date_to']));
	}

	$amountFilterQuery = $filters['amount'] 
		? " AND opportunities.amount >= {$filters['amount']}" 
		: "";

	$myOpportunitiesQuery = (isset($myOpportunitiesWhereIn) && $myOpportunitiesWhereIn) 
		? " AND opportunities.id IN ({$myOpportunitiesWhereIn})"
		: "";

	$dateFromQuery = (isset($formattedDateFrom) && $formattedDateFrom)
		? " AND opportunities.date_entered >= '{$formattedDateFrom}' "
		: "";

	$dateToQuery = (isset($formattedDateTo) && $formattedDateTo)
		? " AND opportunities.date_entered <= '{$formattedDateTo}' "
		: "";
	
	$query = "SELECT * FROM (";

	foreach ($openSalesStages as $parentKey => $parentValue) {
		$query .= "SELECT '{$parentValue}' AS sales_stage,";

		foreach ($retrieveSalesGroupUsers as $key => $value) {
			$query .= "(
				SELECT SUM(
					IFNULL(
						GREATEST(
							DATEDIFF(
								IFNULL(
									(SELECT DATE_FORMAT(oa_before.date_created, '%Y-%m-%d') FROM opportunities_audit AS oa_before WHERE oa_before.parent_id = opportunities.id AND oa_before.field_name = 'sales_stage' AND oa_before.before_value_string = '{$parentKey}' ORDER BY oa_before.date_created DESC LIMIT 1),
									DATE_FORMAT(NOW(), '%Y-%m-%d')
								),
								IFNULL(
									(SELECT DATE_FORMAT(oa_after.date_created, '%Y-%m-%d') FROM opportunities_audit AS oa_after WHERE oa_after.parent_id = opportunities.id AND oa_after.field_name = 'sales_stage' AND oa_after.after_value_string = '{$parentKey}' ORDER BY oa_after.date_created DESC LIMIT 1),
									(SELECT DATE_FORMAT(opp.date_entered, '%Y-%m-%d') FROM opportunities opp WHERE opportunities.id = opp.id AND opp.deleted = 0 AND opp.sales_stage = '{$parentKey}')
								)
							), 0
						), 0
					)
				)
				FROM opportunities 
				LEFT JOIN users
					ON opportunities.assigned_user_id = users.id
				WHERE opportunities.deleted = 0
					AND users.deleted = 0
					AND opportunities.sales_stage NOT LIKE 'Closed%'
					AND opportunities.assigned_user_id = '{$key}'
				{$securityGroupQuery}
				{$amountFilterQuery}
				{$myOpportunitiesQuery}
				{$dateFromQuery}
				{$dateToQuery}
			) AS '{$key}'";

			if (end($retrieveSalesGroupUsers) <> $value) {
				$query .= ",";
			}
		}

		if (end($openSalesStages) <> $parentValue) {
			$query .= " UNION ";
		}
	}

	$query .= ") AS opportunity_by_velocity";
	
	$result = $db->query($query);

	$data = [];

	while( $row = $db->fetchByAssoc($result) ) {
		$data[] = $row;
	}

	echo json_encode($data);

?>