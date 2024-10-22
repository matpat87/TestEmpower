<?php
	require_once('custom/modules/Opportunities/helpers/OpportunitiesHelper.php');

	class PopulateListColumnHook
	{
		public function populateReportsColumn($bean, $event, $arguments)
		{
			global $app_list_strings, $sugar_config;

			$bean->opportunity_link = $sugar_config['site_url'] . '/index.php?module=Opportunities&action=DetailView&record=' . $bean->opportunity_id;
			$bean->amount_value = $bean->full_year_amount;
			$bean->amount_weighted_value = $bean->full_year_amount_weighted;
			$bean->full_year_amount = convert_to_money($bean->full_year_amount);
			$bean->full_year_amount_weighted = convert_to_money($bean->full_year_amount_weighted);
			$bean->next_step = 	htmlspecialchars_decode($bean->next_step);
			$bean->status = $bean->sales_stage && $bean->status ? OpportunitiesHelper::get_status($bean->sales_stage)[$bean->status] : '';
			$bean->date_closed = $bean->date_closed . '&nbsp;(' . $bean->date_closed_type . ')';
			
			if ( in_array( $bean->sales_stage, ['Closed Won', 'Closed Lost', 'ClosedRejected'] ) ) {
				$bean->date_closed = $bean->closed_date_c ? $bean->closed_date_c . '&nbsp;(' . $bean->date_closed_type . ')' : '';
			}

			$bean->sales_stage = get_dropdown_index("sales_stage_dom", $app_list_strings['sales_stage_dom'][$bean->sales_stage]);
		}

	}