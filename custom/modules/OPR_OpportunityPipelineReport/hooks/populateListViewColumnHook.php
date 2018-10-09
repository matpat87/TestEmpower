<?php

	class PopulateListColumnHook
	{
		public function populateReportsColumn($bean, $event, $arguments)
		{
			global $app_list_strings, $sugar_config;

			$bean->opportunity_link = $sugar_config['site_url'] . '/index.php?module=Opportunities&action=DetailView&record=' . $bean->opportunity_id;
			$bean->amount_value = $bean->full_year_amount;
			$bean->full_year_amount = convert_to_money($bean->full_year_amount);
			$bean->next_step = 	htmlspecialchars_decode($bean->next_step);
			$bean->status = $bean->sales_stage;
			$bean->sales_stage = get_dropdown_index("sales_stage_dom", $bean->sales_stage);
		}

	}