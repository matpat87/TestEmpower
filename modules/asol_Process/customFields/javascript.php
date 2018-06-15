<?php 
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

// Get sugarcrm Theme
if ($_REQUEST['sugar_body_only'] == 'true') {
	$_SESSION['sugar_body_only'] = true;
	
	$themeObject = SugarThemeRegistry::current();
	$css = $themeObject->getCSS();
	$js = $themeObject->getJS();
} else {
	$_SESSION['sugar_body_only'] = false;
	
	$css = '';
	$js = '';
}

?>

<?php echo $css; ?>
<?php echo $js; ?>

<script src="modules/asol_Process/___common_WFM/plugins_js_css_images/jsLab/LAB.min.js?version=<?php wfm_utils::echoVersionWFM(); ?>" type="text/javascript"></script>

<link href="modules/asol_Process/___common_WFM/css/asol_popupHelp.css?version=<?php wfm_utils::echoVersionWFM(); ?>" rel="stylesheet" type="text/css" />
<link href="modules/asol_Process/___common_WFM/plugins_js_css_images/jquery.ui/css/jquery.ui.min.css?version=<?php wfm_utils::echoVersionWFM(); ?>" rel="stylesheet" type="text/css" />

<script>

	var asol_var = new Array();
	asol_var['_REQUEST'] = Array();
	asol_var['_REQUEST']['action'] = "<?php echo $_REQUEST['action']; ?>";
	asol_var['data_source'] = "<?php echo $data_source; ?>";

	loadJqueryScripts();
	
	function main() {
		//alert("JQuery is now loaded");
		
		// jQuery-ui
		$.fx.speeds._default = 500;
		$.extend($.ui.dialog.prototype.options, {width: 500, show: "side", hide: "scale"});
		
		$(document).ready(function() {

			switch (asol_var['data_source']) {
				case 'database':
					visibility_data_source_database();
					break;
				case 'form':
					visibility_data_source_form();
					break;
				default:
					visibility_data_source_database();
			}
						
			$("select#data_source").change(function () {
				switch ($(this).val()) {
					case 'database':
						visibility_data_source_database();
						break;
					case 'form':
						visibility_data_source_form();
						break;
				}
			});

			buttonSaveOnClick();
			
		});
	}

	function wfm_save() {
		return true;
	}

	function onChange_alternativeDatabase(dropdownlist) {
		window.onbeforeunload = function () {
			return;
		};
		
		dropdownlist.form.action.value = asol_var['_REQUEST']['action'];
		dropdownlist.form.submit();
	}

	function visibility_data_source_database() {

		$("div#LBL_DB_CONFIGURATION_PANEL").css("display", "block"); /*For sugarcrm 641*/
		$("#detailpanel_2").css("display", "block"); /*As of sugarcrm 655*/

		$("div#LBL_FORM_PANEL").css("display", "none"); /*For sugarcrm 641*/
		$("#detailpanel_3").css("display", "none"); /*As of sugarcrm 655*/
		
	}

	function visibility_data_source_form() {

		$("div#LBL_DB_CONFIGURATION_PANEL").css("display", "none"); /*For sugarcrm 641*/
		$("#detailpanel_2").css("display", "none"); /*As of sugarcrm 655*/

		$("div#LBL_FORM_PANEL").css("display", "block"); /*For sugarcrm 641*/
		$("#detailpanel_3").css("display", "block"); /*As of sugarcrm 655*/
		
	}
	
</script>	