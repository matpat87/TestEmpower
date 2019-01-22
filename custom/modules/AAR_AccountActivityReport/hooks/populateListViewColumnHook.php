<?php

	class PopulateListColumnHook
	{
		public function populateReportsColumn($bean, $event, $arguments)
		{
			global $app_list_strings, $sugar_config;

			$bean->custom_date = date("m/d/Y", strtotime($bean->custom_date));
		}

	}