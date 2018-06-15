<?php
/**
 * @author AlineaSol
 */
class asol_ControllerConfiguration {
	/**
	 *
	 * @param array $color        	
	 * @return string
	 */
	static public function saveColor($color) {
		require_once ('modules/asol_CalendarEvents/include/server/models/configCRUD.php');
		
		$oldArray = asol_ConfigCRUD::getLanguage ();
		$newArray = array ();
		
		foreach ( $color as $key => $value ) {
			$newArray [$key] = $oldArray [$key];
		}
		
		$colorEncode = base64_encode ( serialize ( $color ) );
		$languageEncode = base64_encode ( serialize ( $newArray ) );
		
		asol_ConfigCRUD::saveLanguage ( $languageEncode );
		asol_ConfigCRUD::saveColor ( $colorEncode );
		
		return $colorEncode;
	}
	/**
	 *
	 * @param array $type        	
	 * @return string
	 */
	static public function saveType($type) {
		require_once ('modules/asol_CalendarEvents/include/server/models/configCRUD.php');
		
		$actualColor = asol_ConfigCRUD::getColor ();
		if ($type [id] == "") {
			$actualColor [str_replace ( " ", "-", $type ['language'] ['en_us'] )] = array (
					'background' => '3A87AD',
					'border' => '3A87AD',
					'text' => 'FFFFFF' 
			);
		}
		
		$actualLanguage = asol_ConfigCRUD::getLanguage ();
		if ($type [id] == "") {
			$actualLanguage [str_replace ( " ", "-", $type ['language'] ['en_us'] )] = $type ['language'];
		} else {
			$actualLanguage [$type[id]] = $type ['language'];
		}
		
		$actualStructure = asol_ConfigCRUD::getStructure ();
		if (!isset($type['structure']['customFields'])) 
			$type['structure']['customFields'] = array();
		if ($type [id] == "") {
			$actualStructure [str_replace ( " ", "-", $type ['language'] ['en_us'] )] = $type ['structure'];
		} else {
			$actualStructure [$type[id]] = $type ['structure'];
		}
		
		$colorEncode = base64_encode ( serialize ( $actualColor ) );
		$languageEncode = base64_encode ( serialize ( $actualLanguage ) );
		$structureEncode = base64_encode ( serialize ( $actualStructure ) );
		
		asol_ConfigCRUD::saveColor ( $colorEncode );
		asol_ConfigCRUD::saveLanguage ( $languageEncode );
		asol_ConfigCRUD::saveStructure ( $structureEncode );
		
		return $languageEncode;
	}
	/**
	 *
	 * @param array $type        	
	 * @return string
	 */
	static public function deleteType($type) {
		require_once ('modules/asol_CalendarEvents/include/server/models/configCRUD.php');
		require_once ('modules/asol_CalendarEvents/include/server/models/eventsCRUD.php');
		
		$actualColor = asol_ConfigCRUD::getColor ();
		$actualLanguage = asol_ConfigCRUD::getLanguage ();
		$actualStructure = asol_ConfigCRUD::getStructure ();
		
		unset ( $actualColor [$type], $actualLanguage [$type], $actualStructure [$type] );
		
		$colorEncode = base64_encode ( serialize ( $actualColor ) );
		$languageEncode = base64_encode ( serialize ( $actualLanguage ) );
		$structureEncode = base64_encode ( serialize ( $actualStructure ) );
		
		asol_ConfigCRUD::saveColor ( $colorEncode );
		asol_ConfigCRUD::saveLanguage ( $languageEncode );
		asol_ConfigCRUD::saveStructure ( $structureEncode );
		
		asol_EventsCRUD::deleteAllEventAssocType ( $type );
		
		return $languageEncode;
	}
	/**
	 *
	 * @param array $timezone        	
	 * @return string
	 */
	static public function saveTimezone($timezone) {
		require_once ('modules/asol_CalendarEvents/include/server/models/configCRUD.php');
		
		if ($timezone ['timezoneVisibility'] == 'false')
			$timezone ['timezoneVisibility'] = '0';
		else
			$timezone ['timezoneVisibility'] = '1';
		
		$timezoneEncode = base64_encode ( serialize ( $timezone ['timezoneList'] ) );
		
		asol_ConfigCRUD::saveTimezoneVisible ( $timezone ['timezoneVisibility'] );
		asol_ConfigCRUD::saveTimezone ( $timezoneEncode );
		
		return $timezoneEncode;
	}
	
