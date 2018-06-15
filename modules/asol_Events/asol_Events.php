<?php
require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

require_once('modules/asol_Process/___common_WFM/php/Basic_wfm.php');

class asol_Events extends Basic_wfm {

	var $new_schema = true;
	var $module_dir = 'asol_Events';
	var $object_name = 'asol_Events';
	var $table_name = 'asol_events';
	var $importable = false;
	var $disable_row_level_security = true ; // to ensure that modules created and deployed under CE will continue to function under team security if the instance is upgraded to PRO
	var $id;
	var $name;
	var $date_entered;
	var $date_modified;
	var $modified_user_id;
	var $modified_by_name;
	var $created_by;
	var $created_by_name;
	var $description;
	var $deleted;
	var $created_by_link;
	var $modified_user_link;
	var $assigned_user_id;
	var $assigned_user_name;
	var $assigned_user_link;
	var $type;
	var $trigger_type;
	var $trigger_event;
	var $conditions;
	var $scheduled_tasks;
	var $scheduled_type;
	var $subprocess_type;
	var $audit;

	function asol_Events(){
		parent::Basic_wfm();
	}

	function getTriggerModule() {

		global $db;

		$event_id = $this->id;

		if (!empty($event_id)) { // If the event is already created then it prints the trigger_module.

			$process_query = $db->query("
											SELECT asol_process.trigger_module as trigger_module
											FROM asol_proces_asol_events_c
											INNER JOIN asol_process ON (asol_process.id = asol_proces_asol_events_c.asol_proce6f14process_ida AND asol_process.deleted = 0)
											WHERE asol_proces_asol_events_c.asol_procea8ca_events_idb = '{$event_id}' AND asol_proces_asol_events_c.deleted = 0						  
									  	");
			$process_row = $db->fetchByAssoc($process_query);
				
			$triggerModule = $process_row['trigger_module'];
			
			if (empty($triggerModule)) { // RecycleBin
				$process_query = $db->query("
										SELECT asol_process.trigger_module as trigger_module
										FROM asol_process_asol_events_1_c
										INNER JOIN asol_process ON (asol_process.id = asol_process_asol_events_1_c.asol_process_asol_events_1asol_process_ida AND asol_process.deleted = 0)
										WHERE asol_process_asol_events_1_c.asol_process_asol_events_1asol_events_idb = '{$event_id}' AND asol_process_asol_events_1_c.deleted = 0						  
								  	");
				$process_row = $db->fetchByAssoc($process_query);

				$triggerModule = $process_row['trigger_module'];
			}

			return $triggerModule;

		} else { // Else, it will take the name from the hidden information in the save-sugar button.

			$parent_process_id = $_REQUEST["return_id"];// return_id is within save-sugar button's php code

			$process_query = $db->query("
											SELECT trigger_module
											FROM asol_process
											WHERE id = '{$parent_process_id}'
										");
			$process_row = $db->fetchByAssoc($process_query);

			return $process_row['trigger_module'];
		}
	}
	
	function getAudit() {
	
		global $db;
	
		$event_id = $this->id;
	
		if (!empty($event_id)) { // If the event is already created then it prints the audit.
	
			$process_query = $db->query("
				SELECT asol_process.audit as audit
				FROM asol_proces_asol_events_c
				INNER JOIN asol_process ON (asol_process.id = asol_proces_asol_events_c.asol_proce6f14process_ida AND asol_process.deleted = 0)
				WHERE asol_proces_asol_events_c.asol_procea8ca_events_idb = '{$event_id}' AND asol_proces_asol_events_c.deleted = 0
				");
			$process_row = $db->fetchByAssoc($process_query);

			$audit = $process_row['audit'];

				if (empty($audit)) { // RecycleBin
					$process_query = $db->query("
						SELECT asol_process.audit as audit
						FROM asol_process_asol_events_1_c
						INNER JOIN asol_process ON (asol_process.id = asol_process_asol_events_1_c.asol_process_asol_events_1asol_process_ida AND asol_process.deleted = 0)
						WHERE asol_process_asol_events_1_c.asol_process_asol_events_1asol_events_idb = '{$event_id}' AND asol_process_asol_events_1_c.deleted = 0
					");
					$process_row = $db->fetchByAssoc($process_query);

					$audit = $process_row['audit'];
				}
	
			return $audit;
	
		} else { // Else, it will take the name from the hidden information in the save-sugar button.
	
			$parent_process_id = $_REQUEST["return_id"];// return_id is within save-sugar button's php code

			$process_query = $db->query("
				SELECT audit
				FROM asol_process
				WHERE id = '{$parent_process_id}'
			");
			$process_row = $db->fetchByAssoc($process_query);

			return $process_row['audit'];
		}
	}
	
	function getDataSource() {
	
		global $db;
	
		$event_id = $this->id;
	
		if (!empty($event_id)) { // If the event is already created then it prints the data_source.
	
			$process_query = $db->query("
				SELECT asol_process.data_source as data_source
				FROM asol_proces_asol_events_c
				INNER JOIN asol_process ON (asol_process.id = asol_proces_asol_events_c.asol_proce6f14process_ida AND asol_process.deleted = 0)
				WHERE asol_proces_asol_events_c.asol_procea8ca_events_idb = '{$event_id}' AND asol_proces_asol_events_c.deleted = 0
			");
			$process_row = $db->fetchByAssoc($process_query);
	
			$data_source = $process_row['data_source'];
	
			if (empty($data_source)) { // RecycleBin
				$process_query = $db->query("
					SELECT asol_process.data_source as data_source
					FROM asol_process_asol_events_1_c
					INNER JOIN asol_process ON (asol_process.id = asol_process_asol_events_1_c.asol_process_asol_events_1asol_process_ida AND asol_process.deleted = 0)
					WHERE asol_process_asol_events_1_c.asol_process_asol_events_1asol_events_idb = '{$event_id}' AND asol_process_asol_events_1_c.deleted = 0
				");
				$process_row = $db->fetchByAssoc($process_query);

				$data_source = $process_row['data_source'];
			}
	
			return $data_source;
	
		} else { // Else, it will take the name from the hidden information in the save-sugar button.
	
			$parent_process_id = $_REQUEST["return_id"];// return_id is within save-sugar button's php code
	
			$process_query = $db->query("
				SELECT data_source
				FROM asol_process
				WHERE id = '{$parent_process_id}'
			");
			$process_row = $db->fetchByAssoc($process_query);
	
			return $process_row['data_source'];
		}
	}
	
	function getAsolFormsIdC() {
	
		global $db;
	
		$event_id = $this->id;
	
		if (!empty($event_id)) { // If the event is already created then it prints the asol_forms_id_c.
	
			$process_query = $db->query("
				SELECT asol_process.asol_forms_id_c as asol_forms_id_c
				FROM asol_proces_asol_events_c
				INNER JOIN asol_process ON (asol_process.id = asol_proces_asol_events_c.asol_proce6f14process_ida AND asol_process.deleted = 0)
				WHERE asol_proces_asol_events_c.asol_procea8ca_events_idb = '{$event_id}' AND asol_proces_asol_events_c.deleted = 0
			");
			$process_row = $db->fetchByAssoc($process_query);
	
			$asol_forms_id_c = $process_row['asol_forms_id_c'];
	
			if (empty($asol_forms_id_c)) { // RecycleBin
				$process_query = $db->query("
					SELECT asol_process.asol_forms_id_c as asol_forms_id_c
					FROM asol_process_asol_events_1_c
					INNER JOIN asol_process ON (asol_process.id = asol_process_asol_events_1_c.asol_process_asol_events_1asol_process_ida AND asol_process.deleted = 0)
					WHERE asol_process_asol_events_1_c.asol_process_asol_events_1asol_events_idb = '{$event_id}' AND asol_process_asol_events_1_c.deleted = 0
				");
				$process_row = $db->fetchByAssoc($process_query);

				$asol_forms_id_c = $process_row['asol_forms_id_c'];
			}
	
			return $asol_forms_id_c;
	
		} else { // Else, it will take the name from the hidden information in the save-sugar button.
	
			$parent_process_id = $_REQUEST["return_id"];// return_id is within save-sugar button's php code
	
			$process_query = $db->query("
				SELECT asol_forms_id_c
				FROM asol_process
				WHERE id = '{$parent_process_id}'
			");
			$process_row = $db->fetchByAssoc($process_query);
	
			return $process_row['asol_forms_id_c'];
		}
	}

	function getProcessStatus() {

		global $db;

		$event_id = $this->id;

		if (!empty($event_id)) { // If the event is already created then it prints the status.

			$process_query = $db->query("
											SELECT asol_process.status as status
											FROM asol_proces_asol_events_c
											INNER JOIN asol_process ON (asol_process.id = asol_proces_asol_events_c.asol_proce6f14process_ida AND asol_process.deleted = 0)
											WHERE asol_proces_asol_events_c.asol_procea8ca_events_idb = '{$event_id}' AND asol_proces_asol_events_c.deleted = 0						  
									  	");
			$process_row = $db->fetchByAssoc($process_query);

			return $process_row['status'];

		} else { // Else, it will take the name from the hidden information in the save-sugar button.

			$parent_process_id = $_REQUEST["return_id"];// return_id is within save-sugar button's php code

			$process_query = $db->query("
											SELECT status
											FROM asol_process
											WHERE id = '{$parent_process_id}'
										");
			$process_row = $db->fetchByAssoc($process_query);

			return $process_row['status'];
		}
	}

	function getAlternativeDatabase() {

		global $db;

		$event_id = $this->id;

		if (!empty($event_id)) { // If the event is already created then it prints the alternative_database.

			$process_query = $db->query("
											SELECT asol_process.alternative_database as alternative_database
											FROM asol_proces_asol_events_c
											INNER JOIN asol_process ON (asol_process.id = asol_proces_asol_events_c.asol_proce6f14process_ida AND asol_process.deleted = 0)
											WHERE asol_proces_asol_events_c.asol_procea8ca_events_idb = '{$event_id}' AND asol_proces_asol_events_c.deleted = 0						  
									  	");
			$process_row = $db->fetchByAssoc($process_query);

			return $process_row['alternative_database'];

		} else { // Else, it will take the name from the hidden information in the save-sugar button.

			$parent_process_id = $_REQUEST["return_id"];// return_id is within save-sugar button's php code

			$process_query = $db->query("
											SELECT alternative_database
											FROM asol_process
											WHERE id = '{$parent_process_id}'
										");
			$process_row = $db->fetchByAssoc($process_query);

			return $process_row['alternative_database'];
		}
	}

	function get_list_view_data() {

		$wfm_event_fields = parent::get_list_view_data();

		// PROCESS_STATUS
		$process_status = $this->getProcessStatus();
		$process_status_html = wfm_utils::getProcessStatusHtml($process_status);
		$wfm_event_fields['PROCESS_STATUS'] = $process_status_html;

		// FORCE_EXECUTE_EVENT
		if ($this->trigger_type == 'scheduled') {
			$LBL_FORCE_EXECUTE_EVENT_BUTTON = translate('LBL_FORCE_EXECUTE_EVENT_BUTTON','asol_Events');

			$forceExecuteEvent = "<img src='modules/asol_Process/___common_WFM/images/force_execute_event.png' onClick='forceExecuteEvent(\"{$this->id}\");' title='{$LBL_FORCE_EXECUTE_EVENT_BUTTON}' style='cursor: pointer;' />";
			$wfm_event_fields['FORCE_EXECUTE_EVENT'] = $forceExecuteEvent;
		}

		return $wfm_event_fields;
	}
}
?>