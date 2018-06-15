<?php
/**
 * @author AlineaSol
 */
class asol_ConfigCRUD {
	public static $calendarevents_id = "asol_CalendarEvents";
	public static $calendareventsconfig_table = "asol_calendarevents_config";
	/**
	 *
	 * @param string $color        	
	 * @param string $language        	
	 * @param string $timezone_visible        	
	 * @param string $timezone        	
	 * @param string $structure        	
	 */
	static public function resetConfig($color, $language, $timezone_visible, $timezone, $structure) {
		global $db;
		
		$db->query ( "UPDATE " . self::$calendareventsconfig_table . " SET config='" . $color . "' WHERE category='color'" );
		
		$db->query ( "UPDATE " . self::$calendareventsconfig_table . " SET config='" . $language . "' WHERE category='language'" );
		
		$db->query ( "UPDATE " . self::$calendareventsconfig_table . " SET config='" . $timezone_visible . "' WHERE category='timezone_visible'" );
		
		$db->query ( "UPDATE " . self::$calendareventsconfig_table . " SET config='" . $timezone . "' WHERE category='timezone'" );
		
		$db->query ( "UPDATE " . self::$calendareventsconfig_table . " SET config='" . $structure . "' WHERE category='structure'" );
	}
	/**
	 *
	 * @return array
	 */
	static public function getLanguage() {
		global $db;
		
		$result = $db->query ( "SELECT " . self::$calendareventsconfig_table . ".config FROM " . self::$calendareventsconfig_table . " WHERE category='language'" );
		
		$row = $db->fetchByAssoc ( $result );
		
		return unserialize ( base64_decode ( $row ['config'] ) );
	}
	/**
	 *
	 * @param string $language        	
	 */
	static public function saveLanguage($language) {
		global $db;
		
		$db->query ( "UPDATE " . self::$calendareventsconfig_table . " SET config='" . $language . "' WHERE category='language'" );
	}
	/**
	 *
	 * @return array
	 */
	static public function getColor() {
		global $db;
		
		$result = $db->query ( "SELECT " . self::$calendareventsconfig_table . ".config FROM " . self::$calendareventsconfig_table . " WHERE category='color'" );
		
		$row = $db->fetchByAssoc ( $result );
		
		return unserialize ( base64_decode ( $row ['config'] ) );
	}
	/**
	 *
	 * @param string $color        	
	 */
	static public function saveColor($color) {
		global $db;
		
		$db->query ( "UPDATE " . self::$calendareventsconfig_table . " SET config='" . $color . "' WHERE category='color'" );
	}
	/**
	 *
	 * @return array
	 */
	static public function getStructure() {
		global $db;
		
		$result = $db->query ( "SELECT " . self::$calendareventsconfig_table . ".config FROM " . self::$calendareventsconfig_table . " WHERE category='structure'" );
		
		$row = $db->fetchByAssoc ( $result );
		
		return unserialize ( base64_decode ( $row ['config'] ) );
	}
	/**
	 *
	 * @param string $structure        	
	 */
	static public function saveStructure($structure) {
		global $db;
		
		$db->query ( "UPDATE " . self::$calendareventsconfig_table . " SET config='" . $structure . "' WHERE category='structure'" );
	}
	/**
	 *
	 * @return integer 0 || 1
	 */
	static public function getTimezoneVisible() {
		global $db;
		
		$result = $db->query ( "SELECT " . self::$calendareventsconfig_table . ".config FROM " . self::$calendareventsconfig_table . " WHERE category='timezone_visible'" );
		
		$row = $db->fetchByAssoc ( $result );
		
		return $row ['config'];
	}
	/**
	 *
	 * @param string $timezone_visible        	
	 */
	static public function saveTimezoneVisible($timezone_visible) {
		global $db;
		
		$db->query ( "UPDATE " . self::$calendareventsconfig_table . " SET config='" . $timezone_visible . "' WHERE category='timezone_visible'" );
	}
	/**
	 *
	 * @return array
	 */
	static public function getTimezone() {
		global $db;
		
		$result = $db->query ( "SELECT " . self::$calendareventsconfig_table . ".config FROM " . self::$calendareventsconfig_table . " WHERE category='timezone'" );
		
		$row = $db->fetchByAssoc ( $result );
		
		return unserialize ( base64_decode ( $row ['config'] ) );
	}
	/**
	 *
	 * @param string $timezone        	
	 */
	static public function saveTimezone($timezone) {
		global $db;
		
		$db->query ( "UPDATE " . self::$calendareventsconfig_table . " SET config='" . $timezone . "' WHERE category='timezone'" );
	}
}