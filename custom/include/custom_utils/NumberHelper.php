<?php

	class NumberHelper
	{
		public static function GetCurrencyValue($field_value, $currencySign = '$')
		{
			$result = $field_value;

			if(strpos($field_value, $currencySign) === false) {
				$result = $currencySign . number_format($field_value, 2, '.', ',');
			}

			return $result;
		}
	}

?>