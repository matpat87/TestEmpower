<?php
	require_once('custom/include/custom_utils/SalesActivityReportQuery.php');
	require_once('custom/include/custom_utils/BudgetReportQuery.php');
	require_once('custom/include/custom_utils/TimeAndDate.php');
	require_once('custom/include/custom_utils/OpportunityPipelineReport.php');

	function string_replace_all($find, $replace, $string)
	{
		$lastPos = 0;
		$positions = array();
		$replaceLength = strlen($find);

		while (($lastPos = strpos($string, $find, $lastPos))!== false) {
		    $positions[] = $lastPos;
		    $lastPos = $lastPos + $replaceLength;
		}

		// Displays 3 and 10
		foreach ($positions as $value) {
		    $string = str_replace($find, $replace, $string);
		}

		return $string;
	}

	function convert_to_money($string_money)
	{
		return "$" . number_format($string_money, 2, '.', ',');
	}

	function get_dropdown_index($dropdown_name, $dropdown_value)
	{
		global $app_list_strings;

		$index = 0;
		$dropdown = array();

		if(!empty($app_list_strings) && $app_list_strings[$dropdown_name] != null)
		{
			$dropdown = $app_list_strings[$dropdown_name];
			$i = 0;

			foreach ($dropdown as $key => $value) {

				if($value == $dropdown_value)
				{
					$index = $i;
				}

				$i++;
			}
		}

		return $index;
	}

	function getUserRepresentativesForReports()
	{
		global $db, $current_user;

		$user_representatives = array();
		$query = "";

		if($current_user->is_admin)
		{
			$query = "SELECT u.id, 
						CONCAT(u.first_name, ' ', u.last_name) AS name
					FROM users as u
					INNER JOIN users_cstm as uc
						on uc.id_c = u.id
					WHERE u.deleted = 0
					ORDER by name asc";
		}
		else
		{
			$query = "SELECT u.id,
						CONCAT(u.first_name, ' ', u.last_name) AS name
                    FROM securitygroups AS s
                    INNER JOIN securitygroups_cstm AS sc
                        ON sc.id_c = s.id
                    INNER JOIN securitygroups_users AS su
                        ON su.securitygroup_id = s.id
                        AND su.deleted = 0
                    INNER JOIN users AS u
                        ON u.id = su.user_id
                        AND u.deleted = 0
                    WHERE s.deleted = 0
                        AND sc.type_c = 'Sales Group'
                        AND s.assigned_user_id = '{$current_user->id}'
					ORDER by name asc";
		}

		$result = $db->query($query, false);

		while (($row = $db->fetchByAssoc($result)) != null) {
        	$user_representatives[$row['id']] = $row['name'];
    	}

		return $user_representatives;
	}

	function getAccountsForReports()
	{
		global $db, $current_user;

		$dropdown_data = array();
		$query = "";

		if($current_user->is_admin)
		{
			$query = "SELECT id, 
					name
				  FROM accounts
				  WHERE deleted = 0
				  ORDER by name asc";
		}
		else
		{
			$query = "SELECT a.id,
							a.name
						FROM securitygroups AS s
						INNER JOIN securitygroups_cstm AS sc
							ON sc.id_c = s.id
						INNER JOIN securitygroups_records AS sr
							ON sr.securitygroup_id = s.id
							AND sr.deleted = 0
							AND sr.module = 'Accounts'
						INNER JOIN accounts AS a
							ON a.id = sr.record_id
						WHERE s.deleted = 0
							AND sc.type_c = 'Sales Group'
							AND s.assigned_user_id = '{$current_user->id}'
						ORDER by a.name asc";
		}

		$result = $db->query($query, false);

		while (($row = $db->fetchByAssoc($result)) != null) {
        	$dropdown_data[$row['id']] = $row['name'];
    	}

		return $dropdown_data;
	}

?>