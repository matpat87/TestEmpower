<?php
/**
 * @author AlineaSol
 */
class asol_ControllerCreate {
	/**
	 *
	 * @method It shows creation view
	 */
	static public function display() {
		require_once ("modules/asol_Common/include/commonUtils.php");
		
		global $sugar_config;
		
		$customFields = array ();
		$existDomains = asol_CommonUtils::isDomainsInstalled ();
		
		if (! $existDomains) {
			$model = new asol_CalendarEvents ();
			
			foreach ( $model->field_defs as $key => $value ) {
				if ($value ["source"] == "custom_fields")
					$customFields [$key] = $value ["labelValue"];
			}
		}
		
		require_once ("modules/asol_CalendarEvents/include/server/views/viewCreate.php");
	}
}
