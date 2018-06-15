<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

global $db, $timedate, $app_list_strings;

// Get System Users & Roles For Current User Environment
$systemUsersAndRoles = wfm_reports_utils::getSystemUsersAndRolesAndNotificationEmails(wfm_domains_utils::wfm_isDomainsInstalled());
$users_opts = $systemUsersAndRoles['users'];
$acl_roles_opts = $systemUsersAndRoles['roles'];
$notificationEmails = $systemUsersAndRoles['notificationEmails'];

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

// BEGIN - Forms

if (wfm_utils::isCommonBaseInstalled()) {

	require_once("modules/asol_Common/include/commonUtils.php");

	if (asol_CommonUtils::isFormsViewsInstalled()) {

		//if (wfm_utils::hasPremiumFeatures()) {

			$form_id = $focus->getAsolFormsIdC();
			
			$form_fields_info = wfm_utils::getFormFields($form_id);
			wfm_utils::wfm_log('asol_debug', '$form_fields_info=['.var_export($form_fields_info, true).']', __FILE__, __METHOD__, __LINE__);
			
			$form_fields = (isset($form_fields_info['fields'])) ? $form_fields_info['fields'] : null;
			$form_fields_labels = (isset($form_fields_info['fields_labels'])) ? $form_fields_info['fields_labels'] : null;
			
			$availableEditableFields = Array(); 
			foreach ($form_fields as $key_field => $value_field) {
				$availableEditableFields[] = Array('reference' => $form_fields[$key_field], 'label' => $form_fields_labels[$key_field]);
			}
			
			wfm_utils::wfm_log('asol_debug', '$availableEditableFields=['.var_export($availableEditableFields, true).']', __FILE__, __METHOD__, __LINE__);
		//}
	}
}

if (wfm_utils::isCommonBaseInstalled()) {
	require_once("modules/asol_Common/include/commonUtils.php");

	if (asol_CommonUtils::isFormsViewsInstalled()) {
		require_once("modules/asol_Forms/include/server/formsUtils.php");
	}
}

// END - Forms
?>

<?php echo $css; ?>
<?php echo $js; ?>

<script	src="modules/asol_Process/___common_WFM/plugins_js_css_images/jsLab/LAB.min.js?version=<?php wfm_utils::echoVersionWFM(); ?>" type="text/javascript"></script>

<script	src="modules/asol_Process/___common_WFM/js/jquery.min.js?version=<?php wfm_utils::echoVersionWFM(); ?>" type="text/javascript"></script>
<script	src="modules/asol_Process/___common_WFM/plugins_js_css_images/jquery.ui/js/jquery.ui.min.js?version=<?php wfm_utils::echoVersionWFM(); ?>" type="text/javascript"></script>
<script type="text/javascript">
	var jQueryWFM = $.noConflict(true);
</script>

<link href="modules/asol_Process/___common_WFM/css/asol_popupHelp.css?version=<?php wfm_utils::echoVersionWFM(); ?>" rel="stylesheet" type="text/css" />
<link href="modules/asol_Process/___common_WFM/css/tabs.css?version=<?php wfm_utils::echoVersionWFM(); ?>" rel="stylesheet" type="text/css" />
<link href="modules/asol_Process/___common_WFM/plugins_js_css_images/jquery.ui/css/jquery.ui.min.css?version=<?php wfm_utils::echoVersionWFM(); ?>" rel="stylesheet" type="text/css" />

<!-- BEGIN  CodeMirror -->
<link href='modules/asol_Process/___common_WFM/plugins_js_css_images/codemirror_php/codemirror.css' rel='stylesheet'>
<script	src='modules/asol_Process/___common_WFM/plugins_js_css_images/codemirror_php/codemirror.js'></script>
<script	src='modules/asol_Process/___common_WFM/plugins_js_css_images/codemirror_php/matchbrackets.js'></script>
<script	src='modules/asol_Process/___common_WFM/plugins_js_css_images/codemirror_php/htmlmixed.js'></script>
<script	src='modules/asol_Process/___common_WFM/plugins_js_css_images/codemirror_php/xml.js'></script>
<script	src='modules/asol_Process/___common_WFM/plugins_js_css_images/codemirror_php/javascript.js'></script>
<script	src='modules/asol_Process/___common_WFM/plugins_js_css_images/codemirror_php/css.js'></script>
<script	src='modules/asol_Process/___common_WFM/plugins_js_css_images/codemirror_php/clike.js'></script>
<script	src='modules/asol_Process/___common_WFM/plugins_js_css_images/codemirror_php/php.js'></script>

