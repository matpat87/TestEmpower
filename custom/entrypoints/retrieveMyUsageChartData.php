<?php
	require_once('custom/include/Carbon/src/Carbon/Carbon.php');
	use Carbon\Carbon;

	global $db;
	$db = DBManagerFactory::getInstance();

	$modules = ['Accounts', 'Calls', 'Customer Issues', 'Contacts', 'Emails', 'Leads', 'Meetings', 'Notes', 'Opportunities', 'Projects', 'Tasks'];
	$salesGroupUserId = $_REQUEST['my_usage_sales_group_user_id'];

	$query = "";

	for ($i=11; $i >= 0; $i--) {
		$query .= " SELECT * FROM ( ";
		
		$carbonNow = $i == 0 ? Carbon::now() : Carbon::now()->subMonth($i);
    $year = $carbonNow->year;
		$month = $carbonNow->month < 10 ? '0' . $carbonNow->month : $carbonNow->month;
		
		$query .= " (
			SELECT '{$year}-{$month}' AS YearMonth
		) AS YearMonth, ";

		foreach ($modules as $module) {
			switch ($module) {
				case 'Customer Issues':
					$tableName = 'cases';
					break;
				case 'Projects':
					$tableName = 'project';
					break;
				default:
					$tableName = strtolower($module);
					break;
			}

			$query .= " ( 
					SELECT COUNT(*) AS '{$module}' 
					FROM {$tableName} 
					WHERE deleted = 0 
					AND YEAR(date_modified) = '{$year}' 
					AND MONTH(date_modified) = '{$month}'
					AND modified_user_id = '{$salesGroupUserId}'
					AND assigned_user_id = '{$salesGroupUserId}'
				) AS {$tableName} ";

			if ($module != end($modules)) {
				$query .= ' , ';
			}
		}

		$query .= " ) ";

		if($i > 0) {
			$query .= ' UNION ALL ';
		}
	}
	
	$result = $db->query($query);

	$data = [];
	$ctr = 0;
	
	while( $row = $db->fetchByAssoc($result) ) {
		$data[$ctr] = $row;
		$ctr++;
	}
	
	echo json_encode($data);

?>