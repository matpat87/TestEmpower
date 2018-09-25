<?php
	
	function getUserRepresentatives()
	{
		global $db, $current_user;

		$user_representatives = array();
		$user_roles = getRoles();

		$query = "SELECT u.id, 
					CONCAT(u.first_name, ' ', u.last_name) AS name
					FROM users as u
					INNER JOIN users_cstm as uc
						on uc.id_c = u.id
					WHERE u.deleted = 0";

		if(in_array("Admin", $user_roles))
		{

		}
		else if(in_array("Executive", $user_roles))
		{

		}
		else if(in_array("Supervisor", $user_roles))
		{
			$query .=  " AND u.reports_to_id = '{$current_user->id}'";
		}
		else if(in_array("Salesperson", $user_roles))
		{
			$query .=  " AND 1=0";
		}

		
		$result = $db->query($query, false);

		while (($row = $db->fetchByAssoc($result)) != null) {
        	$user_representatives[$row['id']] = $row['name'];
    	}

		return $user_representatives;
	}

	function getAccountsForOpportunityPipeline()
	{
		global $db, $current_user;

		$dropdown_data = array();
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

		$dropdown_data = array();
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

		$dropdown_data = array();
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

	function getTypesForOpportunityPipeline()
	{
		global $db, $current_user, $app_list_strings;

		$dropdown_data = array();

		foreach ($app_list_strings['opr_type_list'] as $key => $value) {
			if(!empty($key))
			{
				$dropdown_data[$value] = $value;
			}
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

	function getFromQueryrForOpportunityPipeline()
	{
		global $db, $current_user;

		$query = "FROM accounts AS a
                INNER JOIN accounts_cstm AS ac
                    ON ac.id_c = a.id
                INNER JOIN accounts_opportunities AS ao
                    ON ao.account_id = a.id
                    AND ao.deleted = 0
                INNER JOIN opportunities AS o
                    ON o.id = ao.opportunity_id
                    AND o.deleted = 0
                INNER JOIN opportunities_cstm AS oc
                    ON oc.id_c = o.`id`
                INNER JOIN users AS u
                    ON u.id = o.assigned_user_id
                LEFT JOIN mkt_markets_opportunities_1_c AS mmo
				    ON mmo.mkt_markets_opportunities_1opportunities_idb = o.id
				LEFT JOIN mkt_markets AS mm
				    ON mm.id = mmo.mkt_markets_opportunities_1mkt_markets_ida";

        return $query;
	}

	function getRoles()
	{
		global $current_user;
		$roles = array();
		include_once("modules/ACLRoles/ACLRole.php");
		$acl_role = new ACLRole();
		$roleNames = $acl_role->getUserRoleNames($current_user->id);
		
		foreach($roleNames as $roleName)
		{
			$roles[] = $roleName;
		}

		if($current_user->is_admin)
		{
			$role[] = "Admin";
		}

		return $roles;
	}

?>