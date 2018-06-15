<?php

require_once("data/SugarBean.php");
require_once("include/SugarEmailAddress/SugarEmailAddress.php");

class wfm_utils {

	static $common_version = '2.4';
	static $error_reporting_level = E_ERROR;
	static $wfm_edition = 'Community'; // Community/Enterprise
	static $wfm_release_version = '5.16.1';
	static $wfm_code_version = 'D20170222T1100'; // php, js, css, ...
	static $wfm_db_structure_version = 6;
	static $wfm_workflows_version = 6;

	static function set_error_reporting_level () {
		error_reporting(self::$error_reporting_level);
	}
	
	static function echoVersionWFM() {

		echo self::$wfm_code_version;
	}

	static function wfm_log($logLevel, $logText, $file, $function=null, $line=null) {

		global $sugar_config;

		switch ($logLevel) {
			case 'flow_debug':
				$logLevel = (isset($sugar_config['WFM_changeLogLevelFromFlowDebugTo'])) ? $sugar_config['WFM_changeLogLevelFromFlowDebugTo'] : 'debug';
				break;
			case 'asol_debug':
				$logLevel = (isset($sugar_config['WFM_changeLogLevelFromAsolDebugTo'])) ? $sugar_config['WFM_changeLogLevelFromAsolDebugTo'] : 'debug';
				break;
			case 'asol':
				$asolLogLevelEnabled = ((isset($sugar_config['asolLogLevelEnabled'])) && ($sugar_config['asolLogLevelEnabled'] == true)) ? true : false;
				$logLevel = ($asolLogLevelEnabled) ? 'asol' : 'debug';

				$logLevel = (isset($sugar_config['WFM_changeLogLevelFromAsolTo'])) ? $sugar_config['WFM_changeLogLevelFromAsolTo'] : $logLevel;
				break;
		}

		$wfm_log_prefix = "**********[ASOL][WFM][".session_id()."]";

		if (($logLevel == 'debug') && ($sugar_config['logger']['level'] != 'debug')) {
		} else {
			
			$log_trace = $wfm_log_prefix.': '.pathinfo($file, PATHINFO_BASENAME)."[$line]->".$function.': '.$logText;
			
			$WFM_log_to_independent_file = ((isset($sugar_config['WFM_log_to_independent_file'])) && ($sugar_config['WFM_log_to_independent_file'] == true)) ? true : false;
			
			if ($WFM_log_to_independent_file) {
				require_once('modules/asol_Process/___common_WFM/php/wfm_logger.php');
				$wfm_log = new wfm_logger();
				$wfm_log->log($logLevel, $log_trace);
			} else {
				$GLOBALS['log']->$logLevel($log_trace);
			}
		}
	}

	static function wfm_echo($type, $text) {

		$gmdate = "<code style='color: green'>(gmdate=[".gmdate('Y-m-d H:i:s')."])</code>";

		$session_id = "<code style='color: blue'>[".session_id()."]</code>";

		switch ($type) {
			case 'crontab':
				if ($_REQUEST['execution_type'] != "crontab") {
					break;
				}
				echo "<br>$gmdate$session_id $text";
				break;

			default:
				echo "<br>$gmdate $text";
		}
	}

	static function wfm_curl($type, $submit_url, $query_string, $exit, $timeout) {

		global $sugar_config;

		if ($submit_url == null) {
			// set URL
			// Url sintax : scheme://username:password@domain:port/path?query_string#fragment_id
			$site_url = (isset($sugar_config['WFM_site_url'])) ? $sugar_config['WFM_site_url'] : $sugar_config['site_url'];
			$site_url .= '/';
			$submit_url = $site_url."index.php";
		}

		switch ($type) {
			case 'post':

				// cURL by means of POST
				$curl = curl_init();

				curl_setopt($curl, CURLOPT_URL, $submit_url); // The URL to fetch. This can also be set when initializing a session with curl_init().
				curl_setopt($curl, CURLOPT_POST, true); // TRUE to do a regular HTTP POST.
				curl_setopt($curl, CURLOPT_POSTFIELDS, $query_string); // The full data to post in a HTTP "POST" operation.
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // FALSE to stop cURL from verifying the peer's certificate.

				if ($timeout != null) {


					//curl_setopt($curl, /*CURLOPT_RETURNTRANSFER*/ 19913, true);
					//curl_setopt($curl, /*CURLOPT_NOSIGNAL*/ 99, 1);
					//curl_setopt($curl, /*CURLOPT_TIMEOUT_MS*/ 155, 100);
					//curl_setopt($curl, /*CURLOPT_CONNECTTIMEOUT_MS */ 156, 40);


					//curl_setopt($curl, CURLOPT_TIMEOUT_MS, $timeout); // Added in cURL 7.16.2. Available since PHP 5.2.3. // The maximum number of milliseconds to allow cURL functions to execute. If libcurl is built to use the standard system name resolver, that portion of the connect will still use full-second resolution for timeouts with a minimum timeout allowed of one second.
					//curl_setopt($curl, CURLOPT_CONNECTTIMEOUT_MS, $timeout); // Added in cURL 7.16.2. Available since PHP 5.2.3. // The number of milliseconds to wait while trying to connect. Use 0 to wait indefinitely. If libcurl is built to use the standard system name resolver, that portion of the connect will still use full-second resolution for timeouts with a minimum timeout allowed of one second.

					curl_setopt($curl, CURLOPT_TIMEOUT, $timeout); // The maximum number of seconds to allow cURL functions to execute.
					curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout); // The number of seconds to wait while trying to connect. Use 0 to wait indefinitely.
				}

				if (isset($sugar_config['WFM_site_login_username_password'])) { // Basic Authentication (Site Login)
					curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC) ; // The HTTP authentication method(s) to use.
					//curl_setopt($curl, CURLOPT_SSLVERSION, 3);
					//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
					//curl_setopt($curl, CURLOPT_HEADER, true);
					//curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					//curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
					curl_setopt($curl, CURLOPT_USERPWD, $sugar_config['WFM_site_login_username_password']); // A username and password formatted as "[username]:[password]" to use for the connection.
					self::wfm_log('debug', "cURL -> Basic Authentication (Site Login) =[".$sugar_config['WFM_site_login_username_password']."]", __FILE__, __METHOD__, __LINE__);
				}

				self::wfm_log('debug', "cURL=[".$site_url."index.php?".$query_string."]", __FILE__, __METHOD__, __LINE__);
				curl_exec($curl);
				self::wfm_log('debug', "curl_getinfo=[".print_r(curl_getinfo($curl),true)."]", __FILE__, __METHOD__, __LINE__);

				if(curl_errno($curl)) {
					self::wfm_log('debug', " curl_errno=[".print_r(curl_errno($curl),true)."]", __FILE__, __METHOD__, __LINE__);
				}

				curl_close($curl);
				self::wfm_log('debug', "EXIT cURL REQUEST*******************************************", __FILE__, __METHOD__, __LINE__);

				break;

			case 'get':

				// cURL by means of GET
				/*$ch = curl_init();
				 curl_setopt($ch, CURLOPT_URL, $site_url."index.php?entryPoint=wfm_engine&trigger_module=".$trigger_module."&trigger_event=".$trigger_event."&bean_id=".$bean_id."&current_user_id=".$current_user->id."&bean_ungreedy_count=".$bean_ungreedy_count."&old_bean=".$urlencode_serialized_old_bean."&new_bean=".$urlencode_serialized_new_bean."&execution_type=logic_hook");
				 self::wfm_log('debug', "*****site_url*******cURL=".$site_url."index.php?entryPoint=wfm_engine&trigger_module=".$trigger_module."&trigger_event=".$trigger_event."&bean_id=".$bean_id."&current_user_id=".$current_user->id."&bean_ungreedy_count=".$bean_ungreedy_count."&old_bean=".$urlencode_serialized_old_bean."&new_bean=".$urlencode_serialized_new_bean."&execution_type=logic_hook****************", __FILE__, __METHOD__, __LINE__);

				 curl_setopt($ch, CURLOPT_HEADER, 0);
				 curl_setopt($ch, CURLOPT_TIMEOUT, 1);

				 curl_exec($ch);

				 // close cURL resource, and free up system resources
				 curl_close($ch);*/

