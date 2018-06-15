<?php
require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

require_once('modules/asol_Process/___common_WFM/php/Basic_wfm.php');

class asol_Task extends Basic_wfm {

	var $new_schema = true;
	var $module_dir = 'asol_Task';
	var $object_name = 'asol_Task';
	var $table_name = 'asol_task';
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
	var $async;
	var $delay_type;
	var $delay;
	var $date;
	var $task_order;
	var $task_type;
	var $task_implementation;
	var $audit;

	function asol_Task(){
		parent::Basic_wfm();
	}

	function getParentActivityId() {

		global $db;
		$task_id = $this->id;
			
		if (!empty($task_id)) {// If the task is already created then it prints the trigger_module.
			$parent_query = $db->query("
											SELECT asol_activ5b86ctivity_ida AS asol_parent_activity_from_task 
											FROM asol_activity_asol_task_c 
											WHERE asol_activf613ol_task_idb = '{$task_id}' AND deleted = 0
										");
			$parent_row = $db->fetchByAssoc($parent_query);

			$activity_id = $parent_row["asol_parent_activity_from_task"];
		}
		else {// Else, it will take the trigger_module from the hidden information in the save-sugar button.
			$activity_id = $_REQUEST["relate_id"];
		}

		return $activity_id;
	}

	function getTriggerModule() {

		$activity_id = $this->getParentActivityId();

		if (empty($activity_id)) { // RecycleBin

			global $db;

			$process_query = $db->query("
										SELECT asol_process.trigger_module as trigger_module
										FROM asol_process_asol_task_c
										INNER JOIN asol_process ON (asol_process.id = asol_process_asol_task_c.asol_process_asol_taskasol_process_ida AND asol_process.deleted = 0)
										WHERE asol_process_asol_task_c.asol_process_asol_taskasol_task_idb = '{$this->id}' AND asol_process_asol_task_c.deleted = 0	
								  	");
			$process_row = $db->fetchByAssoc($process_query);

			$triggerModule = $process_row['trigger_module'];
			
			return $triggerModule;

		} else {
			
			$focus = new asol_Activity();
			$focus->retrieve($activity_id);

			return $focus->getTriggerModule();
		}
	}
	
	function getAudit() {

		$activity_id = $this->getParentActivityId();

		if (empty($activity_id)) { // RecycleBin

			global $db;

			$process_query = $db->query("
										SELECT asol_process.audit as audit
										FROM asol_process_asol_task_c
										INNER JOIN asol_process ON (asol_process.id = asol_process_asol_task_c.asol_process_asol_taskasol_process_ida AND asol_process.deleted = 0)
										WHERE asol_process_asol_task_c.asol_process_asol_taskasol_task_idb = '{$this->id}' AND asol_process_asol_task_c.deleted = 0	
								  	");
			$process_row = $db->fetchByAssoc($process_query);

			$audit = $process_row['audit'];
			
			return $audit;

		} else {
			
			$focus = new asol_Activity();
			$focus->retrieve($activity_id);

			return $focus->getAudit();
		}
	}
	
	function getDataSource() {
	
		$activity_id = $this->getParentActivityId();
	
		if (empty($activity_id)) { // RecycleBin
	
			global $db;
	
			$process_query = $db->query("
				SELECT asol_process.data_source as data_source
				FROM asol_process_asol_task_c
				INNER JOIN asol_process ON (asol_process.id = asol_process_asol_task_c.asol_process_asol_taskasol_process_ida AND asol_process.deleted = 0)
				WHERE asol_process_asol_task_c.asol_process_asol_taskasol_task_idb = '{$this->id}' AND asol_process_asol_task_c.deleted = 0
			");
			$process_row = $db->fetchByAssoc($process_query);

			$data_source = $process_row['data_source'];
				
			return $data_source;
	
		} else {
			
			$focus = new asol_Activity();
			$focus->retrieve($activity_id);
	
			return $focus->getDataSource();
		}
	}
	
	function getAsolFormsIdC() {
	
		$activity_id = $this->getParentActivityId();
	
		if (empty($activity_id)) { // RecycleBin
	
			global $db;
	
			$process_query = $db->query("
					SELECT asol_process.asol_forms_id_c as asol_forms_id_c
					FROM asol_process_asol_task_c
					INNER JOIN asol_process ON (asol_process.id = asol_process_asol_task_c.asol_process_asol_taskasol_process_ida AND asol_process.deleted = 0)
					WHERE asol_process_asol_task_c.asol_process_asol_taskasol_task_idb = '{$this->id}' AND asol_process_asol_task_c.deleted = 0
					");
			$process_row = $db->fetchByAssoc($process_query);
	
			$asol_forms_id_c = $process_row['asol_forms_id_c'];
	
			return $asol_forms_id_c;
	
		} else {
				
			$focus = new asol_Activity();
			$focus->retrieve($activity_id);
	
			return $focus->getAsolFormsIdC();
		}
	}

	function getAlternativeDatabase() {

		$activity_id = $this->getParentActivityId();

		$focus = new asol_Activity();
		$focus->retrieve($activity_id);

		return $focus->getAlternativeDatabase();
	}
}
?>