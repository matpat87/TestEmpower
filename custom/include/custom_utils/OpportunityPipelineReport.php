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
		// OnTrack #1639: Depracated $app_list_strings['opr_type_list'] loop as Opportunity type list has been updated;
		// This is to update the Advanced Filter field Type list as it is in Opportunities
		foreach ($app_list_strings['opportunity_type_dom'] as $key => $value) {
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
										IF(a.name != '', CONCAT(a.name, ' (', a.account_type, ')'), 'N/A') AS 'account_c',
                    o.id AS opportunity_id,
                    o.name AS opportunity_name,
                    IFNULL(u.user_name, '[N/A]') AS sales_rep,
                    o.amount AS full_year_amount,
                    oc.amount_weighted_c AS full_year_amount_weighted,
					oc.oppid_c AS opportunity_id_num,
                    o.date_closed,
										oc.closed_date_c,
										DATE_FORMAT(o.date_entered, '%Y-%m-%d') AS created_date,
										IF(o.`sales_stage` = 'Closed Won' OR  o.`sales_stage` = 'Closed Lost' OR o.`sales_stage` = 'ClosedRejected', 'ACT', 'EST') AS date_closed_type,
                    o.sales_stage,
										oc.status_c AS status,
										oc.probability_prcnt_c AS probability_c,
                    SUBSTRING_INDEX(o.`next_step`,'<br',1) AS next_step ";

         return $query;
	}

	function getFromQueryrForOpportunityPipeline()
	{
		global $db, $current_user;

		$query = " FROM opportunities AS o
            LEFT JOIN accounts_opportunities AS ao
                ON ao.opportunity_id = o.id
                AND ao.deleted = 0
			LEFT JOIN accounts AS a
				ON a.id = ao.account_id
				AND a.deleted = 0
            LEFT JOIN accounts_cstm AS ac
                ON ac.id_c = a.id
            LEFT JOIN opportunities_cstm AS oc
                ON oc.id_c = o.id
            LEFT JOIN users AS u
                ON u.id = o.assigned_user_id
            LEFT JOIN mkt_markets_opportunities_1_c AS mmo
				ON mmo.mkt_markets_opportunities_1opportunities_idb = o.id
				AND mmo.deleted = 0
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