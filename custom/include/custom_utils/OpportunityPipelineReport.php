<?php

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
		$query = "";

		if($current_user->is_admin)
		{
			$query = "SELECT id, 
					name
				  FROM mkt_markets
				  WHERE deleted = 0
				  ORDER by name asc";
		}
		else
		{
			$query = "SELECT m.id,
							m.name
						FROM mkt_markets as m
						WHERE m.deleted = 0 
							AND (m.assigned_user_id in 
									(SELECT u.id
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
                                    )
                                    OR m.assigned_user_id = '{$current_user->id}')
						ORDER by m.name asc";
		}

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
                    o.id AS opportunity_id,
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
                ON oc.id_c = o.id
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