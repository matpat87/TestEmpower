<?php
	require_once('custom/include/Carbon/src/Carbon/Carbon.php');
	use Carbon\Carbon;

	global $db, $app_list_strings, $current_user;
	$db = DBManagerFactory::getInstance();

	$modules = ['Accounts', 'Calls', 'Customer Issues', 'Contacts', 'Emails', 'Leads', 'Meetings', 'Notes', 'Opportunities', 'Projects', 'Tasks'];
	$salesStages = $app_list_strings['sales_stage_dom'];
	
	$filters = [
		'my_opportunities' => $_REQUEST['opportunity_by_value_my_opportunities'] ?? [],
		'sales_stage' => $_REQUEST['opportunity_by_value_sales_stages'] ?? [],
		'assigned_to' => $_REQUEST['opportunity_by_value_sales_group_user_ids'] ?? [],
		'amount' => $_REQUEST['opportunity_by_value_amount'] ?? '',
		'date_from' => $_REQUEST['opportunity_by_value_date_from'] ?? '',
		'date_to' => $_REQUEST['opportunity_by_value_date_to'] ?? '',
	];

	if (! $current_user->is_admin) {
		$securityGroupQuery = " AND ( ( opportunities.assigned_user_id ='{$current_user->id}'  or  EXISTS (SELECT  1
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
	
	if ($filters['my_opportunities']) {
		$myOpportunitiesWhereIn = formatDataArrayForWhereInQuery($filters['my_opportunities']);
		$myOpportunitiesQuery = " AND opportunities.id IN ({$myOpportunitiesWhereIn})";
	} else {
		$myOpportunitiesQuery = "";
	}

	if ($filters['sales_stage']) {
		$salesStageWhereIn = formatDataArrayForWhereInQuery($filters['sales_stage']);
		$salesStageQuery = " AND opportunities.sales_stage IN ({$salesStageWhereIn})";
		$explodedSalesStage = explode(',', $filters['sales_stage']);
	} else {
		$salesStageWhereIn = formatDataArrayForWhereInQuery(implode(',', array_keys($app_list_strings['sales_stage_dom'])));
		$salesStageQuery = " AND opportunities.sales_stage IN ({$salesStageWhereIn})";
	}

	if ($filters['assigned_to']) {
		$assignedToWhereIn = formatDataArrayForWhereInQuery($filters['assigned_to']);
		$assignedToQuery = " AND users.id IN ({$assignedToWhereIn})";
		$grandTotalAssignedToQuery = " AND opportunities.assigned_user_id IN ({$assignedToWhereIn})";
	} else {
		$retrieveSalesGroupUsers = retrieveSalesGroupUsers();
		$keyIds = array_keys($retrieveSalesGroupUsers);
		$implodedIds = implode(',', $keyIds);
		
		$assignedToWhereIn = formatDataArrayForWhereInQuery($implodedIds);
		$assignedToQuery = " AND users.id IN ({$assignedToWhereIn})";
		$grandTotalAssignedToQuery = " AND opportunities.assigned_user_id IN ({$assignedToWhereIn})";
	}

	$amountFilterQuery = $filters['amount'] ? " AND opportunities.amount >= {$filters['amount']}" : '';

	if ($filters['date_from']) {
		$formattedDateFrom = date('Y-m-d', strtotime($filters['date_from']));
		$dateFromQuery = " AND opportunities.date_entered >= '{$formattedDateFrom}'";
	}

	if ($filters['date_to']) {
		$formattedDateTo = date('Y-m-d', strtotime($filters['date_to']));
		$dateToQuery = " AND opportunities.date_entered <= '{$formattedDateTo}'";
	}
	
	$ctr = 1;
	
	$query = "SELECT IFNULL(users.user_name, 'UNASSIGNED')  AS username, ";

	foreach ($salesStages as $key => $value) {
		if (isset($explodedSalesStage) && ! in_array($key, $explodedSalesStage)) continue;

		$query .= " 
			(
				SELECT IFNULL(SUM(opportunities.amount), 0) FROM opportunities
						WHERE opportunities.deleted = 0
						{$securityGroupQuery}
						AND opportunities.sales_stage = '{$key}'
						AND opportunities.assigned_user_id = users.id
						{$amountFilterQuery}
						{$myOpportunitiesQuery}
						{$dateFromQuery}
						{$dateToQuery}";
		$query .= " ) AS 'sales_stage_{$ctr}',
		";
		
		$ctr++;
	}

	$query .= " 
		(
			SELECT IFNULL(SUM(opportunities.amount), 0) FROM opportunities
					WHERE opportunities.deleted = 0
					{$securityGroupQuery}
					{$salesStageQuery}
					AND opportunities.assigned_user_id = users.id
					{$amountFilterQuery}
					{$myOpportunitiesQuery}
					{$dateFromQuery}
					{$dateToQuery}";
	$query .= "	) AS 'grand_total' 
		FROM users 
		WHERE users.deleted = 0
		{$assignedToQuery}
		ORDER BY grand_total ASC
	";

	$result = $db->query($query);

	$data = [];
	$ctr = 0;
	
	while( $row = $db->fetchByAssoc($result) ) {
		if ($row['grand_total'] > 0) {
			$data[$ctr] = $row;
			$ctr++;
		}
	}
	
	echo json_encode($data);

?>