<style type='text/css'>
	.CodeMirror {
		border-top: 1px solid black;
		border-bottom: 1px solid black;
		min-width: 625px;
		/*max-width: 625px;*/
		max-height: 500px;
		height: 400px;
	}
	
	.CodeMirror-gutters {
		background-color: wheat;
	}
	
	.CodeMirror-scroll {
		overflow-y: scroll;
		overflow-x: scroll;
	}
</style>
<!-- END  CodeMirror -->

<?php 

wfm_utils::addFormsScripts($availableEditableFields);

?>

<script>

	var codemirror_editor;
	
	var asol_var = new Array();

	asol_var['data_source'] = "<?php echo $data_source; ?>";
	
	asol_var['task_type'] = "<?php echo $task_type; ?>";
	
	asol_var['translateFieldLabels'] = "<?php echo $translateFieldLabels; ?>";
	
	asol_var['_REQUEST'] = Array();
	asol_var['_REQUEST']['module'] = "<?php echo $_REQUEST['module']; ?>";
	asol_var['_REQUEST']['action'] = "<?php echo $_REQUEST['action']; ?>";
	asol_var['_REQUEST']['task_type'] = "<?php echo $_REQUEST['task_type']; ?>";

	asol_var['focus'] = Array();
	asol_var['focus']['task_type'] = "<?php echo $focus->task_type ?>";
	asol_var['focus']['task_implementation'] = "<?php echo $focus->task_implementation; ?>";
	asol_var['task_implementation'] = "<?php echo $task_implementation; ?>";
	
	asol_var['users_opts'] = "<?php echo $users_opts; ?>";
	asol_var['acl_roles_opts'] = "<?php echo $acl_roles_opts; ?>";
	asol_var['notificationEmails'] = "<?php echo $notificationEmails; ?>";
	asol_var['calendar_dateformat'] = "<?php echo $timedate->get_cal_date_format(); ?>";

	asol_var['fields_labels_imploded'] = "<?php echo $fields_labels_imploded; ?>";
	asol_var['fields_type_imploded'] = "<?php echo $fields_type_imploded; ?>";
	asol_var['fields_enum_operators_imploded'] = "<?php echo $fields_enum_operators_imploded; ?>";
	asol_var['fields_enum_references_imploded'] = "<?php echo $fields_enum_references_imploded; ?>";
	asol_var['relate_modules_imploded'] = "<?php echo $relate_modules_imploded; ?>";
	asol_var['is_required_imploded'] = "<?php echo $is_required_imploded; ?>";

	asol_var['rhs_key'] = "<?php echo $rhs_key; ?>";
	asol_var['related_fields_type_imploded'] = "<?php echo $related_fields_type_imploded; ?>";
	asol_var['related_fields_enum_operators_imploded'] = "<?php echo $related_fields_enum_operators_imploded; ?>";
	asol_var['related_fields_enum_references_imploded'] = "<?php echo $related_fields_enum_references_imploded; ?>";

	asol_var['form_language'] = "<?php echo rawurlencode(json_encode($form_language)); ?>";
	asol_var['form_dropdowns'] = "<?php echo rawurlencode(json_encode($form_dropdowns)); ?>";

	loadJqueryScripts();
	
	function main() {
		//alert('ENTRY function  main');
		
		// jQuery-ui
		$.fx.speeds._default = 500;
		$.extend($.ui.dialog.prototype.options, {width: 500, show: "side", hide: "scale"});
		
		$(document).ready(function() {
			//alert("jQuery ready");

			manage_delayVisibility();

			generate_taskImplementation_default_noData('task_type', asol_var['focus']['task_type'], asol_var['users_opts'], asol_var['acl_roles_opts'], asol_var['notificationEmails'], asol_var['calendar_dateformat']);

			if ((asol_var['_REQUEST']['task_type'] == '')) {// If I just got the EditView
				remember_taskImplementation(asol_var['focus']['task_type'], asol_var['focus']['task_implementation']);
			}
			
			if ((asol_var['_REQUEST']['task_type'] == 'create_object')) {// If EditView redirects to EditView with task_type=create_object
				fillRequiredFields('module_values_Table', 'fields', asol_var['fields_labels_imploded'], asol_var['fields_type_imploded'], asol_var['fields_enum_operators_imploded'], asol_var['fields_enum_references_imploded'], asol_var['relate_modules_imploded'], asol_var['is_required_imploded'], asol_var['calendar_dateformat']);
			}

			if ((asol_var['_REQUEST']['task_type'] == 'add_custom_variables')) {
				remember_taskImplementation(asol_var['task_type'], asol_var['task_implementation']);
			}

			if ((asol_var['_REQUEST']['task_type'] == 'get_objects')) {
				remember_taskImplementation(asol_var['task_type'], asol_var['task_implementation']);
			}

			manage_sendEmail();	

			if (asol_var['task_type'] == 'php_custom') {
				php_custom_codemirror();
			}

			buttonSaveOnClick();
	 	});
	}

	function wfm_save() {
		
		save_php_custom(); 
		document.getElementById('task_implementation_hidden').value=format_taskImplementation('task_type');

		return true;
	}

	function save_php_custom() {
		if ($('#task_type').val() == 'php_custom') {
			var php_custom_object = document.getElementById('php_custom');
			if (php_custom_object !== null) {
				php_custom_object.value = codemirror_editor.getValue();
			}
		}
	}
	
	function onChange_task_type(dropdown) {
		window.onbeforeunload = function () {return;};
		switch (dropdown.value) {
			case 'create_object':
			case 'add_custom_variables':
			case 'get_objects':
				$('#objectModule').val('');
				
			case 'modify_object':
				dropdown.form.action.value = "wfeEditView"; 
				dropdown.form.submit(); 
				
				break;
			default:

				visibility_taskImplementation();
				
				generate_taskImplementation_default_noData("task_type", null, asol_var['users_opts'], asol_var['acl_roles_opts'], asol_var['notificationEmails'], asol_var['calendar_dateformat']); 
			
				if (dropdown.value == asol_var['focus']['task_type']) {
					remember_taskImplementation(asol_var['focus']['task_type'], asol_var['focus']['task_implementation']);
				} 

				if (dropdown.value == 'php_custom') {
					php_custom_codemirror();
				}
				
				break;
		}
	}

	function visibility_taskImplementation() {
		
		document.getElementById("task_implementation.default").style.display = "";

		var task_imp_co = document.getElementById("task_implementation.create_modify_object");
		if (task_imp_co !== null) {
			task_imp_co.style.display = "none";
		}
		var task_imp_acv = document.getElementById("task_implementation.add_custom_variables");
		if (task_imp_acv !== null) {
			task_imp_acv.style.display = "none";
		}
		var task_imp_go = document.getElementById("task_implementation.get_objects");
		if (task_imp_go !== null) {
			task_imp_go.style.display = "none";
		}
	}

	function onChange_objectModule(dropdown) {
		window.onbeforeunload = function () {return;}; 
		dropdown.form.module.value = asol_var['_REQUEST']['module'];
		dropdown.form.action.value = asol_var['_REQUEST']['action'];
		dropdown.form.submit();
	}

	function onChange_objectModule_addCustomVariables(dropdown) {
		window.onbeforeunload = function () {return;}; 
		dropdown.form.module.value = asol_var['_REQUEST']['module'];
		dropdown.form.action.value = asol_var['_REQUEST']['action'];
		dropdown.form.task_implementation_hidden.value = format_taskImplementation('task_type');
		dropdown.form.submit();
	}

	function createModifyObject_onClick_addFields() {
		insertObjectField('module_values_Table', 'fields', asol_var['fields_labels_imploded'], asol_var['fields_type_imploded'], asol_var['fields_enum_operators_imploded'], asol_var['fields_enum_references_imploded'], asol_var['relate_modules_imploded'], asol_var['is_required_imploded'], asol_var['calendar_dateformat']);
	}

	function createModifyObject_onClick_addRelationships() {
		insertRelationships('relationshipsTable', 'relationshipsSelect');
	}

	function fields_onClick(dropdownlist) {
		if (dropdownlist.options[dropdownlist.selectedIndex].style.color == 'blue') { 
			document.getElementById('show_related_button').style.display = 'inline';
		} else {
			document.getElementById('show_related_button').style.display = 'none';
		}
	}

	function fields_onDblClick(dropdown) {
		window.onbeforeunload = function () {
			return;
		}; 
		if (dropdown[dropdown.selectedIndex].style.color == 'blue') { 
			dropdown.form.action.value = asol_var['_REQUEST']['action'];
			dropdown.form.rhs_key.value = dropdown.value;
			dropdown.form.task_implementation_hidden.value = format_taskImplementation('task_type');
			dropdown.form.submit();
		}
	}

	function onClick_addFields_button() {

		var custom_variable_get_objects_name_input = document.getElementById('custom_variable_get_objects_name');

		if (custom_variable_get_objects_name_input !== null) {
			InsertConditions('conditions_Table', 'fields', asol_var['fields_labels_imploded'], asol_var['fields_type_imploded'], asol_var['fields_enum_operators_imploded'], asol_var['fields_enum_references_imploded'], null, asol_var['rhs_key'], asol_var['related_fields_type_imploded'], asol_var['related_fields_enum_operators_imploded'], asol_var['related_fields_enum_references_imploded'], asol_var['calendar_dateformat']);
		} else {
			insertCustomVariables('acv_Table', 'fields', asol_var['fields_labels_imploded'], asol_var['fields_type_imploded'], asol_var['fields_enum_operators_imploded'], asol_var['fields_enum_references_imploded'], null, asol_var['rhs_key'], asol_var['related_fields_type_imploded'], asol_var['related_fields_enum_operators_imploded'], asol_var['related_fields_enum_references_imploded'], asol_var['calendar_dateformat']);
		}
	}

	function onClick_addRelatedFields_button() {

		var custom_variable_get_objects_name_input = document.getElementById('custom_variable_get_objects_name');

		if (custom_variable_get_objects_name_input !== null) {
			InsertConditions('conditions_Table', null, asol_var['fields_labels_imploded'], asol_var['fields_type_imploded'], asol_var['fields_enum_operators_imploded'], asol_var['fields_enum_references_imploded'], 'related_fields', asol_var['rhs_key'], asol_var['related_fields_type_imploded'], asol_var['related_fields_enum_operators_imploded'], asol_var['related_fields_enum_references_imploded'], asol_var['calendar_dateformat']);
		} else {
			insertCustomVariables('acv_Table', null, asol_var['fields_labels_imploded'], asol_var['fields_type_imploded'], asol_var['fields_enum_operators_imploded'], asol_var['fields_enum_references_imploded'], 'related_fields', asol_var['rhs_key'], asol_var['related_fields_type_imploded'], asol_var['related_fields_enum_operators_imploded'], asol_var['related_fields_enum_references_imploded'], asol_var['calendar_dateformat']);
		}
	}

	function onClick_addNotAField_button() {
		addCustomVariable_from_notAField('acv_Table');
	}

	function onClick_addFormFields_button() {
		insertCustomVariables('acv_Table', 'fields', asol_var['fields_labels_imploded'], asol_var['fields_type_imploded'], asol_var['fields_enum_operators_imploded'], asol_var['fields_enum_references_imploded'], 'related_fields', asol_var['rhs_key'], asol_var['related_fields_type_imploded'], asol_var['related_fields_enum_operators_imploded'], asol_var['related_fields_enum_references_imploded'], asol_var['calendar_dateformat']);
	}
	
	////////////////////////////////////////////////
	////////////////////////////////////////////////
	
	function manage_sendEmail() {
		
		// initialization when DOM is ready
		send_email_select_all();

		$("#task_type").change(function() {
			if ($("#task_type").val() == "send_email") {
				send_email_select_all();
			}
		});

		// when clicking the tabs
		jQueryWFM("#a_all").live('click', function() {
			refresh_to_cc_bcc_readonly();
			send_email_select_all();
		});
		jQueryWFM("#a_to").live('click', function() {
			send_email_select_to();
		});
		jQueryWFM("#a_cc").live('click', function() {
			send_email_select_cc();
		});
		jQueryWFM("#a_bcc").live('click', function() {
			send_email_select_bcc();
		});
	}
	
	function manage_delayVisibility() {
		delayVisibility($("#delay_type").val());
		
		$("#delay_type").change(function () {
			delayVisibility($(this).val());

			// If you choose delay_type=no_delay then set delay to zero
			if ($("#delay_type").val() == 'no_delay') {
				$("#time").val('minutes');
				$("#time_amount").val('0');
			}
		});
	}
	
	// If you choose delay_type=no_delay then time-dropwdowns must be hidden
	function delayVisibility(value) {
		switch (value) {
			case 'no_delay':
				$("#delay_label, #time, #time_amount").css('visibility', 'hidden');
				$("#date_label, #date_field").css('visibility', 'hidden');
				break;
			case 'on_creation':
			case 'on_modification':
			case 'on_finish_previous_task':
				$("#delay_label, #time, #time_amount").css('visibility', 'visible');
				$("#date_label, #date_field").css('visibility', 'hidden');
				break;
			case 'on_date':
				$("#delay_label, #time, #time_amount").css('visibility', 'hidden');
				$("#date_label, #date_field").css('visibility', 'visible');
				break;
		}
	}

	function send_email_select_all() {
		$("#a_all").addClass("active");
		$("#a_to").removeClass("active");
		$("#a_cc").removeClass("active");
		$("#a_bcc").removeClass("active");

		$("#a_all").parent().addClass("selected");
		$("#a_to").parent().removeClass("selected");
		$("#a_cc").parent().removeClass("selected");
		$("#a_bcc").parent().removeClass("selected");
		
		
		$("#all").addClass("active");
		$("#all").removeClass("inactive");

		$("#to").addClass("inactive");
		$("#to").removeClass("active");

		$("#cc").addClass("inactive");
		$("#cc").removeClass("active");

		$("#bcc").addClass("inactive");
		$("#bcc").removeClass("active");
	}

	function send_email_select_to() {
		$("#a_all").removeClass("active");
		$("#a_to").addClass("active");
		$("#a_cc").removeClass("active");
		$("#a_bcc").removeClass("active");

		$("#a_all").parent().removeClass("selected");
		$("#a_to").parent().addClass("selected");
		$("#a_cc").parent().removeClass("selected");
		$("#a_bcc").parent().removeClass("selected");

		
		$("#all").addClass("inactive");
		$("#all").removeClass("active");

		$("#to").addClass("active");
		$("#to").removeClass("inactive");

		$("#cc").addClass("inactive");
		$("#cc").removeClass("active");

		$("#bcc").addClass("inactive");
		$("#bcc").removeClass("active");
	}

	function send_email_select_cc() {
		$("#a_all").removeClass("active");
		$("#a_to").removeClass("active");
		$("#a_cc").addClass("active");
		$("#a_bcc").removeClass("active");

		$("#a_all").parent().removeClass("selected");
		$("#a_to").parent().removeClass("selected");
		$("#a_cc").parent().addClass("selected");
		$("#a_bcc").parent().removeClass("selected");


		$("#all").addClass("inactive");
		$("#all").removeClass("active");

		$("#to").addClass("inactive");
		$("#to").removeClass("active");

		$("#cc").addClass("active");
		$("#cc").removeClass("inactive");

		$("#bcc").addClass("inactive");
		$("#bcc").removeClass("active");
	}

	function send_email_select_bcc() {
		$("#a_all").removeClass("active");
		$("#a_to").removeClass("active");
		$("#a_cc").removeClass("active");
		$("#a_bcc").addClass("active");

		$("#a_all").parent().removeClass("selected");
		$("#a_to").parent().removeClass("selected");
		$("#a_cc").parent().removeClass("selected");
		$("#a_bcc").parent().addClass("selected");

		
		$("#all").addClass("inactive");
		$("#all").removeClass("active");

		$("#to").addClass("inactive");
		$("#to").removeClass("active");

		$("#cc").addClass("inactive");
		$("#cc").removeClass("active");

		$("#bcc").addClass("active");
		$("#bcc").removeClass("inactive");
	}	
	
	function refresh_to_cc_bcc_readonly() {
		var to_cc_bcc = {0:'to', 1:'cc', 2:'bcc'};
		for (var index in to_cc_bcc) {
			var users_roles_notificationEmails = {0:'users', 1:'roles', 2:'notificationEmails'};
			for (var index2 in users_roles_notificationEmails) {
				var selected_options = $.map($("#email_"+users_roles_notificationEmails[index2]+"_for_"+to_cc_bcc[index]+" option:selected"), function(e) { return $(e).text(); })
				$("#email_"+users_roles_notificationEmails[index2]+"_for_"+to_cc_bcc[index]+"_readonly").val(selected_options.join(","));
			}
			$("#email_list_for_"+to_cc_bcc[index]+"_readonly").val($("#email_list_for_"+to_cc_bcc[index]).val());
		}
	}

	function php_custom_codemirror() {
    	codemirror_editor = CodeMirror.fromTextArea(document.getElementById("php_custom"), {
	        lineNumbers: true,
	        matchBrackets: true,
	        mode: "application/x-httpd-php",
	        indentUnit: 4,
	        indentWithTabs: true,
	        enterMode: "keep",
	        tabMode: "shift",
	        autofocus: true
        });
	}
	
</script>

<?php
require_once("modules/asol_Process/___common_WFM/php/javascript_common_activity_task.php");
require_once("modules/asol_Process/___common_WFM/php/javascript_common_event_activity_task.php");
?>