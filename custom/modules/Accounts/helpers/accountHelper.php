<?php

class AccountHelper {
	function retrieveCurrentYTDBudget($bean) {
		$currentMonth = date('n');
		$currentYTDBudget = 0;
		
		for ($i=1 ; $i <= $currentMonth; $i++) {
			$field = 'cur_year_month' . $i . '_c';
			$currentYTDBudget += $bean->$field;
		}

		return $currentYTDBudget;
	}

	function retrieveCurrentMonthBudget($bean) {
		$currentMonth = date('n');
		$field = 'cur_year_month' . $currentMonth . '_c';
		$currentMonthBudget = $bean->$field;
		return $currentMonthBudget;
	}
}