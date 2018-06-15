<?php
/**
 * @author AlineaSol
 */
class asol_ControllerEvents {
	/**
	 *
	 * @param array $event        	
	 * @return string
	 */
	static public function saveEvent($event) {
		require_once ("modules/asol_Common/include/commonUtils.php");
		require_once ("modules/asol_CalendarEvents/include/server/calendarUtils.php");
		
		$model = null;
		
		if ($event ['id'] == null) {
			$model = new asol_CalendarEvents ();
		} else {
			$model = BeanFactory::getBean ( asol_CalendarUtils::$calendarevents_id, $event ['id'] );
		}
		
		$avoidFields = array (
				'id',
				'asol_domain_published_mode',
				'asol_domain_child_share_depth',
				'asol_multi_create_domain',
				'asol_published_domain' 
		);
		
		foreach ( $event as $key => $value ) {
			if (! in_array ( $key, $avoidFields ))
				$model->$key = $value;
		}
		
		$eventId = $model->save ();
		
		if (asol_CommonUtils::isDomainsInstalled ()) {
			require_once ("modules/asol_Domains/AlineaSolDomainsFunctions.php");
			
			$_REQUEST ["record"] = $eventId;
			$_REQUEST ["module"] = asol_CalendarUtils::$calendarevents_id;
			$_REQUEST ["asol_domain_published_mode"] = $event ["asol_domain_published_mode"];
			$_REQUEST ["asol_domain_child_share_depth"] = $event ["asol_domain_child_share_depth"];
			$_REQUEST ["asol_multi_create_domain"] = $event ["asol_multi_create_domain"];
			$_REQUEST ["asol_published_domain"] = $event ["asol_published_domain"];
			
			asol_manageDomains::managePublicationDomainRequest ( 'asol_domain_published_mode', 'asol_domain_child_share_depth', 'asol_multi_create_domain', 'asol_published_domain' );
		}
		
		return $eventId;
	}
	/**
	 *
	 * @param string $eventId        	
	 * @return string
	 */
	static public function deleteEvent($eventId) {
		require_once ("modules/asol_CalendarEvents/include/server/calendarUtils.php");
		
		$model = BeanFactory::getBean ( asol_CalendarUtils::$calendarevents_id, $eventId );
		$model->deleted = 1;
		return $model->save ();
	}
	/**
	 *
	 * @param string $timezone        	
	 * @param string $month
	 *        	- Format: MMYYYY -
	 * @param array $categories        	
	 * @param array $countries        	
	 * @return string
	 */
	static public function fetchEvents($timezone, $month, $categories, $countries) {
		require_once ("modules/asol_CalendarEvents/include/server/models/eventsCRUD.php");
		
		$queryResult = asol_EventsCRUD::ObtainEvents ( $timezone, $month );
		
		$events = self::applyFilter ( $queryResult, $categories, $countries );
		
		return json_encode ( $events );
	}
	/**
	 *
	 * @param $db->query $queryResult        	
	 * @param array $categories        	
	 * @param array $countries        	
	 * @return array
	 */
	private function applyFilter($queryResult, $categories, $countries) {
		require_once ("modules/asol_Common/include/commonUtils.php");
		require_once ("modules/asol_CalendarEvents/include/server/models/configCRUD.php");
		
		global $db;
		
		$events = array ();
		$colorconfiguration = asol_ConfigCRUD::getColor ();
		
		while ( $row = $db->fetchByAssoc ( $queryResult ) ) {
			
			$eventIsValid = false;
			
			$arrayCountry = explode ( ";;", substr ( $row ["country"], 1, - 1 ) );
			
			if (asol_CommonUtils::isDomainsInstalled ()) {
				if ($arrayCountry [0] != "") {
					if (! empty ( $countries )) {
						foreach ( $arrayCountry as $country ) {
							$eventIsValid = in_array ( $country, $countries );
							if ($eventIsValid)
								break;
						}
					} else {
						$eventIsValid = true;
					}
				} else {
					$eventIsValid = true;
				}
			} else {
				$eventIsValid = true;
			}
			
			if ($eventIsValid == true) {
				if (empty ( $categories ))
					$eventIsValid = true;
				else
					$eventIsValid = in_array ( $row ["category"], $categories );
			} else {
				if (empty ( $categories ))
					$eventIsValid = true;
			}
			
			if ($eventIsValid) {
				if ($row ["allDay"] == 1)
					$row ["allDay"] = true;
				else
					$row ["allDay"] = false;
				
				$row ["info"] = htmlspecialchars_decode ( $row ["info"] );
				$row ["backgroundColor"] = "#" . $colorconfiguration [$row ["category"]] ["background"];
				$row ["borderColor"] = "#" . $colorconfiguration [$row ["category"]] ["border"];
				$row ["textColor"] = "#" . $colorconfiguration [$row ["category"]] ["text"];
				
				$events [] = $row;
			}
		}
		
		return $events;
	}
}
