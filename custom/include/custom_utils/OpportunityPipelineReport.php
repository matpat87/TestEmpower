<?php
	
	function getUserRepresentatives()
	{
		global $db, $current_user;

		$user_representatives = array('' => 'All');
		$query = "SELECT id, 
					CONCAT(first_name, ' ',last_name) AS name
				  FROM users
				  WHERE deleted = 0";
		$result = $db->query($query, false);

		while (($row = $db->fetchByAssoc($result)) != null) {
        	$user_representatives[$row['id']] = $row['name'];
    	}

		return $user_representatives;
	}

	function getAccountsForOpportunityPipeline()
	{
		global $db, $current_user;

		$dropdown_data = array('' => 'All');
		$query = "SELECT id, 
					name
				  FROM accounts
				  WHERE deleted = 0";
		$result = $db->query($query, false);

		while (($row = $db->fetchByAssoc($result)) != null) {
        	$dropdown_data[$row['id']] = $row['name'];
    	}

		return $dropdown_data;
	}

	function getCampaignsForOpportunityPipeline()
	{
		global $db, $current_user;

		$dropdown_data = array('' => 'All');
		$query = "SELECT id, 
					name
				  FROM campaigns
				  WHERE deleted = 0";
		$result = $db->query($query, false);

		while (($row = $db->fetchByAssoc($result)) != null) {
        	$dropdown_data[$row['id']] = $row['name'];
    	}

		return $dropdown_data;
	}

	function getMarketsForOpportunityPipeline()
	{
		global $db, $current_user;

		$dropdown_data = array('' => 'All');
		$query = "SELECT id, 
					name
				  FROM mkt_markets
				  WHERE deleted = 0";
		$result = $db->query($query, false);

		while (($row = $db->fetchByAssoc($result)) != null) {
        	$dropdown_data[$row['id']] = $row['name'];
    	}

		return $dropdown_data;
	}

?>