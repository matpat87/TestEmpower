<?php

	class TimeAndDateCustom
	{
		public $new_york_format = 'America/New_York';

		public function get_timestamp($country_format, $date_separator = '-', $time_separator = ':')
		{
			$time_format = "Y{$date_separator}m{$date_separator}d H{$time_separator}i{$time_separator}s";
			$amNY = new DateTime($country_format);
			return $amNY->format($time_format);
		}
	}

?>