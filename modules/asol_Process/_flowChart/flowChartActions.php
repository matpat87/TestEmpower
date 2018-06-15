<?php

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
require_once("modules/asol_Process/_flowChart/flowChartActionsFunctions.php");
require_once("modules/asol_Process/_flowChart/flowChartFunctions.php");

wfm_utils::set_error_reporting_level();

wfm_utils::wfm_log('flow_debug', '$_REQUEST=['.var_export($_REQUEST, true).']', __FILE__, __METHOD__, __LINE__);

global $current_user, $sugar_config, $db;

/* BEGIN - Bugfix for sugarcrm 641 and for sugarcrm 7.X.X */
if (($sugar_config['sugar_version'] == '6.4.1') || version_compare($sugar_config['sugar_version'], '7', '>=')) {
	clean_incoming_data_AsolFixFor641();
}
/* END - Bugfix for sugarcrm 641 */

wfm_utils::wfm_log('flow_debug', '$current_user->user_name=['.var_export($current_user->user_name, true).']', __FILE__, __METHOD__, __LINE__);

$action = $_REQUEST['action'];

/* BEGIN - Check wfe_operation_counter */

switch ($action) {
	case 'wfmModulesLogicHookEnabled':
		break;

	case 'reorderTasks':
	case 'deleteRelationship':
	case 'createRelationship':
	case 'createObjectAndRelationship':
	case 'cloneNode':
	case 'removeNode':
	case 'deleteNode':
	case 'moveNode':
	case 'emptyRecycleBin':
	case 'saveObjectAndReload':

		$processId = $_REQUEST['processId'];
		$wfe_operation_counter = $_REQUEST['wfe_operation_counter'];

		$process = wfm_utils::getBean('asol_Process', $processId);

		if ($process->wfe_operation_counter == $wfe_operation_counter) {
			$process->wfe_operation_counter = intval($process->wfe_operation_counter) + 1;
			$process->save();
		} else {

			// Send response to client
			$response = Array(
				'ok' => false,
				'errorType' => 'wfe_operation_counter_error',
			);
			echo json_encode($response);
			exit();
		}

		break;
}

/* END - Check wfe_operation_counter */

