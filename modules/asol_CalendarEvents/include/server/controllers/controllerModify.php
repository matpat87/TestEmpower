<?php
/**
 * @author AlineaSol
 */
class asol_ControllerModify {
	/**
	 *
	 * @method It shows view modify
	 * @return string if an error
	 */
	static public function display() {
		require_once ("modules/asol_Common/include/commonUtils.php");
		require_once ("modules/asol_CalendarEvents/include/server/models/configCRUD.php");
		
		global $current_language, $sugar_config;
		
		$type = $_REQUEST ['eventType'];
		
		if ($type == "")
			return "There was an error";
		
		$model = new asol_CalendarEvents ();
		$existDomains = asol_CommonUtils::isDomainsInstalled ();
		$language = asol_ConfigCRUD::getLanguage ();
		$structure = asol_ConfigCRUD::getStructure ();
		
		require_once ("modules/asol_CalendarEvents/include/server/views/viewModify.php");
	}
}