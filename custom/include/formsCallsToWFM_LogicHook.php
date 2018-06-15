<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

class formsCallsToWFM_LogicHook {
	
	var $form_id;
	var $trigger_event;
	var $form_parameters;
	
	function formsCallsToWFM_LogicHook($form_id, $trigger_event, $form_parameters) {
		$this->form_id = $form_id;
		$this->trigger_event = $trigger_event;
		$this->form_parameters = $form_parameters;
	}
	
	function getFormId() {
		return $this->form_id;
	}
	
	function getTriggerEvent() {
		return $this->trigger_event;
	}
	
	function getFormParameters() {
		return $this->form_parameters;
	}
	
	function executeWFM() {
	
		$executeResult = false;
		
		$form_id = $this->getFormId();
		$form_parameters = $this->getFormParameters();
		
		wfm_utils::wfm_log('asol_debug', '$form_id=['.var_export($form_id, true).']', __FILE__, __METHOD__, __LINE__);
		wfm_utils::wfm_log('asol_debug', '$form_parameters=['.var_export($form_parameters, true).']', __FILE__, __METHOD__, __LINE__);
		
		$bean = wfm_utils::getBean('asol_Forms', $form_id);
		
		foreach ($form_parameters as $field_name => $field_parameters) {
			if (!empty($field_name)) {
				$bean->field_defs[$field_name]['type'] = null; // FIXME // needed to get add form's parameters to the bean
				$bean->$field_name = $field_parameters['value']['new'];
				$bean->fetched_row[$field_name] = $field_parameters['value']['old'];
			}
		}
		
		require_once("custom/include/wfm_hook.php");
		$wfm = new wfm_hook_process();
		$executeResult = $wfm->execute_process($bean, $this->getTriggerEvent(), null);
		wfm_utils::wfm_log('asol_debug', '$executeResult=['.var_export($executeResult,true).']', __FILE__, __METHOD__, __LINE__);
		
		return $executeResult;
	}
	
}