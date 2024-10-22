<?php
	require_once('custom/include/Carbon/src/Carbon/Carbon.php');
	use Carbon\Carbon;

	global $db, $app_list_strings, $current_user;
	$db = DBManagerFactory::getInstance();

	$salesStages = $app_list_strings['sales_stage_dom'];

	$filters = [
		// 'sales_stage' => $_REQUEST['opportunity_by_value_sales_stages'] ?? [],
		'assigned_to' => $_REQUEST['leads_performance_sales_group_user_ids'] ?? [],
		'date_from' => $_REQUEST['lead_performance_date_from'] ?? '',
		'date_to' => $_REQUEST['lead_performance_date_to'] ?? '',
	];

	if (! $current_user->is_admin) {
		$securityGroupQuery = " OR ( ( EXISTS (SELECT  1
			FROM securitygroups secg
			INNER JOIN securitygroups_users secu
				ON secg.id = secu.securitygroup_id
				AND secu.deleted = 0
				AND secu.user_id = '{$current_user->id}'
			INNER JOIN securitygroups_records secr
				ON secg.id = secr.securitygroup_id
				AND secr.deleted = 0
				AND secr.module = 'Leads'
			WHERE secr.record_id = leads.id
				AND secg.deleted = 0) ) ) ";
	} else {
		$securityGroupQuery = '';
	}
	

	if ($filters['assigned_to']) {
		$assignedToWhereIn = formatDataArrayForWhereInQuery($filters['assigned_to']);
		$assignedToQuery = " AND assigned_user_id IN ({$assignedToWhereIn})";
		
	} else {
		$retrieveSalesGroupUsers = retrieveSalesGroupUsers();
		$keyIds = array_keys($retrieveSalesGroupUsers);
		$implodedIds = implode(',', $keyIds);
		
		$assignedToWhereIn = formatDataArrayForWhereInQuery($implodedIds);
		$assignedToQuery = " AND assigned_user_id IN ({$assignedToWhereIn})";
		
	}

	if ($filters['date_from'] != '') {
		$formattedDateFrom = date('Y-m-d', strtotime($filters['date_from']));
		$dateFromQuery = " AND date_entered >= '{$formattedDateFrom}'";
	} else {
		// Get Date 1 year ago 
		$dateFrom = Carbon::now()->subYear()->toDateString();
		$dateFromQuery = " AND DATE(date_entered) >= DATE('{$dateFrom}')";
		
	}

	if ($filters['date_to'] != '') {
		$formattedDateTo = date('Y-m-d', strtotime($filters['date_to']));
		$dateToQuery = " AND date_entered <= '{$formattedDateTo}'";
	} else {
		$dateTo = Carbon::now()->toDateString();
		$dateToQuery = " AND DATE(date_entered) <= DATE('{$dateTo}')";
	}
	
	$ctr = 1;

	$query = "
		SELECT 
			`status` AS lead_status, count(id) AS leads_count
		FROM
			leads
		WHERE
			deleted = 0 
			{$assignedToQuery}
 			{$securityGroupQuery}
 			{$dateFromQuery}	
 			{$dateToQuery}	
		GROUP BY lead_status;
	
	";
	
	$result = $db->query($query);

	$data = [];
	$ctr = 0;
	
	while( $row = $db->fetchByAssoc($result) ) {
		if ($row['leads_count'] > 0) {
			$data[$ctr] = $row;
			$ctr++;
		}
	}
	echo json_encode($data);

?>