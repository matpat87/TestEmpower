<?php
	$salesGroupUsers = retrieveSalesGroupUsers();
	
	if (isset($_REQUEST['opportunity_by_velocity_sales_group_user_ids'])) {
		$explodedSalesGroupUserIds = explode(',', $_REQUEST['opportunity_by_velocity_sales_group_user_ids']);
	}

	$newSalesGroupUsersArray = [];

	foreach ($salesGroupUsers as $key => $value) {
		if (isset($explodedSalesGroupUserIds) && ! in_array($key, $explodedSalesGroupUserIds)) {
			continue;
		}
		
		$newSalesGroupUsersArray[$key] = $value;
	}

	echo json_encode($newSalesGroupUsersArray);
?>