switch ($action) {

	case 'wfmModulesLogicHookEnabled':

		$ok = false;

		$checked = ($_REQUEST['checked'] == 'true') ? true : false;
		wfm_utils::setWfmModulesLogicHookEnabled($checked);

		$ok = true;

		// Send response to client
		$response = Array(
			'ok' => $ok,
		);
		echo json_encode($response);
		break;

	case 'reorderTasks':

		$ok = false;

		$reorderTasksInfo = jsonDecode($_REQUEST['jsonReorderTasksInfo']);

		foreach ($reorderTasksInfo as $taskInfo) {
			$taskBean = wfm_utils::getBean('asol_Task', $taskInfo['id']);
			$taskBean->task_order = $taskInfo['task_order'] + 1;
			$taskBean->save();
		}

		$ok = true;

		// Send response to client
		$response = Array(
			'ok' => $ok,
		);
		echo json_encode($response);
		break;

	case 'deleteRelationship':

		$ok = false;

		$recycleBinOpenTab = false;

		$sourceModule = $_REQUEST['sourceModule'];
		$sourceId = $_REQUEST['sourceId'];
		$targetModule = $_REQUEST['targetModule'];
		$targetId = $_REQUEST['targetId'];
		$processId = $_REQUEST['processId'];

		switch ($sourceModule) {

			case 'asol_Events':
				
				$event = wfm_utils::getBean($sourceModule, $sourceId);
				$link = 'asol_events_asol_activity';
				$event->load_relationship($link);
				$event->$link->delete($event->id, $targetId);
				$event->save();

				// If no parents then move to recycle-bin
				$activity = wfm_utils::getBean($targetModule, $targetId);
				$activity->load_relationship($link);
				$parents = array();
				foreach ($activity->$link->getBeans() as $parent) {
					$parents[$parent->id] = $parent;
				}
				if (count($parents) == 0) {
					$process = wfm_utils::getBean('asol_Process', $processId);
					$link = 'asol_process_asol_activity';
					$process->load_relationship($link);
					$process->$link->add($targetId);
					$process->save();

					$recycleBinOpenTab = true;
				}

				$ok = true;

				break;

			case 'asol_Activity':
				
				$activity = wfm_utils::getBean($targetModule, $targetId);
				
				// Remove relationship
				
				$link = 'asol_activ898activity_ida';
				$activity->$link = '';
				
				remove_activity_to_activity_relationship($activity->id);
				
				// Add relationship
				
				//$link = 'asol_process_asol_activityasol_process_ida';
				//$activity->$link = $processId;
				
				$rel_name = 'asol_process_asol_activity';
				$activity->load_relationship($rel_name);
				$activity->$rel_name->add($processId);
				$activity->save();

				$recycleBinOpenTab = true;

				$ok = true;

				break;
		}

		// Send response to client
		$response = Array(
			'ok' => $ok,
			'recycleBinOpenTab' => $recycleBinOpenTab
		);
		echo json_encode($response);
		break;

	case 'createRelationship':

		$ok = false;

		$sourceModule = $_REQUEST['sourceModule'];
		$sourceId = $_REQUEST['sourceId'];
		$targetModule = $_REQUEST['targetModule'];
		$targetId = $_REQUEST['targetId'];
		$targetRelationship = $_REQUEST['targetRelationship'];
		$processId = $_REQUEST['processId'];

		switch ($sourceModule) {
			case 'asol_Events':

				switch ($targetRelationship) {
					case 'asol_eventssol_activity_c':

						// Save relationship.
						$event = wfm_utils::getBean($sourceModule, $sourceId);
						$link = 'asol_events_asol_activity';
						$event->load_relationship($link);
						$event->$link->add($targetId);
						$event->save();

						$ok = true;

						break;

					default:

						$activity = wfm_utils::getBean($targetModule, $targetId);
						// Add relationship
						$link = 'asol_event87f4_events_ida';
						$activity->$link = $sourceId;
						// Remove relationship
						$link = 'asol_activ898activity_ida';
						$activity->$link = '';
						// Remove relationship
						$link = 'asol_process_asol_activityasol_process_ida';
						$activity->$link = '';
						$activity->save();

						$ok = true;

						break;
				}

				break;
			case 'asol_Activity':

				// Remove event-relationship
				$activity = wfm_utils::getBean($targetModule, $targetId);
				$link = 'asol_events_asol_activity';
				$activity->load_relationship($link);

				foreach ($activity->$link->getBeans() as $parent) {
					$event = wfm_utils::getBean('asol_Events', $parent->id);
					$link = 'asol_events_asol_activity';
					$event->load_relationship($link);
					$event->$link->delete($event->id, $targetId);
				}

				/* Add relatinship*/
				$activity = wfm_utils::getBean($targetModule, $targetId);

				$link = 'asol_process_asol_activityasol_process_ida';
				$activity->$link = '';

				//$link = 'asol_event87f4_events_ida';
				//$activity->$link = '';

				$link = 'asol_activ898activity_ida';
				$activity->$link = '';

				$activity->save();
				$activity = wfm_utils::getBean($targetModule, $targetId);

				$link = 'asol_activ898activity_ida';
				$activity->$link = $sourceId;

				$activity->save();

				$ok = true;

				break;
		}


		// Send response to client
		$response = Array(
			'ok' => $ok,
		);
		echo json_encode($response);
		break;

	case 'createObjectAndRelationship':

		$draggedNode = jsonDecode($_REQUEST['jsonDraggedNode']);
		$validTargetNode = jsonDecode($_REQUEST['jsonValidTargetNode']);
		$processId = $_REQUEST['processId'];
		
		$_SESSION['WFM'] = Array();
		$_SESSION['WFM']['return_module'] = $validTargetNode['module'];
		$_SESSION['WFM']['relate_id'] = $validTargetNode['id'];
		$_SESSION['WFM']['relate_to'] = true; // FIXME
		$_SESSION['WFM']['module'] = $draggedNode['module'];

		switch ($draggedNode['module']) {

			case 'asol_Events':

				$process = wfm_utils::getBean('asol_Process', $processId);
				$process->event_counter = intval($process->event_counter) + 1;
				$process->save();

				switch ($validTargetNode['module']) {
					case 'asol_Process':

						// Save object.
						$event = BeanFactory::newBean('asol_Events');
						fillFields($event, $draggedNode, null, $process->event_counter);
						$eventId = $event->save();

						switch ($validTargetNode['targetIsLayout']) {
							case 'workflow':
								// Save relationship.
								$process = wfm_utils::getBean('asol_Process', $validTargetNode['id']);
								$link = 'asol_process_asol_events';
								$process->load_relationship($link);
								$process->$link->add($eventId);
								$process->save();
								break;
							case 'recycleBin':
								// Save relationship.
								$process = wfm_utils::getBean('asol_Process', $validTargetNode['id']);
								$link = 'asol_process_asol_events_1';
								$process->load_relationship($link);
								$process->$link->add($eventId);
								$process->save();
								break;
						}

						$ok = true;

						break;
					default:
						$ok = false;
						break;
				}

				break;

			case 'asol_Activity':

				$process = wfm_utils::getBean('asol_Process', $processId);
				$process->activity_counter = intval($process->activity_counter) + 1;
				$process->save();

				switch ($validTargetNode['module']) {

					case 'asol_Process':

						// Save object.

						$activity = BeanFactory::newBean('asol_Activity');
						fillFields($activity, $draggedNode, null, $process->activity_counter);
						$activityId = $activity->save();

						switch ($validTargetNode['targetIsLayout']) {
							case 'workflow':
								break;
							case 'recycleBin':
								// Save relationship.
								$process = wfm_utils::getBean('asol_Process', $validTargetNode['id']);
								$link = 'asol_process_asol_activity';
								$process->load_relationship($link);
								$process->$link->add($activityId);
								$process->save();
								break;
						}

						$ok = true;

						break;

					case 'asol_Events':

						// Save object.
						$activity = BeanFactory::newBean('asol_Activity');
						fillFields($activity, $draggedNode, null, $process->activity_counter);
						$activityId = $activity->save();

						// Save relationship.
						$event = wfm_utils::getBean('asol_Events', $validTargetNode['id']);
						$link = 'asol_events_asol_activity';
						$event->load_relationship($link);
						$event->$link->add($activityId);
						$event->save();

						$ok = true;

						break;
							
					case 'asol_Activity':

						// Save object.
						$activity = BeanFactory::newBean('asol_Activity');
						fillFields($activity, $draggedNode, null, $process->activity_counter);
						$activity->asol_activ898activity_ida = $validTargetNode['id'];
						$activityId = $activity->save();

						//						// Save relationship.
						//						$parentActivity = wfm_utils::getBean('asol_Activity', $validTargetNode['id']);
						//						$link = 'asol_activity_asol_activity';
						//						$parentActivity->load_relationship($link);
						//						$parentActivity->$link->add($activityId);
						//						$parentActivity->save();

						$ok = true;

						break;
							
					default:
						$ok = false;
						break;
				}

				break;

			case 'asol_Task':

				$process = wfm_utils::getBean('asol_Process', $processId);
				$process->task_counter = intval($process->task_counter) + 1;
				$process->save();

				switch ($validTargetNode['module']) {

					case 'asol_Process':

						// Save object.
						$task = BeanFactory::newBean('asol_Task');
						fillFields($task, $draggedNode, $processId, $process->task_counter);
						$taskId = $task->save();

						switch ($validTargetNode['targetIsLayout']) {
							case 'workflow':
								break;
							case 'recycleBin':
								// Save relationship.
								$process = wfm_utils::getBean('asol_Process', $validTargetNode['id']);
								$link = 'asol_process_asol_task';
								$process->load_relationship($link);
								$process->$link->add($taskId);
								$process->save();
								break;
						}

						$ok = true;

						break;
							
					case 'asol_Activity':

						// Save object.
						$task = BeanFactory::newBean('asol_Task');
						fillFields($task, $draggedNode, $processId, $process->task_counter);
						$taskId = $task->save();

						// Save relationship.
						$activity = wfm_utils::getBean('asol_Activity', $validTargetNode['id']);
						$link = 'asol_activity_asol_task';
						$activity->load_relationship($link);
						$activity->$link->add($taskId);
						$activity->save();

						$ok = true;

						break;
					default:
						$ok = false;
						break;
				}

				break;

			default:
				$ok = false;
				break;
		}
		
		unset($_SESSION['WFM']);

		// Send response to client
		$response = Array(
			'ok' => $ok,
		);
		echo json_encode($response);

		break;

	case 'cloneNode':

		$type = $_REQUEST['type'];
		$sourceModule = $_REQUEST['sourceModule'];
		$sourceId = $_REQUEST['sourceId'];
		$targetModule = $_REQUEST['targetModule'];
		$targetId = $_REQUEST['targetId'];
		$processId = $_REQUEST['processId'];

		$ok = cloneNode($type, $sourceModule, $sourceId, $targetModule, $targetId, $processId);

		// Send response to client
		$response = Array(
			'ok' => $ok,
		);
		echo json_encode($response);

		break;

	case 'removeNode':

		$ok = false;

		$module = $_REQUEST['module'];
		$id = $_REQUEST['id'];
		$processId = $_REQUEST['processId'];

		switch ($module) {
			
			case 'asol_Events':

				$event = wfm_utils::getBean($module, $id);

				manageEventDuplicity($event);

				// Remove relationship
				
				$link = 'asol_proce6f14process_ida';
				$event->$link = '';
				
				$rel_name = 'asol_process_asol_events';
				$event->load_relationship($rel_name);
				$event->$rel_name->delete($event->id, $processId);
				
				// Add relationship
				
				//$link = 'asol_process_asol_events_1asol_process_ida';
				//$event->$link = $processId;
				
				$rel_name = 'asol_process_asol_events_1';
				$event->load_relationship($rel_name);
				$event->$rel_name->add($processId);
				$event->save();

				$ok = true;

				break;
				
			case 'asol_Activity':

				// Remove event-activity-relationship (many-to-many)
				
				$activity = wfm_utils::getBean($module, $id);
				$rel_name = 'asol_events_asol_activity';
				$activity->load_relationship($rel_name);
				foreach ($activity->$rel_name->getBeans() as $parent) {
					$event = wfm_utils::getBean('asol_Events', $parent->id);
					$event->load_relationship($rel_name);
					$event->$rel_name->delete($event->id, $activity->id);
					$event->save();
				}

				// Remove activity-activity relationship
				
				$activity = wfm_utils::getBean($module, $id);
				
				$link = 'asol_activ898activity_ida';
				$activity->$link = '';

				remove_activity_to_activity_relationship($activity->id);
				
				// Add relationship
				
				$activity = wfm_utils::getBean($module, $id);
				
				//$link = 'asol_process_asol_activityasol_process_ida';
				//$activity->$link = $processId;
				
				$rel_name = 'asol_process_asol_activity';
				$activity->load_relationship($rel_name);
				$activity->$rel_name->add($processId);
				$activity->save();

				$ok = true;

				break;
				
			case 'asol_Task':
				
				// Remove relationship
				
				$task = wfm_utils::getBean($module, $id);
				
				//$link = 'asol_activ5b86ctivity_ida';
				//$task->$link = '';
 				
 				$rel_name = 'asol_activity_asol_task';
 				$task->load_relationship($rel_name);
 				foreach ($task->$rel_name->getBeans() as $parent) {
 					$activity = wfm_utils::getBean('asol_Activity', $parent->id);
 					$activity->load_relationship($rel_name);
 					$activity->$rel_name->delete($activity->id, $task->id);
 					$activity->save();
 				}
	
				// Add relationship
				
				$task = wfm_utils::getBean($module, $id);
				
				//$link = 'asol_process_asol_taskasol_process_ida';
				//$task->$link = $processId;
				
				$rel_name = 'asol_process_asol_task';
				$task->load_relationship($rel_name);
				$task->$rel_name->add($processId);
				$task->save();

				$ok = true;

				break;
		}

		// Send response to client
		$response = Array(
			'ok' => $ok,
		);
		echo json_encode($response);

		break;

	case 'deleteNode':

		$ok = false;

		$module = $_REQUEST['module'];
		$id = $_REQUEST['id'];

		$bean = wfm_utils::getBean($module, $id);
		$bean->mark_deleted($bean->id);

		$ok = true;

		// Send response to client
		$response = Array(
			'ok' => $ok,
		);
		echo json_encode($response);

		break;

	case 'moveNode':

		$ok = false;

		$sourceModule = $_REQUEST['sourceModule'];
		$sourceId = $_REQUEST['sourceId'];
		$targetModule = $_REQUEST['targetModule'];
		$targetId = $_REQUEST['targetId'];
		$processId = $_REQUEST['processId'];

		switch ($sourceModule) {

			case 'asol_Events':

				switch ($targetId) {
					case 'workflow':

						$event = wfm_utils::getBean($sourceModule, $sourceId);

						manageEventDuplicity($event);

						$link = 'asol_process_asol_events_1asol_process_ida';
						$event->$link = '';
						$link = 'asol_proce6f14process_ida';
						$event->$link = $processId;

						$event->save();

						$ok = true;

						break;
						//					case 'recycleBin':
						//						$link = 'asol_proce6f14process_ida';
						//						$event->$link = '';
						//						$link = 'asol_process_asol_events_1asol_process_ida';
						//						$event->$link = $processId;
						//
						//						break;
				}

				break;
					
			case 'asol_Activity':

				switch ($targetModule) {

					case 'asol_Events':

						// Remove event-to-activity relationship
						
						$activity = wfm_utils::getBean($sourceModule, $sourceId);
						$rel_name = 'asol_events_asol_activity';
						$activity->load_relationship($rel_name);

						$parents = $activity->$rel_name->getBeans();
						if (is_array($parents)) {
							foreach ($parents as $parent) {
								$event = wfm_utils::getBean('asol_Events', $parent->id);
								$rel_name = 'asol_events_asol_activity';
								$event->load_relationship($rel_name);
								$event->$rel_name->delete($event->id, $activity->id);
								$event->save();
							}
						}
						
						// Remove activity-to-activity relationship
						
						$activity = wfm_utils::getBean($sourceModule, $sourceId);
						remove_activity_to_activity_relationship($activity->id);

						// Remove recycleBin-to-activity relationship
						
						$activity = wfm_utils::getBean($sourceModule, $sourceId);
						$link = 'asol_process_asol_activityasol_process_ida';
						$activity->$link = '';
						$rel_name = 'asol_process_asol_activity';
						$activity->load_relationship($rel_name);
						$activity->$rel_name->delete($activity->id, $processId);
						$activity->save();

						// Add event-to-activity relationship
						
						$activity = wfm_utils::getBean($sourceModule, $sourceId);
						$link = 'asol_event87f4_events_ida';
						$activity->$link = $targetId;
						$activity->save();

						$ok = true;

						break;

					case 'asol_Activity':

						// Remove event-to-activity relationship
						
						$activity = wfm_utils::getBean($sourceModule, $sourceId);
						$rel_name = 'asol_events_asol_activity';
						$activity->load_relationship($rel_name);

						$parents = $activity->$rel_name->getBeans();
						if (is_array($parents)) {
							foreach ($parents as $parent) {
								$event = wfm_utils::getBean('asol_Events', $parent->id);
								$rel_name = 'asol_events_asol_activity';
								$event->load_relationship($rel_name);
								$event->$rel_name->delete($event->id, $activity->id);
								$event->save();
							}
						}
						
						// Remove activity-to-activity relationship
						
						$activity = wfm_utils::getBean($sourceModule, $sourceId);
						remove_activity_to_activity_relationship($activity->id);

						// Remove recycleBin-to-activity relationship
						
						$activity = wfm_utils::getBean($sourceModule, $sourceId);
						$link = 'asol_process_asol_activityasol_process_ida';
						$activity->$link = '';
						$rel_name = 'asol_process_asol_activity';
						$activity->load_relationship($rel_name);
						$activity->$rel_name->delete($activity->id, $processId);
						$activity->save();
						
						// Add activity-to-activity relationship
						
						$activity = wfm_utils::getBean($sourceModule, $sourceId);
						$link = 'asol_activ898activity_ida';
						$activity->$link = $targetId;
						$activity->save();

						$ok = true;

						break;

				}

				break;
					
			case 'asol_Task':

				
				$task = wfm_utils::getBean($sourceModule, $sourceId);
				
				// Remove relationship
				$link = 'asol_process_asol_taskasol_process_ida';
				$task->$link = '';

				// Add relationship
				$link = 'asol_activ5b86ctivity_ida';
				$task->$link = $targetId;

				$task->save();

				$ok = true;

				break;
		}

		// Send response to client
		$response = Array(
			'ok' => $ok,
		);
		echo json_encode($response);

		break;

	case 'emptyRecycleBin':

		$ok = false;

		$module = $_REQUEST['module'];
		$processId = $_REQUEST['processId'];

		switch ($module) {
			case 'all':
				markDeletedRecycleBinEvents($processId);
				markDeletedRecycleBinActivities($processId);
				markDeletedRecycleBinTasks($processId);
				$ok = true;
				break;
			case 'asol_Events':
				markDeletedRecycleBinEvents($processId);
				$ok = true;
				break;
			case 'asol_Activity':
				markDeletedRecycleBinActivities($processId);
				$ok = true;
				break;
			case 'asol_Task':
				markDeletedRecycleBinTasks($processId);
				$ok = true;
				break;
		}

		// Send response to client
		$response = Array(
			'ok' => $ok,
		);
		echo json_encode($response);

		break;

	case 'saveObjectAndReload':

		$ok = false;

		$processId = $_REQUEST['processId'];
		$editViewForm = $_REQUEST['editViewForm'];

		$object = Array();
		foreach ($editViewForm as $field) {
			$object[$field['name']] = $field['value'];;
		}

		wfm_utils::wfm_log('flow_debug', '$object=['.var_export($object, true).']', __FILE__, __METHOD__, __LINE__);

		switch ($object['module']) {
			case 'asol_Process':
				wfm_utils::saveProcess($object);
				if (wfm_domains_utils::wfm_isDomainsInstalled()) {
					require_once("modules/asol_Domains/AlineaSolDomainsFunctions.php");
					$temp = $_REQUEST;
					$_REQUEST = $object;
					wfm_utils::wfm_log('flow_debug', '$_REQUEST=['.var_export($_REQUEST, true).']', __FILE__, __METHOD__, __LINE__);
					asol_manageDomains::managePublicationDomainRequest('asol_domain_published_mode', 'asol_domain_child_share_depth', 'asol_multi_create_domain', 'asol_published_domain');
					$_REQUEST = $temp;
				}
				break;
			case 'asol_Events':
				wfm_utils::saveEvent($object);
				break;
			case 'asol_Activity':
				wfm_utils::saveActivity($object);
				break;
			case 'asol_Task':
				wfm_utils::saveTask($object);
				break;
		}

		$html = generateFlowChart($processId);
		$ok = true;

		// Send response to client
		$response = Array(
			'ok' => $ok,
			'html' => $html,
		);
		echo json_encode($response);

		break;
}