<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

wfm_utils::wfm_log('debug', 'ENTRY', __FILE__);

$bean_module = $trigger_module;
// wfm_utils::wfm_log('debug', '$bean_module=['.var_export($bean_module, true).']', __FILE__, __METHOD__, __LINE__);

$multiple = 'multiple';

$data_source = $focus->getDataSource();

switch ($data_source) {
	
	case 'database':
		
		$show_idRelationships = true;
		
		require_once('modules/asol_Process/___common_WFM/php/module_fields.fields_relatedFields.common.php');
		//printModuleFields($sel_altDb, $sel_altDbTable, $focus, $bean_module, $multiple, $show_idRelationships);
		
		break;
		
	case 'form':
		
		global $db, $beanList, $beanFiles, $mod_strings, $timedate, $sugar_config;
		
		// Whether translate or not variable for all this php-file
		$translateFieldLabels = ((!isset($sugar_config['WFM_TranslateLabels'])) || ($sugar_config['WFM_TranslateLabels'])) ? true : false;
		
		require_once('modules/asol_Process/___common_WFM/php/form_fields.fields.common.php');
		
		$show_idRelationships = false;
		$currentTableFields = printFormFieldsSelect($form_id, $multiple, $show_idRelationships);
		wfm_utils::wfm_log('asol_debug', '$currentTableFields=['.var_export($currentTableFields, true).']', __FILE__, __METHOD__, __LINE__);
		
		$fields = (isset($currentTableFields['fields'])) ? $currentTableFields['fields'] : null;
		$fields_labels = (isset($currentTableFields['fields_labels'])) ? $currentTableFields['fields_labels'] : null;
		$fields_type = (isset($currentTableFields['fields_type'])) ? $currentTableFields['fields_type'] : null;
		$fields_enum_operators = (isset($currentTableFields['fields_enum_operators'])) ? $currentTableFields['fields_enum_operators'] : null;
		$fields_enum_references = (isset($currentTableFields['fields_enum_references'])) ? $currentTableFields['fields_enum_references'] : null;
		$has_related = (isset($currentTableFields['has_related'])) ? $currentTableFields['has_related'] : null;
		$dropdowns = (isset($currentTableFields['dropdowns'])) ? $currentTableFields['dropdowns'] : null;
		
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
		
		$form_language = array_combine($fields, $fields_labels);
		
		$form_dropdowns = array_combine($fields, $dropdowns);
		wfm_utils::wfm_log('asol_debug', '$form_dropdowns=['.var_export($form_dropdowns, true).']', __FILE__, __METHOD__, __LINE__);
		
		break;
		
}


wfm_utils::wfm_log('debug', 'EXIT', __FILE__);

?>