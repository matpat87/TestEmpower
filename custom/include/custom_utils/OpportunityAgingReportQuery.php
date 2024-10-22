<?php
	class OpportunityAgingReportQuery
	{
		public function customSelectQuery(): string
		{
			global $app_list_strings;

			$select = " 
						SELECT users.user_name AS sales_rep,
						opportunities.id AS opportunity_id,
						opportunities.name AS opportunity_name,
						IF(accounts.name != '', CONCAT(accounts.name, ' (', accounts.account_type, ')'), 'N/A') AS account_name,
						opportunities.opportunity_type AS opportunity_type,
						opportunities.amount AS opportunity_value,
						opportunities_cstm.oppid_c AS opportunity_id_number,
					";

			$ctr = 1;

			foreach ($app_list_strings['sales_stage_dom'] as $key => $value) {
				if (! in_array($key, ['Closed', 'ClosedWon', 'ClosedLost', 'ClosedRejected'])) {

					$select .= "
						(
							SELECT IFNULL(
								GREATEST(
									DATEDIFF(
										IFNULL(
											(SELECT DATE_FORMAT(oa_before.date_created, '%Y-%m-%d') FROM opportunities_audit AS oa_before WHERE oa_before.parent_id = opportunities.id AND oa_before.field_name = 'sales_stage' AND oa_before.before_value_string = '{$key}' ORDER BY oa_before.date_created DESC LIMIT 1),
											DATE_FORMAT(NOW(), '%Y-%m-%d')
										),
										IFNULL(
											(SELECT DATE_FORMAT(oa_after.date_created, '%Y-%m-%d') FROM opportunities_audit AS oa_after WHERE oa_after.parent_id = opportunities.id AND oa_after.field_name = 'sales_stage' AND oa_after.after_value_string = '{$key}' ORDER BY oa_after.date_created DESC LIMIT 1),
											(SELECT DATE_FORMAT(opp.date_entered, '%Y-%m-%d') FROM opportunities opp WHERE opportunities.id = opp.id AND opp.deleted = 0 AND opp.sales_stage = '{$key}')
										)
									), 0
								), 0
							)	
						) AS 'sales_stage_{$ctr}',
					";

					$ctr++;
				}
			}

			$select .= " 0 AS sales_stage_total ";
			
			return $select;
		}

		public function customFromQuery(): string
		{
			return "
						FROM opportunities 
						LEFT JOIN accounts_opportunities AS accounts_opportunities
							ON accounts_opportunities.opportunity_id = opportunities.id
							AND accounts_opportunities.deleted = 0
						LEFT JOIN accounts
							ON accounts.id = accounts_opportunities.account_id
							AND accounts.deleted = 0
						LEFT JOIN accounts_cstm
							ON accounts.id = accounts_cstm.id_c
						LEFT JOIN opportunities_cstm
							ON opportunities.id = opportunities_cstm.id_c
						LEFT JOIN users
							ON users.id = opportunities.assigned_user_id
							AND users.deleted = 0
						LEFT JOIN users_cstm
							ON users.id = users_cstm.id_c
					";
		}

		public function customWhereQuery($where): string
		{
			$where = str_replace('custom_account_non_db', 'accounts.id', $where);
			$where = str_replace('custom_assigned_to_non_db', 'opportunities.assigned_user_id', $where);
			$where = str_replace('custom_sales_group_non_db', 'users_cstm.sales_group_c', $where);
			$where = str_replace('custom_division_non_db', 'opportunities_cstm.division_c', $where);
			$where = str_replace('custom_sales_stage_non_db', 'opportunities.sales_stage', $where);
			$where = str_replace('custom_type_non_db', 'opportunities.opportunity_type', $where);

			$where = self::handleSalesGroupFilter($where);
			$where = self::handleDivisionFilter($where);
			$where = self::handleSecurityGroupFilter($where);
			$where = self::handleSalesStageFilter($where);

			return $where;
		}

		public function customOrderByQuery($orderBy): string
		{
			$orderBy = " ORDER BY sales_rep, opportunity_id_number ASC ";
			return $orderBy;
		}

		private function handleSalesGroupFilter($where): string
		{
			$dropdownSalesGroupList = getSalesGroupForReports();
			unset($dropdownSalesGroupList['All']);

			$whereInFilter = handleArrayToWhereInFormatAll($dropdownSalesGroupList);
			$where = str_replace("users_cstm.sales_group_c in ('All'", "opportunities_cstm.sales_group_c in ({$whereInFilter}", $where);

			return $where;
		}

		private function handleDivisionFilter($where): string
		{
			$dropdownDivisionList = getDivisionsForReports();
			unset($dropdownDivisionList['All']);

			$whereInFilter = handleArrayToWhereInFormatAll($dropdownDivisionList);
			$where = str_replace("opportunities_cstm.division_c in ('All'", "opportunities_cstm.division_c in ({$whereInFilter}", $where);

			return $where;
		}

		private function handleSecurityGroupFilter($where): string
		{
			global $current_user;

			$securityGroupBean = BeanFactory::getBean('SecurityGroups');
			$userSalesSecurityGroupBean = $securityGroupBean->retrieve_by_string_fields(
				array('assigned_user_id' => $current_user->id, 'type_c' => 'Sales Group'), false, false
			);

			if (! $current_user->is_admin) {
				$where .= (! empty($userSalesSecurityGroupBean)) 
				? " AND (users.id in (SELECT users.id
					FROM securitygroups
					INNER JOIN securitygroups_cstm
						ON securitygroups_cstm.id_c = securitygroups.id
					INNER JOIN securitygroups_users
						ON securitygroups_users.securitygroup_id = securitygroups.id
						AND securitygroups_users.deleted = 0
					WHERE securitygroups.deleted = 0 
						AND securitygroups_cstm.type_c = 'Sales Group'
						AND securitygroups.assigned_user_id = '{$current_user->id}')
						OR users.id = '{$current_user->id}') "
				: " AND users.id = '{$current_user->id}' ";
			}

			return $where;
		}

		private function handleSalesStageFilter($where): string
		{
			$where .= (strpos($where, 'opportunities.sales_stage') == false) ? " AND opportunities.sales_stage NOT LIKE 'Closed%' " : "";
			return $where;
		}
	}
?>