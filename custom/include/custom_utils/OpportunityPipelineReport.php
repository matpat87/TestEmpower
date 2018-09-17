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

	function getSelectQueryForOpportunityPipeline()
	{
		global $db, $current_user;

		$query = "SELECT a.id,
					ac.division_c,
                    a.name AS account_c,
                    o.name AS opportunity_name,
                    u.user_name AS sales_rep,
                    o.amount AS full_year_amount,
                    o.date_closed,
                    o.sales_stage,
                    o.next_step ";

         return $query;
	}

	function getWhereQueryrForOpportunityPipeline()
	{
		global $db, $current_user;

		$query = "FROM accounts AS a
                INNER JOIN accounts_cstm AS ac
                    ON ac.`id_c` = a.`id`
                INNER JOIN accounts_opportunities AS ao
                    ON ao.`account_id` = a.`id`
                    AND ao.`deleted` = 0
                INNER JOIN opportunities AS o
                    ON o.`id` = ao.`opportunity_id`
                    AND o.`deleted` = 0
                INNER JOIN opportunities_cstm AS oc
                    ON oc.`id_c` = o.`id`
                INNER JOIN users AS u
                    ON u.id = o.`assigned_user_id`";

        return $query;
	}

?>