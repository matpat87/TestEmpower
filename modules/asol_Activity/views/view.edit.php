<?php

require_once('include/MVC/View/views/view.edit.php');
 
class asol_ActivityViewEdit extends ViewEdit {
	function asol_ActivityViewEdit() {
		parent::ViewEdit();
	}

	function display() {
		
		parent::display();
		
		// WFM Variable Generator
		echo '<br>';
		echo wfm_reports_utils::managePremiumFeature("openWFMVariableGenerator", "wfm_utils_premium.php", "openWFMVariableGenerator", $extraParams);
	}
}
?>