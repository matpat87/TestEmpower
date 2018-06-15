<?php
/**
 * @author AlineaSol
 */
class asol_ControllerCalendar {
	/**
	 * @method It shows the main view
	 */
	static public function display() {
		require_once ("modules/asol_Common/include/commonUtils.php");
		require_once ("modules/asol_CalendarEvents/include/server/calendarUtils.php");
		require_once ("modules/asol_CalendarEvents/include/server/models/configCRUD.php");
		
		global $current_language, $current_user, $timedate;
		
		$fdow = 0; //First Day of the Week
		$dashlet = "false"; //The view is not a dashlet
		$canEdit = false;
		$canDelete = false;
		$existDomains = false;
		$categories = array ();
		$enableCountries = array ();
		$categoriesFilter = array ();
		$timezoneList = asol_ConfigCRUD::getTimezone ();
		$timezoneVisible = asol_ConfigCRUD::getTimezoneVisible ();
		$sugarUserTimezone = $timedate->userTimezone ( $current_user );
		
		if (asol_CommonUtils::isDomainsInstalled ()) {
			require_once ("modules/asol_Domains/AlineaSolDomainsFunctions.php");
			$existDomains = true;
			$enableCountries = asol_manageDomains::getChildCountryDomains ( $current_user->asol_default_domain, true );
		}
		
		$categoriesFilter = asol_ConfigCRUD::getLanguage ();
		
		if ($current_user->is_admin || (ACLController::checkAccess ( asol_CalendarUtils::$calendarevents_id, "edit", true ))) {
			$canEdit = true;
		}
		
		if ($current_user->is_admin || (ACLController::checkAccess ( asol_CalendarUtils::$calendarevents_id, "delete", true ))) {
			$canDelete = true;
		}
		
		if ($current_user->getPreference ( "fdow" ) != "") {
			$fdow = $current_user->getPreference ( "fdow" );
		}
		
		$categories = self::getCategories ();
		
		require_once ("modules/asol_CalendarEvents/include/server/views/viewCalendar.php");
	}
	/**
	 * @method It shows a calendar dashlet
	 * @return A string that contains the HTML for the dashlet
	 */
	static public function displayDashlet() {
		require_once ("modules/asol_Common/include/commonUtils.php");
		require_once ("modules/asol_CalendarEvents/include/server/calendarUtils.php");
		require_once ("modules/asol_CalendarEvents/include/server/models/configCRUD.php");
		
		global $current_language, $current_user, $timedate;
		
		$fdow = 0;
		$dashlet = "true"; //The view is a dashlet
		$canEdit = false;
		$canDelete = false;
		$sugarUserTimezone = $timedate->userTimezone ( $current_user );
		
		if (!asol_CommonUtils::isDomainsInstalled ()) {
			
			if ($current_user->is_admin || (ACLController::checkAccess ( asol_CalendarUtils::$calendarevents_id, "edit", true ))) {
				$canEdit = true;
			}
			
			if ($current_user->is_admin || (ACLController::checkAccess ( asol_CalendarUtils::$calendarevents_id, "delete", true ))) {
				$canDelete = true;
			}
		}

		if ($current_user->getPreference ( "fdow" ) != "") {
			$fdow = $current_user->getPreference ( "fdow" );
		}
		
		$categories = asol_ConfigCRUD::getLanguage ();
		
		return (include "modules/asol_CalendarEvents/include/server/views/viewDashlet.php");
	}
	/**
	 * @method Obtain the categories
	 * @return Associative Array <language, translatation>
	 */
	private function getCategories() {
		require_once ("modules/asol_CalendarEvents/include/server/models/configCRUD.php");
		
		global $current_user;
		
		$categories = array ();
		
		$categories = asol_ConfigCRUD::getLanguage ();
		
		return $categories;
	}
}
