<?php
	require_once('custom/include/custom_utils/SalesActivityReportQuery.php');

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

?>