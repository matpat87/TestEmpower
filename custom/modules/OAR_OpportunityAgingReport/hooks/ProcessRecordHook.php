<?php
	class ProcessRecordHook
	{
		public function handleListFieldValues(&$bean, $event, $arguments)
		{
			global $app_list_strings, $sugar_config;

			$bean->opportunity_link = $sugar_config['site_url'] . '/index.php?module=Opportunities&action=DetailView&record=' . $bean->opportunity_id;
			
			$ctr = 1;
			$bean->sales_stage_total = 0;

			foreach ($app_list_strings['sales_stage_dom'] as $key => $value) {
				if (! in_array($key, ['Closed', 'ClosedWon', 'ClosedLost', 'ClosedRejected'])) {
					$sales_stage_num = "sales_stage_{$ctr}";
					$bean->sales_stage_total += $bean->$sales_stage_num;
					$ctr++;
				}
			}
		}

	}