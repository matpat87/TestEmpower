<?php

	class PopulateListColumnHook
	{
		public function populateReportsColumn($bean, $event, $arguments)
		{
			global $app_list_strings;

			$bean->full_year_amount = convert_to_money($bean->full_year_amount);
			$bean->next_step = 	htmlspecialchars_decode($bean->next_step);
			$bean->sales_stage = get_dropdown_index("sales_stage_dom", $bean->sales_stage);
		}

	}