				break;
		}

		if ($exit) {
			exit();
		}
	}

	static function wfm_generate_field_input($field_name, $field_value, $size=30, $class='', $style='') {
		return "<input type='text' accesskey='7' title='' value='{$field_value}' maxlength='255' size='{$size}' id='{$field_name}' name='{$field_name}' class='{$class}' style='{$style}' />";
	}
	
	static function wfm_generate_field_relate($fieldId_name, $fieldId_value, $fieldName_name, $fieldName_value, $module, $disabled) {
		self::wfm_log('asol_debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);
		
		// FIXME
		
		$version = self::$wfm_code_version;
		
		$button_select = "
			<button type='button' id='btn_{$fieldName_name}' name='btn_{$fieldName_name}' tabindex='0' title='Select' class='button firstChild' value='Select' onclick='open_popup(\"{$module}\", 600, 400, \"\", true, false, {\"call_back_function\":\"set_return\",\"form_name\":\"EditView\",\"field_to_name_array\":{\"id\":\"{$fieldId_name}\",\"name\":\"{$fieldName_name}\"}}, \"single\", true);'>
				<img src='themes/default/images/id-ff-select.png?v={$version}' />
			</button>	
		";
		
		$button_view = "
			<button type='button' id='btn_open_{$fieldName_name}' name='btn_open_{$fieldName_name}' onclick='openSelectedItemInPopup(document.getElementById(\"{$fieldId_name}\").value, \"{$module}\", 100, 100);' value='Select' class='button firstChild'>
				<img src='modules/asol_Process/___common_WFM/images/open_item_14.png?v={$version}' />
			</button>
		";
		
		$button_remove = "
			<button type='button' id='btn_clr_{$fieldName_name}' name='btn_clr_{$fieldName_name}' onclick='document.getElementById(\"{$fieldName_name}\").value =\"\"; document.getElementById(\"{$fieldId_name}\").value = \"\";' tabindex='0' title='Clear Selection' class='button lastChild' value='Clear Selection'>
				<img src='themes/default/images/id-ff-clear.png?v={$version}' />
			</button>
		";
		
		if ($disabled) {
			$input_name_disabled = 'disabled';
			$buttons = $button_view;
		} else {
			$input_name_disabled = '';
			$buttons = $button_select . $button_view . $button_remove;
		}
		
		$relate = "
			<input {$input_name_disabled} type='text' id='{$fieldName_name}' name='{$fieldName_name}' value='{$fieldName_value}'  title='{$fieldName_value}' ondblclick='' onmouseover='this.title=this.value;' class='sqsEnabled yui-ac-input' tabindex='0' size='' autocomplete='off' />
			<input type='hidden' id='{$fieldId_name}' name='{$fieldId_name}' value='{$fieldId_value}' />
			<span class='id-ff multiple'>
				$buttons
			</span>
		";
		
		return $relate;
		
	}

	static function wfm_generate_field_select($dropdownlist_key, $field_name, $field_value, $onChange, $disabled) {

		global $app_list_strings;

		$select = "<select id='{$field_name}' name='{$field_name}' onChange='{$onChange}' {$disabled}>";
		foreach ($app_list_strings[$dropdownlist_key] as $key => $value) {
			$value =  (isset($app_list_strings[$dropdownlist_key][$key])) ? $app_list_strings[$dropdownlist_key][$key] : $key; // If language not defined
			$selected = ($field_value == $key) ? 'selected' : '';
			$select .= "<option onmouseover='this.title=this.innerHTML;' value='{$key}' {$selected}>{$value}</option>";
		}
		$select .= "</select>";

		return $select;
	}
	
	static function wfm_generate_field_checkbox($field_name, $field_value, $disabled, $onClick='') {
	
		global $app_list_strings;
	
		$checked = ($field_value) ? 'checked' : '';
		
		if (empty($disabled)) { // if not disabled
			$checkbox = "<input type='hidden' name='{$field_name}' value='0'> ";
			$checkbox .= "<input type='checkbox' id='{$field_name}' name='{$field_name}' value='1' {$disabled} {$checked} onclick='{$onClick}'/>";
		} else {
			$checkbox = "<input type='checkbox' id='{$field_name}' name='{$field_name}' value='1' {$disabled} {$checked} />";
			$checkbox .= "<input type='hidden' name='{$field_name}' value='{$field_value}'> ";
		}
		return $checkbox;
	}

	static function wfm_generate_alternativeDB_select($array, $field_name, $field_value, $onChange, $disabled) {

		$select = "<select id='{$field_name}' name='{$field_name}' onChange='{$onChange}' {$disabled}>";
		$select .= "<option onmouseover='this.title=this.innerHTML;' value='-1'>".translate('LBL_REPORT_NATIVE_DB', 'asol_Process')."</option>";
		if ($array != null) {
			foreach ($array as $key => $value) {
				$value =  (isset($array[$key])) ? $array[$key] : $key; // If language not defined
				$selected = ($field_value == $key) ? 'selected' : '';
				$select .= "<option onmouseover='this.title=this.innerHTML;' value='{$key}' {$selected}>{$value}</option>";
			}
		}
		$select .= "</select>";

		return $select;
	}

	static function wfm_generate_alternativeDBtable_select($array, $field_name, $field_value, $onChange, $disabled) {

		$select = "<select id='{$field_name}' name='{$field_name}' onChange='{$onChange}' {$disabled}>";
		foreach ($array as $value) {
			$selected = ($field_value == $value) ? 'selected' : '';
			$select .= "<option onmouseover='this.title=this.innerHTML;' value='{$value}' {$selected}>{$value}</option>";
		}
		$select .= "</select>";

		return $select;
	}

	static function wfm_generate_select($array, $field_name, $field_value, $onChange, $disabled) {

		$select = "<select id='{$field_name}' name='{$field_name}' onChange='{$onChange}' {$disabled}>";
		foreach ($array as $key => $value) {
			$value =  (isset($array[$key])) ? $array[$key] : $key; // If language not defined
			$selected = ($field_value == $key) ? 'selected' : '';
			$select .= "<option onmouseover='this.title=this.innerHTML;' value='{$key}' {$selected}>{$value}</option>";
		}
		$select .= "</select>";

		return $select;
	}

	static function wfm_generate_trigger_event_select($trigger_module, $field_name, $field_value, $onChange, $disabled, $data_source) {

		global $app_list_strings;
		
		$dropdownlist_key = 'wfm_trigger_event_list';
		$dropdownlist_key_2 = 'wfm_trigger_event_list_not_users';
		$dropdownlist_key_3 = 'wfm_trigger_event_list_for_data_source_form';

		$select = "<select id='{$field_name}' name='{$field_name}' onChange='{$onChange}' {$disabled}>";
		
		if ($data_source == 'form') {
			foreach ($app_list_strings[$dropdownlist_key_3] as $key => $value) {
				$value =  (isset($app_list_strings[$dropdownlist_key_3][$key])) ? $app_list_strings[$dropdownlist_key_3][$key] : $key; // If language not defined
				$selected = ($field_value == $key) ? 'selected' : '';
				$select .= "<option onmouseover='this.title=this.innerHTML;' value='{$key}' {$selected}>{$value}</option>";
			}
		} else {

			if ($trigger_module == 'Users') {
				foreach ($app_list_strings[$dropdownlist_key] as $key => $value) {
					$value =  (isset($app_list_strings[$dropdownlist_key][$key])) ? $app_list_strings[$dropdownlist_key][$key] : $key; // If language not defined
					$selected = ($field_value == $key) ? 'selected' : '';
					$select .= "<option onmouseover='this.title=this.innerHTML;' value='{$key}' {$selected}>{$value}</option>";
				}
			} else {
				foreach ($app_list_strings[$dropdownlist_key_2] as $key => $value) {
					$value =  (isset($app_list_strings[$dropdownlist_key_2][$key])) ? $app_list_strings[$dropdownlist_key_2][$key] : $key; // If language not defined
					$selected = ($field_value == $key) ? 'selected' : '';
					$select .= "<option onmouseover='this.title=this.innerHTML;' value='{$key}' {$selected}>{$value}</option>";
				}
			}
		}
		
		$select .= "</select>";

		return $select;
	}

	static function wfm_generate_field_module_select($field_name, $field_value, $onChange, $disabled) {

		global $current_user, $app_list_strings;

		// Get modules that the current_user can access
		$acl_modules = ACLAction::getUserActions($current_user->id);

		$modules = Array();
		foreach($acl_modules as $key => $mod){
			if ($mod['module']['access']['aclaccess'] >= 0) {
				$modules[$key] = (isset($app_list_strings['moduleList'][$key])) ? $app_list_strings['moduleList'][$key] : $key;  // If language not defined
			}
		}
		asort($modules);

		// Generate select
		$select = "<select id='{$field_name}' name='{$field_name}' onChange='{$onChange}' {$disabled}>";
		$select .= "<option onmouseover='this.title=this.innerHTML;' value=''></option>";
		foreach ($modules as $key => $value) {
			$selected = ($field_value == $key) ? 'selected' : '';
			$select .= "<option onmouseover='this.title=this.innerHTML;' value='{$key}' {$selected}>{$value}</option>";
		}
		$select .= "</select>";

		return $select;
	}

	static function generateSelectOptions($array) {

		$options = "";
		foreach ($array as $key => $value) {
			$options .= "<option onmouseover='this.title=this.innerHTML;' value='{$value}'>{$value}</option>";
		}

		return $options;
	}

	static function wfm_generate_moduleFields_selectFields($fields, $rhs_key, $has_related, $fields_labels, $fields_labels_key, $multiple, $show_idRelationships) {

		$fieldsSelect = "<select id='fields' name='fields' onclick='fields_onClick(this);' onDblClick='fields_onDblClick(this);' {$multiple} size=10 style='width:178px'>";
		if (empty($fields)) {
			$fields = Array();
		}
		foreach ($fields as $fieldK => $field) {
			if ( ($has_related[$fieldK] == "true") && (($field != 'id') || (($field == 'id')&&($show_idRelationships))) ) {
				$style = "style='color:blue;'";
				$plus = ' +';
				$selected = ($rhs_key == $field) ? 'selected' : '';
			} else  {
				$style = '';
				$plus = '';
				$selected = '';
			}

			$title = "generateTitleForFieldName(\"{$fields_labels[$fieldK]}\", \"{$field}\", \"\")";

			$fieldsSelect .= "<option onmouseover='this.title = {$title};' {$style} value='{$field}' title='' label_key='{$fields_labels_key[$fieldK]}' {$selected}>{$fields_labels[$fieldK]}{$plus}</option>";
		}
		$fieldsSelect .= '</select>';

		return $fieldsSelect;
	}
	
	static function wfm_generate_formFields_selectFields($fields, $rhs_key, $has_related, $fields_labels, $fields_labels_key, $multiple, $show_idRelationships) {
	
		$fieldsSelect = "<select id='fields' name='fields' {$multiple} size=10 style='width:178px'>";
		if (empty($fields)) {
			$fields = Array();
		}
		foreach ($fields as $fieldK => $field) {
			if ( ($has_related[$fieldK] == "true") && (($field != 'id') || (($field == 'id')&&($show_idRelationships))) ) {
				$style = "style='color:blue;'";
				$plus = ' +';
				$selected = ($rhs_key == $field) ? 'selected' : '';
			} else  {
				$style = '';
				$plus = '';
				$selected = '';
			}
	
			$title = "generateTitleForFieldName(\"{$fields_labels[$fieldK]}\", \"{$field}\", \"\")";
	
			$fieldsSelect .= "<option onmouseover='this.title = {$title};' {$style} value='{$field}' title='' label_key='{$fields_labels_key[$fieldK]}' {$selected}>{$fields_labels[$fieldK]}{$plus}</option>";
		}
		$fieldsSelect .= '</select>';
	
		return $fieldsSelect;
	}

	static function wfm_generate_moduleFields_selectFields_isrequired($fields, $rhs_key, $is_required, $fields_labels, $fields_labels_key, $multiple) {

		$fieldsSelect = "<select id='fields' name='fields' onclick='' onDblClick='' {$multiple} size=10 style='width:178px'>";
		if (empty($fields)) {
			$fields = Array();
		}
		foreach ($fields as $fieldK => $field) {
			if ($is_required[$fieldK] == "true") {
				$asterisk = ' *';
				$selected = ($rhs_key == $field) ? 'selected' : '';
			} else  {
				$asterisk = '';
				$selected = '';
			}

			$title = "generateTitleForFieldName(\"{$fields_labels[$fieldK]}\", \"{$field}\", \"\")";

			$fieldsSelect .= "<option onmouseover='this.title = {$title};' value='{$field}' title='{$field}' label_key='{$fields_labels_key[$fieldK]}' {$selected}>{$fields_labels[$fieldK]}{$asterisk}</option>";
		}
		$fieldsSelect .= '</select>';

		return $fieldsSelect;
	}

	static function generateHtmlRelationshipsSelect($labels, $names, $vnames, $relationships, $moduleLabels, $modules, $multiple) {

		$select = "<select id='relationshipsSelect' name='relationshipsSelect' onclick='' onDblClick='' multiple='' size=10 style='width:178px'>";
		if (empty($names)) {
			$names = Array();
		}
		foreach ($names as $key => $name) {
			if (empty($names[$key]) || empty($modules[$key])) {
				continue;
			}

			$select .= "<option onmouseover='this.title=this.innerHTML;' value='{$names[$key]}' label='{$labels[$key]}' relationship='{$relationships[$key]}' module='{$modules[$key]}' vname='{$vnames[$key]}' > {$labels[$key]} ({$moduleLabels[$key]}) [{$relationships[$key]}] </option>";
		}
		$select .= '</select>';

		return $select;
	}

	static function getRelationshipsInfo($module) {
		global $beanList, $app_list_strings;

		if ($module != '') {
			if(isset($beanList[$module]) && $beanList[$module]){
				$mod = new $beanList[$module]();
				$getLinkedFields = $mod->get_linked_fields();
				wfm_utils::wfm_log('flow_debug', '$getLinkedFields=['.var_export($getLinkedFields, true).']', __FILE__, __METHOD__, __LINE__);
					
				foreach($getLinkedFields as $relationship){
					$names[] = $relationship['name'];
					$relationships[] = $relationship['relationship'];
					if (!empty($relationship['module'])) {
						$relationshipModule = $relationship['module'];
					} else {
						if($mod->load_relationship($relationship['name'])){
							$relationshipModule = $mod->$relationship['name']->getRelatedModuleName();
						} else {
							$relationshipModule = '';
						}
					}
					$modules[] = $relationshipModule;
					$moduleLabel = $app_list_strings['moduleList'][$relationshipModule];
					$moduleLabels[] = (!empty($moduleLabel)) ? $moduleLabel : $relationshipModule;
					$bean_names[] = $relationship['bean_name'];
					$vnames[] = $relationship['vname'];
					$label = translate($relationship['vname'], $module);
					$labels[] = (!empty($label)) ? $label : $relationship['vname'];
				}
			}
		}

		return Array(
			'names' => $names,
		    'relationships' => $relationships,
		    'modules' => $modules,
			'moduleLabels' => $moduleLabels,
		    'bean_names' => $bean_names,
		    'vnames' => $vnames,
			'labels' => $labels
		);
	}

	static function wfm_generate_moduleFields_selectRelatedFields($related_fields, $related_fields_labels, $related_fields_labels_key, $related_fields_relationship, $related_fields_relationship_labels, $multiple) {
		self::wfm_log('debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);

		$relatedFieldsSelect = "<select id='related_fields' name='related_fields' multiple size=10 style='width:178px'>";
		if (empty($related_fields)) {
			$related_fields = Array();
		}
		$aux_counter = 0;
		$aux_previous_module = "";
		foreach ($related_fields as $rFieldK => $relatedField) {
			$relatedField_array = explode('.', $relatedField);
			$aux_current_module = $relatedField_array[0];
			$aux_current_module = str_replace('_cstm', '', $aux_current_module);
			$aux_current_module .= $related_fields_relationship[$rFieldK];
			if ($aux_current_module != $aux_previous_module) {
				if ($aux_counter != 0) {
					$relatedFieldsSelect .= "</optgroup>";
				}
				if ($aux_counter + 1 != count($related_fields)) {
					$related_fields_label_array = explode('.', $related_fields_labels[$rFieldK]);
					$aux_current_module_label = $related_fields_label_array[0];
					if (($aux_current_module_label == $related_fields_relationship_labels[$rFieldK]) || ($related_fields_relationship_labels[$rFieldK] == '')) {
						$relatedFieldsSelect .= "<optgroup label='{$aux_current_module_label}' title='{$aux_current_module_label}'>";
					} else {
						$relatedFieldsSelect .= "<optgroup label='{$aux_current_module_label} ({$related_fields_relationship_labels[$rFieldK]})' title='{$aux_current_module_label} ({$related_fields_relationship_labels[$rFieldK]})'>";
					}
				}
			}

			$title = "generateTitleForFieldName(\"{$related_fields_labels[$rFieldK]}\", \"{$relatedField}\", \"\")";
			$relatedFieldsSelect .= "<option onmouseover='this.title = {$title};' value='{$relatedField}' title='{$relatedField}' label_key='{$related_fields_labels_key[$rFieldK]}'>{$related_fields_labels[$rFieldK]}</option>";

			$aux_previous_module = $aux_current_module;
			$aux_counter++;
		}
		$relatedFieldsSelect .= "</optgroup>";
		$relatedFieldsSelect .= '</select>';

		return $relatedFieldsSelect;
	}

	static function addRelationShipNameToLowerCase($fieldLabel, $relationShipLabel) {

		$fieldLabelArray = explode('.', $fieldLabel);
		$tableName = array_shift($fieldLabelArray);

		return strtolower($tableName.'.'.$relationShipLabel.'.'.implode('.', $fieldLabelArray));
	}

	static function _getModLanguageJS($module){

		global $sugar_config;

		$instanceName = $sugar_config['MVNA_Instance_Name'];
		$domainName = $sugar_config['domain_name'];

		if (isset($instanceName)) {
			$asolCacheDir = $instanceName.'/'.$domainName.'/';
		} else {
			$asolCacheDir = '';
		}

		if (!is_file(sugar_cached('jsLanguage/')."{$asolCacheDir}{$module}/{$GLOBALS['current_language']}.js")) {
			require_once ('include/language/jsLanguage.php');
			jsLanguage::createModuleStringsCache($module, $GLOBALS['current_language']);
		}
		return getVersionedScript("cache/jsLanguage/{$asolCacheDir}{$module}/{$GLOBALS['current_language']}.js", $GLOBALS['sugar_config']['js_lang_version']);
	}

	static function getAppStringsCache() {

		global $sugar_config;

		$instanceName = $sugar_config['MVNA_Instance_Name'];
		$domainName = $sugar_config['domain_name'];

		if (isset($instanceName)) {
			$asolCacheDir = $instanceName.'/'.$domainName.'/';
		} else {
			$asolCacheDir = '';
		}

		if (!is_file(sugar_cached('jsLanguage/') . $asolCacheDir . $GLOBALS['current_language'] . '.js')) {
			require_once ('include/language/jsLanguage.php');
			jsLanguage::createAppStringsCache($GLOBALS['current_language']);
		}
		echo getVersionedScript('cache/jsLanguage/'. $asolCacheDir . $GLOBALS['current_language'] . '.js', $GLOBALS['sugar_config']['js_lang_version']);
	}

	static function wfm_add_jsModLanguages($trigger_module, $add_related_modules, $add_id_relationships, $related_modules, $focus, $bean, $fieldsToBeRemoved, $translateFieldLabels, $rhs_key) {
		//self::wfm_log('debug', 'get_defined_vars=['.print_r(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);
		// Get Language file references

		if (empty($trigger_module)) {
			return false;
		}

		$audit_language_file_reference = self::_getModLanguageJS('Audit');
		$process_language_file_reference = self::_getModLanguageJS('asol_Process');
		
		// trigger_module
		$module_language_file_reference = self::_getModLanguageJS($trigger_module);
		$related_module_language_file_reference = '';

		$related_modules_idRelationships = Array();
		
		if ($add_id_relationships) {
			// for id relationships
			$currentTableFields = wfm_reports_utils::getCrmTableFields($bean, $trigger_module, $fieldsToBeRemoved, $translateFieldLabels, $rhs_key, true);
			//self::wfm_log('debug', '$currentTableFields=['.print_r($currentTableFields, true).']', __FILE__, __METHOD__, __LINE__);
			$related_modules_idRelationships = (isset($currentTableFields['related_modules'])) ? $currentTableFields['related_modules'] : Array();
		}

		if ($add_related_modules) {

			// total
			$related_modules_total = array_filter(array_unique(array_merge($related_modules, $related_modules_idRelationships)));
	
			foreach($related_modules_total as $key => $value) {
				$related_module_language_file_reference .= self::_getModLanguageJS($value) . "\n";
			}
		}

		echo '<!-- BEGIN - Language file references -->'."\n".$audit_language_file_reference."\n".$process_language_file_reference."\n".$module_language_file_reference."\n".$related_module_language_file_reference."\n".'<!-- END - Language file references -->';
	}

	static function wfm_get_moduleTableName_moduleName_conversion_array($focus){

		global $beanList, $beanFiles;

		$acl_modules = ACLAction::getUserActions($focus->created_by);

		// Get an array of table names for admin accesible modules
		$modulesTables = Array();
		foreach($acl_modules as $key=>$mod){

			if($mod['module']['access']['aclaccess'] >= 0){

				$class_name = $beanList[$key];
				if (!empty($class_name)) {

					require_once($beanFiles[$class_name]);

					$bean = new $class_name();
					$table_name = $bean->table_name;

					$modulesTables[$table_name] = $key;

					unset($bean);
				}
			}
		}

		return $modulesTables;
	}

	static function wfm_get_moduleName_moduleTableName_conversion_array($user_id){

		global $beanList, $beanFiles;

		$acl_modules = ACLAction::getUserActions($user_id);

		//Get an array of table names for admin accesible modules
		$modulesTables = Array();
		foreach($acl_modules as $key=>$mod){

			if($mod['module']['access']['aclaccess'] >= 0){

				$class_name = $beanList[$key];
				if (!empty($class_name)) {

					require_once($beanFiles[$class_name]);

					$bean = new $class_name();
					$table_name = $bean->table_name;

					$modulesTables[$key] = $table_name;

					unset($bean);
				}
			}
		}

		return $modulesTables;
	}

	static function wfm_getHourOffset_and_TimeZone($current_user_id) {
		self::wfm_log('debug', "ENTRY", __FILE__, __METHOD__, __LINE__);
		self::wfm_log('debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);

		require_once('modules/Users/User.php');
		$theUser = new User();
		//self::wfm_log('asol', 'ANTES 1', __FILE__, __METHOD__, __LINE__);
		$theUser->retrieve($current_user_id);
		//self::wfm_log('asol', 'DESPUES 1', __FILE__, __METHOD__, __LINE__);

		self::wfm_log('debug', "\$theUser->user_name=[$theUser->user_name]  ", __FILE__, __METHOD__, __LINE__);

		$userTZ = $theUser->getPreference("timezone");
		//self::wfm_log('debug', "\$userTZ=[$userTZ]  ", __FILE__, __METHOD__, __LINE__);

		date_default_timezone_set($userTZ);

		$phpDateTime = new DateTime(null, new DateTimeZone($userTZ));
		$hourOffset = $phpDateTime->getOffset()*-1;

		return Array(
		'userTZ' => $userTZ,
		'hourOffset' => $hourOffset
		);
	}

	/**
	 * Convert array to curl-parameter
	 * 1) replace special characters, 2) serialize, 3)urlencode
	 * @param $array
	 */
	static function wfm_convert_array_to_curl_parameter($array) {

		$array = str_replace('\'', "&#039;", $array); // To avoid problems with sugarcrm-decoding in sugarcrm 6520
		$array = str_replace("&quot;", "&#34;", $array); // To avoid problems with sugarcrm-decoding
		$array = str_replace(">", "&gt;", $array); // To avoid problems with Save.php
		$array = str_replace("<", "&lt;", $array); // To avoid problems with Save.php
		$serialized_array = serialize($array);
		//self::wfm_log('debug', "\$serialized_array=[".$serialized_array."]", __FILE__, __METHOD__, __LINE__);
		$urlencode_serialized_array = urlencode($serialized_array);
		//self::wfm_log('debug', "\$urlencode_serialized_array=[".$urlencode_serialized_array."]", __FILE__, __METHOD__, __LINE__);

		return $urlencode_serialized_array;
	}

	/**
	 * Build array with field_defs non-db from the bean (retrieved from DB, need fixUpFormatting)
	 */
	static function wfm_get_bean_variable_array($alternative_database, $trigger_module, $object_id) {
		wfm_utils::wfm_log('debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);

		global $beanList, $beanFiles, $current_user;

		$bean_variable_array = Array();

		if ($alternative_database == '-1') {
			// Retrieve bean
			$class_name = $beanList[$trigger_module];
			require_once($beanFiles[$class_name]);
			$bean = new $class_name();
			//self::wfm_log('asol', 'ANTES 4', __FILE__, __METHOD__, __LINE__);
			$bean->retrieve($object_id);
			//self::wfm_log('asol', 'DESPUES 4', __FILE__, __METHOD__, __LINE__);
			$bean->fixUpFormatting(); // datetimes from user format to DB format
			//$bean = BeanFactory::getBean($trigger_module, $object_id);
			//self::wfm_log('debug', '$bean=['.print_r($bean, true).']', __FILE__, __METHOD__, __LINE__);

			// Build array
			$bean_variable_array = self::getBeanFieldsNotAnObjectNotAnArray($bean);
		} else {
			//********************************************//
			//*****Managing External Database Queries*****//
			//********************************************//
			$alternativeDb = ($alternative_database >= 0) ? $alternative_database : false;
			$externalDataBaseQueryParams = wfm_reports_utils::wfm_manageExternalDatabaseQueries($alternativeDb, $trigger_module);

			$useAlternativeDbConnection = $externalDataBaseQueryParams["useAlternativeDbConnection"];
			$trigger_module_table = $externalDataBaseQueryParams["report_table"];

			$rs = Basic_wfm::getSelectionResults("SHOW COLUMNS FROM ".$trigger_module_table, false, $alternativeDb);

			foreach($rs as $value){

				$fieldConstraint = $value['Key'];//PRI  MUL

				if ($fieldConstraint == 'PRI') {
					$field_ID_name = $value['Field'];
				}
			}

			$sql = "SELECT * FROM {$trigger_module_table} WHERE {$field_ID_name} = '{$object_id}'";
			$object_row = Basic_wfm::getSelectionResults($sql, false, $alternativeDb);
			$bean_variable_array = $object_row[0];
		}
		
		$bean_variable_array['module_dir'] = $trigger_module;

		return $bean_variable_array;
	}

	static function getAuditRecord($module, $id) {
		
		global $db;
		
		$tableName = self::get_bean_table($module);
		
		$sql = "
			SELECT * 
			FROM {$tableName}_audit
			WHERE id = '{$id}'
		";
		$query = $db->query($sql);
		$row = $db->fetchByAssoc($query);

		return $row;
	}
	
	/**
	 * Get bean field_defs non-db array
	 */
	static function wfm_get_bean_fieldDefs_array($trigger_module) {

		global $beanList, $beanFiles;

		// Retrieve bean
		$class_name = $beanList[$trigger_module];
		require_once($beanFiles[$class_name]);
		$bean = new $class_name();

		// Build array
		$field_defs = Array();
		foreach ($bean->field_defs as $key => $value) {
			if ($bean->field_defs[$key]['source'] != 'non-db') {
				$field_defs[] = $key;
			}
		}

		return $field_defs;
	}

	/**
	 * Build array with field_defs non-db from the bean (passed by reference in the logic_hook)
	 */
	static function wfm_get_bean_variable_array_from_bean_field_defs_not_equals_non_db($bean) {

		global $current_user;

		self::wfm_log('debug', '$current_user->id=['.var_export($current_user->id, true).']', __FILE__, __METHOD__, __LINE__);

		// Build array
		$bean_variable_array = Array();
		foreach ($bean->field_defs as $key => $value) {
			if ($bean->field_defs[$key]['source'] != 'non-db') {
				$bean_variable_array[$key] = $bean->$key;
			}
		}

		return $bean_variable_array;
	}

	static function getBeanFields($bean) {

		$bean_variable_array = Array();
		foreach ($bean->field_defs as $key => $value) {
			$bean_variable_array[$key] = $bean->$key;
		}

		return $bean_variable_array;
	}

	static function getBeanFieldsTypeNotEqualsLink($bean) {

		$bean_variable_array = Array();
		foreach ($bean->field_defs as $key => $value) {
			if ($bean->field_defs[$key]['type'] != 'link') {
				$bean_variable_array[$key] = $bean->$key;
			}
		}

		return $bean_variable_array;
	}

	static function getBeanFieldsNotAnObjectNotAnArray($bean) {

		$bean_variable_array = Array();
		foreach ($bean->field_defs as $key => $value) {
			if ((!is_object($bean->$key)) && (!is_array($bean->$key))) {
				$bean_variable_array[$key] = $bean->$key;
			}
		}
		
		$bean_variable_array['email1'] = $bean->email1;
		
		// asol_email_list
		if (isset($bean->emailAddress)) { // Not all modules have emailAddresses
			// Get new emails from this module (get them from $bean)
			$new_emails = $bean->emailAddress->addresses;
			$new_emails_string = "";
			foreach($new_emails as $key => $value) {
				$new_emails_string .= $new_emails[$key]['email_address'] . ',';
			}
			$new_emails_string = substr($new_emails_string, 0, -1);
		}
		$bean_variable_array['asol_email_list'] = $new_emails_string;

		return $bean_variable_array;
	}

	/**
	 * Convert curl-parameter to array
	 * 1) replace &quot; ,(not urldecode) 2) unserialize
	 */
	static function wfm_convert_curl_parameter_to_array($curl_parameter) {

		//self::wfm_log('debug', "\$curl_parameter=[".$curl_parameter."]", __FILE__, __METHOD__, __LINE__);
		$html_entity_decoded__array = str_replace("&quot;", '"', $curl_parameter);
		//self::wfm_log('debug', "\$html_entity_decoded__array=[".$html_entity_decoded__array."]", __FILE__, __METHOD__, __LINE__);
		$unserialized__html_entity_decoded__array = unserialize($html_entity_decoded__array);
		//self::wfm_log('debug', "\$unserialized__html_entity_decoded__array=[".print_r($unserialized__html_entity_decoded__array,true)."]", __FILE__, __METHOD__, __LINE__);
		$array = $unserialized__html_entity_decoded__array;
		//+++++++++++self::wfm_log('debug', "\$array=[".print_r($array,true)."]", __FILE__, __METHOD__, __LINE__);

		// BEGIN - Debug array
		/*
		 $urldecoded_array =  urldecode($html_entity_decoded); // urldecode not necessary
		 $urldecoded_array =  urldecode($curl_parameter);
		 self::wfm_log('debug', "\$urldecoded_array=[".$urldecoded_array."]", __FILE__, __METHOD__, __LINE__);
		 $urldecoded__html_entity_decoded__array = urldecode($html_entity_decoded__array);
		 self::wfm_log('debug', "\$urldecoded__html_entity_decoded__array=[".$urldecoded__html_entity_decoded__array."]", __FILE__, __METHOD__, __LINE__);
		 $unserialized__urldecoded_array = unserialize($urldecoded_array);
		 self::wfm_log('debug', "\$unserialized__urldecoded_array=[".print_r($unserialized__urldecoded_array,true)."]", __FILE__, __METHOD__, __LINE__);
		 $unserialized__urldecoded__html_entity_decoded__array = unserialize($urldecoded__html_entity_decoded__array);
		 self::wfm_log('debug', "\$unserialized__urldecoded__html_entity_decoded__array=[".print_r($unserialized__urldecoded__html_entity_decoded__array,true)."]", __FILE__, __METHOD__, __LINE__);
		 */
		// END - Debug old_bean

		// BEGIN - Debug to disk-file
		/*$file_content = "wfm_engine.php*************** \n\n";
		 $file_content.= "\$curl_parameter=[".$curl_parameter]."] \n\n";
		 $file_content.= "\$html_entity_decoded__old_bean=[".$html_entity_decoded__array."] \n\n";
		 $file_content.= "\$unserialized__html_entity_decoded__array=[".print_r($unserialized__html_entity_decoded__array,true)."] \n\n";

		 $file = fopen("test_after_curl.txt", "a+");
		 fwrite($file, $file_content);
		 fclose($file);*/
		// END - Debug to disk-file

		return $array;
	}

	static function getTriggerModule_fromEventId($event_id) {

		global $db;

		$process_query = $db->query("
									SELECT asol_process.trigger_module as trigger_module
									FROM asol_proces_asol_events_c
									INNER JOIN asol_process ON (asol_process.id = asol_proces_asol_events_c.asol_proce6f14process_ida AND asol_process.deleted = 0)
									WHERE asol_proces_asol_events_c.asol_procea8ca_events_idb = '{$event_id}' AND asol_proces_asol_events_c.deleted = 0							  
							  	");
		$process_row = $db->fetchByAssoc($process_query);

		return $process_row['trigger_module'];
	}

	static function getProcess_fromEventId($event_id) {

		global $db;

		$process_query = $db->query("
									SELECT asol_process.*
									FROM asol_proces_asol_events_c
									INNER JOIN asol_process ON (asol_process.id = asol_proces_asol_events_c.asol_proce6f14process_ida AND asol_process.deleted = 0)
									WHERE asol_proces_asol_events_c.asol_procea8ca_events_idb = '{$event_id}' AND asol_proces_asol_events_c.deleted = 0							  
							  	");
		$process_row = $db->fetchByAssoc($process_query);

		return $process_row;
	}

	static function getTriggerModule_fromProcessId($process_id) {

		global $db;

		$sql = "
			SELECT trigger_module
			FROM asol_process
			WHERE id = '{$process_id}' AND asol_process.deleted = 0							  
	  	";
		self::wfm_log('debug', '$sql=['.var_export($sql, true).']', __FILE__, __METHOD__, __LINE__);
		$process_query = $db->query($sql);
		$process_row = $db->fetchByAssoc($process_query);

		return $process_row['trigger_module'];
	}
	
	static function getAudit_fromProcessId($process_id) {

		global $db;

		$sql = "
			SELECT audit
			FROM asol_process
			WHERE id = '{$process_id}' AND asol_process.deleted = 0							  
	  	";
		self::wfm_log('debug', '$sql=['.var_export($sql, true).']', __FILE__, __METHOD__, __LINE__);
		$process_query = $db->query($sql);
		$process_row = $db->fetchByAssoc($process_query);

		return $process_row['audit'];
	}
	
	static function getDataSource_fromProcessId($process_id) {
	
		global $db;
	
		$sql = "
			SELECT data_source
			FROM asol_process
			WHERE id = '{$process_id}' AND asol_process.deleted = 0
		";
		self::wfm_log('debug', '$sql=['.var_export($sql, true).']', __FILE__, __METHOD__, __LINE__);
		$process_query = $db->query($sql);
		$process_row = $db->fetchByAssoc($process_query);
	
		return $process_row['data_source'];
	}

	static function getProcess_fromProcessId($process_id) {

		global $db;

		$process_query = $db->query("
									SELECT *
									FROM asol_process
									WHERE id = '{$process_id}' AND asol_process.deleted = 0							  
							  	");
		$process_row = $db->fetchByAssoc($process_query);

		return $process_row;
	}

	static function getAlternativeDatabase_fromProcessId($process_id) {

		global $db;

		$process_query = $db->query("
									SELECT alternative_database
									FROM asol_process
									WHERE id = '{$process_id}' AND asol_process.deleted = 0							  
							  	");
		$process_row = $db->fetchByAssoc($process_query);

		return $process_row['alternative_database'];
	}

	static function getScheduledType_fromEventId($event_id) {

		global $db;

		$event_query = $db->query("
									SELECT scheduled_type
									FROM asol_events
									WHERE id = '{$event_id}' AND asol_events.deleted = 0							  
							  	");
		$event_row = $db->fetchByAssoc($event_query);

		return $event_row['scheduled_type'];
	}

	static function wfm_SavePhpCustomToFile($id, $task_implementation) {

		$phpCode = str_replace(array("\n", "\r"), array('\n', '\r'), $task_implementation); // needed for line-feeds and carriage-return
		$task_implementation = $phpCode;

		$script = $task_implementation;
		$script_to_disk_file = rawurldecode($script);//rawurldecode() does not decode plus symbols ('+') into spaces. urldecode() does.

		$myFile = "{$id}.php";
		$fh = fopen("modules/asol_Task/_temp_php_custom_Files/{$myFile}", 'w') or die("can't open file");
		$stringData = $script_to_disk_file;
		fwrite($fh, $stringData);
		fclose($fh);
	}

	/**
	 * Swap scheduled_tasks from DB-format to user-format
	 */
	static function wfm_prepareTasks_fromDB_toSugar($scheduled_tasks) {

		global $timedate;

		if (strpos($scheduled_tasks, '${GMT}') !== false) {
			$scheduled_tasks = substr($scheduled_tasks, 0, -6);
		}

		$tasks = explode("|", $scheduled_tasks);

		if (($tasks[0] == "") || ($tasks[0] == '${GMT}')) {
			$tasks = Array();
		}

		if (!isset($_REQUEST['scheduled_tasks_hidden'])) {// This avoid adding offset each time the show-related-button is clicked(submit)
			foreach ($tasks as $key => $task){
				$taskValues = explode(":", $task);

				$time1 = explode(",", $taskValues[3]);
				$auxDateTime = $timedate->handle_offset(date("Y")."-".date("m")."-".date("d")." ".$time1[0].":".$time1[1], $timedate->get_db_date_time_format());

				$auxDateTimeArray = explode(" ", $auxDateTime);
				$taskValues[3] = implode(",", explode(":", $auxDateTimeArray[1]));

				if((!$timedate->check_matching_format($taskValues[4], $timedate->get_date_format())) && ($taskValues[4]!="")) {
					$taskValues[4] = $timedate->swap_formats($taskValues[4], $GLOBALS['timedate']->dbDayFormat, $timedate->get_date_format() );
				}

				$tasks[$key] = implode(":", $taskValues);
			}
		}

		$tasks_string = implode("|", $tasks);

		return $tasks_string;
	}

	/**
	 * Swap scheduled_tasks from user-format to DB-format
	 */
	static function wfm_prepareTasks_fromSugar_toDB($scheduled_tasks) {

		global $timedate, $current_user;

		$tasks = ($scheduled_tasks == '${GMT}') ? array() : explode("|", $scheduled_tasks);

		foreach($tasks as $key => $task) {
			$values = explode(":", $task);
			if ((!$timedate->check_matching_format($values[4], $GLOBALS['timedate']->dbDayFormat)) && ($values[4]!="")) {
				$values[4] = $timedate->swap_formats($values[4], $timedate->get_date_format(), $GLOBALS['timedate']->dbDayFormat );
			}

			$userTZ = $current_user->getPreference("timezone");

			$phpDateTime = new DateTime(null, new DateTimeZone($userTZ));
			$hourOffset = $phpDateTime->getOffset()*-1;

			$time1 = explode(",", $values[3]);
			$values[3] = date("H,i", @mktime($time1[0],$time1[1],0,date("m"),date("d"),date("Y"))+$hourOffset);

			$tasks[$key] = implode(":", $values);
		}
		$scheduled_tasks = (empty($tasks)) ? '${GMT}' : implode("|", $tasks);

		return $scheduled_tasks;
	}

	/**
	 * Swap conditions from DB-format to user-format
	 */
	static function wfm_prepareConditions_fromDB_toSugar($conditions) {

		global $timedate;

		// Swap datetime-format (from database-format to sugar-format)

		$filterValues = explode('${pipe}', $conditions);

		foreach ($filterValues as $key => $value) {
			$values = explode('${dp}', $value);
			if ((($values[6] == "date") || ($values[6] == "datetime") || ($values[6] == "datetimecombo") || ($values[6] == "timestamp")) && (($values[3] != "last") && ($values[3] != "this") && ($values[3] != "next") && ($values[3] != "not last") && ($values[3] != "not this") && ($values[3] != "not next"))) {
				if ((!$timedate->check_matching_format($values[4], $timedate->get_date_format())) && ($values[4]!="")) {
					$values[4] = $timedate->swap_formats($values[4],$GLOBALS['timedate']->dbDayFormat , $timedate->get_date_format() );
				}
				if ((!$timedate->check_matching_format($values[5], $timedate->get_date_format())) && ($values[5]!="")) {
					$values[5] = $timedate->swap_formats($values[5], $GLOBALS['timedate']->dbDayFormat , $timedate->get_date_format() );
				}
			}
			$filterValues[$key] = implode('${dp}', $values);
		}

		$conditions = implode('${pipe}', $filterValues);

		return $conditions;
	}

	/**
	 * Swap conditions from user-format to DB-format
	 */
	static function wfm_prepareConditions_fromSugar_toDB($conditions) {

		global $timedate;

		// Swap datetime-format (from sugar-format to database-format)

		$filterValues = explode('${pipe}', $conditions);

		foreach ($filterValues as $key1 => $value){
			$values = explode('${dp}', $value);
			if ((($values[6] == "date") || ($values[6] == "datetime") || ($values[6] == "datetimecombo") || ($values[6] == "timestamp")) && (($values[3] != "last") && ($values[3] != "this") && ($values[3] != "next") && ($values[3] != "not last") && ($values[3] != "not this") && ($values[3] != "not next"))){
				if((!$timedate->check_matching_format($values[4], $GLOBALS['timedate']->dbDayFormat)) && ($values[4]!="")) {
					$values[4] = $timedate->swap_formats($values[4], $timedate->get_date_format(), $GLOBALS['timedate']->dbDayFormat );
				}
				if((!$timedate->check_matching_format($values[5], $GLOBALS['timedate']->dbDayFormat)) && ($values[5]!="")) {
					$values[5] = $timedate->swap_formats($values[5], $timedate->get_date_format(), $GLOBALS['timedate']->dbDayFormat );
				}
			}
			$filterValues[$key1] = implode('${dp}', $values);
		}
		$conditions = implode('${pipe}', $filterValues);

		return $conditions;
	}




	static function getRealIP()
	{
		//// wfm_utils::wfm_log('debug', '$_SERVER=['.print_r($_SERVER, true).']', __FILE__, __METHOD__, __LINE__);
		//// wfm_utils::wfm_log('debug', '$_ENV=['.print_r($_ENV, true).']', __FILE__, __METHOD__, __LINE__);

		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ($_SERVER['HTTP_X_FORWARDED_FOR'] != ''))
		{
			$client_ip =
			( !empty($_SERVER['REMOTE_ADDR']) ) ?
			$_SERVER['REMOTE_ADDR']
			:
			( ( !empty($_ENV['REMOTE_ADDR']) ) ?
			$_ENV['REMOTE_ADDR']
			:
               "unknown" );

			// los proxys van añadiendo al final de esta cabecera
			// las direcciones ip que van "ocultando". Para localizar la ip real
			// del usuario se comienza a mirar por el principio hasta encontrar
			// una dirección ip que no sea del rango privado. En caso de no
			// encontrarse ninguna se toma como valor el REMOTE_ADDR

			$entries = preg_split('/[, ]/', $_SERVER['HTTP_X_FORWARDED_FOR']);

			reset($entries);
			while (list(, $entry) = each($entries))
			{
				$entry = trim($entry);
				if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list) )
				{
					// http://www.faqs.org/rfcs/rfc1918.html
					$private_ip = array(
                  '/^0\./', 
                  '/^127\.0\.0\.1/', 
                  '/^192\.168\..*/', 
                  '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/', 
                  '/^10\..*/');

					$found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

					if ($client_ip != $found_ip)
					{
						$client_ip = $found_ip;
						break;
					}
				}
			}
		}
		else
		{
			$client_ip =
			( !empty($_SERVER['REMOTE_ADDR']) ) ?
			$_SERVER['REMOTE_ADDR']
			:
			( ( !empty($_ENV['REMOTE_ADDR']) ) ?
			$_ENV['REMOTE_ADDR']
			:
               "unknown" );
		}

		return $client_ip;

	}

	static function getRealIP2() {

		//Just get the headers if we can or else use the SERVER global
		if ( function_exists( 'apache_request_headers' ) ) {

			$headers = apache_request_headers();

		} else {

			$headers = $_SERVER;

		}

		//Get the forwarded IP if it exists
		if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {

			$the_ip = $headers['X-Forwarded-For'];

		} elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )
		) {

			$the_ip = $headers['HTTP_X_FORWARDED_FOR'];

		} else {
				
			$the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );

		}

		return $the_ip;

	}
	
	static public function isCommonBaseInstalled() {
	
		global $db;
		
// 		if (isset($_SESSION['isCommonBaseInstalled']) && $_SESSION['isCommonBaseInstalled']) {
// 			$isCommonBaseInstalled = $_SESSION['isCommonBaseInstalled'];
// 		} else {
			$sql = "SELECT * FROM upgrade_history WHERE id_name='AlineaSolCommonBase' AND status='installed' AND version >= '".self::$common_version."'";
			$commonBaseQuery = $db->query($sql);
			$isCommonBaseInstalled = ($commonBaseQuery->num_rows > 0);
			$_SESSION['isCommonBaseInstalled'] = $isCommonBaseInstalled;
// 		}
	
		return $isCommonBaseInstalled;
	
	}

	/**
	 * $start = 'http';
	 * $end = 'com';
	 * $str = 'http://google.com';
	 * str_starts_with($str, $start); // TRUE
	 * @param $haystack
	 * @param $needle
	 */
	static function str_starts_with($haystack, $needle)	{
		return strpos($haystack, $needle) === 0;
	}

	/**
	 * $start = 'http';
	 * $end = 'com';
	 * $str = 'http://google.com';
	 * str_ends_with($str, $end); // TRUE
	 * @param $haystack
	 * @param $needle
	 */
	static function str_ends_with($haystack, $needle) {
		return strpos($haystack, $needle) + strlen($needle) ===	strlen($haystack);
	}

	/**
	 *
	 * Get all next_activities(children, grandchildren...) for an activity
	 * @param $activity_id
	 * @param $next_activities -> You need to call this function like this: "getNextActivities($activity_id);" without the second parameter, because this is just for implementing recursiveness(there is a call to the function inside the function itself)
	 */
	static function getNextActivities($activity_id, & $next_activities=array()){ // recursive

		self::wfm_log('debug', "Executing getNextActivities function", __FILE__, __METHOD__, __LINE__);

		global $db;
		$next_activities_query = $db->query("
											SELECT asol_activ9e2dctivity_idb  AS next_activity_id
											FROM asol_activisol_activity_c
											WHERE asol_activ898activity_ida  = '{$activity_id}' AND deleted = 0
										");

		while($next_activities_row = $db->fetchByAssoc($next_activities_query)) {
			$next_activities[] = $next_activities_row['next_activity_id'];

			self::getNextActivities($next_activities_row['next_activity_id'], $next_activities);
		}

		return $next_activities;
	}

	static function getNextActivitiesTEST($activity_id, & $next_activities=array()){ // recursive

		self::wfm_log('debug', "Executing getNextActivities function", __FILE__, __METHOD__, __LINE__);

		global $db;
		$next_activities_query = $db->query("
											SELECT rels.asol_activ9e2dctivity_idb  AS next_activity_id, objs.name AS name
											FROM asol_activisol_activity_c AS rels
											INNER JOIN asol_activity AS objs ON objs.id = rels.asol_activ9e2dctivity_idb 
											WHERE rels.asol_activ898activity_ida  = '{$activity_id}' AND rels.deleted = 0 AND objs.deleted = 0
											ORDER BY rels.date_modified
										");

		while ($next_activities_row = $db->fetchByAssoc($next_activities_query)) {
			$next_activities[] = Array('next_activity_id' => $next_activities_row['next_activity_id'], 'name' => $next_activities_row['name']);
			//$next_activities[] = $next_activities_row['next_activity_id'];

			self::getNextActivities($next_activities_row['next_activity_id'], $next_activities);
		}


		return $next_activities;
	}


	static function checkWorkFlowExists($process_id) {
		return Basic_wfm::checkRecordAlreadyExists('asol_process', $process_id);
	}

	static function getWorkFlowsExist($imported_workflows) {

		$workflows_exist_process_ids = Array();

		if (array_key_exists('processes', $imported_workflows)) {
			foreach ($imported_workflows['processes'] as $process) {
				if (self::checkWorkFlowExists($process['id'])) {
					$workflows_exist_process_ids[] = $process['id'];
				}
			}
		}

		return $workflows_exist_process_ids;
	}

	static function checkAffectedRows($type, $sql=null, $file=null, $function=null, $line=null) {

		global $db, $mod_strings;
		
		if ($sql != null) {
			$sql_log_message = '$sql=['.var_export($sql, true).'], *called_from=['.pathinfo($file, PATHINFO_BASENAME)."[$line]->".$function.']';
			self::wfm_log('debug', $sql_log_message, __FILE__, __METHOD__, __LINE__);
		}

		$affected_rows = $db->getAffectedRowCount('result_never_mind'); // {-1: query failed, 0: DB not affected, >0: number of rows affected}
		
		if ($affected_rows < 1) {
			self::wfm_log('fatal', "Query failed or DB not affected (\$affected_rows < 1): type=[{$type}], sql_log_message=[{$sql_log_message}]", __FILE__, __METHOD__, __LINE__);
			//self::wfm_echo($type, $error_message);
			//exit();
			
			throw new Exception($type);
		}
	}

	static function migrateWorkflows(&$imported_workflows) {
		
		wfm_utils::wfm_log('asol_debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);
		
		$workflows_version = isset($imported_workflows['version']) ? $imported_workflows['version'] : null;
			
		if ($workflows_version === null) { // The file was exported from a WFM version prior to the introduction of "automatically migrate workflows when importing exported-workflows-file" (WFM v5.11.0)
		} else {
				
			if (version_compare($workflows_version, self::$wfm_release_version, '<')) { // Migrate
				// Migrate from version "$workflows_version" to version "wfm_utils::$wfm_release_version"
				
				// from version WFM-version=5.7 to WFM-version=5.13.0 
				if (array_key_exists('processes', $imported_workflows)) {
					foreach ($imported_workflows['processes'] as $key_process => $process) {
						if (!isset($imported_workflows['processes'][$key_process]['data_source'])) {
							$imported_workflows['processes'][$key_process]['data_source'] = 'database';
						} elseif (isset($imported_workflows['processes'][$key_process]['data_source']) && empty($imported_workflows['processes'][$key_process]['data_source'])) {
							$imported_workflows['processes'][$key_process]['data_source'] = 'database';
						}
					}
				}
				
				// from version WFM-version=5.13.0 to WFM-version=5.16.0
				if (array_key_exists('tasks', $imported_workflows)) {
					foreach ($imported_workflows['tasks'] as $key_task => $task) {
						if (!isset($imported_workflows['tasks'][$key_task]['async'])) {
							$imported_workflows['tasks'][$key_task]['async'] = 'sync';
						} elseif (isset($imported_workflows['tasks'][$key_task]['async']) && empty($imported_workflows['tasks'][$key_task]['async'])) {
							$imported_workflows['tasks'][$key_task]['async'] = 'sync';
						}
					}
				}
				if (array_key_exists('processes', $imported_workflows)) {
					foreach ($imported_workflows['processes'] as $key_process => $process) {
						if (!isset($imported_workflows['processes'][$key_process]['async'])) {
							if ($imported_workflows['processes'][$key_process]['use_curl'] === '0') {
								$imported_workflows['processes'][$key_process]['async'] = 'sync';
							} elseif ($imported_workflows['processes'][$key_process]['use_curl'] === '1') {
								$imported_workflows['processes'][$key_process]['async'] = 'async_curl';
							}
						}
					}
				}
					
			} elseif (version_compare($workflows_version, self::$wfm_release_version, '>')) { // Do not migrate // Not possible // Not supported
			} elseif (version_compare($workflows_version, self::$wfm_release_version, '==')) { // Do not migrate // Not needed
			}
		}
		
	}
	
	static function importWorkFlows($imported_workflows, $workflows_exist_process_ids, $workflows_exist, $in_context_process_id, $import_type, $prefix, $suffix, $rename_type, $set_status_type, $import_domain_type, $explicit_domain, $import_email_template_type, $if_email_template_already_exists, $version_compatibility_type) {

		// wfm_utils::wfm_log('debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);

		// BEGIN - Migrate
		if ($version_compatibility_type == 'migrate') {
			self::migrateWorkflows($imported_workflows);	
		}
		// END - Migrate
		
		$isDomainsInstalled = wfm_domains_utils::wfm_isDomainsInstalled();

		$query_domains_columns = ($isDomainsInstalled) ? ", asol_domain_id, asol_domain_child_share_depth, asol_multi_create_domain, asol_published_domain" : '';

		if ($import_type == 'replace') {
			if ($in_context_process_id == null) {
				self::deleteWorkFlows($workflows_exist_process_ids);
			} else { // Delete in-context WorkFlow
				self::deleteWorkFlows($in_context_process_id);
			}
		}

		$current_datetime = gmdate('Y-m-d H:i:s');

		$use_old_data = ((!$workflows_exist) || ($import_type == 'replace')); // FIXME
		$use_old_data = ($import_type == 'replace');

		global $db, $mod_strings;

		// Create wfm-processes

		$old_ids__and__new_ids__process__array = Array();

		if (array_key_exists('processes', $imported_workflows)) {
			foreach ($imported_workflows['processes'] as $process) {

				$process_id = ($use_old_data) ? $process['id'] : create_guid();
				$process_name =  "{$prefix}{$process['name']}{$suffix}";
				$process_status = self::getProcessStatusWhenImportingWorkFlow($import_type, $set_status_type, $process);
				$process_date_entered = ($use_old_data) ? $process['date_entered'] : $current_datetime;
				$process_date_modified = ($use_old_data) ? $process['date_modified'] : $current_datetime;
				$query_domains_values = ($isDomainsInstalled) ? self::modifySqlImportWorkFlowsWithDomains($process, $import_domain_type, $explicit_domain) : '';

				$db->query("
					DELETE FROM asol_process
					WHERE id = '{$process_id}'  
				");

				$db->query("
					REPLACE INTO asol_process (id             , name             , date_entered             , date_modified             , modified_user_id                , created_by                , description                , deleted                , assigned_user_id                , status             , async               , audit               , trigger_module                , alternative_database                   , data_source   				  , asol_forms_id_c                             {$query_domains_columns})
					VALUES					 ('{$process_id}', '{$process_name}', '{$process_date_entered}', '{$process_date_modified}', '{$process['modified_user_id']}', '{$process['created_by']}', '{$process['description']}', '{$process['deleted']}', '{$process['assigned_user_id']}', '{$process_status}','{$process['async']}','{$process['audit']}', '{$process['trigger_module']}', '{$process['alternative_database']}'    , '{$process['data_source']}'  , '{$process['asol_forms_id_c']}'             {$query_domains_values}) 
				");
				self::checkAffectedRows('import_workflows_error');

				$old_ids__and__new_ids__process__array[$process['id']] = $process_id;
			}
		}

		// Create wfm-events

		$old_ids__and__new_ids__event__array = Array();

		if (array_key_exists('events', $imported_workflows)) {
			foreach ($imported_workflows['events'] as $parent_process_id => $events_from_parent_process_id) {
				foreach ($events_from_parent_process_id as $event) {

					$event_id = ($use_old_data) ? $event['id'] : create_guid();
					$event_name = ($rename_type == 'all_wfm_entities') ? "{$prefix}{$event['name']}{$suffix}" : $event['name'];
					$event_date_entered = ($use_old_data) ? $event['date_entered'] : $current_datetime;
					$event_date_modified = ($use_old_data) ? $event['date_modified'] : $current_datetime;
					$query_domains_values = ($isDomainsInstalled) ? self::modifySqlImportWorkFlowsWithDomains($event, $import_domain_type, $explicit_domain) : '';

					$db->query("
						DELETE FROM asol_events
						WHERE id = '{$event_id}'  
					");

					$db->query("
							REPLACE INTO asol_events (id           , name           , date_entered           , date_modified           , modified_user_id              , created_by              , description              , deleted              , assigned_user_id              , type              , trigger_type              , trigger_event              , conditions              , scheduled_tasks              , scheduled_type               , subprocess_type                           {$query_domains_columns})
							VALUES                  ('{$event_id}', '{$event_name}', '{$event_date_entered}', '{$event_date_modified}', '{$event['modified_user_id']}', '{$event['created_by']}', '{$event['description']}', '{$event['deleted']}', '{$event['assigned_user_id']}', '{$event['type']}', '{$event['trigger_type']}', '{$event['trigger_event']}', '{$event['conditions']}', '{$event['scheduled_tasks']}', '{$event['scheduled_type']}' , '{$event['subprocess_type']}'             {$query_domains_values})
						");
					self::checkAffectedRows('import_workflows_error');

					$old_ids__and__new_ids__event__array[$event['id']] = $event_id;

					$event_relationship_id = ($use_old_data) ? $event['relationship']['id'] : create_guid();
					$event_relationship_date_modified = ($use_old_data) ? $event['relationship']['date_modified'] : $current_datetime;
					$event_relationship_ida = ($use_old_data) ? $event['relationship']['asol_proce6f14process_ida'] : $old_ids__and__new_ids__process__array[$parent_process_id];
					$event_relationship_idb = ($use_old_data) ? $event['relationship']['asol_procea8ca_events_idb'] : $event_id;

					$db->query("
						DELETE FROM asol_proces_asol_events_c
						WHERE id = '{$event_relationship_id}'  
					");

					$db->query("
						REPLACE INTO asol_proces_asol_events_c (id                              , date_modified                              , deleted                              , asol_proce6f14process_ida                              , asol_procea8ca_events_idb                              )
						VALUES                                ('{$event_relationship_id}', '{$event_relationship_date_modified}', '{$event['relationship']['deleted']}', '{$event_relationship_ida}', '{$event_relationship_idb}')
					");
					self::checkAffectedRows('import_workflows_error');
				}
			}
		}

		// Create wfm-activities

		$old_ids__and__new_ids__activity__array = Array();

		if (array_key_exists('activities', $imported_workflows)) {
			foreach ($imported_workflows['activities'] as $parent_event_id => $activities_from_parent_event_id) {
				foreach ($activities_from_parent_event_id as $activity) {

					self::wfm_log('debug', '$old_ids__and__new_ids__activity__array=['.var_export($old_ids__and__new_ids__activity__array, true).']', __FILE__, __METHOD__, __LINE__);
					if (!array_key_exists($activity['id'], $old_ids__and__new_ids__activity__array)) {	// Event duplicity.

						$activity_id = ($use_old_data) ? $activity['id'] : create_guid();
						$activity_name = ($rename_type == 'all_wfm_entities') ? "{$prefix}{$activity['name']}{$suffix}" : $activity['name'];
						$activity_date_entered = ($use_old_data) ? $activity['date_entered'] : $current_datetime;
						$activity_date_modified = ($use_old_data) ? $activity['date_modified'] : $current_datetime;
						$query_domains_values = ($isDomainsInstalled) ? self::modifySqlImportWorkFlowsWithDomains($activity, $import_domain_type, $explicit_domain) : '';

						$db->query("
							DELETE FROM asol_activity
							WHERE id = '{$activity_id}'  
						");

						$db->query("
								REPLACE INTO asol_activity (id                 , name                 , date_entered                 , date_modified                 , modified_user_id                 , created_by                 , description                 , deleted                 , assigned_user_id                 , conditions                 , delay                 , type                 {$query_domains_columns})
								VALUES					  ('{$activity_id}', '{$activity_name}', '{$activity_date_entered}', '{$activity_date_modified}', '{$activity['modified_user_id']}', '{$activity['created_by']}', '{$activity['description']}', '{$activity['deleted']}', '{$activity['assigned_user_id']}', '{$activity['conditions']}', '{$activity['delay']}', '{$activity['type']}'               {$query_domains_values})
						");
						self::checkAffectedRows('import_workflows_error');

						$old_ids__and__new_ids__activity__array[$activity['id']] = $activity_id;
					} else {
						self::wfm_log('debug', "Event duplicity", __FILE__, __METHOD__, __LINE__);
					}

					$activity_relationship_id = ($use_old_data) ? $activity['relationship']['id'] : create_guid();
					$activity_relationship_date_modified = ($use_old_data) ? $activity['relationship']['date_modified'] : $current_datetime;
					$activity_relationship_ida = ($use_old_data) ? $activity['relationship']['asol_event87f4_events_ida'] : $old_ids__and__new_ids__event__array[$parent_event_id];
					$activity_relationship_idb = ($use_old_data) ? $activity['relationship']['asol_event8042ctivity_idb'] : $activity_id;

					$db->query("
						DELETE FROM asol_eventssol_activity_c
						WHERE id = '{$activity_relationship_id}'  
					");

					$db->query("
						REPLACE INTO asol_eventssol_activity_c (id                                 , date_modified                                 , deleted                                 , asol_event87f4_events_ida                                 , asol_event8042ctivity_idb                                 )
						VALUES                                ('{$activity_relationship_id}', '{$activity_relationship_date_modified}', '{$activity['relationship']['deleted']}', '{$activity_relationship_ida}', '{$activity_relationship_idb}')
					");
					self::checkAffectedRows('import_workflows_error');
				}
			}
		}

		// Create wfm-activities(next_activities)

		//$old_ids__and__new_ids__next_activity__array = Array(); -> activities and next_activities in the same array

		if (array_key_exists('next_activities', $imported_workflows)) {
			foreach ($imported_workflows['next_activities'] as $parent_activity_id => $activities_from_parent_activity_id) {
				foreach ($activities_from_parent_activity_id as $next_activity) {

					$next_activity_id = ($use_old_data) ? $next_activity['id'] : create_guid();
					$next_activity_name = ($rename_type == 'all_wfm_entities') ? "{$prefix}{$next_activity['name']}{$suffix}" : $next_activity['name'];
					$next_activity_date_entered = ($use_old_data) ? $next_activity['date_entered'] : $current_datetime;
					$next_activity_date_modified = ($use_old_data) ? $next_activity['date_modified'] : $current_datetime;
					$query_domains_values = ($isDomainsInstalled) ? self::modifySqlImportWorkFlowsWithDomains($next_activity, $import_domain_type, $explicit_domain) : '';

					$db->query("
						DELETE FROM asol_activity
						WHERE id = '{$next_activity_id}'  
					");

					$db->query("
							REPLACE INTO asol_activity (id                      , name                      , date_entered                      , date_modified                      , modified_user_id                      , created_by                      , description                      , deleted                      , assigned_user_id                      , conditions                      , delay                      , type                      {$query_domains_columns})
							VALUES					  ('{$next_activity_id}', '{$next_activity_name}', '{$next_activity_date_entered}', '{$next_activity_date_modified}', '{$next_activity['modified_user_id']}', '{$next_activity['created_by']}', '{$next_activity['description']}', '{$next_activity['deleted']}', '{$next_activity['assigned_user_id']}', '{$next_activity['conditions']}', '{$next_activity['delay']}', '{$next_activity['type']}'               {$query_domains_values})
					");
					self::checkAffectedRows('import_workflows_error');

					$old_ids__and__new_ids__activity__array[$next_activity['id']] = $next_activity_id;

					$next_activity_relationship_id = ($use_old_data) ? $next_activity['relationship']['id'] : create_guid();
					$next_activity_relationship_date_modified = ($use_old_data) ? $next_activity['relationship']['date_modified'] : $current_datetime;
					$next_activity_relationship_ida = ($use_old_data) ? $next_activity['relationship']['asol_activ898activity_ida'] : $old_ids__and__new_ids__activity__array[$parent_activity_id];
					$next_activity_relationship_idb = ($use_old_data) ? $next_activity['relationship']['asol_activ9e2dctivity_idb'] : $next_activity_id;

					$db->query("
						DELETE FROM asol_activisol_activity_c
						WHERE id = '{$next_activity_relationship_id}'  
					");

					$db->query("
						REPLACE INTO asol_activisol_activity_c (id                                      , date_modified                                      , deleted                                      , asol_activ898activity_ida                                      , asol_activ9e2dctivity_idb                                      )
						VALUES                                ('{$next_activity_relationship_id}', '{$next_activity_relationship_date_modified}', '{$next_activity['relationship']['deleted']}', '{$next_activity_relationship_ida}', '{$next_activity_relationship_idb}')
					");
					self::checkAffectedRows('import_workflows_error');
				}
			}
		}

		// Create wfm-tasks

		if (array_key_exists('tasks', $imported_workflows)) {
			foreach ($imported_workflows['tasks'] as $parent_activity_id => $tasks_from_parent_activity_id) {
				foreach ($tasks_from_parent_activity_id as $task) {

					$task_id = ($use_old_data) ? $task['id'] : create_guid();
					$task_name = ($rename_type == 'all_wfm_entities') ? "{$prefix}{$task['name']}{$suffix}" : $task['name'];
					$task_implementation = $task['task_implementation'];
					$task_date_entered = ($use_old_data) ? $task['date_entered'] : $current_datetime;
					$task_date_modified = ($use_old_data) ? $task['date_modified'] : $current_datetime;
					$query_domains_values = ($isDomainsInstalled) ? self::modifySqlImportWorkFlowsWithDomains($task, $import_domain_type, $explicit_domain) : '';

					switch ($task['task_type']) {
						case 'send_email':
							self::manageImportEmailTemplates($task_implementation, $task['email_template'], $import_email_template_type, $if_email_template_already_exists, $query_domains_columns, $query_domains_values);
							break;
						case 'php_custom':
							self::wfm_SavePhpCustomToFile($task_id, $task['task_implementation']);
							break;
					}

					$db->query("
						DELETE FROM asol_task
						WHERE id = '{$task_id}'  
					");

					$db->query("
							REPLACE INTO asol_task (id          , name          , date_entered          , date_modified          , modified_user_id             , created_by             , description             , deleted             , assigned_user_id             , async             , delay_type             , delay             , date             , task_type             , task_order             , task_implementation                     {$query_domains_columns} )
							VALUES                 ('{$task_id}', '{$task_name}', '{$task_date_entered}', '{$task_date_modified}', '{$task['modified_user_id']}', '{$task['created_by']}', '{$task['description']}', '{$task['deleted']}', '{$task['assigned_user_id']}', '{$task['async']}', '{$task['delay_type']}', '{$task['delay']}', '{$task['date']}', '{$task['task_type']}', '{$task['task_order']}', '{$task_implementation}'                  {$query_domains_values})
					");
					self::checkAffectedRows('import_workflows_error');

					$task_relationship_id = ($use_old_data) ? $task['relationship']['id'] : create_guid();
					$task_relationship_date_modified = ($use_old_data) ? $task['relationship']['date_modified'] : $current_datetime;
					$task_relationship_ida = ($use_old_data) ? $task['relationship']['asol_activ5b86ctivity_ida'] : $old_ids__and__new_ids__activity__array[$parent_activity_id];
					$task_relationship_idb = ($use_old_data) ? $task['relationship']['asol_activf613ol_task_idb'] : $task_id;

					$db->query("
						DELETE FROM asol_activity_asol_task_c
						WHERE id = '{$task_relationship_id}'  
					");

					$db->query("
						REPLACE INTO asol_activity_asol_task_c (id                             , date_modified                             , deleted                             , asol_activ5b86ctivity_ida                             , asol_activf613ol_task_idb                             )
						VALUES                                ('{$task_relationship_id}', '{$task_relationship_date_modified}', '{$task['relationship']['deleted']}', '{$task_relationship_ida}', '{$task_relationship_idb}')
					");
					self::checkAffectedRows('import_workflows_error');
				}
			}
		}

		self::wfm_echo('import', $mod_strings['LBL_IMPORT_WORKFLOWS_OK']);
	}

	static function deleteWorkFlows($process_ids_array) {

		$workflows = self::getWorkFlows($process_ids_array);

		global $db, $mod_strings;

		// Create wfm-processes

		$old_ids__and__new_ids__process__array = Array();

		if (array_key_exists('processes', $workflows)) {
			foreach ($workflows['processes'] as $process) {

				$db->query("DELETE FROM asol_process WHERE id = '{$process['id']}'");
				self::checkAffectedRows('delete_workflows_error');
			}
		}

		// Create wfm-events

		$old_ids__and__new_ids__event__array = Array();

		if (array_key_exists('events', $workflows)) {
			foreach ($workflows['events'] as $parent_process_id => $events_from_parent_process_id) {
				foreach ($events_from_parent_process_id as $event) {


					$db->query("DELETE FROM asol_events WHERE id = '{$event['id']}'");
					self::checkAffectedRows('delete_workflows_error');

					$db->query("DELETE FROM asol_proces_asol_events_c WHERE id = '{$event['relationship']['id']}'");
					self::checkAffectedRows('delete_workflows_error');
				}
			}
		}

		// Create wfm-activities

		$old_ids__and__new_ids__activity__array = Array();

		if (array_key_exists('activities', $workflows)) {
			foreach ($workflows['activities'] as $parent_event_id => $activities_from_parent_event_id) {
				foreach ($activities_from_parent_event_id as $activity) {

					self::wfm_log('debug', '$old_ids__and__new_ids__activity__array=['.var_export($old_ids__and__new_ids__activity__array, true).']', __FILE__, __METHOD__, __LINE__);

					if (!array_key_exists($activity['id'], $old_ids__and__new_ids__activity__array)) {	// Event duplicity.

						$db->query("DELETE FROM asol_activity WHERE id = '{$activity['id']}'");
						self::checkAffectedRows('delete_workflows_error');

						$old_ids__and__new_ids__activity__array[$activity['id']] = $activity['id'];
					} else {
						self::wfm_log('debug', "Event duplicity", __FILE__, __METHOD__, __LINE__);
					}

					$db->query("DELETE FROM asol_eventssol_activity_c WHERE id = '{$activity['relationship']['id']}'");
					self::checkAffectedRows('delete_workflows_error');
				}
			}
		}

		// Create wfm-activities(next_activities)

		//$old_ids__and__new_ids__next_activity__array = Array(); -> activities and next_activities in the same array

		if (array_key_exists('next_activities', $workflows)) {
			foreach ($workflows['next_activities'] as $parent_activity_id => $activities_from_parent_activity_id) {
				foreach ($activities_from_parent_activity_id as $next_activity) {

					$db->query("DELETE FROM asol_activity WHERE id = '{$next_activity['id']}'");
					self::checkAffectedRows('delete_workflows_error');

					$old_ids__and__new_ids__activity__array[$next_activity['id']] = $new_next_activity_id;

					$db->query("DELETE FROM asol_activisol_activity_c WHERE id = '{$next_activity['relationship']['id']}'");
					self::checkAffectedRows('delete_workflows_error');
				}
			}
		}

		// Create wfm-tasks

		if (array_key_exists('tasks', $workflows)) {
			foreach ($workflows['tasks'] as $parent_activity_id => $tasks_from_parent_activity_id) {
				foreach ($tasks_from_parent_activity_id as $task) {

					$db->query("DELETE FROM asol_task WHERE id = '{$task['id']}'");
					self::checkAffectedRows('delete_workflows_error');

					$db->query("DELETE FROM asol_activity_asol_task_c WHERE id = '{$task['relationship']['id']}'");
					self::checkAffectedRows('delete_workflows_error');

					if ($task['task_type'] == "php_custom") {
						//self::wfm_SavePhpCustomToFile($task['id'], $task['task_implementation']);
					}
				}
			}
		}

	}

	static function publishWorkFlows($process_ids_array, $modeToSave, $levelToSave, $domainsToSave, $selectedIsPublishReqParam) {

		$workflows = self::getWorkFlows($process_ids_array);

		global $db, $mod_strings;

		// Create wfm-processes

		$old_ids__and__new_ids__process__array = Array();

		if (array_key_exists('processes', $workflows)) {
			foreach ($workflows['processes'] as $process) {

			}
		}

		// Create wfm-events

		$old_ids__and__new_ids__event__array = Array();

		if (array_key_exists('events', $workflows)) {
			foreach ($workflows['events'] as $parent_process_id => $events_from_parent_process_id) {
				foreach ($events_from_parent_process_id as $event) {
					self::publishRecord('asol_events', $event['id'], $modeToSave, $levelToSave, $domainsToSave, $selectedIsPublishReqParam);
				}
			}
		}

		// Create wfm-activities

		$old_ids__and__new_ids__activity__array = Array();

		if (array_key_exists('activities', $workflows)) {
			foreach ($workflows['activities'] as $parent_event_id => $activities_from_parent_event_id) {
				foreach ($activities_from_parent_event_id as $activity) {

					self::wfm_log('debug', '$old_ids__and__new_ids__activity__array=['.var_export($old_ids__and__new_ids__activity__array, true).']', __FILE__, __METHOD__, __LINE__);

					if (!array_key_exists($activity['id'], $old_ids__and__new_ids__activity__array)) {	// Event duplicity.

						self::publishRecord('asol_activity', $activity['id'], $modeToSave, $levelToSave, $domainsToSave, $selectedIsPublishReqParam);

						$old_ids__and__new_ids__activity__array[$activity['id']] = $activity['id'];
					} else {
						self::wfm_log('debug', "Event duplicity", __FILE__, __METHOD__, __LINE__);
					}

				}
			}
		}

		// Create wfm-activities(next_activities)

		//$old_ids__and__new_ids__next_activity__array = Array(); -> activities and next_activities in the same array

		if (array_key_exists('next_activities', $workflows)) {
			foreach ($workflows['next_activities'] as $parent_activity_id => $activities_from_parent_activity_id) {
				foreach ($activities_from_parent_activity_id as $next_activity) {

					self::publishRecord('asol_activity', $next_activity['id'], $modeToSave, $levelToSave, $domainsToSave, $selectedIsPublishReqParam);

					$old_ids__and__new_ids__activity__array[$next_activity['id']] = $new_next_activity_id;
				}
			}
		}

		// Create wfm-tasks

		if (array_key_exists('tasks', $workflows)) {
			foreach ($workflows['tasks'] as $parent_activity_id => $tasks_from_parent_activity_id) {
				foreach ($tasks_from_parent_activity_id as $task) {

					self::publishRecord('asol_task', $task['id'], $modeToSave, $levelToSave, $domainsToSave, $selectedIsPublishReqParam);
				}
			}
		}

	}

	static function publishRecord($moduleTable, $record_id, $modeToSave, $levelToSave, $domainsToSave, $selectedIsPublishReqParam) {

		global $db;

		$db->query("UPDATE ".$moduleTable." SET asol_domain_published_mode = ".$modeToSave." WHERE id = '".$record_id."'");
		$db->query("UPDATE ".$moduleTable." SET asol_domain_child_share_depth = '".$levelToSave."' WHERE id = '".$record_id."'");
		$db->query("UPDATE ".$moduleTable." SET asol_multi_create_domain = '".$domainsToSave."' WHERE id = '".$record_id."'");

		if ($selectedIsPublishReqParam == null) {
			if ($modeToSave == 0) {
				$db->query("UPDATE ".$moduleTable." SET asol_published_domain = 0 WHERE id='".$record_id."'");
			} else {
				$db->query("UPDATE ".$moduleTable." SET asol_published_domain = 1 WHERE id='".$record_id."'");
			}
		} else {
			if ($_REQUEST[$selectedIsPublishReqParam] == 0) {
				$db->query("UPDATE ".$moduleTable." SET asol_published_domain = 0 WHERE id='".$record_id."'");
			} else {
				$db->query("UPDATE ".$moduleTable." SET asol_published_domain = 1 WHERE id='".$record_id."'");
			}
		}
	}

	static function getWorkFlows($process_ids_array) {
		self::wfm_log('asol', "ENTRY", __FILE__, __METHOD__, __LINE__);
		self::wfm_log('debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);

		global $db;

		$workflows = Array();
		
		$workflows['version'] = wfm_utils::$wfm_release_version;

		foreach($process_ids_array as $process_id) {
			$process_query = $db->query ("
									SELECT *
									FROM asol_process
									WHERE id = '{$process_id}'
								");
			$process_row = $db->fetchByAssoc($process_query);

			$workflows['processes'][] = $process_row;
		}

		self::wfm_log('debug', '1 $workflows=['.var_export($workflows, true).']', __FILE__, __METHOD__, __LINE__);

		// Search for events
		foreach ($workflows['processes'] as $process) {

			$event_relationships_from_process = Array();
			$event_relationships_from_process_query = $db->query("
															SELECT *
															FROM asol_proces_asol_events_c
															WHERE asol_proce6f14process_ida = '{$process['id']}' AND deleted = 0
														");
			while ($event_relationships_from_process_row = $db->fetchByAssoc($event_relationships_from_process_query)) {
				$event_relationships_from_process[] = $event_relationships_from_process_row;
			}

			foreach ($event_relationships_from_process as $event_relationship) {
				$event_query = $db->query ("
										SELECT *
										FROM asol_events
										WHERE id = '{$event_relationship['asol_procea8ca_events_idb']}'
									");
				$event_row = $db->fetchByAssoc($event_query);

				$event_and_relationship = $event_row;
				$event_and_relationship['relationship'] = $event_relationship;

				$workflows['events'][$process['id']][] = $event_and_relationship;
			}
		}
		self::wfm_log('debug', '2 $workflows=['.var_export($workflows, true).']', __FILE__, __METHOD__, __LINE__);

		// Search for activities
		if (is_array($workflows['events'])) {
			foreach ($workflows['events'] as $events_from_parent_process_id) {
				foreach ($events_from_parent_process_id as $event) {
					$activity_relationships_from_event = Array();
					$activity_relationships_from_event_query = $db->query("
																SELECT *
																FROM asol_eventssol_activity_c
																WHERE asol_event87f4_events_ida = '{$event['id']}' AND deleted = 0
												   			");

					while ($activity_relationships_from_event_row = $db->fetchByAssoc($activity_relationships_from_event_query)) {
						$activity_relationships_from_event[] = $activity_relationships_from_event_row;
					}

					foreach ($activity_relationships_from_event as $activity_relationship) {
						$activity_query = $db->query ("
											SELECT *
											FROM asol_activity
											WHERE id = '{$activity_relationship['asol_event8042ctivity_idb']}'
										");
						$activity_row = $db->fetchByAssoc($activity_query);

						$activity_and_relationship = $activity_row;
						$activity_and_relationship['relationship'] = $activity_relationship;

						$workflows['activities'][$event['id']][] = $activity_and_relationship;
						//self::wfm_log('debug', "3 part \$workflows=[".var_export($workflows,true)."]", __FILE__, __METHOD__, __LINE__);
					}
				}
			}
		}
		self::wfm_log('debug', '3 $workflows=['.var_export($workflows, true).']', __FILE__, __METHOD__, __LINE__);

		// Search for next_activities from activities(from events)
		$activity_ids = Array();

		if (is_array($workflows['activities'])) {
			foreach ($workflows['activities'] as $activities_from_parent_event_id) {
				foreach ($activities_from_parent_event_id as $activity) {

					self::wfm_log('debug', '$activity_ids=['.var_export($activity_ids, true).']', __FILE__, __METHOD__, __LINE__);
					if (!in_array($activity['id'], $activity_ids)) { // Event duplicity.

						$next_activity_ids_all_tree = self::getNextActivities($activity['id']);

						self::wfm_log('debug', '$next_activity_ids_all_tree=['.var_export($next_activity_ids_all_tree, true).']', __FILE__, __METHOD__, __LINE__);

						foreach($next_activity_ids_all_tree as $next_activity_id) {
							$next_activity_query = $db->query("
														SELECT *
														FROM asol_activity
														WHERE id = '{$next_activity_id}'
													");
							$next_activity_row = $db->fetchByAssoc($next_activity_query);

							$activity_relationship_query = $db->query("
															SELECT *
															FROM asol_activisol_activity_c
															WHERE asol_activ9e2dctivity_idb  = '{$next_activity_row['id']}' AND deleted = 0
														");
							$activity_relationship_row = $db->fetchByAssoc($activity_relationship_query);

							$next_activity_and_relationship = $next_activity_row;
							$next_activity_and_relationship['relationship'] = $activity_relationship_row;

							$workflows['next_activities'][$activity_relationship_row['asol_activ898activity_ida']][] = $next_activity_and_relationship;
						}

						$activity_ids[] = $activity['id'];
					} else {
						self::wfm_log('debug', "Event duplicity", __FILE__, __METHOD__, __LINE__);
					}
				}
			}
		}
		self::wfm_log('debug', '4 $workflows=['.var_export($workflows, true).']', __FILE__, __METHOD__, __LINE__);

		// Search for tasks from activities
		$event_duplicity = Array();

		if (is_array($workflows['activities'])) {
			foreach ($workflows['activities'] as $activities_from_parent_event_id) {

				foreach($activities_from_parent_event_id as $activity) {

					if (in_array($activity['id'], $event_duplicity)) {
						continue;
					}
					$event_duplicity[] = $activity['id'];

					$task_relationships_from_activity = Array();
					$task_relationships_from_activity_query = $db->query("
																SELECT *
																FROM asol_activity_asol_task_c
																WHERE asol_activ5b86ctivity_ida = '{$activity['id']}' AND deleted = 0
															");
					while ($task_relationships_from_activity_row = $db->fetchByAssoc($task_relationships_from_activity_query)) {
						$task_relationships_from_activity[] = $task_relationships_from_activity_row;
					}

					foreach ($task_relationships_from_activity as $task_relationship) {
						$task_query = $db->query("
												SELECT *
												FROM asol_task
												WHERE id = '{$task_relationship['asol_activf613ol_task_idb']}'
											");
						$task_row = $db->fetchByAssoc($task_query);

						$task_and_relationship_and_emailtemplate = $task_row;
						$task_and_relationship_and_emailtemplate['relationship'] = $task_relationship;

						if ($task_row['task_type'] == 'send_email') {
							$fields = explode('${pipe}', $task_row['task_implementation']);
							$emailTemplateId = $fields[0];
							$task_emailtemplate = Basic_wfm::getRecord('email_templates', $emailTemplateId);
							$task_and_relationship_and_emailtemplate['email_template'] = $task_emailtemplate;
						}

						$workflows['tasks'][$activity['id']][] = $task_and_relationship_and_emailtemplate;
					}
				}
			}
		}
		self::wfm_log('debug', '5 $workflows=['.var_export($workflows, true).']', __FILE__, __METHOD__, __LINE__);

		// Search for tasks from next_activities
		if (is_array($workflows['next_activities'])) {
			foreach ($workflows['next_activities'] as $next_activities_from_parent_activity_id) {

				foreach($next_activities_from_parent_activity_id as $activity) {

					$task_relationships_from_activity = Array();
					$task_relationships_from_activity_query = $db->query("
																		SELECT *
																		FROM asol_activity_asol_task_c
																		WHERE asol_activ5b86ctivity_ida = '{$activity['id']}' AND deleted = 0
																	");
					while ($task_relationships_from_activity_row = $db->fetchByAssoc($task_relationships_from_activity_query)) {
						$task_relationships_from_activity[] = $task_relationships_from_activity_row;
					}

					foreach ($task_relationships_from_activity as $task_relationship) {
						$task_query = $db->query("
										SELECT *
										FROM asol_task
										WHERE id = '{$task_relationship['asol_activf613ol_task_idb']}'
									");
						$task_row = $db->fetchByAssoc($task_query);

						$task_and_relationship_and_emailtemplate = $task_row;
						$task_and_relationship_and_emailtemplate['relationship'] = $task_relationship;

						if ($task_row['task_type'] == 'send_email') {
							$fields = explode('${pipe}', $task_row['task_implementation']);
							$emailTemplateId = $fields[0];
							$task_emailtemplate = Basic_wfm::getRecord('email_templates', $emailTemplateId);
							$task_and_relationship_and_emailtemplate['email_template'] = $task_emailtemplate;
						}

						$workflows['tasks'][$activity['id']][] = $task_and_relationship_and_emailtemplate;

					}
				}
			}
		}
		self::wfm_log('debug', '6 $workflows=['.var_export($workflows, true).']', __FILE__, __METHOD__, __LINE__);

		return $workflows;
	}

	static function modifySqlImportWorkFlowsWithDomains($wfm_module, $import_domain_type, $explicit_domain) {
		self::wfm_log('debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);

		global $current_user;

		switch ($import_domain_type) {
			case 'keep_domain':
				$asol_domain_id = $wfm_module['asol_domain_id'];
				break;
			case 'use_current_user_domain':
				$asol_domain_id = $current_user->asol_default_domain;
				break;
			case 'use_explicit_domain':
				$asol_domain_id = $explicit_domain;
				break;
			default:
				break;
		}

		$query_domains_values = ", '{$asol_domain_id}', '{$wfm_module['asol_domain_child_share_depth']}', '{$wfm_module['asol_multi_create_domain']}', '{$wfm_module['asol_published_domain']}'";

		return $query_domains_values;
	}

	static function convert_recordIds_fromUrl_toDB_format($record_ids) {
		self::wfm_log('debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);

		$record_ids_array = explode(',', $record_ids);

		$record_ids_string = '';
		foreach ($record_ids_array as $record_id) {
			$record_ids_string .= "'{$record_id}',";
		}

		if (!empty($record_ids_string)) {
			$record_ids_string = substr($record_ids_string, 0, -1);
		} else {
			$record_ids_string = "''";
		}

		return $record_ids_string;
	}

	static function getProcessStatusWhenImportingWorkFlow($import_type, $set_status_type, $process) {

		if ($import_type == 'clone') {
			switch ($set_status_type) {
				case 'keep_status':
					$process_status = $process['status'];
					break;
				case 'set_status_inactive':
					$process_status = 'inactive';
					break;
				case 'set_status_active':
					$process_status = 'active';
					break;
			}
		} else {
			$process_status = $process['status'];
		}

		return $process_status;
	}

	static function getProcessStatusHtml($process_status) {

		global $app_list_strings;

		$font_color = ($process_status == 'active') ? 'green' : 'red';
		$process_status_html = "<b><font color='{$font_color}'>{$app_list_strings['wfm_process_status_list'][$process_status]}</font></b>";

		return $process_status_html;
	}

	public static function setSendEmailAddresses(& $reportMailer, $emailArray, $contextDomainId = null) {

		//self::wfm_log('asol', 'get_defined_vars=['.print_r(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);

		global $current_user, $db;


		//*************************************//
		//********Manage Report Domain*********//
		//*************************************//
		$domainsQuery = $db->query("SELECT * FROM upgrade_history WHERE id_name='AlineaSolDomains' AND status='installed'");
		$isDomainsInstalled = ($domainsQuery->num_rows > 0);

		if ($isDomainsInstalled) {
			$domainId = ($contextDomainId != null) ? $contextDomainId : $current_user->asol_default_domain;
		}

		//***********************//
		//****** TO EMAILS ******//
		//***********************//
		foreach ($emailArray['users_to'] as $key => $value) {
			$userBean = BeanFactory::getBean('Users', $value);
			if (!empty($userBean)) {
				$userEmail = $userBean->getUsersNameAndEmail();
				$validUserMail = ($isDomainsInstalled) ? (($userEmail['email'] != "") && ($userBean->asol_domain_id == $domainId)) : ($userEmail['email'] != "");
				if ($validUserMail) {
					//$reportMailer->AddAddress($userEmail['email']);
					self::wfm_AddAddress('to', $userEmail['email'], $reportMailer);
				}
			}
		}
		if (wfm_notification_emails_utils::isNotificationEmailsInstalled()) {
			foreach ($emailArray['notificationEmails_to'] as $key => $value) {
				$userBean = BeanFactory::getBean('asol_NotificationEmails', $value);
				if (!empty($userBean)) {
					$validUserMail = ($isDomainsInstalled) ? (($userBean->name != "") && ($userBean->asol_domain_id == $domainId)) : ($userBean->name != "");
					if ($validUserMail) {
						//$reportMailer->AddAddress($userEmail['email']);
						self::wfm_AddAddress('to', $userBean->name, $reportMailer);
					}
				}
			}
		}
		foreach($emailArray['roles_to'] as $key => $value) {
			$usersFromRole = Array();
			if ($isDomainsInstalled) {
				$usersFromRoleSql = "SELECT acl_roles_users.user_id FROM acl_roles_users LEFT JOIN users ON acl_roles_users.user_id=users.id WHERE acl_roles_users.role_id = '".$value."' AND users.asol_domain_id='".$domainId."' AND users.deleted=0";
			} else {
				$usersFromRoleSql = "SELECT acl_roles_users.user_id FROM acl_roles_users LEFT JOIN users ON acl_roles_users.user_id=users.id WHERE acl_roles_users.role_id = '".$value."'  AND users.deleted=0";
			}
			self::wfm_log('asol', '$usersFromRoleSql=['.var_export($usersFromRoleSql, true).']', __FILE__, __METHOD__, __LINE__);
			$usersFromRoleRs = $db->query($usersFromRoleSql);
			while($userFromRole_Row = $db->fetchByAssoc($usersFromRoleRs))
			$usersFromRole[] = $userFromRole_Row['user_id'];
			self::wfm_log('asol', '$usersFromRole=['.var_export($usersFromRole, true).']', __FILE__, __METHOD__, __LINE__);
			foreach($usersFromRole as $key => $value) {
				$userEmail = BeanFactory::getBean('Users', $value)->getUsersNameAndEmail();
				if ($userEmail['email'] != "") {
					//$reportMailer->AddAddress($userEmail['email']);
					self::wfm_AddAddress('to', $userEmail['email'], $reportMailer);
				}
			}
		}
		foreach ($emailArray['emails_to'] as $key => $value){
			if ($value != "") {
				//$reportMailer->AddAddress($value);
				self::wfm_AddAddress('to', $value, $reportMailer);
			}
		}

		//***********************//
		//****** CC EMAILS ******//
		//***********************//
		//Emails de los destinatarios copias
		foreach ($emailArray['users_cc'] as $key => $value) {
			$userBean = BeanFactory::getBean('Users', $value);
			if (!empty($userBean)) {
				$userEmail = $userBean->getUsersNameAndEmail();
				$validUserMail = ($isDomainsInstalled) ? (($userEmail['email'] != "") && ($userBean->asol_domain_id == $domainId)) : ($userEmail['email'] != "");
				if ($validUserMail) {
					//$reportMailer->AddCC($userEmail['email']);
					self::wfm_AddAddress('cc', $userEmail['email'], $reportMailer);
				}
			}
		}
		if (wfm_notification_emails_utils::isNotificationEmailsInstalled()) {
			foreach ($emailArray['notificationEmails_cc'] as $key => $value) {
				$userBean = BeanFactory::getBean('asol_NotificationEmails', $value);
				if (!empty($userBean)) {
					$validUserMail = ($isDomainsInstalled) ? (($userBean->name != "") && ($userBean->asol_domain_id == $domainId)) : ($userBean->name != "");
					if ($validUserMail) {
						//$reportMailer->AddCC($userEmail['email']);
						self::wfm_AddAddress('cc', $userBean->name, $reportMailer);
					}
				}
			}
		}
		foreach($emailArray['roles_cc'] as $key => $value) {
			$usersFromRole = Array();
			if ($isDomainsInstalled) {
				$usersFromRoleSql = "SELECT acl_roles_users.user_id FROM acl_roles_users LEFT JOIN users ON acl_roles_users.user_id=users.id WHERE acl_roles_users.role_id = '".$value."' AND users.asol_domain_id='".$domainId."' AND users.deleted=0";
			} else {
				$usersFromRoleSql = "SELECT acl_roles_users.user_id FROM acl_roles_users LEFT JOIN users ON acl_roles_users.user_id=users.id WHERE acl_roles_users.role_id = '".$value."'  AND users.deleted=0";
			}
			self::wfm_log('asol', '$usersFromRoleSql=['.var_export($usersFromRoleSql, true).']', __FILE__, __METHOD__, __LINE__);
			$usersFromRoleRs = $db->query($usersFromRoleSql);
			while($userFromRole_Row = $db->fetchByAssoc($usersFromRoleRs))
			$usersFromRole[] = $userFromRole_Row['user_id'];
			self::wfm_log('asol', '$usersFromRole=['.var_export($usersFromRole, true).']', __FILE__, __METHOD__, __LINE__);
			foreach($usersFromRole as $key => $value) {
				$userBean = BeanFactory::getBean('Users', $value);
				//self::wfm_log('asol', '$userBean=['.print_r($userBean, true).']', __FILE__, __METHOD__, __LINE__);
				$userEmail = $userBean->getUsersNameAndEmail();
				//$userEmail = BeanFactory::getBean('Users', $value)->getUsersNameAndEmail();
				if ($userEmail['email'] != "") {
					//$reportMailer->AddCC($userEmail['email']);
					self::wfm_AddAddress('cc', $userEmail['email'], $reportMailer);
				}
			}
		}
		foreach ($emailArray['emails_cc'] as $key => $value){
			if ($value != "") {
				//$reportMailer->AddCC($value);
				self::wfm_AddAddress('cc', $value, $reportMailer);
			}
		}

		//***********************//
		//***** BCC EMAILS ******//
		//***********************//
		foreach ($emailArray['users_bcc'] as $key => $value) {
			$userBean = BeanFactory::getBean('Users', $value);
			if (!empty($userBean)) {
				$userEmail = $userBean->getUsersNameAndEmail();
				$validUserMail = ($isDomainsInstalled) ? (($userEmail['email'] != "") && ($userBean->asol_domain_id == $domainId)) : ($userEmail['email'] != "");
				if ($validUserMail) {
					//$reportMailer->AddBCC($userEmail['email']);
					self::wfm_AddAddress('bcc', $userEmail['email'], $reportMailer);
				}
			}
		}
		if (wfm_notification_emails_utils::isNotificationEmailsInstalled()) {
			foreach ($emailArray['notificationEmails_bcc'] as $key => $value) {
				$userBean = BeanFactory::getBean('asol_NotificationEmails', $value);
				if (!empty($userBean)) {
					$validUserMail = ($isDomainsInstalled) ? (($userBean->name != "") && ($userBean->asol_domain_id == $domainId)) : ($userBean->name != "");
					if ($validUserMail) {
						//$reportMailer->AddBCC($userEmail['email']);
						self::wfm_AddAddress('bcc', $userBean->name, $reportMailer);
					}
				}
			}
		}
		foreach($emailArray['roles_bcc'] as $key => $value) {
			$usersFromRole = Array();
			if ($isDomainsInstalled) {
				$usersFromRoleSql = "SELECT acl_roles_users.user_id FROM acl_roles_users LEFT JOIN users ON acl_roles_users.user_id=users.id WHERE acl_roles_users.role_id = '".$value."' AND users.asol_domain_id='".$domainId."' AND users.deleted=0";
			} else {
				$usersFromRoleSql = "SELECT acl_roles_users.user_id FROM acl_roles_users LEFT JOIN users ON acl_roles_users.user_id=users.id WHERE acl_roles_users.role_id = '".$value."'  AND users.deleted=0";
			}
			$usersFromRoleRs = $db->query($usersFromRoleSql);
			while($userFromRole_Row = $db->fetchByAssoc($usersFromRoleRs))
			$usersFromRole[] = $userFromRole_Row['user_id'];
			self::wfm_log('asol', '$usersFromRole=['.var_export($usersFromRole, true).']', __FILE__, __METHOD__, __LINE__);
			foreach($usersFromRole as $key => $value) {
				$userEmail = BeanFactory::getBean('Users', $value)->getUsersNameAndEmail();
				if ($userEmail['email'] != "") {
					//$reportMailer->AddBCC($userEmail['email']);
					self::wfm_AddAddress('bcc', $userEmail['email'], $reportMailer);
				}
			}
		}
		foreach ($emailArray['emails_bcc'] as $key => $value){
			if ($value != "") {
				//$reportMailer->AddBCC($value);
				self::wfm_AddAddress('bcc', $value, $reportMailer);
			}
		}

	}

	static function wfm_AddAddress($value_to_cc_bcc, $email, & $sugarPHPMailer) {

		global $sugar_config;

		if (!empty($email)) {

			// Modify emails in development-sugarcrm-instance
			$WFM_development_mode = ((isset($sugar_config['WFM_development_mode'])) && ($sugar_config['WFM_development_mode'])) ? true : false;
			if ($WFM_development_mode) {
				$WFM_development_mode_allowed_emails = (isset($sugar_config['WFM_development_mode_allowed_emails']) && is_array($sugar_config['WFM_development_mode_allowed_emails'])) ? $sugar_config['WFM_development_mode_allowed_emails'] : Array();
				if (!in_array($email, $WFM_development_mode_allowed_emails)) {
					$WFM_development_mode_notAllowedEmails_textAddedToEmailAddress = (isset($sugar_config['WFM_development_mode_notAllowedEmails_textAddedToEmailAddress']) && is_string($sugar_config['WFM_development_mode_notAllowedEmails_textAddedToEmailAddress'])) ? $sugar_config['WFM_development_mode_notAllowedEmails_textAddedToEmailAddress'] : 'XWFMnotAllowedEmailX';
					$email = str_replace('@', "@{$WFM_development_mode_notAllowedEmails_textAddedToEmailAddress}", $email);
				}
			}

			switch ($value_to_cc_bcc) {
				case 'to':									
					$sugarPHPMailer->AddAddress($email);
					break;
				case 'cc':
					$sugarPHPMailer->AddCC($email);
					break;
				case 'bcc':
					$sugarPHPMailer->AddBCC($email);
			}
		}
	}

	static function getPublishedDomains($event_id) {

		$process = self::getProcess_fromEventId($event_id);

		$processDomainId = $process['asol_domain_id'];
		$processDomainIsPublished = ($process['asol_published_domain'] == '1') ? true : false;

		$processDomainPublishedMode = $process['asol_domain_published_mode'];
		$processDomainPublishedLevels = ($process['asol_domain_child_share_depth'] === ';;') ? array() : explode(';;', substr($process['asol_domain_child_share_depth'], 1, -1));
		$processDomainPublishedDomains = ($process['asol_multi_create_domain'] === ';;') ? array() : explode(';;', substr($process['asol_multi_create_domain'], 1, -1));

		$domainPublishingInfo = array(
			'domains' => $processDomainPublishedDomains,
			'levels' => $processDomainPublishedLevels,
			'mode' => $processDomainPublishedMode,
			'mainDomain' => $processDomainId,
			'isPublished' => $processDomainIsPublished
		);

		require_once("modules/asol_Domains/AlineaSolDomainsFunctions.php");

		$processPublishedDomains = asol_manageDomains::getDomainsPublished($domainPublishingInfo);
		//$processPublishedDomains[] = $processDomainId;

		return $processPublishedDomains;
	}

	static function initializeEmailArray(& $emailArray) {

		$emailArray = Array();
		$emailArray['emails_to'] = Array();
		$emailArray['users_to'] = Array();
		$emailArray['roles_to'] = Array();
		$emailArray['notificationEmails_to'] = Array();
		$emailArray['emails_cc'] = Array();
		$emailArray['users_cc'] = Array();
		$emailArray['roles_cc'] = Array();
		$emailArray['notificationEmails_cc'] = Array();
		$emailArray['emails_bcc'] = Array();
		$emailArray['users_bcc'] = Array();
		$emailArray['roles_bcc'] = Array();
		$emailArray['notificationEmails_bcc'] = Array();

	}

	static function hasLogicHook($module, $logic_hook='after_save', $action=array(2, "wfm_hook",  "custom/include/wfm_hook.php", "wfm_hook_process", "execute_process")) {

		require_once ('include/utils/logic_utils.php');

		$hasLogicHook = false; // For after_save and before_save, both at the same time

		if(file_exists("custom/modules/{$module}/logic_hooks.php")){
			$hook_array = get_hook_array($module);

			if (check_existing_element($hook_array, $logic_hook, $action) == true) {
				$hasLogicHook = true;
			}
		}

		return $hasLogicHook;
	}

	static function getSendEmailsWithNoEmailTemplate($process_id) {

		$send_emails_with_no_email_template = Array();

		$workflow = self::getWorkFlows(Array($process_id));

		// Validate wfm-tasks

		if (array_key_exists('tasks', $workflow)) {
			foreach ($workflow['tasks'] as $parent_activity_id => $tasks_from_parent_activity_id) {
				foreach ($tasks_from_parent_activity_id as $task) {
					if ($task['task_type'] == 'send_email') {
						$fields = explode('${pipe}', $task['task_implementation']);
						$emailTemplateId = $fields[0];

						if (!Basic_wfm::checkRecordAlreadyExists('email_templates', $emailTemplateId)) {
							$send_emails_with_no_email_template[] = Array('id' => $task['id'], 'name' => $task['name']);
						}
					}
				}
			}
		}

		return $send_emails_with_no_email_template;
	}

	static function validate_send_email_references_existing_email_template($process_id) {

		$send_emails = self::getSendEmailsWithNoEmailTemplate($process_id);
		if (count($send_emails) == 0) {
			return false;
		} else {
			$tasks_rows = '';
			foreach ($send_emails as $send_email) {
				$tasks_rows .= "<tr><td>{$send_email['name']}</td><td>{$send_email['id']}</td></tr>";
			}

			$error = translate('LBL_VALIDATE_SEND_EMAIL_REFERENCES_EXISTING_EMAIL_TEMPLATE_ERROR', 'asol_Process');
			$tasks_table = "<table class=\\\"popupHelp\\\">{$tasks_rows}</table>";
			$info_icon =  "<img border='0' class='inlineHelpTip' alt='Info' src='themes/Sugar5/images/helpInline.gif' onClick='return SUGAR.util.showHelpTips(this, &quot;<div class=\\\"detail view  detail508\\\"><table class=\\\"list view\\\"><tr><td width=\\\"20%\\\"><b>Error:</b></td><td width=\\\"80%\\\">".$error."</td></tr><tr><td width=\\\"20%\\\"><b>Tasks:</b></td><td width=\\\"80%\\\">".$tasks_table."</td></tr></table></div>&quot;, &quot;&quot;, &quot;&quot;);'>";

			return $info_icon;
		}
	}

	static function manageImportEmailTemplates(& $task_implementation, $task_email_template, $import_email_template_type, $if_email_template_already_exists, $query_domains_columns, $query_domains_values) {

		global $db;

		switch ($import_email_template_type) {

			case 'do_not_import':
				break;

			case 'import':

				$fields = explode('${pipe}', $task_implementation);
				$emailTemplateId = $fields[0];

				if (!empty($emailTemplateId)) { // So import does not create an empty email_template

					$current_datetime = gmdate('Y-m-d H:i:s');

					if (Basic_wfm::checkRecordAlreadyExists('email_templates', $emailTemplateId)) {
						switch ($if_email_template_already_exists) {
							case 'replace':
								$db->query("DELETE FROM email_templates WHERE id = '{$task_email_template['id']}' ");

								$task_email_template_id = $task_email_template['id'];
								$task_email_template_date_entered = $task_email_template['date_entered'];
								$task_email_template_date_modified = $task_email_template['date_modified'];
								break;
							case 'clone':
								$task_email_template_id = create_guid();
								$task_email_template_date_entered = $current_datetime;
								$task_email_template_date_modified = $current_datetime;
								break;
						}
					} else {
						$task_email_template_id = $task_email_template['id'];
						$task_email_template_date_entered = $task_email_template['date_entered'];
						$task_email_template_date_modified = $task_email_template['date_modified'];
					}

					$fields[0] = $task_email_template_id;
					$task_implementation = implode('${pipe}', $fields);

					$db->query("
							REPLACE INTO email_templates (id                            , date_entered                            , date_modified                            , modified_user_id                            , created_by                            , published                            , name                            , description                            , subject                            , body                            , body_html                            , deleted                            , assigned_user_id                            , text_only	                                       {$query_domains_columns} )
							VALUES                      ('{$task_email_template_id}', '{$task_email_template_date_entered}', '{$task_email_template_date_modified}', '{$task_email_template['modified_user_id']}', '{$task_email_template['created_by']}', '{$task_email_template['published']}', '{$task_email_template['name']}', '{$task_email_template['description']}', '{$task_email_template['subject']}', '{$task_email_template['body']}', '{$task_email_template['body_html']}', '{$task_email_template['deleted']}', '{$task_email_template['assigned_user_id']}', '{$task_email_template['text_only']}'                 {$query_domains_values})
					");
				}

				break;
		}
	}

	static function getEventInitialize($process_id) {

		global $db;

		$objects = Array();

		$sql = "
				SELECT asol_events.*
				FROM asol_events
				INNER JOIN asol_proces_asol_events_c ON (asol_proces_asol_events_c.asol_procea8ca_events_idb = asol_events.id AND asol_proces_asol_events_c.deleted = 0)
				INNER JOIN asol_process ON (asol_process.id = asol_proces_asol_events_c.asol_proce6f14process_ida AND asol_process.deleted = 0)
				WHERE asol_events.type = 'initialize' AND asol_process.id = '{$process_id}'
		   ";
		$object_query = $db->query($sql);

		while ($object_row = $db->fetchByAssoc($object_query)) {
			$objects[] = $object_row;
		}

		return $objects;
	}

	static function convertArrayToStringDB($array) {

		$string = '';

		foreach ($array as $item) {
			$string .= "'{$item}',";
		}

		if (!empty($string)) {
			$string = substr($string, 0, -1);
		} else {
			$string = "''";
		}

		return $string;
	}


	static function getInitializeWorkingNode($process_id) {

		global $db;

		// Get the wfm-event-initialize that belongs to the WorkFlow with this wfm-process
		$sql_event = "
			SELECT asol_events.*
			FROM asol_events
			INNER JOIN asol_proces_asol_events_c ON (asol_proces_asol_events_c.asol_procea8ca_events_idb = asol_events.id AND asol_proces_asol_events_c.deleted = 0)
			INNER JOIN asol_process ON (asol_process.id = asol_proces_asol_events_c.asol_proce6f14process_ida AND asol_process.deleted = 0)
			WHERE asol_process.id = '{$process_id}' AND asol_events.type = 'initialize'
			LIMIT 1				  
	    ";
		$query_event = $db->query($sql_event);
		$row_event = $db->fetchByAssoc($query_event);

		// Get working_node type=initialize
		$sql_working_node = "
			SELECT *
			FROM asol_workingnodes
			WHERE asol_events_id_c = '{$row_event['id']}'
		"; // FIXME - (mycrm) - One of our colleagues had identified a process in SugarCRM instance, localized in wfm_utils.php File from Workflow Module, process that takes 7 minutes because in the query is no ID, no event found, related with the Process. Is there a way to fix such behavior without modifying the code? ( Otherwise we need to add in front of  query some validation like if(isset($row_event["id"])) or something. )  
		$query_working_node = $db->query($sql_working_node);
		$row_working_node = $db->fetchByAssoc($query_working_node);

		return $row_working_node;
	}
	
	static function getWorkingNodeById($working_node_id) {
		
		global $db;
		
		$sql_working_node = "
			SELECT *
			FROM asol_workingnodes
			WHERE id = '{$working_node_id}'
		";
		$query_working_node = $db->query($sql_working_node);
		$row_working_node = $db->fetchByAssoc($query_working_node);

		return $row_working_node;
	}

	static function getGlobalCustomVariables($process_id) {

		$working_node = self::getInitializeWorkingNode($process_id);

		$custom_variables = unserialize(base64_decode($working_node['custom_variables']));

		return $custom_variables['GLOBAL_CVARS'];
	}

	static function setGlobalCustomVariables($process_id, $global_custom_variables) {

		global $db;

		$working_node = self::getInitializeWorkingNode($process_id);

		wfm_utils::wfm_log('debug', '$working_node=['.var_export($working_node, true).']', __FILE__, __METHOD__, __LINE__);

		if (!empty($working_node)) {

			// Update working_node type=initialize
			$custom_variables = unserialize(base64_decode($working_node['custom_variables']));
			$custom_variables['GLOBAL_CVARS'] = $global_custom_variables;

			$date_modified = gmdate('Y-m-d H:i:s');
			$custom_variables_to_db = base64_encode(serialize($custom_variables));

			$sql_update = "
				UPDATE asol_workingnodes 
				SET custom_variables = '{$custom_variables_to_db}', date_modified = '{$date_modified}'
				WHERE id = '{$working_node['id']}'
			";
			$db->query($sql_update);
		}
	}

	static function putWorkingNodeToSleep($working_node) {

		global $db;

		$date_modified = gmdate('Y-m-d H:i:s');

		$sql_update = "
			UPDATE asol_workingnodes 
			SET status = 'sleeping' , date_modified = '{$date_modified}'
			WHERE id = '{$working_node['id']}' AND status != 'sleeping'
		";
		$db->query($sql_update);
		self::checkAffectedRows('concurrence_error', $sql, __FILE__, __METHOD__, __LINE__);

		usleep(rand(1000000, 2000000));

		$sql_update = "
			UPDATE asol_workingnodes
			SET status = '{$working_node['status']}' , date_modified = '{$date_modified}' 
			WHERE id = '{$working_node['id']}' and status = 'sleeping'
		";
		$db->query($sql_update);
		self::checkAffectedRows('concurrence_error', $sql, __FILE__, __METHOD__, __LINE__);

	}

	static function addPremiumAppListStrings(& $app_list_strings, $language, $premiumFeature) {

		$extraParams = Array(
			'app_list_strings' => $app_list_strings,
			'language' => $language
		);

		$newAppListStrings = wfm_reports_utils::managePremiumFeature($premiumFeature, "wfm_utils_premium.php", $premiumFeature, $extraParams);

		if ($newAppListStrings !== false) {
			$app_list_strings = $newAppListStrings;
		}
	}

	/*
	static function addFormsScriptsForEnterprise($availableEditableFields) {
	
		$premiumFeature = 'addFormsScripts';
		
		$extraParams = Array(
			'availableEditableFields' => $availableEditableFields,
		);
	
		wfm_reports_utils::managePremiumFeature($premiumFeature, "wfm_utils_premium.php", $premiumFeature, $extraParams);
	}
	*/
	
	function addFormsScripts($availableEditableFields)  {
	
		global $app_list_strings;
	
		if (wfm_utils::isCommonBaseInstalled()) {
	
			require_once("modules/asol_Common/include/commonUtils.php");
	
			if (asol_CommonUtils::isFormsViewsInstalled()) {
	
				//if (wfm_utils::hasPremiumFeatures()) {
	
					echo '
					<!-- BEGIN - Forms -->
	
					<script type="text/javascript" src="modules/asol_Common/include/client/libraries/jscolor/jscolor.js?version='.wfm_utils::$wfm_code_version.'"></script>
					<script type="text/javascript" src="modules/asol_Forms/include/client/helpers/formsResponseGenerator.js?version='.wfm_utils::$wfm_code_version.'"></script>
	
					<script type="text/javascript">
	
						var availableEditableFields ='.json_encode($availableEditableFields).';
						var availableItems ='.json_encode(asol_FormsUtils::getAvailableItems()).';
	
						asolFormResponseGenerator.setAvailableElements(availableEditableFields);
						asolFormResponseGenerator.setAvailableItems(availableItems);
	
						asolFormResponseGenerator.setModule("asol_Forms");
						asolFormResponseGenerator.setLanguage({
							"title" : "'.translate("LBL_FORM_RESPONSE_GENERATOR", "asol_Forms").'",
							"generate" : "'.translate("LBL_FORM_RESPONSE_GENERATE", "asol_Forms").'",
							"success" : {
								"label" : "'.translate("LBL_FORM_RESPONSE_SUCCESS", "asol_Forms").'",
								"true" : "'.translate("LBL_FORM_RESPONSE_SUCCESS_TRUE", "asol_Forms").'",
								"false" : "'.translate("LBL_FORM_RESPONSE_SUCCESS_FALSE", "asol_Forms").'",
								"sys_forms_success" : "'.translate("LBL_FORM_RESPONSE_SUCCESS_SYS_FORMS_SUCCESS", "asol_Forms").'",
							},
							"messages" : {
								"label" : "'.translate("LBL_FORM_RESPONSE_MESSAGES", "asol_Forms").'",
								"scope" : {
									"label" : "'.translate("LBL_FORM_RESPONSE_MESSAGES_SCOPE", "asol_Forms").'",
									"field" : "'.translate("LBL_FORM_RESPONSE_MESSAGES_SCOPE_FIELD", "asol_Forms").'",
									"global" : "'.translate("LBL_FORM_RESPONSE_MESSAGES_SCOPE_GLOBAL", "asol_Forms").'",
								},
								"field" : "'.translate("LBL_FORM_RESPONSE_MESSAGES_FIELD", "asol_Forms").'",
								"color" : "'.translate("LBL_FORM_RESPONSE_MESSAGES_COLOR", "asol_Forms").'",
								"value" : "'.translate("LBL_FORM_RESPONSE_MESSAGES_VALUE", "asol_Forms").'",
							},
							"actions" : {
								"label" : "'.translate("LBL_FORM_RESPONSE_ACTIONS", "asol_Forms").'",
								"operation" : {
									"label" : "'.translate("LBL_FORM_RESPONSE_ACTIONS_OPERATION", "asol_Forms").'",
									"reload" : "'.translate("LBL_FORM_RESPONSE_ACTIONS_OPERATION_RELOAD", "asol_Forms").'",
									"load" : "'.translate("LBL_FORM_RESPONSE_ACTIONS_OPERATION_LOAD", "asol_Forms").'",
									"hide" : "'.translate("LBL_FORM_RESPONSE_ACTIONS_OPERATION_HIDE", "asol_Forms").'",
									"show" : "'.translate("LBL_FORM_RESPONSE_ACTIONS_OPERATION_SHOW", "asol_Forms").'",
									"close" : "'.translate("LBL_FORM_RESPONSE_ACTIONS_OPERATION_CLOSE", "asol_Forms").'",
								},
								"target" : {
									"label" : "'.translate("LBL_FORM_RESPONSE_ACTIONS_OPERATION_TARGET", "asol_Forms").'",
									"self" : "'.translate("LBL_FORM_RESPONSE_ACTIONS_OPERATION_TARGET_SELF", "asol_Forms").'",
								},
								"parameters" : {
									"label" : "'.translate("LBL_FORM_RESPONSE_ACTIONS_OPERATION_PARAMETERS", "asol_Forms").'",
									"module" : {
										"label" : "'.translate("LBL_FORM_RESPONSE_ACTIONS_OPERATION_PARAMETERS_MODULE", "asol_Forms").'",
										"forms" : "'.translate("LBL_FORM_RESPONSE_ACTIONS_OPERATION_PARAMETERS_MODULE_FORMS", "asol_Forms").'",
										"views" : "'.translate("LBL_FORM_RESPONSE_ACTIONS_OPERATION_PARAMETERS_MODULE_VIEWS", "asol_Forms").'",
										"reports" : "'.translate("LBL_FORM_RESPONSE_ACTIONS_OPERATION_PARAMETERS_MODULE_REPORTS", "asol_Forms").'",
									},
									"record" : "'.translate("LBL_FORM_RESPONSE_ACTIONS_OPERATION_PARAMETERS_RECORD", "asol_Forms").'",
									"mapping" : {
										"title" : "'.translate("LBL_FORM_RESPONSE_ACTIONS_OPERATION_PARAMETERS_MAPPING", "asol_Forms").'",
										"reference" : "'.translate("LBL_FORM_RESPONSE_ACTIONS_OPERATION_PARAMETERS_MAPPING_REFERENCE", "asol_Forms").'",
										"value" : "'.translate("LBL_FORM_RESPONSE_ACTIONS_OPERATION_PARAMETERS_MAPPING_VALUE", "asol_Forms").'",
									}
								}
							}
						});
					</script>
	
					<!-- END - Forms -->
					';
	
					echo wfm_utils::_getModLanguageJS('asol_Forms');
				//}
	
			}
		}
	
	}

	static function addPremiumModuleRoles(& $newModules, $premiumFeature) {

		$extraParams = Array(
			'newModules' => $newModules,
		);

		$newModuleRoles = wfm_reports_utils::managePremiumFeature($premiumFeature, "wfm_utils_premium.php", $premiumFeature, $extraParams);

		if ($newModuleRoles !== false) {
			$newModules = $newModuleRoles;
		}
	}

	static function get_bean_table($module_name) {
		global $beanList, $beanFiles;
		$class_name = $beanList[$module_name];
		require_once($beanFiles[$class_name]);
		$class_name = new $class_name();
		$table=$class_name->table_name;
		return $table;
	}

	static public function getInitJqueryScriptHtml() {

		return '
		function initJqueryScripts() {
	
			if (typeof jQuery === "undefined") {
		
				$LAB.script("modules/asol_Reports/include/js/jquery.min.js").wait().script("modules/asol_Reports/include/js/jquery.UI.min.js").wait(function(){ setDialogFxDisplay(); initDragDropElements(); initEmailFrame(); });
			 	
			} else if (typeof jQuery.ui === "undefined") {
		
				$LAB.script("modules/asol_Reports/include/js/jquery.UI.min.js").wait(function(){ setDialogFxDisplay(); initDragDropElements(); initEmailFrame(); });
			 	
			} else {
		
				setDialogFxDisplay(); initDragDropElements(); initEmailFrame();
		
			}
			
		}
		';

	}

	static public function cleanDeletedWFMEntitiesAndRelationships() {

		global $db;

		$tables = Array(
			'asol_process',
			'asol_events',
			'asol_activity',
			'asol_task',

			'asol_proces_asol_events_c',
			'asol_eventssol_activity_c',
			'asol_activisol_activity_c',
			'asol_activity_asol_task_c',
		);

		foreach ($tables as $table) {
			$db->query("DELETE FROM {$table} WHERE deleted = 1;");
		}
	}

	static public function cleanUnrelatedWFMEntities() {

		global $db;

		// TODO disable wfm-entities logic_hooks
		// FIXME

		// Events

		$bean = BeanFactory::getBean('asol_Events');
		$events = $bean->get_full_list();

		if (is_array($events)) {
			foreach ($events as $ev) {

				require_once("modules/asol_Events/asol_Events.php");
				$event = new asol_Events();
				$event->retrieve($ev->id); // Because get_full_list does not load relationships.
				//$event = BeanFactory::getBean('asol_Events', $event->id); // Does not retrieve fresh-bean // The Last 10 loaded beans are cached in memory to prevent multiple retrieves per request.

				wfm_utils::wfm_log('flow_debug', '$event->name=['.var_export($event->name, true).']', __FILE__, __METHOD__, __LINE__);
				wfm_utils::wfm_log('flow_debug', '$event->asol_proce6f14process_ida=['.var_export($event->asol_proce6f14process_ida, true).']', __FILE__, __METHOD__, __LINE__);
				wfm_utils::wfm_log('flow_debug', '$event->asol_process_asol_events_name=['.var_export($event->asol_process_asol_events_name, true).']', __FILE__, __METHOD__, __LINE__);
				wfm_utils::wfm_log('flow_debug', '$event->asol_process_asol_events_1asol_process_ida=['.var_export($event->asol_process_asol_events_1asol_process_ida, true).']', __FILE__, __METHOD__, __LINE__);
				wfm_utils::wfm_log('flow_debug', '$event->asol_process_asol_events_1_name=['.var_export($event->asol_process_asol_events_1_name, true).']', __FILE__, __METHOD__, __LINE__);

				$hasParent = ((!empty($event->asol_proce6f14process_ida)) || (!empty($event->asol_process_asol_events_1asol_process_ida))) ? true : false;

				if (!$hasParent) {
					wfm_utils::wfm_log('flow_debug', 'Delete $event->name=['.var_export($event->name, true).']', __FILE__, __METHOD__, __LINE__);
					$event->mark_deleted($event->id);
				}
			}
		}

		// Activities

		do {
			$isNecessaryAnotherLoop = false; // Unlimited next-activities.

			$bean = BeanFactory::getBean('asol_Activity');
			$activities = $bean->get_full_list();

			if (is_array($activities)) {
				foreach ($activities as $act) {

					require_once("modules/asol_Activity/asol_Activity.php");
					$activity = new asol_Activity();
					$activity->retrieve($act->id); // Because get_full_list does not load relationships.
					//$activity = BeanFactory::getBean('asol_Activity', $activity->id); // Does not retrieve fresh-bean // The Last 10 loaded beans are cached in memory to prevent multiple retrieves per request.

					wfm_utils::wfm_log('flow_debug', '$activity->name=['.var_export($activity->name, true).']', __FILE__, __METHOD__, __LINE__);
					wfm_utils::wfm_log('flow_debug', '$activity->asol_activ898activity_ida=['.var_export($activity->asol_activ898activity_ida, true).']', __FILE__, __METHOD__, __LINE__);
					wfm_utils::wfm_log('flow_debug', '$activity->asol_activity_asol_activity_name=['.var_export($activity->asol_activity_asol_activity_name, true).']', __FILE__, __METHOD__, __LINE__);
					wfm_utils::wfm_log('flow_debug', '$activity->asol_process_asol_activityasol_process_ida=['.var_export($activity->asol_process_asol_activityasol_process_ida, true).']', __FILE__, __METHOD__, __LINE__);
					wfm_utils::wfm_log('flow_debug', '$activity->asol_process_asol_activity_name=['.var_export($activity->asol_process_asol_activity_name, true).']', __FILE__, __METHOD__, __LINE__);

					$hasParent = false;

					$link = 'asol_events_asol_activity';
					if ($activity->load_relationship($link)) {
						$relatedBeans = $activity->$link->getBeans();
						$hasParent = (!empty($relatedBeans)) ? true : $hasParent;
						wfm_utils::wfm_log('flow_debug', 'asol_events_asol_activity(many-to-many) $hasParent=['.var_export($hasParent, true).']', __FILE__, __METHOD__, __LINE__);
					}

					$hasParent = (!empty($activity->asol_activ898activity_ida)) ? true : $hasParent;
					$hasParent = (!empty($activity->asol_process_asol_activityasol_process_ida)) ? true : $hasParent;

					if (!$hasParent) {
						wfm_utils::wfm_log('flow_debug', 'Delete $activity->name=['.var_export($activity->name, true).']', __FILE__, __METHOD__, __LINE__);
						$activity->mark_deleted($activity->id);
						$isNecessaryAnotherLoop = true;
					}
				}
			}
		} while ($isNecessaryAnotherLoop);

		// Tasks

		$bean = BeanFactory::getBean('asol_Task');
		$tasks = $bean->get_full_list();

		if (is_array($tasks)) {
			foreach ($tasks as $t) {

				require_once("modules/asol_Task/asol_Task.php");
				$task = new asol_Task();
				$task->retrieve($t->id); // Because get_full_list does not load relationships.
				// $task = BeanFactory::getBean('asol_Task', $task->id); // Does not retrieve fresh-bean // The Last 10 loaded beans are cached in memory to prevent multiple retrieves per request.

				wfm_utils::wfm_log('flow_debug', '$task->name=['.var_export($task->name, true).']', __FILE__, __METHOD__, __LINE__);
				wfm_utils::wfm_log('flow_debug', '$task->asol_activ5b86ctivity_ida=['.var_export($task->asol_activ5b86ctivity_ida, true).']', __FILE__, __METHOD__, __LINE__);
				wfm_utils::wfm_log('flow_debug', '$task->asol_activity_asol_task_name=['.var_export($task->asol_activity_asol_task_name, true).']', __FILE__, __METHOD__, __LINE__);
				wfm_utils::wfm_log('flow_debug', '$task->asol_process_asol_taskasol_process_ida=['.var_export($task->asol_process_asol_taskasol_process_ida, true).']', __FILE__, __METHOD__, __LINE__);
				wfm_utils::wfm_log('flow_debug', '$task->asol_process_asol_task_name=['.var_export($task->asol_process_asol_task_name, true).']', __FILE__, __METHOD__, __LINE__);

				$hasParent = ((!empty($task->asol_activ5b86ctivity_ida)) || (!empty($task->asol_process_asol_taskasol_process_ida))) ? true : false;

				if (!$hasParent) {
					wfm_utils::wfm_log('flow_debug', 'Delete $task->name=['.var_export($task->name, true).']', __FILE__, __METHOD__, __LINE__);
					$task->mark_deleted($task->id);
				}
			}
		}

		// Clean deleted=1
		self::cleanDeletedWFMEntitiesAndRelationships();
	}

	static public function cleanUnrelatedWFMEntities_test() {

		global $db;

		$db->query("
			DELETE FROM asol_events
			WHERE id NOT IN (
				SELECT id FROM (
				 	SELECT asol_events.id, asol_events.name
				 	FROM asol_events
					INNER JOIN asol_proces_asol_events_c
					ON asol_events.id = asol_proces_asol_events_c.asol_procea8ca_events_idb
					WHERE asol_events.deleted = 0 AND asol_proces_asol_events_c.deleted = 0
				) AS relatedEventsIds
			)
			;
		");
			
		$db->query("
			DELETE FROM asol_activity
			WHERE id NOT IN (
				SELECT id FROM (
				 	SELECT asol_activity.id, asol_activity.name
				 	FROM asol_activity
					INNER JOIN asol_eventssol_activity_c
					ON asol_activity.id = asol_eventssol_activity_c.asol_event8042ctivity_idb
					WHERE asol_activity.deleted = 0 AND asol_eventssol_activity_c.deleted = 0
					
					UNION
					
					SELECT asol_activity.id, asol_activity.name
				 	FROM asol_activity
					INNER JOIN asol_activisol_activity_c
					ON asol_activity.id = asol_activisol_activity_c.asol_activ9e2dctivity_idb
					WHERE asol_activity.deleted = 0 AND asol_activisol_activity_c.deleted = 0
				) AS relatedActivitiesIds
			)
			;
		");

		$db->query("
			DELETE FROM asol_events
			WHERE id NOT IN (
				SELECT id FROM (
				 	SELECT asol_events.id, asol_events.name
				 	FROM asol_events
					INNER JOIN asol_proces_asol_events_c
					ON asol_events.id = asol_proces_asol_events_c.asol_procea8ca_events_idb
					WHERE asol_events.deleted = 0 AND asol_proces_asol_events_c.deleted = 0
				) AS relatedEventsIds
			)
			;
		");

	}

	static public function cleanDeletedLoginAudit() {

		global $db;

		$db->query("DELETE FROM asol_loginaudit WHERE deleted = 1;");

	}

	static public function cleanDeletedEmailTemplates() {

		global $db;

		$db->query("DELETE FROM email_templates WHERE deleted = 1;");

	}

	static public function cleanWFMBrokenWorkingNodes() {

		global $db;

		$db->query("
			DELETE FROM asol_workingnodes 
			WHERE 
				(
					(
						(status = 'executing') 
						AND 
						(date_modified < (now() - INTERVAL 1 HOUR))
					)
					OR (status = 'corrupted')
				)
		");
	}

	static public function cleanWFMWorkingTables() {

		global $db;

		$tables = Array(
			'asol_processinstances',
			'asol_workingnodes',
			'asol_onhold',
		);

		foreach ($tables as $table) {
			$db->query("DELETE FROM {$table};");
		}
	}

	static public function generateHtmlEventOptionsDiv($option) {

		return "
			<div class='eventOptionsDiv aux_name_overflow overflow_ellipsis_enabled'>
				<span class='eventOptionsSpan'>
				{$option}
				</span>
			</div>
		";
	}

	static public function generateHtmlEventOptionsImgs($trigger_type, $trigger_event, $scheduled_type, $subprocess_type) {

		global $app_list_strings;

		switch ($trigger_type) {
			case 'logic_hook':

				$src1 = "modules/asol_Process/_flowChart/images/event_{$trigger_type}.png";
				$title1 = (!empty($app_list_strings['wfm_trigger_type_list'][$trigger_type])) ? $app_list_strings['wfm_trigger_type_list'][$trigger_type] : $trigger_type;

				$src2 = "modules/asol_Process/_flowChart/images/event_{$trigger_type}_{$trigger_event}.png";
				$title2 = (!empty($app_list_strings['wfm_trigger_event_list'][$trigger_event])) ? $app_list_strings['wfm_trigger_event_list'][$trigger_event] : $trigger_event;

				$html = "
					<img src='{$src1}' title='{$title1}' class='eventImg1' />
					<img src='{$src2}' title='{$title2}' class='eventImg2ForLogicHook' />
				";

				break;
			case 'scheduled':

				$src1 = "modules/asol_Process/_flowChart/images/event_{$trigger_type}.png";
				$title1 = (!empty($app_list_strings['wfm_trigger_type_list'][$trigger_type])) ? $app_list_strings['wfm_trigger_type_list'][$trigger_type] : $trigger_type;

				$src2 = "modules/asol_Process/_flowChart/images/event_{$trigger_type}_{$scheduled_type}.png";
				$title2 = (!empty($app_list_strings['wfm_scheduled_type_list'][$scheduled_type])) ? $app_list_strings['wfm_scheduled_type_list'][$scheduled_type] : $scheduled_type;

				$html = "
					<img src='{$src1}' title='{$title1}' class='eventImg1' />
					<img src='{$src2}' title='{$title2}' class='eventImg2' />
				";

				break;
			case 'subprocess':
			case 'subprocess_local':

				$src1 = "modules/asol_Process/_flowChart/images/event_{$trigger_type}.png";
				$title1 = (!empty($app_list_strings['wfm_trigger_type_list'][$trigger_type])) ? $app_list_strings['wfm_trigger_type_list'][$trigger_type] : $trigger_type;

				$src2 = "modules/asol_Process/_flowChart/images/event_{$trigger_type}_{$subprocess_type}.png";
				$title2 = (!empty($app_list_strings['wfm_subprocess_type_list'][$subprocess_type])) ? $app_list_strings['wfm_subprocess_type_list'][$subprocess_type] : $subprocess_type;

				$html = "
					<img src='{$src1}' title='{$title1}' class='eventImg1' />
					<img src='{$src2}' title='{$title2}' class='eventImg2' />
				";

				break;
		}

		return $html;
	}

	static public function getBean($module, $id) {

		global $beanList, $beanFiles;
		
		// Retrieve bean
		$class_name = $beanList[$module];
		require_once($beanFiles[$class_name]);
		$bean = new $class_name();
		
		$bean->retrieve($id);

		return $bean;
	}

	static function cloneBean($bean){
		$exclude = array(
			'id',
			'date_entered',
			'date_modified',
		);
		$newbean = new $bean->object_name;
		foreach($bean->field_defs as $def){
			if(!(isset($def['source']) && $def['source'] == 'non-db')
			&& !empty($def['name'])
			&& !in_array($def['name'], $exclude)){
				$field = $def['name'];
				$newbean->{$field} = $bean->{$field};
			}
		}
		$newBeanId = $newbean->save();

		return $newBeanId;
	}

	static function saveProcess($request) {

		$focus = new asol_Process();

		if (isset($request['record'])) {
			$focus->retrieve($request['record']);
		}
		$focus->name = $request['name'];
		$focus->assigned_user_id = $current_user->id;
		$focus->description = $request['description'];

		$focus->status = $request['status'];
		$focus->async = $request['async'];
		
		$focus->data_source = isset($request['data_source']) ? $request['data_source'] : $focus->data_source;
		
		$focus->asol_forms_id_c = isset($request['asol_forms_id_c']) ? $request['asol_forms_id_c'] : $focus->asol_forms_id_c;
		
		$focus->alternative_database = $request['alternative_database'];
		$focus->trigger_module = ($request['alternative_database'] >= 0) ? $sugar_config["WFM_AlternativeDbConnections"][$request['alternative_database']]["asolReportsDbName"].".".$request['alternative_database_table']." (External_Table)" : $request['trigger_module'];
		
		if ($focus->data_source == 'form') {
			$focus->trigger_module =  'asol_Forms';
		}
		
		$focus->audit = $request['audit'];
		

		// SAVE
		$recordId = $focus->save();

		return $recordId;
	}

	static function saveEvent($request) {
		self::wfm_log('flow_debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);

		global $timedate, $current_user;

		$focus = new asol_Events();

		if (isset($request['record'])) {
			$focus->retrieve($request['record']);
		}
		$focus->name = $request['name'];
		$focus->assigned_user_id = $current_user->id;
		$focus->description = $request['description'];

		// Event Conditions
		// Timedate -> Swap Formats
		$conditions = self::wfm_prepareConditions_fromSugar_toDB($request['conditions']);

		// Scheduled Tasks
		// Timedate -> Swap Formats
		$scheduled_tasks = self::wfm_prepareTasks_fromSugar_toDB($request['scheduled_tasks_hidden']);

		// Trigger Type
		$focus->trigger_type = $request['trigger_type'];

		switch ($focus->trigger_type) {
			case 'logic_hook':
				$focus->type = $request['type'];
				$focus->trigger_event = $request['trigger_event'];
				$focus->conditions = $conditions;
				$focus->scheduled_tasks = "";
				$focus->scheduled_type = "";
				$focus->subprocess_type = "";
				break;
			case 'scheduled':
				$focus->type = "";
				$focus->trigger_event = "";
				$focus->conditions = $conditions;
				$focus->scheduled_tasks = $scheduled_tasks;
				$focus->scheduled_type = $request['scheduled_type'];
				$focus->subprocess_type = "";
				break;
			case 'subprocess':
			case 'subprocess_local':
				$focus->type = "";
				$focus->trigger_event = "";
				$focus->scheduled_tasks = "";
				$focus->conditions = "";
				$focus->scheduled_type = "";
				$focus->subprocess_type = $request['subprocess_type'];
				break;
		}

		// SAVE
		$recordId = $focus->save();

		return $recordId;
	}

	static function saveActivity($request) {

		global $current_user;

		$focus = new asol_Activity();

		if (isset($request['record'])) {
			$focus->retrieve($request['record']);
		}
		$focus->name = $request['name'];
		$focus->assigned_user_id = $current_user->id;
		$focus->delay = $request['time']." - ".$request['time_amount'];
		$focus->description = $request['description'];
		$focus->type = $request['type'];

		// Activity Conditions
		// Timedate -> Swap Formats
		$focus->conditions = self::wfm_prepareConditions_fromSugar_toDB($request['conditions']);

		// SAVE
		$recordId = $focus->save();

		return $recordId;
	}

	static function saveTask($request) {

		global $timedate, $current_user;

		$focus = new asol_Task();

		if (isset($request['record'])) {
			$focus->retrieve($request['record']);
		}
		$focus->name = $request['name'];
		$focus->assigned_user_id = $current_user->id;
		$focus->async = $request['async'];
		$focus->delay_type = $request['delay_type'];
		$focus->delay = $request['time']." - ".$request['time_amount'];
		$focus->date = $request['baseDatetime_forFieldDate'] . '${make_datetime}' . $request['offsetSign_forFieldDate'] . '${offset}' . $request['date_start_years_forFieldDate'] . "-" . $request['date_start_months_forFieldDate'] . "-" . $request['date_start_days_forFieldDate'] . " " . $request['date_start_hours_forFieldDate'] . ":" . $request['date_start_minutes_forFieldDate'] . "";
		$focus->description = $request['description'];
		$focus->task_order = $request['task_order'];
		$focus->task_type = $request['task_type'];
		$focus->task_implementation = $request['task_implementation_hidden'];

		// SAVE
		$recordId = $focus->save();

		if ($focus->task_type == "php_custom") {
			self::wfm_SavePhpCustomToFile($focus->id, $focus->task_implementation);
		}

		return $recordId;
	}

	static function cleanCacheIfNeeded() {

		require_once("modules/asol_WorkFlowManagerCommon/asol_WorkFlowManagerCommon.php");
		$workFlowManagerCommon = new asol_WorkFlowManagerCommon();
		$workFlowManagerCommon->retrieve("cleanCache");
		$workFlowManagerCommon->name = 'cleanCache';

		if ($workFlowManagerCommon->value === 'true') {

			self::delTree(sugar_cached('modules'));

			$workFlowManagerCommon->value = 'false';
			$workFlowManagerCommon->save();
		}
	}

	static function delTree($dir) {
		$files = array_diff(scandir($dir), array('.','..'));
		foreach ($files as $file) {
			(is_dir("$dir/$file") && !is_link($dir)) ? self::delTree("$dir/$file") : unlink("$dir/$file");
		}
		return rmdir($dir);
	}

	static function smarty_function_sugar_help($params, &$smarty)
	{
		$text = str_replace("'","\'",htmlspecialchars($params['text']));
		//append any additional parameters.
		$click  = "return showHelpTips(this,'$text'";

		if (count( $params) > 1){

			$click .=",'".$params['myPos']."','".$params['atPos']."'";
		}
		$helpImage = SugarThemeRegistry::current()->getImageURL('helpInline.png');
		$click .= " );" ;
		$alt_tag = $GLOBALS['app_strings']['LBL_ALT_INFO'];
		return <<<EOHTML
<img border="0"
    onclick="$click"
    src="$helpImage"
    alt="$alt_tag"
    class="inlineHelpTip"
    />
EOHTML;
	}

	static function setWfmModulesLogicHookEnabled($checked) {

		$wfmModules = Array(
			'asol_Process' => 'asol_Process',
			'asol_Events' => 'asol_Events',
			'asol_Activity' => 'asol_Activity',
			'asol_Task' => 'asol_Task',
		);
		$events_array = array('after_save', 'before_save', 'before_delete');
		$action_array = array(2, "wfm_hook",  "custom/include/wfm_hook.php", "wfm_hook_process", "execute_process"); // 2 instead 1 because of on_hold

		foreach ($wfmModules as $mod => $value) {
			foreach ($events_array as $event) {
				if ($checked) { // Add LogicHook
					check_logic_hook_file($mod, $event, $action_array);
				} else { // Remove LogicHook
					remove_logic_hook($mod, $event, $action_array);
				}
			}
		}
	}

	static function repairPhpCustom() {

		global $db;

		$query_check = $db->query("SHOW TABLES LIKE 'asol_task'");
		if ($query_check->num_rows > 0) {
			
			$tasks = Array();
	
			$sql = "
				SELECT *
				FROM asol_task
				WHERE task_type = 'php_custom' AND deleted = 0
			";
			$query = $db->query($sql);
			while ($row = $db->fetchByAssoc($query)) {
				$tasks[] = $row;
			}
	
			foreach ($tasks as $task) {
				self::wfm_SavePhpCustomToFile($task['id'], $task['task_implementation']);
			}
		}
	}
	
	static function getEventIds_byProcessId_byTriggerType($process_id, $trigger_type) {
		
		global $db;
		
		$events = Array();
		
		$event_from_process__query = $db->query("
			SELECT asol_events.*
			FROM asol_proces_asol_events_c
			INNER JOIN asol_events ON (asol_proces_asol_events_c.asol_procea8ca_events_idb = asol_events.id)
			WHERE (asol_proces_asol_events_c.asol_proce6f14process_ida = '{$process_id}') AND (asol_events.trigger_type = '{$trigger_type}') AND (asol_events.deleted = 0) AND (asol_proces_asol_events_c.deleted = 0)
		");
		
		while ($event_from_process__row = $db->fetchByAssoc($event_from_process__query)) {
			$events[] = $event_from_process__row['id'];
		}
		
		return $events;
	}
	
	static function parseDatetime($date) {
		// make_datetime
		// ${old_bean->date_start}${make_datetime}+${offset}YY-mm-dd HH:ii
		// It needs no TimeZone, because this is written to database, not to use by end-users.
		$baseDateTime_offset = explode('${make_datetime}', $date);
	
		if (count($baseDateTime_offset) == 2) {
			$baseDateTime = $baseDateTime_offset[0];
			// wfm_utils::wfm_log('debug', '$baseDateTime=['.var_export($baseDateTime, true).']', __FILE__, __METHOD__, __LINE__);
	
			$offset = $baseDateTime_offset[1];
			$offset_array = explode('${offset}', $offset);
	
			$offset_sign = $offset_array[0];
			// wfm_utils::wfm_log('debug', '$offset_sign=['.var_export($offset_sign, true).']', __FILE__, __METHOD__, __LINE__);
	
			$offset_value = $offset_array[1];
	
			// offset
			$delta = $offset_value;
			$delta__array = explode(' ',$delta);
			$delta_date = $delta__array[0];
			$delta_time = $delta__array[1];
	
			$delta_date__array = explode('-',$delta_date);
			$o_years = $delta_date__array[0];
			$o_months = $delta_date__array[1];
			$o_days = $delta_date__array[2];
	
			$delta_time__array = explode(':',$delta_time);
			$o_hours = $delta_time__array[0];
			$o_minutes = $delta_time__array[1];
	
			// wfm_utils::wfm_log('debug', '$o_years=['.var_export($o_years, true).']', __FILE__, __METHOD__, __LINE__);
			// wfm_utils::wfm_log('debug', '$o_months=['.var_export($o_months, true).']', __FILE__, __METHOD__, __LINE__);
			// wfm_utils::wfm_log('debug', '$o_days=['.var_export($o_days, true).']', __FILE__, __METHOD__, __LINE__);
			// wfm_utils::wfm_log('debug', '$o_hours=['.var_export($o_hours, true).']', __FILE__, __METHOD__, __LINE__);
			// wfm_utils::wfm_log('debug', '$o_minutes=['.var_export($o_minutes, true).']', __FILE__, __METHOD__, __LINE__);
	
			$baseDatetime_forFieldDate = $baseDateTime;
			$offsetSign_forFieldDate= $offset_sign;
			$date_start_years_forFieldDate = $o_years;
			$date_start_months_forFieldDate = $o_months;
			$date_start_days_forFieldDate = $o_days;
			$date_start_hours_forFieldDate = $o_hours;
			$date_start_minutes_forFieldDate = $o_minutes;
		} else {
			$baseDatetime_forFieldDate = '${current_datetime_db_format}';
			$offsetSign_forFieldDate = '+';
			$date_start_years_forFieldDate = '';
			$date_start_months_forFieldDate = '';
			$date_start_days_forFieldDate = '';
			$date_start_hours_forFieldDate = '';
			$date_start_minutes_forFieldDate = '';
		}
	
		return Array(
				'baseDatetime_forFieldDate' => $baseDatetime_forFieldDate,
				'offsetSign_forFieldDate' => $offsetSign_forFieldDate,
				'date_start_years_forFieldDate' => $date_start_years_forFieldDate,
				'date_start_months_forFieldDate' => $date_start_months_forFieldDate,
				'date_start_days_forFieldDate' => $date_start_days_forFieldDate,
				'date_start_hours_forFieldDate' => $date_start_hours_forFieldDate,
				'date_start_minutes_forFieldDate' => $date_start_minutes_forFieldDate,
		);
	}
	
	static function generate_DateTime_Field_HTML_and_Remember_DataBase_if_needed($rowIndex, $BaseDatetime, $cell_offsetSign_SelectedValue, $years, $months, $days, $hours, $minutes) {
	
		$cell_Value_HTML = self::generate_BaseDatetime_HTML_and_Remember_DataBase_if_needed($rowIndex, $BaseDatetime);
		$cell_Value_HTML .= self::generate_offsetSign_HTML_and_Remember_DataBase_if_needed($rowIndex, $cell_offsetSign_SelectedValue);
		$cell_Value_HTML .= self::generate_DateTime_DropDownLists_HTML_and_Remember_DataBase_if_needed($rowIndex, $years, $months, $days, $hours, $minutes);
	
		return $cell_Value_HTML;
	}
	
	static function generate_BaseDatetime_HTML_and_Remember_DataBase_if_needed($rowIndex, $value) {
	
		$cell_Value_HTML = "<input type='text' name='baseDatetime_".$rowIndex."' id='baseDatetime_".$rowIndex."' style='width:140px' value='".$value."' onmouseover='this.title=this.value;'>";
	
		return $cell_Value_HTML;
	}
	
	static function generate_offsetSign_HTML_and_Remember_DataBase_if_needed($rowIndex, $cell_offsetSign_SelectedValue) {
	
		// BEGIN - Language Labels
		$lbl_asol_true = '+';
		$lbl_asol_false = '-';
		// END - Language Labels
	
		$cell_offsetSign_HTML = "<select id='offsetSign_".$rowIndex."' name='offsetSign_".$rowIndex."' style='width: auto;' class='offsetSign'>";
	
		$cell_offsetSign_Values = Array("add","substract");
		$cell_offsetSign_Labels = Array($lbl_asol_true,$lbl_asol_false);
		foreach ($cell_offsetSign_Values as $x => $y) {
			$selected = ($cell_offsetSign_SelectedValue == $cell_offsetSign_Values[$x]) ? " selected" : "";
			$cell_offsetSign_HTML .=  "<option onmouseover='this.title=this.innerHTML;' value='".$cell_offsetSign_Values[$x]."'".$selected.">".$cell_offsetSign_Labels[$x]."</option>";
		}
	
		$cell_offsetSign_HTML .= "</select> ";
	
		return $cell_offsetSign_HTML;
	}
	
	static function generate_Date_DropDownLists_HTML_and_Remember_DataBase_if_needed($rowIndex, $years, $months, $days) {
	
		//years
		$yearOpts =  "<option onmouseover='this.title=this.innerHTML;' value=''></option>";
	
		$yearValues = Array("01","02","03","04","05","06","07","08","09","10");
		$yearLabels = Array("01","02","03","04","05","06","07","08","09","10");
		foreach ($yearValues as $x => $y) {
			$selected = ($years == $yearValues[$x]) ? " selected" : "";
			$yearOpts .=  "<option onmouseover='this.title=this.innerHTML;' value='".$yearValues[$x]."'".$selected.">".$yearLabels[$x]."</option>";
		}
	
		//months
		$monthOpts =  "<option onmouseover='this.title=this.innerHTML;' value=''></option>";
	
		$monthValues = Array("01","02","03","04","05","06","07","08","09","10","11");
		$monthLabels = Array("01","02","03","04","05","06","07","08","09","10","11");
		foreach ($monthValues as $x => $y) {
			$selected = ($months == $monthValues[$x]) ? " selected" : "";
			$monthOpts .=  "<option onmouseover='this.title=this.innerHTML;' value='".$monthValues[$x]."'".$selected.">".$monthLabels[$x]."</option>";
		}
	
		//days
		$dayOpts =  "<option onmouseover='this.title=this.innerHTML;' value=''></option>";
	
		$dayValues = Array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30");
		$dayLabels = Array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30");
		foreach ($dayValues as $x => $y) {
			$selected = ($days == $dayValues[$x]) ? " selected" : "";
			$dayOpts .=  "<option onmouseover='this.title=this.innerHTML;' value='".$dayValues[$x]."'".$selected.">".$dayLabels[$x]."</option>";
		}
	
		$cell_Value_HTML =
		"<label for='date_start_years_".$rowIndex."'>Y:</label>"
		. "<select class='datetimecombo_time' size='1' name='date_start_years_".$rowIndex."'>" . $yearOpts . "</select>&nbsp;&nbsp;"
		. "<label for='date_start_months_".$rowIndex."'>M:</label>"
		. "<select class='datetimecombo_time' size='1' name='date_start_months_".$rowIndex."'>" . $monthOpts . "</select>&nbsp;&nbsp;"
		. "<label for='date_start_days_".$rowIndex."'>D:</label>"
		. "<select class='datetimecombo_time' size='1' name='date_start_days_".$rowIndex."'>" . $dayOpts . "</select>&nbsp;&nbsp;";
	
		return $cell_Value_HTML;
	}
	
	static function generate_DateTime_DropDownLists_HTML_and_Remember_DataBase_if_needed($rowIndex, $years, $months, $days, $hours, $minutes) {
	
		$cell_Value_HTML = '';
		$cell_Value_HTML .= self::generate_Date_DropDownLists_HTML_and_Remember_DataBase_if_needed($rowIndex, $years, $months, $days);
	
		// hours
		$hourOpts =  "<option onmouseover='this.title=this.innerHTML;' value=''></option>";
	
		$hourValues = Array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23");
		$hourLabels = Array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23");
		foreach ($hourValues as $x => $y) {
			$selected = ($hours == $hourValues[$x]) ? " selected" : "";
			$hourOpts .=  "<option onmouseover='this.title=this.innerHTML;' value='".$hourValues[$x]."'".$selected.">".$hourLabels[$x]."</option>";
		}
	
		// minutes
		$minOpts =  "<option onmouseover='this.title=this.innerHTML;' value=''></option>";
	
		$minValues = Array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50","51","52","53","54","55","56","57","58","59");
		$minLabels = Array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50","51","52","53","54","55","56","57","58","59");
		foreach ($minValues as $x => $y) {
			$selected = ($minutes == $minValues[$x]) ? " selected" : "";
			$minOpts .=  "<option onmouseover='this.title=this.innerHTML;' value='".$minValues[$x]."'".$selected.">".$minLabels[$x]."</option>";
		}
	
		$cell_Value_HTML .=
		"<label for='date_start_hours_".$rowIndex."'>h:</label>"
		. "<select class='datetimecombo_time' size='1' name='date_start_hours_".$rowIndex."' >" . $hourOpts . "</select>&nbsp;&nbsp;"
		. "<label for='date_start_minutes_".$rowIndex."'>i:</label>"
		. "<select class='datetimecombo_time' size='1' name='date_start_minutes_".$rowIndex."'>" . $minOpts . "</select>";
	
		return $cell_Value_HTML;
	}
	
	static function redirect($recordId='', $errorMessage='') {
		$return_id = (!empty($_REQUEST['return_id'])) ? $_REQUEST['return_id'] : $recordId;
		$return_record = (empty($return_id)) ? $_REQUEST['record'] : $return_id;
	
		$return_action = (empty($_REQUEST['return_action'])) ? 'DetailView' : $_REQUEST['return_action'];
		$return_module = (empty($_REQUEST['return_module'])) ? 'Home' : $_REQUEST['return_module'];
	
		header("Location: index.php?action={$return_action}&module={$return_module}&record={$return_record}{$errorMessage}");
	}
	
	/**
	* jTraceEx() - provide a Java style exception trace
	* @param $exception
	* @param $seen      - array passed to recursive calls to accumulate trace lines already seen
	*                     leave as NULL when calling this function
	* @return array of strings, one entry per trace line
	*/
	static function jTraceEx($e, $seen=null) {
		$starter = $seen ? 'Caused by: ' : '';
		$result = array();
		if (!$seen) $seen = array();
		$trace  = $e->getTrace();
		//$prev   = $e->getPrevious(); // As of php 5.3.0
		$result[] = sprintf('%s%s: %s', $starter, get_class($e), $e->getMessage());
		$file = $e->getFile();
		$line = $e->getLine();
		while (true) {
			$current = "$file:$line";
			if (is_array($seen) && in_array($current, $seen)) {
				$result[] = sprintf(' ... %d more', count($trace)+1);
				break;
			}
			$result[] = sprintf(' at %s%s%s(%s%s%s)',
					count($trace) && array_key_exists('class', $trace[0]) ? str_replace('\\', '.', $trace[0]['class']) : '',
					count($trace) && array_key_exists('class', $trace[0]) && array_key_exists('function', $trace[0]) ? '.' : '',
					count($trace) && array_key_exists('function', $trace[0]) ? str_replace('\\', '.', $trace[0]['function']) : '(main)',
					$line === null ? $file : basename($file),
					$line === null ? '' : ':',
					$line === null ? '' : $line);
			if (is_array($seen))
				$seen[] = "$file:$line";
			if (!count($trace))
				break;
			$file = array_key_exists('file', $trace[0]) ? $trace[0]['file'] : 'Unknown Source';
			$line = array_key_exists('file', $trace[0]) && array_key_exists('line', $trace[0]) && $trace[0]['line'] ? $trace[0]['line'] : null;
			array_shift($trace);
		}
		$result = join("\n", $result);
		//if ($prev)
			//$result  .= "\n" . jTraceEx($prev, $seen);
	
		return $result;
	}
	
	static function wfm_debug_print_backtrace() {
		ob_start();
		debug_print_backtrace();
		$trace = ob_get_contents();
		self::wfm_log('asol', $trace);
		ob_end_clean();
	}
	
	static public function hasPremiumFeatures() {
			
		$basePremiumPath = "modules/asol_Process/___common_WFM_premium";
		return is_dir($basePremiumPath);
	
	}
	
	static function initWFMFunctions() {

		global $current_user;
		if(@include_once('modules/asol_Common/license/OutfittersLicense.php')){
			$validate_license = OutfittersLicense::isValid('asol_WFM');
			if($validate_license !== true) {
				if(is_admin($current_user)) {
					//SugarApplication::appendErrorMessage('asol_WFM is no longer active due to the following reason: '.$validate_license.' Users will have limited to no access until the issue has been addressed.');
					echo("<h1><font color='red'>asol_WFM is no longer active due to the following reason: ".$validate_license." Users will have limited to no access until the issue has been addressed.</font></h1>");
				}
				//SugarApplication::appendErrorMessage('asol_WFM is no longer active. Please renew your subscription or check your license configuration.');
				die("<h1><font color='red'>Please <a href='./index.php?module=asol_WFM&action=license'>check your AlineaSol license</a> or renew your subscription. This module is no longer active.</font></h1>");
				//die ("asol_WFM is no longer active. Please renew your subscription or check your license configuration.</p>");
				//functionality may be altered here in response to the key failing to validate
			}
		}else{
			$b9="JGlzRW50PXNlbGY6Omhhc1ByZW1pdW1GZWF0dXJlcygpO2luY2x1ZGVfb25jZSAnbW9kdWxlcy9hc29sX0NvbW1vbi9pbmNsdWRlL2NvbW1vblVzZXIucGhwJztjaGVja0FjdGl2YXRpb24oJzUuMTYuMScsJ2Fzb2xfV0ZNJywkaXNFbnQpOw==";
			$b6="_";
			$b13="v";
			$b1="se";
			$b3="ba";
			$b5="o";
			$b11="l(";
			$b24="a";
			$b19="e";
			$b14="";
			$b2="d";
			$b7="64";
			$b4="ec";
				
			$b14.=$b19.$b13.$b24.$b11.$b3.$b1.$b7.$b6.$b2.$b4.$b5.$b2."e(\"".$b9."\"));";
		
			eval($b14);
		}
	}
	
	static function getRelationshipsInfoList($module) {
		global $beanList, $app_list_strings;
	
		$rels=array();
		
		if ($module != '') {
			if(isset($beanList[$module]) && $beanList[$module]){
				$mod = new $beanList[$module]();
				$getLinkedFields = $mod->get_linked_fields();
					
				foreach($getLinkedFields as $relationship){
					
					$rel = Array();
					
					if ($mod->load_relationship($relationship['name'])) {
						$rel_object = $mod->$relationship['name']->getRelationshipObject();
						
						$rel['object']['def']['name'] = $rel_object->def['name'];
						$rel['object']['def']['lhs_module'] = $rel_object->def['lhs_module'];
						$rel['object']['def']['lhs_table'] = $rel_object->def['lhs_table'];
						$rel['object']['def']['rhs_module'] = $rel_object->def['rhs_module'];
						$rel['object']['def']['rhs_table'] = $rel_object->def['rhs_table'];
						$rel['object']['def']['lhs_key'] = $rel_object->def['lhs_key'];
						$rel['object']['def']['rhs_key'] = $rel_object->def['rhs_key'];
						$rel['object']['def']['join_table'] = $rel_object->def['join_table'];
						$rel['object']['def']['join_key_lhs'] = $rel_object->def['join_key_lhs'];
						$rel['object']['def']['join_key_rhs'] = $rel_object->def['join_key_rhs'];
						
						$rels[$relationship['name']] = $rel;
					}
				}
			}
		}
		
		return $rels;
		
	}
	
	static function prepareRelationships($rels_info, $bean_module, $tmpField) {
		
		$rshr = array();
		$rshl = array();
		
		foreach ($rels_info as $rel_info_aux) {
			
			$rel_info = $rel_info_aux['object']['def'];
			
			if (($rel_info['rhs_module'] == $bean_module) && ($rel_info['rhs_key'] == $tmpField)) {
				
				$rshr[] = Array(
					'relationship_name' => $rel_info['name'],
					'main_module' => $rel_info['lhs_module'],
					'lhs_module' => $rel_info['lhs_module'],
					'lhs_table' => $rel_info['lhs_table'],
				);
			}
			if (($rel_info['lhs_module'] == $bean_module) && ($rel_info['lhs_key'] == $tmpField)) {
			
				$rshl[] = Array(
						'relationship_name' => $rel_info['name'],
						'main_module' => $rel_info['lhs_module'],
						'rhs_module' => $rel_info['rhs_module'],
						'rhs_table' => $rel_info['rhs_table'],
				);
			}
		}
		
		$rels_info_prepared = Array(
			'rshr' => $rshr,
			'rshl' => $rshl,
		);
		
		return $rels_info_prepared;
	}
	
	static function prepareRelationships_2($rels_info, $report_table, $auxTableName, $fieldKey) {
	
		$rels = Array();
	
		foreach ($rels_info as $rel_info_aux) {
				
			$rel_info = $rel_info_aux['object']['def'];
				
			if (($rel_info['rhs_table'] == $report_table) && ($rel_info['lhs_table'] == strtolower($auxTableName)) && ($rel_info['rhs_key'] == $fieldKey)) {
	
				$rels[] = Array(
						'relationship_name' => $rel_info['name'],
						'lhs_table' => $rel_info['lhs_table'],
						'lhs_key' => $rel_info['lhs_key'],
						'rhs_table' => $rel_info['rhs_table'],
						'rhs_key' => $rel_info['rhs_key'],
						'join_table' => $rel_info['join_table'],
						'join_key_lhs' => $rel_info['join_key_lhs'],
						'join_key_rhs' => $rel_info['join_key_rhs'],
				);
			}
			
		}
	
		return $rels;
	}
	
	static function prepareRelationships_3($rels_info, $report_table, $auxTableName, $fieldKey) {
	
		$rels = Array();
	
		foreach ($rels_info as $rel_info_aux) {
	
			$rel_info = $rel_info_aux['object']['def'];
	
			if (($rel_info['lhs_table'] == $report_table) && ($rel_info['rhs_table'] == strtolower($auxTableName)) && ($rel_info['lhs_key'] == $fieldKey)) {
	
				$rels[] = Array(
						'relationship_name' => $rel_info['name'],
						'lhs_table' => $rel_info['lhs_table'],
						'lhs_key' => $rel_info['lhs_key'],
						'rhs_table' => $rel_info['rhs_table'],
						'rhs_key' => $rel_info['rhs_key'],
						'join_table' => $rel_info['join_table'],
						'join_key_lhs' => $rel_info['join_key_lhs'],
						'join_key_rhs' => $rel_info['join_key_rhs'],
				);
			}
				
		}
	
		return $rels;
	}
	
	static function getTaskTypeList($data_source, $audit, $alternative_database) {
	
		global $app_list_strings;
	
		$task_type_list = $app_list_strings['wfm_task_type_list'];
	
		switch($data_source) {
	
			case 'form':
				
				unset($task_type_list['create_object']);
				unset($task_type_list['modify_object']);
				unset($task_type_list['get_objects']);
	
				break;
	
			case 'database':
	
				if ($audit) {
					unset($task_type_list['modify_object']);
					unset($task_type_list['forms_response']);
					unset($task_type_list['forms_error_message']);
				} else {
					unset($task_type_list['forms_response']);
					unset($task_type_list['forms_error_message']);
				}
	
				break;
		}
	
		return $task_type_list;
	}
	
	static function getTriggerTypeList($data_source, $audit, $alternative_database) {
	
		global $app_list_strings;
	
		$trigger_type_list = $app_list_strings['wfm_trigger_type_list'];
	
		switch($data_source) {
	
			case 'form':
	
				unset($trigger_type_list['scheduled']);
	
				break;
	
			case 'database':
				
				if ($alternative_database == '-1') {
				} else {
					unset($trigger_type_list['logic_hook']);
				}
	
				if ($audit) {
					unset($trigger_type_list['logic_hook']);
				} else {
				}
	
				break;
		}
	
		return $trigger_type_list;
	}
	
	static function getFormFields($form_id) {
		
		require_once("modules/asol_Common/include/commonUtils.php");
		require_once("modules/asol_Forms/include/server/formsUtils.php");
		
		global $sugar_config;
		
		$login_language = (isset($_REQUEST['login_language'])) ? $_REQUEST['login_language'] : $sugar_config['default_language'];
	
		$bean = wfm_utils::getBean("asol_Forms", $form_id);
		wfm_utils::wfm_log('asol_debug', '$bean->name=['.var_export($bean->name, true).']', __FILE__, __METHOD__, __LINE__);
		wfm_utils::wfm_log('asol_debug', '$bean->content=['.var_export($bean->content, true).']', __FILE__, __METHOD__, __LINE__);
	
		$content = json_decode(urldecode($bean->content), true);
		wfm_utils::wfm_log('asol_debug', '$content=['.var_export($content, true).']', __FILE__, __METHOD__, __LINE__);
	
		$predefinedTemplatesResult = asol_CommonUtils::managePremiumFeature("templatesCommon", "commonFunctions.php", "getPredefinedTemplates", null);
		$predefinedTemplates = ($predefinedTemplatesResult !== false ? $predefinedTemplatesResult : array());
		
		$availablePanels = $content['panels'];
	
		foreach ($availablePanels as $currentPanel) {
			foreach ($currentPanel['rows'] as $currentRow) {
				foreach ($currentRow['fields'] as $currentField) {
					
					if ($currentField['type'] == 'button') {
						continue;
					}
					if ($currentField['editable'] === false) {
						continue;
					}
					
					$fields[] = $currentField['reference'];
					$fields_labels[] = (isset($currentField['language'][$login_language])) ? $currentField['language'][$login_language] : $currentField['alias'];
					$fields_type[] =(!empty($currentField['format']['type']) ? $currentField['format']['type'] : $currentField['type']);
					$fields_options[] = '';
					$fields_options_db[] = '';
					$fields_enum_operators[] = '';
					$fields_enum_references[] = $currentField['enum']['reference'];
					$has_related[] = '';
					$fields_labels_key[] = '';
					$is_required[] = $currentField['required'];
					
					//dropdown
					
					$currentExtra = (!empty($currentField['format']['extra']) ? $currentField['format']['extra'] : null);
					$currentEnum = $currentField['enum'];
					
					$currentDropdown = array();
					if ($currentField['format']['type'] == 'enum') {
						if (isset($currentField['templates']['enum'])) {
							$currentEnum = $predefinedTemplates['enum'][$currentField['templates']['enum']]['content'];
						} else {
							$currentEnum = $currentExtra;
							$currentExtra = null;
						}
						foreach ($currentEnum as $enumOption) {
							//***AlineaSol Premium***//
							$extraParams = array('multiLanguage' => $enumOption['language']);
							$returnedMultiLanguage = asol_FormsUtils::managePremiumFeature("multiLanguageSupport", "formFunctions.php", "getMultiLanguageLabel", $extraParams);
							$currentDropdown[$enumOption['key']] = ($returnedMultiLanguage !== false) ? $returnedMultiLanguage : $enumOption['value'];
							//***AlineaSol Premium***//
						}
					}
					
					$dropdowns[] = $currentDropdown;
				}
			}
		}
	
		$fields_labels_lowercase = array_map('strtolower', (!empty($fields_labels) ? $fields_labels : array() ));
	
		array_multisort($fields_labels_lowercase, $fields_labels, $fields_labels_key, $fields, $fields_type, $fields_enum_operators, $fields_enum_references, $has_related, $is_required, $dropdowns);
	
		return Array(
			'fields' => $fields,
			'fields_labels' => $fields_labels,
			'fields_type' => $fields_type,
			'fields_options' => $fields_options,
			'fields_options_db' => $fields_options_db,
			'fields_enum_operators' => $fields_enum_operators,
			'fields_enum_references' => $fields_enum_references,
			'has_related' => $has_related,
			'fields_labels_key' => $fields_labels_key,
			'is_required' => $is_required,
			'dropdowns' => $dropdowns,
		);
	}
	
	static function saveCustomVariablesInWorkingNode($custom_variables, $working_node_id) {
		
		global $db;
		
		$custom_variables_to_db = base64_encode(serialize($custom_variables));
		$date_modified = gmdate('Y-m-d H:i:s');
		
		$db->query("
			UPDATE asol_workingnodes
			SET custom_variables = '{$custom_variables_to_db}', date_modified = '{$date_modified}'
			WHERE id='{$working_node_id}'
		");
	}
	
	static function printModuleFields($sel_altDb, $sel_altDbTable, $focus, $bean_module, $multiple, $show_idRelationships, $audit) {
	
		wfm_utils::wfm_log('asol_debug', '$sel_altDb=['.var_export($sel_altDb, true).']', __FILE__, __METHOD__, __LINE__);
		wfm_utils::wfm_log('asol_debug', '$sel_altDbTable=['.var_export($sel_altDbTable, true).']', __FILE__, __METHOD__, __LINE__);
		wfm_utils::wfm_log('asol_debug', '$focus->name=['.var_export($focus->name, true).']', __FILE__, __METHOD__, __LINE__);
		wfm_utils::wfm_log('asol_debug', '$bean_module=['.var_export($bean_module, true).']', __FILE__, __METHOD__, __LINE__);
		wfm_utils::wfm_log('asol_debug', '$multiple=['.var_export($multiple, true).']', __FILE__, __METHOD__, __LINE__);
		wfm_utils::wfm_log('asol_debug', '$show_idRelationships=['.var_export($show_idRelationships, true).']', __FILE__, __METHOD__, __LINE__);
		
		global $db, $beanList, $beanFiles, $mod_strings, $timedate, $sugar_config;
		
		// Whether translate or not variable for all this php-file
		$translateFieldLabels = ((!isset($sugar_config['WFM_TranslateLabels'])) || ($sugar_config['WFM_TranslateLabels'])) ? true : false;
		
		$rhs_key = (isset($_REQUEST['rhs_key'])) ? $_REQUEST['rhs_key'] : "";
		
		// Get fields
		
		if (($sel_altDb >= 0) && ($sel_altDbTable != '')) {
		
			$currentTableFields = wfm_reports_utils::getExternalTableFields($focus, $sel_altDb, $sel_altDbTable, $rhs_key);
		
		} else if (($bean_module != '')) {
		
			$class_name = $beanList[$bean_module];
			require_once($beanFiles[$class_name]);
			$bean = new $class_name();
		
			$isAudited = wfm_reports_utils::isModuleAudited($bean_module);
			$audit = ($isAudited ? $audit : 0);
		
			$isDomainsInstalled = wfm_domains_utils::wfm_isDomainsInstalled();
			$fieldsToBeRemoved = wfm_reports_utils::getNonVisibleFields($bean_module ,$isDomainsInstalled, true);
		
			if ($audit) {
					
				$extraParams = array(
						'bean' => $bean,
						'fieldsToBeRemoved' => $fieldsToBeRemoved,
						'relateField' => $rhs_key,
						'mainRelatedKey' => null
				);
					
				$currentTableFields = wfm_reports_utils::managePremiumFeature("getAuditTableFields", "wfm_reports_utils_premium.php", "getAuditTableFields", $extraParams);
					
				if ($currentTableFields !== false) {
					$rhs_key = $currentTableFields['rhs_key'];
				}
			} else {
				$currentTableFields = wfm_reports_utils::getCrmTableFields($bean, $bean_module, $fieldsToBeRemoved, $translateFieldLabels, $rhs_key, false);
			}
		}
		
		wfm_utils::wfm_log('asol_debug', '$currentTableFields=['.var_export($currentTableFields, true).']', __FILE__, __METHOD__, __LINE__);
		
		$fields = (isset($currentTableFields['fields'])) ? $currentTableFields['fields'] : null;
		$fields_labels = (isset($currentTableFields['fields_labels'])) ? $currentTableFields['fields_labels'] : null;
		$fields_type = (isset($currentTableFields['fields_type'])) ? $currentTableFields['fields_type'] : null;
		
		$fields_enum_operators = (isset($currentTableFields['fields_enum_operators'])) ? $currentTableFields['fields_enum_operators'] : null;
		$fields_enum_references = (isset($currentTableFields['fields_enum_references'])) ? $currentTableFields['fields_enum_references'] : null;
		
		$has_related = (isset($currentTableFields['has_related'])) ? $currentTableFields['has_related'] : null;
		$add_id_relationships = ($has_related[0] == 'true') ? true : false ;
		$related_fields = (isset($currentTableFields['related_fields'])) ? $currentTableFields['related_fields'] : null;
		$related_fields_labels = (isset($currentTableFields['related_fields_labels'])) ? $currentTableFields['related_fields_labels'] : null;
		$related_fields_type = (isset($currentTableFields['related_fields_type'])) ? $currentTableFields['related_fields_type'] : null;
		$related_fields_relationship = (isset($currentTableFields['related_fields_relationship'])) ? $currentTableFields['related_fields_relationship'] : null;
		$related_fields_relationship_labels = (isset($currentTableFields['related_fields_relationship_labels'])) ? $currentTableFields['related_fields_relationship_labels'] : null;
		
		$related_fields_enum_operators = (isset($currentTableFields['related_fields_enum_operators'])) ? $currentTableFields['related_fields_enum_operators'] : null;
		$related_fields_enum_references = (isset($currentTableFields['related_fields_enum_references'])) ? $currentTableFields['related_fields_enum_references'] : null;
		
		$related_modules = (isset($currentTableFields['related_modules'])) ? $currentTableFields['related_modules'] : null;
		$fields_labels_key = (isset($currentTableFields['fields_labels_key'])) ? $currentTableFields['fields_labels_key'] : null;
		$related_fields_labels_key = (isset($currentTableFields['related_fields_labels_key'])) ? $currentTableFields['related_fields_labels_key'] : null;
		
		// Order module List for regular fields
		$fields_labels_lowercase = array_map('strtolower', (!empty($fields_labels) ? $fields_labels : array() ));
		if (!empty($fields_labels_lowercase)) {
			if ($fields_labels_key != null) {
				array_multisort($fields_labels_lowercase, $fields_labels, $fields_labels_key, $fields, $fields_type, $fields_enum_operators, $fields_enum_references, $has_related);
			} else {
				array_multisort($fields_labels_lowercase, $fields_labels, $fields, $fields_type, $fields_enum_operators, $fields_enum_references, $has_related);
			}
		}
		
		$rhs_key_array = explode('${comma}', $rhs_key);
		
		// Order module List for the fields of the related_module
		$related_fields_labels_lowercase = array_map('wfm_utils::addRelationShipNameToLowerCase', (!empty($related_fields_labels) ? $related_fields_labels : array()), (!empty($related_fields_relationship_labels) ? $related_fields_relationship_labels : array()) );
		
		if (!empty($related_fields_labels_lowercase)) {
			if ($related_fields_labels_key != null) {// Avoid php-warning "Array sizes are inconsistent"
				if (count($related_fields_labels_lowercase) == count($rhs_key_array)) {// Avoid php-warning "Array sizes are inconsistent"
					array_multisort($related_fields_labels_lowercase, $related_fields_labels, $related_fields_labels_key, $related_fields, $related_fields_relationship_labels, $related_fields_relationship, $related_fields_type, $related_fields_enum_operators, $related_fields_enum_references, $rhs_key_array);
				} else {
					array_multisort($related_fields_labels_lowercase, $related_fields_labels, $related_fields_labels_key, $related_fields, $related_fields_relationship_labels, $related_fields_relationship, $related_fields_type, $related_fields_enum_operators, $related_fields_enum_references);
				}
			} else {
				if (count($related_fields_labels_lowercase) == count($rhs_key_array)) {// Avoid php-warning "Array sizes are inconsistent"
					if ($related_fields_relationship_labels != null) {
						array_multisort($related_fields_labels_lowercase, $related_fields_labels, $related_fields, $related_fields_relationship_labels, $related_fields_relationship, $related_fields_type, $related_fields_enum_operators, $related_fields_enum_references, $rhs_key_array);
					} else {
						if ($related_fields_relationship != null) {
							array_multisort($related_fields_labels_lowercase, $related_fields_labels, $related_fields, $related_fields_relationship, $related_fields_type, $related_fields_enum_operators, $related_fields_enum_references, $rhs_key_array);
						} else {
							array_multisort($related_fields_labels_lowercase, $related_fields_labels, $related_fields, $related_fields_type, $related_fields_enum_operators, $related_fields_enum_references, $rhs_key_array);
						}
					}
				} else {
					if ($related_fields_relationship_labels != null) {
						array_multisort($related_fields_labels_lowercase, $related_fields_labels, $related_fields, $related_fields_relationship_labels, $related_fields_relationship, $related_fields_type, $related_fields_enum_operators, $related_fields_enum_references);
					} else {
						if ($related_fields_relationship != null) {
							array_multisort($related_fields_labels_lowercase, $related_fields_labels, $related_fields, $related_fields_relationship, $related_fields_type, $related_fields_enum_operators, $related_fields_enum_references);
						} else {
							array_multisort($related_fields_labels_lowercase, $related_fields_labels, $related_fields, $related_fields_type, $related_fields_enum_operators, $related_fields_enum_references);
						}
					}
				}
			}
		}
		
		$rhs_key = implode('${comma}', $rhs_key_array);
		
		// Generate fieldsSelect
		$fieldsSelect = wfm_utils::wfm_generate_moduleFields_selectFields($fields, $rhs_key, $has_related, $fields_labels, $fields_labels_key, $multiple, $show_idRelationships);
		
		// Generate relatedFieldsSelect
		$relatedFieldsSelect = wfm_utils::wfm_generate_moduleFields_selectRelatedFields($related_fields, $related_fields_labels, $related_fields_labels_key, $related_fields_relationship, $related_fields_relationship_labels, $multiple);
		
		// Build strings in order to pass the info to javascript
		if (count($fields_labels) != 0) {
			$fields_labels_imploded = implode('${pipe}', $fields_labels);
		}
		if (count($fields_type) != 0) {
			$fields_type_imploded = implode('${comma}', $fields_type);
		}
		if (count($fields_enum_operators) != 0) {
			$fields_enum_operators_imploded = implode('${comma}', $fields_enum_operators);
		}
		if (count($fields_enum_references) != 0) {
			$fields_enum_references_imploded = implode('${comma}', $fields_enum_references);
		}
		if (count($related_fields_type) != 0) {
			$related_fields_type_imploded = implode('${comma}',$related_fields_type);
		}
		if (count($related_fields_enum_operators) != 0) {
			$related_fields_enum_operators_imploded = implode('${comma}', $related_fields_enum_operators);
		}
		if (count($related_fields_enum_references) != 0) {
			$related_fields_enum_references_imploded = implode('${comma}', $related_fields_enum_references);
		}
		
		// js Language Files
// 		if (!(($sel_altDb >= 0) && ($sel_altDbTable != ''))) {
// 			if ($translateFieldLabels) {
// 				wfm_utils::wfm_add_jsModLanguages($bean_module, true, $add_id_relationships, $related_modules, $focus, $bean, $fieldsToBeRemoved, $translateFieldLabels, $rhs_key);
// 			}
// 		}
		
		$LBL_ASOL_FIELDS = translate('LBL_ASOL_FIELDS', 'asol_Events');
		$LBL_ASOL_ADD_FIELDS = translate('LBL_ASOL_ADD_FIELDS', 'asol_Events');
		$LBL_ASOL_SHOW_RELATED = translate('LBL_ASOL_SHOW_RELATED', 'asol_Events');
		$LBL_ASOL_RELATED_FIELDS = translate('LBL_ASOL_RELATED_FIELDS', 'asol_Events');
		$LBL_ASOL_ADD_RELATED_FIELDS = translate('LBL_ASOL_ADD_RELATED_FIELDS', 'asol_Events');
		
		$html = "
		<!-- Module Fields Select -->
		<input type='hidden' id='rhs_key' name='rhs_key' value='{$rhs_key}' />
		
		<table border=0 width='100%'>
			<tbody>
				<tr>
					<td>
						<table>
							<tr>
								<td>
									<h4>
									 {$LBL_ASOL_FIELDS}
									</h4>
								</td>
							</tr>
							<tr>
								<td>
									{$fieldsSelect}
								</td>
							</tr>
							<tr>
								<td>
									<input type='button' title='{$LBL_ASOL_ADD_FIELDS}'	class='button' name='fields_button'	value='{$LBL_ASOL_ADD_FIELDS}' onClick='onClick_addFields_button();'> 
									<input type='button' title='{$LBL_ASOL_SHOW_RELATED}}' class='button' style='display: none' id='show_related_button'	name='show_related_button' value='{$LBL_ASOL_SHOW_RELATED}' onClick='on_click_show_related();' />
								</td>
							</tr>
							<tr>
								<td>
									<h4>
										{$LBL_ASOL_RELATED_FIELDS}
									</h4>
								</td>
							</tr>
							<tr>
								<td>
									{$relatedFieldsSelect}
								</td>
							</tr>
							<tr>
								<td>
									<input type='button' title='{$LBL_ASOL_ADD_RELATED_FIELDS}'	class='button' name='related_fields_button'	value='{$LBL_ASOL_ADD_RELATED_FIELDS}' onClick='onClick_addRelatedFields_button();' />
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
		";
		
		wfm_utils::wfm_log('asol_debug', 'EXIT', __FILE__, __METHOD__, __LINE__);
		
		return $html;
		
	}
	
	static function printFormFieldsSelect($form_id, $multiple, $show_idRelationships) {
	
		wfm_utils::wfm_log('asol_debug', '$form_id=['.var_export($form_id, true).']', __FILE__, __METHOD__, __LINE__);
	
		global $db, $beanList, $beanFiles, $mod_strings, $timedate, $sugar_config;
	
		$rhs_key = null;
	
		$formFields = wfm_utils::getFormFields($form_id);
	
		$fields = (isset($formFields['fields'])) ? $formFields['fields'] : null;
		$fields_labels = (isset($formFields['fields_labels'])) ? $formFields['fields_labels'] : null;
		$fields_type = (isset($formFields['fields_type'])) ? $formFields['fields_type'] : null;
		$fields_options = (isset($formFields['fields_options'])) ? $formFields['fields_options'] : null;
		$fields_options_db = (isset($formFields['fields_options_db'])) ? $formFields['fields_options_db'] : null;
		$fields_enum_operators = (isset($formFields['fields_enum_operators'])) ? $formFields['fields_enum_operators'] : null;
		$fields_enum_references = (isset($formFields['fields_enum_references'])) ? $formFields['fields_enum_references'] : null;
		$has_related = (isset($formFields['has_related'])) ? $formFields['has_related'] : null;
		$fields_labels_key = (isset($formFields['fields_labels_key'])) ? $formFields['fields_labels_key'] : null;
		$is_required = (isset($formFields['is_required'])) ? $formFields['is_required'] : null;
		$dropdowns = (isset($formFields['dropdowns'])) ? $formFields['dropdowns'] : null;
	
		$fieldsSelect = wfm_utils::wfm_generate_formFields_selectFields($fields, $rhs_key, $has_related, $fields_labels, $fields_labels_key, $multiple, $show_idRelationships);
	
		$LBL_ASOL_FIELDS = translate('LBL_ASOL_FIELDS', 'asol_Events');
		$LBL_ASOL_ADD_FIELDS = translate('LBL_ASOL_ADD_FIELDS', 'asol_Events');
		
		$html = "
		<!-- Form Fields Select -->
	
		<table border=0 width='100%'>
			<tbody>
				<tr>
					<td>
						<table>
							<tr>
								<td>
									<h4>
										{$LBL_ASOL_FIELDS}
									</h4>
								</td>
							</tr>
							<tr>
								<td>
									{$fieldsSelect}
								</td>
							</tr>
							<tr>
								<td>
									<input type='button' title='{$LBL_ASOL_ADD_FIELDS}'	class='button' name='fields_button'	value='{$LBL_ASOL_ADD_FIELDS}' onClick='onClick_addFormFields_button();'>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
		";
									
		return $html;
	}

}


?>
