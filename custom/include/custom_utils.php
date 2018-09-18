<?php
	require_once('custom/include/custom_utils/SalesActivityReportQuery.php');
	require_once('custom/include/custom_utils/BudgetReportQuery.php');
	require_once('custom/include/custom_utils/TimeAndDate.php');
	require_once('custom/include/custom_utils/OpportunityPipelineReport.php');

	function string_replace_all($find, $replace, $string)
	{
		$lastPos = 0;
		$positions = array();
		$replaceLength = strlen($find);

		while (($lastPos = strpos($string, $find, $lastPos))!== false) {
		    $positions[] = $lastPos;
		    $lastPos = $lastPos + $replaceLength;
		}

		// Displays 3 and 10
		foreach ($positions as $value) {
		    $string = str_replace($find, $replace, $string);
		}

		return $string;
	}

	function convert_to_money($string_money)
	{
		return "$" . number_format($string_money, 2, '.', ',');
	}

	function get_dropdown_index($dropdown_name, $dropdown_value)
	{
		global $app_list_strings;

		$index = 0;
		$dropdown = array();

		if(!empty($app_list_strings) && $app_list_strings[$dropdown_name] != null)
		{
			$dropdown = $app_list_strings[$dropdown_name];
			$i = 0;

			foreach ($dropdown as $key => $value) {

				if($value == $dropdown_value)
				{
					$index = $i;
				}

				$i++;
			}
		}

		return $index;
	}

?>