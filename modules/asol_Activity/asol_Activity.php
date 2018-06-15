<?php
require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

require_once('modules/asol_Process/___common_WFM/php/Basic_wfm.php');

class asol_Activity extends Basic_wfm {

	var $new_schema = true;
	var $module_dir = 'asol_Activity';
	var $object_name = 'asol_Activity';
	var $table_name = 'asol_activity';
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
	var $conditions;
	var $asol_activity_id_c;
	var $next_activity;
	var $delay;
	var $audit;

	function asol_Activity(){
		parent::Basic_wfm();
	}
	
	function getAudit() {

		$activity_id = $this->id;

		if (!empty($activity_id)) { // If the activity is already created then it takes the trigger-module from de bean.
			$activity_id = $this->getParentActivityId($activity_id);

			return $this->getAuditFromActivityId($activity_id);

		} else { // Else, it will take the trigger-module from the hidden information in the save-sugar button.

			if ( $_REQUEST["return_module"] == "asol_Events" ) { // The Activity is going to be created from asol_Events
				$event_id = $_REQUEST["return_id"]; // return_id is within save-sugar button's php code

				return $this->getAuditFromEventId($event_id);

			} elseif ( $_REQUEST['return_module'] == "asol_Activity" ) { // The Activity is going to be created from asol_Activity
				$activity_id = $_REQUEST['return_id'];
				$activity_id = $this->getParentActivityId($activity_id);

				return $this->getAuditFromActivityId($activity_id);
			}
		}
	}
	
