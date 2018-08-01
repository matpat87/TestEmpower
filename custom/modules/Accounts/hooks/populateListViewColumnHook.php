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

	}