	static public function resetConfig() {
		require_once ('modules/asol_CalendarEvents/include/server/models/configCRUD.php');
		
		$asol_calendarevents_config ['color'] = array (
				'holiday' => array (
						'background' => 'CADBFE',
						'border' => 'CADBFE',
						'text' => '000000' 
				),
				'deploy' => array (
						'background' => 'CFBBFE',
						'border' => 'CFBBFE',
						'text' => '000000' 
				),
				'maintenance' => array (
						'background' => 'FED1CF',
						'border' => 'FED1CF',
						'text' => '000000' 
				),
				'meeting' => array (
						'background' => 'FFE8CB',
						'border' => 'FFE8CB',
						'text' => '000000' 
				),
				'seminar' => array (
						'background' => 'FEFBAA',
						'border' => 'FEFBAA',
						'text' => '000000' 
				),
				'new' => array (
						'background' => 'D9EACA',
						'border' => 'D9EACA',
						'text' => '000000' 
				) 
		);
		
		$asol_calendarevents_config ['structure'] = array (
				'holiday' => array (
						'allDay' => '1',
						'domain' => 'countries',
						'customFields' => array () 
				),
				'deploy' => array (
						'allDay' => '0',
						'domain' => 'domain',
						'customFields' => array () 
				),
				'maintenance' => array (
						'allDay' => '0',
						'domain' => 'domain',
						'customFields' => array () 
				),
				'meeting' => array (
						'allDay' => '0',
						'domain' => 'domain',
						'customFields' => array () 
				),
				'seminar' => array (
						'allDay' => '0',
						'domain' => 'domain',
						'customFields' => array () 
				),
				'new' => array (
						'allDay' => '0',
						'domain' => 'domain',
						'customFields' => array () 
				) 
		);
		
		$asol_calendarevents_config ['language'] = array (
				'holiday' => array (
						'en_us' => 'Holidays',
						'sp_ve' => 'Vacaciones' 
				),
				'deploy' => array (
						'en_us' => 'Deploy',
						'sp_ve' => 'Deploy' 
				),
				'maintenance' => array (
						'en_us' => 'Maintenance',
						'sp_ve' => 'Mantenimiento' 
				),
				'meeting' => array (
						'en_us' => 'Meeting',
						'sp_ve' => 'Reunión' 
				),
				'seminar' => array (
						'en_us' => 'Seminar',
						'sp_ve' => 'Seminario' 
				),
				'new' => array (
						'en_us' => 'News',
						'sp_ve' => 'Novedades' 
				) 
		);
		
		$asol_calendarevents_config ['timezone_visible'] = '0';
		
		$asol_calendarevents_config ['timezone'] = array ();
		
		$colorEncode = base64_encode ( serialize ( $asol_calendarevents_config ['color'] ) );
		$languageEncode = base64_encode ( serialize ( $asol_calendarevents_config ['language'] ) );
		$timezoneEncode = base64_encode ( serialize ( $asol_calendarevents_config ['timezone'] ) );
		$structureEncode = base64_encode ( serialize ( $asol_calendarevents_config ['structure'] ) );
		
		asol_ConfigCRUD::resetConfig ( $colorEncode, $languageEncode, $asol_calendarevents_config ['timezone_visible'], $timezoneEncode, $structureEncode );
		
		return $languageEncode;
	}
}
