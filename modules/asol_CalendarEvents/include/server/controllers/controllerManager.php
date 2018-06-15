<?php
/**
 * @author AlineaSol
 */
class asol_ControllerManager {
	/**
	 * @method It shows view manager
	 */
	static public function display() {
		require_once ("modules/asol_CalendarEvents/include/server/models/configCRUD.php");
		
		$languages = asol_ConfigCRUD::getLanguage ();
		$colors = asol_ConfigCRUD::getColor ();
		$availableTimezones = array ();
		$myTimezone = asol_ConfigCRUD::getTimezone ();
		$phpTimezone = DateTimeZone::listIdentifiers ();
		$timezoneVisible = asol_ConfigCRUD::getTimezoneVisible ();
		
		$availableContinents = array (
				'Africa',
				'America',
				'Antarctica',
				'Arctic',
				'Asia',
				'Atlantic',
				'Australia',
				'Europe',
				'Indian',
				'Pacific' 
		);
		
		foreach ( $phpTimezone as $zone ) {
			$tzArray = explode ( '/', $zone );
			$continent = $tzArray [0];
			
			if (in_array ( $continent, $availableContinents )) {
				$availableTimezones [] = $zone;
			}
		}
		
		require_once ("modules/asol_CalendarEvents/include/server/views/viewManager.php");
	}
}
