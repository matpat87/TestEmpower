<?php
	require_once('custom/modules/Accounts/helpers/accountHelper.php');
	
	class populateListViewColumnHook
	{
		public function populateCurrentYTDBudget($bean, $event, $arguments)
		{
			$accountBean = BeanFactory::getBean('Accounts', $bean->id);
			$currentYTDBudget = AccountHelper::retrieveCurrentYTDBudget($accountBean);
	    	$bean->ytd_budget_c = $currentYTDBudget;
		}

		public function populateCurrentMonthBudget($bean, $event, $arguments)
		{
			$accountBean = BeanFactory::getBean('Accounts', $bean->id);
			$currentMonthBudget = AccountHelper::retrieveCurrentMonthBudget($accountBean);
	    	$bean->curr_month_budget_c = $currentMonthBudget;
		}

	}