	function getAuditFromActivityId($activity_id) {

		global $db;

		$audit = '';

		$process_query = $db->query("
										SELECT asol_process.audit as audit
										FROM asol_eventssol_activity_c
										INNER JOIN asol_proces_asol_events_c ON (asol_proces_asol_events_c.asol_procea8ca_events_idb = asol_eventssol_activity_c.asol_event87f4_events_ida AND asol_proces_asol_events_c.deleted = 0)
										INNER JOIN asol_process ON (asol_process.id = asol_proces_asol_events_c.asol_proce6f14process_ida AND asol_process.deleted = 0)
										WHERE asol_eventssol_activity_c.asol_event8042ctivity_idb = '{$activity_id}' AND asol_eventssol_activity_c.deleted = 0						  
								  	");
		$process_row = $db->fetchByAssoc($process_query);

		$audit = $process_row['audit'];

		if (empty($audit)) { // RecycleBin
				
			$process_query = $db->query("
										SELECT asol_process.audit as audit
										FROM asol_process_asol_activity_c
										INNER JOIN asol_process ON (asol_process.id = asol_process_asol_activity_c.asol_process_asol_activityasol_process_ida AND asol_process.deleted = 0)
										WHERE asol_process_asol_activity_c.asol_process_asol_activityasol_activity_idb = '{$activity_id}' AND asol_process_asol_activity_c.deleted = 0						  
								  	");
			$process_row = $db->fetchByAssoc($process_query);

			$audit = $process_row['audit'];
				
			if (empty($audit)) { // RecycleBin
					
				$process_query = $db->query("
										SELECT asol_process.audit as audit
										FROM asol_eventssol_activity_c
										INNER JOIN asol_process_asol_events_1_c ON (asol_process_asol_events_1_c.asol_process_asol_events_1asol_events_idb = asol_eventssol_activity_c.asol_event87f4_events_ida AND asol_process_asol_events_1_c.deleted = 0)
										INNER JOIN asol_process ON (asol_process.id = asol_process_asol_events_1_c.asol_process_asol_events_1asol_process_ida AND asol_process.deleted = 0)
										WHERE asol_eventssol_activity_c.asol_event8042ctivity_idb = '{$activity_id}' AND asol_eventssol_activity_c.deleted = 0						  
					  
								  	");
				$process_row = $db->fetchByAssoc($process_query);

				$audit = $process_row['audit'];
			}
		}

		return $audit;
	}

	function getAuditFromEventId($event_id) {

		global $db;

		$audit = '';

		$process_query = $db->query("
										SELECT asol_process.audit as audit
										FROM asol_proces_asol_events_c
										INNER JOIN asol_process ON (asol_process.id = asol_proces_asol_events_c.asol_proce6f14process_ida AND asol_process.deleted = 0)
										WHERE asol_proces_asol_events_c.asol_procea8ca_events_idb = '{$event_id}' AND asol_proces_asol_events_c.deleted = 0						  
								  	");
		$process_row = $db->fetchByAssoc($process_query);

		$audit = $process_row['audit'];

		if (empty($audit)) {
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
	}

	function getTriggerModule() {

		$activity_id = $this->id;

		if (!empty($activity_id)) { // If the activity is already created then it takes the trigger-module from de bean.
			$activity_id = $this->getParentActivityId($activity_id);

			return $this->getTriggerModuleFromActivityId($activity_id);

		} else { // Else, it will take the trigger-module from the hidden information in the save-sugar button.

			if ( $_REQUEST["return_module"] == "asol_Events" ) { // The Activity is going to be created from asol_Events
				$event_id = $_REQUEST["return_id"]; // return_id is within save-sugar button's php code

				return $this->getTriggerModuleFromEventId($event_id);

			} elseif ( $_REQUEST['return_module'] == "asol_Activity" ) { // The Activity is going to be created from asol_Activity
				$activity_id = $_REQUEST['return_id'];
				$activity_id = $this->getParentActivityId($activity_id);

				return $this->getTriggerModuleFromActivityId($activity_id);
			}
		}
	}
	
	function getParentActivityId($activity_id) {

		global $db;

		$parent_query = $db->query("
										SELECT asol_activ898activity_ida  
										FROM asol_activisol_activity_c 
										WHERE asol_activ9e2dctivity_idb = '{$activity_id}' AND deleted = 0
									");
		$parent_row = $db->fetchByAssoc($parent_query);

		while ($parent_row) { // While a activity is pointed by other activity.
			$parent_query = $db->query("
											SELECT asol_activ898activity_ida  
											FROM asol_activisol_activity_c 
											WHERE asol_activ9e2dctivity_idb = '{$activity_id}' AND deleted = 0
										");
			$parent_row = $db->fetchByAssoc($parent_query);
			if ($parent_row == null) {
				break;
			} else {
				$activity_id = $parent_row["asol_activ898activity_ida"]; // $activity_id = her parent activity
			}
		}

		return $activity_id;
	}

	function getTriggerModuleFromActivityId($activity_id) {

		global $db;

		$triggerModule = '';

		$process_query = $db->query("
										SELECT asol_process.trigger_module as trigger_module
										FROM asol_eventssol_activity_c
										INNER JOIN asol_proces_asol_events_c ON (asol_proces_asol_events_c.asol_procea8ca_events_idb = asol_eventssol_activity_c.asol_event87f4_events_ida AND asol_proces_asol_events_c.deleted = 0)
										INNER JOIN asol_process ON (asol_process.id = asol_proces_asol_events_c.asol_proce6f14process_ida AND asol_process.deleted = 0)
										WHERE asol_eventssol_activity_c.asol_event8042ctivity_idb = '{$activity_id}' AND asol_eventssol_activity_c.deleted = 0						  
								  	");
		$process_row = $db->fetchByAssoc($process_query);

		$triggerModule = $process_row['trigger_module'];

		if (empty($triggerModule)) { // RecycleBin
				
			$process_query = $db->query("
										SELECT asol_process.trigger_module as trigger_module
										FROM asol_process_asol_activity_c
										INNER JOIN asol_process ON (asol_process.id = asol_process_asol_activity_c.asol_process_asol_activityasol_process_ida AND asol_process.deleted = 0)
										WHERE asol_process_asol_activity_c.asol_process_asol_activityasol_activity_idb = '{$activity_id}' AND asol_process_asol_activity_c.deleted = 0						  
								  	");
			$process_row = $db->fetchByAssoc($process_query);

			$triggerModule = $process_row['trigger_module'];
				
			if (empty($triggerModule)) { // RecycleBin
					
				$process_query = $db->query("
										SELECT asol_process.trigger_module as trigger_module
										FROM asol_eventssol_activity_c
										INNER JOIN asol_process_asol_events_1_c ON (asol_process_asol_events_1_c.asol_process_asol_events_1asol_events_idb = asol_eventssol_activity_c.asol_event87f4_events_ida AND asol_process_asol_events_1_c.deleted = 0)
										INNER JOIN asol_process ON (asol_process.id = asol_process_asol_events_1_c.asol_process_asol_events_1asol_process_ida AND asol_process.deleted = 0)
										WHERE asol_eventssol_activity_c.asol_event8042ctivity_idb = '{$activity_id}' AND asol_eventssol_activity_c.deleted = 0						  
					  
								  	");
				$process_row = $db->fetchByAssoc($process_query);

				$triggerModule = $process_row['trigger_module'];
			}
		}

		return $triggerModule;
	}

	function getTriggerModuleFromEventId($event_id) {

		global $db;

		$triggerModule = '';

		$process_query = $db->query("
										SELECT asol_process.trigger_module as trigger_module
										FROM asol_proces_asol_events_c
										INNER JOIN asol_process ON (asol_process.id = asol_proces_asol_events_c.asol_proce6f14process_ida AND asol_process.deleted = 0)
										WHERE asol_proces_asol_events_c.asol_procea8ca_events_idb = '{$event_id}' AND asol_proces_asol_events_c.deleted = 0						  
								  	");
		$process_row = $db->fetchByAssoc($process_query);

		$triggerModule = $process_row['trigger_module'];

		if (empty($triggerModule)) {
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
	}

	function getParentEvent() {

		global $db;
		$activity_id = $this->id;

		$activity_id = $this->getParentActivityId($activity_id);
		$event_array =  $this->getTriggerArray($activity_id);

		return $event_array["id"];
	}

	function getEventModuleNameFromEventModuleId($event_id) {

		global $db;

		$eventQuery = $db->query("
									SELECT name  
									FROM asol_events 
									WHERE id = '{$event_id}' AND deleted = 0
								");
		$eventRow = $db->fetchByAssoc($eventQuery);

		return $eventRow["name"];
	}

	function getSavedDelay(){

		global $db;
		$activity_id = $this->id;

		$parent_query = $db->query("
										SELECT delay 
										FROM asol_activity 
										WHERE id = '{$activity_id}' AND deleted = 0
									");
		$parent_row = $db->fetchByAssoc($parent_query);

		return $parent_row;
	}


	function getAlternativeDatabase() {

		$activity_id = $this->id;

		if (!empty($activity_id)) { // If the activity is already created then it takes the trigger-module from de bean.
			$activity_id = $this->getParentActivityId($activity_id);

			return $this->getAlternativeDatabaseFromActivityId($activity_id);

		} else { // Else, it will take the trigger-module from the hidden information in the save-sugar button.

			if ( $_REQUEST["return_module"] == "asol_Events" ) { // The Activity is going to be created from asol_Events
				$event_id = $_REQUEST["return_id"]; // return_id is within save-sugar button's php code

				return $this->getAlternativeDatabaseFromEventId($event_id);

			} elseif ( $_REQUEST['return_module'] == "asol_Activity" ) { // The Activity is going to be created from asol_Activity
				$activity_id = $_REQUEST['return_id'];
				$activity_id = $this->getParentActivityId($activity_id);

				return $this->getAlternativeDatabaseFromActivityId($activity_id);
			}
		}
	}

	function getAlternativeDatabaseFromActivityId($activity_id) {

		global $db;

		$process_query = $db->query("
										SELECT asol_process.alternative_database as alternative_database
										FROM asol_eventssol_activity_c
										INNER JOIN asol_proces_asol_events_c ON (asol_proces_asol_events_c.asol_procea8ca_events_idb = asol_eventssol_activity_c.asol_event87f4_events_ida AND asol_proces_asol_events_c.deleted = 0)
										INNER JOIN asol_process ON (asol_process.id = asol_proces_asol_events_c.asol_proce6f14process_ida AND asol_process.deleted = 0)
										WHERE asol_eventssol_activity_c.asol_event8042ctivity_idb = '{$activity_id}' AND asol_eventssol_activity_c.deleted = 0						  
								  	");
		$process_row = $db->fetchByAssoc($process_query);

		return $process_row['alternative_database'];
	}

	function getAlternativeDatabaseFromEventId($event_id) {

		global $db;

		$process_query = $db->query("
										SELECT asol_process.alternative_database as alternative_database
										FROM asol_proces_asol_events_c
										INNER JOIN asol_process ON (asol_process.id = asol_proces_asol_events_c.asol_proce6f14process_ida AND asol_process.deleted = 0)
										WHERE asol_proces_asol_events_c.asol_procea8ca_events_idb = '{$event_id}' AND asol_proces_asol_events_c.deleted = 0						  
								  	");
		$process_row = $db->fetchByAssoc($process_query);

		return $process_row['alternative_database'];
	}
	
	
	// BEGIN - data_source
	function getDataSource() {
	
		$activity_id = $this->id;
	
		if (!empty($activity_id)) { // If the activity is already created then it takes the trigger-module from de bean.
			$activity_id = $this->getParentActivityId($activity_id);
	
			return $this->getDataSourceFromActivityId($activity_id);
	
		} else { // Else, it will take the trigger-module from the hidden information in the save-sugar button.
	
			if ( $_REQUEST["return_module"] == "asol_Events" ) { // The Activity is going to be created from asol_Events
				$event_id = $_REQUEST["return_id"]; // return_id is within save-sugar button's php code
	
				return $this->getDataSourceFromEventId($event_id);
	
			} elseif ( $_REQUEST['return_module'] == "asol_Activity" ) { // The Activity is going to be created from asol_Activity
				$activity_id = $_REQUEST['return_id'];
				$activity_id = $this->getParentActivityId($activity_id);
	
				return $this->getDataSourceFromActivityId($activity_id);
			}
		}
	}
	
	function getDataSourceFromActivityId($activity_id) {
	
		global $db;
	
		$process_query = $db->query("
			SELECT asol_process.data_source as data_source
			FROM asol_eventssol_activity_c
			INNER JOIN asol_proces_asol_events_c ON (asol_proces_asol_events_c.asol_procea8ca_events_idb = asol_eventssol_activity_c.asol_event87f4_events_ida AND asol_proces_asol_events_c.deleted = 0)
			INNER JOIN asol_process ON (asol_process.id = asol_proces_asol_events_c.asol_proce6f14process_ida AND asol_process.deleted = 0)
			WHERE asol_eventssol_activity_c.asol_event8042ctivity_idb = '{$activity_id}' AND asol_eventssol_activity_c.deleted = 0
		");
		$process_row = $db->fetchByAssoc($process_query);
	
		return $process_row['data_source'];
	}
	
	function getDataSourceFromEventId($event_id) {
	
		global $db;
	
		$process_query = $db->query("
			SELECT asol_process.data_source as data_source
			FROM asol_proces_asol_events_c
			INNER JOIN asol_process ON (asol_process.id = asol_proces_asol_events_c.asol_proce6f14process_ida AND asol_process.deleted = 0)
			WHERE asol_proces_asol_events_c.asol_procea8ca_events_idb = '{$event_id}' AND asol_proces_asol_events_c.deleted = 0
		");
		$process_row = $db->fetchByAssoc($process_query);
	
		return $process_row['data_source'];
	}
	
	// END - data_source
	
	// BEGIN - asol_forms_id_c
	function getAsolFormsIdC() {
	
		$activity_id = $this->id;
	
		if (!empty($activity_id)) { // If the activity is already created then it takes the trigger-module from de bean.
			$activity_id = $this->getParentActivityId($activity_id);
	
			return $this->getAsolFormsIdCFromActivityId($activity_id);
	
		} else { // Else, it will take the trigger-module from the hidden information in the save-sugar button.
	
			if ( $_REQUEST["return_module"] == "asol_Events" ) { // The Activity is going to be created from asol_Events
				$event_id = $_REQUEST["return_id"]; // return_id is within save-sugar button's php code
	
				return $this->getAsolFormsIdCFromEventId($event_id);
	
			} elseif ( $_REQUEST['return_module'] == "asol_Activity" ) { // The Activity is going to be created from asol_Activity
				$activity_id = $_REQUEST['return_id'];
				$activity_id = $this->getParentActivityId($activity_id);
	
				return $this->getAsolFormsIdCFromActivityId($activity_id);
			}
		}
	}
	
	function getAsolFormsIdCFromActivityId($activity_id) {
	
		global $db;
	
		$process_query = $db->query("
			SELECT asol_process.asol_forms_id_c as asol_forms_id_c
			FROM asol_eventssol_activity_c
			INNER JOIN asol_proces_asol_events_c ON (asol_proces_asol_events_c.asol_procea8ca_events_idb = asol_eventssol_activity_c.asol_event87f4_events_ida AND asol_proces_asol_events_c.deleted = 0)
			INNER JOIN asol_process ON (asol_process.id = asol_proces_asol_events_c.asol_proce6f14process_ida AND asol_process.deleted = 0)
			WHERE asol_eventssol_activity_c.asol_event8042ctivity_idb = '{$activity_id}' AND asol_eventssol_activity_c.deleted = 0
		");
		$process_row = $db->fetchByAssoc($process_query);
	
		return $process_row['asol_forms_id_c'];
	}
	
	function getAsolFormsIdCFromEventId($event_id) {
	
		global $db;
	
		$process_query = $db->query("
				SELECT asol_process.asol_forms_id_c as asol_forms_id_c
				FROM asol_proces_asol_events_c
				INNER JOIN asol_process ON (asol_process.id = asol_proces_asol_events_c.asol_proce6f14process_ida AND asol_process.deleted = 0)
				WHERE asol_proces_asol_events_c.asol_procea8ca_events_idb = '{$event_id}' AND asol_proces_asol_events_c.deleted = 0
				");
		$process_row = $db->fetchByAssoc($process_query);
	
		return $process_row['asol_forms_id_c'];
	}
	
	// END - asol_forms_id_c

}
?>