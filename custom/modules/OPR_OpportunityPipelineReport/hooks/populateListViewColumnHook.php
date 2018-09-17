<?php

	class PopulateListColumnHook
	{
		public function populateReportsColumn($bean, $event, $arguments)
		{
			$bean->full_year_amount = convert_to_money($bean->full_year_amount);
			$bean->next_step = 	htmlspecialchars_decode($bean->next_step);
		}

	}