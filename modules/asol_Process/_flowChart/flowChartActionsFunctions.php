<?php

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");

function jsonDecode($json) {
	$json = htmlspecialchars_decode($json, ENT_QUOTES);
	$array = json_decode($json, true);
	return $array;
}

function fillFields(&$bean, $draggedNode, $processId, $counter) {

	wfm_utils::wfm_log('flow_debug', '$processId=['.var_export($processId, true).']', __FILE__, __METHOD__, __LINE__);

	switch ($draggedNode['module']) {
		case 'asol_Events':
			$bean->name = 'Event_ ' . $counter;
			$bean->trigger_type = $draggedNode['bean']['trigger_type'];
			$bean->trigger_event = $draggedNode['bean']['trigger_event'];
			$bean->scheduled_type = $draggedNode['bean']['scheduled_type'];
			$bean->subprocess_type = $draggedNode['bean']['subprocess_type'];

			$bean->type = ($bean->trigger_type == 'logic_hook') ? 'start' : '';
			break;
				
		case 'asol_Activity':
			$bean->name = 'Activity_ ' . $counter;
			$bean->delay = 'minutes - 0';
			break;
				
		case 'asol_Task':
				
			$bean->name = 'Task_ ' . $counter;
			$bean->delay = 'minutes - 0';
			$bean->task_type = $draggedNode['bean']['task_type'];
				
			switch ($bean->task_type) {
				case 'send_email':
					$bean->task_implementation = '${pipe}${pipe}${pipe}${pipe}${pipe}${pipe}${pipe}${pipe}${pipe}${pipe}${pipe}${pipe}${pipe}${pipe}${pipe}${pipe}';
					break;
				case 'php_custom':
					$bean->task_implementation = '';
					break;
				case 'continue':
					$bean->task_implementation = '';
					break;
				case 'end':
					$bean->task_implementation = 'false';
					break;
				case 'create_object':
					$bean->task_implementation = '${mod}${relationships}';
					break;
				case 'modify_object':
					$process = wfm_utils::getBean('asol_Process', $processId);
					$bean->task_implementation = $process->trigger_module.'${mod}${relationships}';
					break;
				case 'call_process':
					$bean->task_implementation = '{"process_id":"","process_name":"","event_id":"","event_name":"","object_module":"","object_ids":"","execute_subprocess_immediately":false}';
					break;
				case 'add_custom_variables':
					$bean->task_implementation = '';
					break;
			}
			break;
	}
}

function markDeletedRecycleBinEvents($processId) {

	global $db;

	$events = Array();

	$sql = "
		SELECT asol_events.*
		FROM asol_events
		INNER JOIN asol_process_asol_events_1_c ON asol_process_asol_events_1_c.asol_process_asol_events_1asol_events_idb = asol_events.id
		WHERE asol_process_asol_events_1_c.asol_process_asol_events_1asol_process_ida = '{$processId}' AND asol_process_asol_events_1_c.deleted = 0 AND asol_events.deleted = 0
		ORDER BY asol_process_asol_events_1_c.date_modified DESC
	";
	$query = $db->query($sql);
	while ($row = $db->fetchByAssoc($query)) {
		$events[] = $row;
	}

	foreach ($events as $event) {
		$eventBean = wfm_utils::getBean('asol_Events', $event['id']);
		$eventBean->mark_deleted($eventBean->id);
	}
}

function markDeletedRecycleBinActivities($processId) {

	global $db;

	$activities = Array();

	$sql = "
		SELECT asol_activity.*
		FROM asol_activity
		INNER JOIN asol_process_asol_activity_c ON asol_process_asol_activity_c.asol_process_asol_activityasol_activity_idb = asol_activity.id
		WHERE asol_process_asol_activity_c.asol_process_asol_activityasol_process_ida = '{$processId}' AND asol_process_asol_activity_c.deleted = 0 AND asol_activity.deleted = 0
		ORDER BY asol_process_asol_activity_c.date_modified DESC
	";
	$query = $db->query($sql);
	while ($row = $db->fetchByAssoc($query)) {
		$activities[] = $row;
	}

	foreach ($activities as $activity) {
		$activityBean = wfm_utils::getBean('asol_Activity', $activity['id']);
		$activityBean->mark_deleted($activityBean->id);
	}
}

function markDeletedRecycleBinTasks($processId) {

	global $db;

	$tasks = Array();

	$sql = "
		SELECT asol_task.*
		FROM asol_task
		INNER JOIN asol_process_asol_task_c ON asol_process_asol_task_c.asol_process_asol_taskasol_task_idb = asol_task.id
		WHERE asol_process_asol_task_c.asol_process_asol_taskasol_process_ida = '{$processId}' AND asol_process_asol_task_c.deleted = 0 AND asol_task.deleted = 0
		ORDER BY asol_process_asol_task_c.date_modified DESC
	";
	$query = $db->query($sql);
	while ($row = $db->fetchByAssoc($query)) {
		$tasks[] = $row;
	}

	foreach ($tasks as $task) {
		$taskBean = wfm_utils::getBean('asol_Task', $task['id']);
		$taskBean->mark_deleted($taskBean->id);
	}
}

function getObjectHierarchy($module, $id) {

	global $db;

	$workflows = Array();

	$workflows['events']['auxId'] = $id;

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
					//// wfm_utils::wfm_log('debug', "3 part \$workflows=[".var_export($workflows,true)."]", __FILE__, __METHOD__, __LINE__);
				}
			}
		}
	}
	wfm_utils::wfm_log('debug', '3 $workflows=['.var_export($workflows, true).']', __FILE__, __METHOD__, __LINE__);
}

function cloneNode($type, $sourceModule, $sourceId, $targetModule, $targetId, $processId) {
	wfm_utils::wfm_log('flow_debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);

	$ok = false;

	switch ($targetId) {

		case 'recycleBin':

			switch ($sourceModule) {
				case 'asol_Events':

					if ($type == 'cloneNodeAndDescendants') {
						$workFlow = getObjectDescendants($sourceModule, $sourceId);
						$clonedBeanId = cloneObjectDescendants($workFlow, $sourceModule);

						$clonedBean = wfm_utils::getBean($sourceModule, $clonedBeanId);

						// Add relationship
						$link = 'asol_process_asol_events_1asol_process_ida';


						$clonedBean->$link = $processId;
						$clonedBean->save();

					} else  {
						$link = 'asol_process_asol_events_1asol_process_ida';

						// Save object.
						$bean = wfm_utils::getBean($sourceModule, $sourceId);
						$clonedBeanId = wfm_utils::cloneBean($bean);
						$clonedBean = wfm_utils::getBean($sourceModule, $clonedBeanId);

						// Add relationship
						$clonedBean->$link = $processId;
						$clonedBean->save();
					}

					break;
				case 'asol_Activity':

					if ($type == 'cloneNodeAndDescendants') {
						$workFlow = getObjectDescendants($sourceModule, $sourceId);
						$clonedBeanId = cloneObjectDescendants($workFlow, $sourceModule);

						$clonedBean = wfm_utils::getBean($sourceModule, $clonedBeanId);

						// Add relationship
						$link = 'asol_process_asol_activityasol_process_ida';
						$clonedBean->$link = $processId;
						$clonedBean->save();

					} else  {
							
						$link = 'asol_process_asol_activityasol_process_ida';

						// Save object.
						$bean = wfm_utils::getBean($sourceModule, $sourceId);
						$clonedBeanId = wfm_utils::cloneBean($bean);
						$clonedBean = wfm_utils::getBean($sourceModule, $clonedBeanId);

						// Add relationship
						$clonedBean->$link = $processId;
						$clonedBean->save();
					}

					break;
				case 'asol_Task':
					$link = 'asol_process_asol_taskasol_process_ida';

					// Save object.
					$bean = wfm_utils::getBean($sourceModule, $sourceId);
					$clonedBeanId = wfm_utils::cloneBean($bean);
					$clonedBean = wfm_utils::getBean($sourceModule, $clonedBeanId);

					// Add relationship
					$clonedBean->$link = $processId;
					$clonedBean->save();

					break;
			}

			$ok = true;

			break;

		default:

			switch ($sourceModule) {

				case 'asol_Events':

					switch ($targetId) {
						case 'workflow':
								
							$targetModule = 'asol_Process';

							if ($type == 'cloneNodeAndDescendants') {
								$workFlow = getObjectDescendants($sourceModule, $sourceId);
								$clonedBeanId = cloneObjectDescendants($workFlow, $sourceModule);

								$clonedBean = wfm_utils::getBean($sourceModule, $clonedBeanId);

								// Add relationship
								$link = 'asol_proce6f14process_ida';
								$clonedBean->$link = $processId;
								$clonedBean->save();

							} else  {
									
								// Save object.
								$event = wfm_utils::getBean($sourceModule, $sourceId);
								$clonedEventId = wfm_utils::cloneBean($event);

								// Save relationship.
								$process = wfm_utils::getBean($targetModule, $processId);
								$link = 'asol_process_asol_events';
								$process->load_relationship($link);
								$process->$link->add($clonedEventId);
								$process->save();
							}

							$ok = true;

							break;
						default:
							$ok = false;
							break;
					}

					break;

				case 'asol_Activity':

					switch ($targetModule) {

						case 'asol_Events':

							if ($type == 'cloneNodeAndDescendants') {
								$workFlow = getObjectDescendants($sourceModule, $sourceId);
								$clonedBeanId = cloneObjectDescendants($workFlow, $sourceModule);

								$clonedBean = wfm_utils::getBean($sourceModule, $clonedBeanId);

								// Add relationship
								$link = 'asol_event87f4_events_ida';
								$clonedBean->$link = $targetId;
								$clonedBean->save();

							} else  {
									
								// Save object.
								$activity = wfm_utils::getBean($sourceModule, $sourceId);
								$clonedActivityId = wfm_utils::cloneBean($activity);

								// Save relationship.
								$event = wfm_utils::getBean($targetModule, $targetId);
								$link = 'asol_events_asol_activity';
								$event->load_relationship($link);
								$event->$link->add($clonedActivityId);
								$event->save();
							}

							$ok = true;

							break;

						case 'asol_Activity':

							if ($type == 'cloneNodeAndDescendants') {
								$workFlow = getObjectDescendants($sourceModule, $sourceId);
								$clonedBeanId = cloneObjectDescendants($workFlow, $sourceModule);

								$clonedBean = wfm_utils::getBean($sourceModule, $clonedBeanId);

								// Add relationship
								$link = 'asol_activ898activity_ida';
								$clonedBean->$link = $targetId;
								$clonedBean->save();

							} else  {
									
								// Save object.
								$activity = wfm_utils::getBean($sourceModule, $sourceId);
								$clonedActivityId = wfm_utils::cloneBean($activity);

								$clonedActivity = wfm_utils::getBean($sourceModule, $clonedActivityId);
								$clonedActivity->asol_activ898activity_ida = $targetId;
								$clonedActivity->save();
							}

							$ok = true;

							break;

						default:
							$ok = false;
							break;
					}

					break;

				case 'asol_Task':

					switch ($targetModule) {
						case 'asol_Activity':

							// Save object.
							$task = wfm_utils::getBean($sourceModule, $sourceId);
							$clonedTaskId = wfm_utils::cloneBean($task);

							// Save relationship.
							$activity = wfm_utils::getBean($targetModule, $targetId);
							$link = 'asol_activity_asol_task';
							$activity->load_relationship($link);
							$activity->$link->add($clonedTaskId);
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

			break;

	}

	return $ok;
}

function cloneNodeAndDescendants($sourceModule, $sourceId, $targetModule, $targetId, $processId) {

}


function getObjectDescendants($module, $id) {

	global $db;

	$workflows = Array();

	switch ($module) {

		case 'asol_Events':

			$event_query = $db->query ("
										SELECT *
										FROM asol_events
										WHERE id = '{$id}'
									");
			$event_row = $db->fetchByAssoc($event_query);

			$event_and_relationship = $event_row;
			$event_and_relationship['relationship'] = $event_relationship;

			$workflows['events']['auxId'][] = $event_and_relationship;


			// wfm_utils::wfm_log('debug', '2 $workflows=['.var_export($workflows, true).']', __FILE__, __METHOD__, __LINE__);

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
							//// wfm_utils::wfm_log('debug', "3 part \$workflows=[".var_export($workflows,true)."]", __FILE__, __METHOD__, __LINE__);
						}
					}
				}
			}
			// wfm_utils::wfm_log('debug', '3 $workflows=['.var_export($workflows, true).']', __FILE__, __METHOD__, __LINE__);

			// Search for next_activities from activities(from events)
			$activity_ids = Array();

			if (is_array($workflows['activities'])) {
				foreach ($workflows['activities'] as $activities_from_parent_event_id) {
					foreach ($activities_from_parent_event_id as $activity) {

						// wfm_utils::wfm_log('debug', '$activity_ids=['.var_export($activity_ids, true).']', __FILE__, __METHOD__, __LINE__);
						if (!in_array($activity['id'], $activity_ids)) { // Event duplicity.

							$next_activity_ids_all_tree = wfm_utils::getNextActivities($activity['id']);

							// wfm_utils::wfm_log('debug', '$next_activity_ids_all_tree=['.var_export($next_activity_ids_all_tree, true).']', __FILE__, __METHOD__, __LINE__);

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
							// wfm_utils::wfm_log('debug', "Event duplicity", __FILE__, __METHOD__, __LINE__);
						}
					}
				}
			}
			// wfm_utils::wfm_log('debug', '4 $workflows=['.var_export($workflows, true).']', __FILE__, __METHOD__, __LINE__);

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

							$workflows['tasks'][$activity['id']][] = $task_and_relationship_and_emailtemplate;
						}
					}
				}
			}
			// wfm_utils::wfm_log('debug', '5 $workflows=['.var_export($workflows, true).']', __FILE__, __METHOD__, __LINE__);

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

							$workflows['tasks'][$activity['id']][] = $task_and_relationship_and_emailtemplate;

						}
					}
				}
			}
			wfm_utils::wfm_log('flow_debug', '6 $workflows=['.var_export($workflows, true).']', __FILE__, __METHOD__, __LINE__);



			break;

		case 'asol_Activity':


			$activity_query = $db->query ("
											SELECT *
											FROM asol_activity
											WHERE id = '{$id}'
										");
			$activity_row = $db->fetchByAssoc($activity_query);

			$activity_and_relationship = $activity_row;
			$activity_and_relationship['relationship'] = $activity_relationship;

			$workflows['activities']['auxID'][] = $activity_and_relationship;
			//// wfm_utils::wfm_log('debug', "3 part \$workflows=[".var_export($workflows,true)."]", __FILE__, __METHOD__, __LINE__);

			// wfm_utils::wfm_log('debug', '3 $workflows=['.var_export($workflows, true).']', __FILE__, __METHOD__, __LINE__);

			// Search for next_activities from activities(from events)
			$activity_ids = Array();

			if (is_array($workflows['activities'])) {
				foreach ($workflows['activities'] as $activities_from_parent_event_id) {
					foreach ($activities_from_parent_event_id as $activity) {

						// wfm_utils::wfm_log('debug', '$activity_ids=['.var_export($activity_ids, true).']', __FILE__, __METHOD__, __LINE__);
						if (!in_array($activity['id'], $activity_ids)) { // Event duplicity.

							$next_activity_ids_all_tree = wfm_utils::getNextActivities($activity['id']);

							// wfm_utils::wfm_log('debug', '$next_activity_ids_all_tree=['.var_export($next_activity_ids_all_tree, true).']', __FILE__, __METHOD__, __LINE__);

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
							// wfm_utils::wfm_log('debug', "Event duplicity", __FILE__, __METHOD__, __LINE__);
						}
					}
				}
			}
			// wfm_utils::wfm_log('debug', '4 $workflows=['.var_export($workflows, true).']', __FILE__, __METHOD__, __LINE__);

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

							$workflows['tasks'][$activity['id']][] = $task_and_relationship_and_emailtemplate;
						}
					}
				}
			}
			// wfm_utils::wfm_log('debug', '5 $workflows=['.var_export($workflows, true).']', __FILE__, __METHOD__, __LINE__);

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

							$workflows['tasks'][$activity['id']][] = $task_and_relationship_and_emailtemplate;

						}
					}
				}
			}
			wfm_utils::wfm_log('flow_debug', '6 $workflows=['.var_export($workflows, true).']', __FILE__, __METHOD__, __LINE__);

			break;
	}

	return $workflows;
}

function cloneObjectDescendants($imported_workflows, $module) {

	$current_datetime  = date("Y-m-d H:i:s", mktime(gmdate("H"), gmdate("i"), gmdate("s") , gmdate("m"), gmdate("d"), gmdate("Y")));
	
	$workflows_exist_process_ids = null;
	$workflows_exist = false;
	$in_context_process_id;
	$import_type = 'clone';
	$prefix = '';
	$suffix = '';
	$rename_type;
	$set_status_type;
	$import_domain_type = 'keep_domain';
	$explicit_domain;
	$import_email_template_type;
	$if_email_template_already_exists;

	$isDomainsInstalled = wfm_domains_utils::wfm_isDomainsInstalled();

	$query_domains_columns = ($isDomainsInstalled) ? ", asol_domain_id, asol_domain_child_share_depth, asol_multi_create_domain, asol_published_domain" : '';

	global $db;


	// Create wfm-events

	$old_ids__and__new_ids__event__array = Array();

	if (array_key_exists('events', $imported_workflows)) {
		foreach ($imported_workflows['events'] as $parent_process_id => $events_from_parent_process_id) {
			foreach ($events_from_parent_process_id as $event) {

				$event_id = create_guid();
				$event_name =  $event['name'];
				$event_date_entered = $current_datetime;
				$event_date_modified = $current_datetime;
				$query_domains_values = ($isDomainsInstalled) ? wfm_utils::modifySqlImportWorkFlowsWithDomains($event, $import_domain_type, $explicit_domain) : '';

				$db->query("
						DELETE FROM asol_events
						WHERE id = '{$event_id}'  
					");

				$db->query("
							INSERT INTO asol_events (id           , name           , date_entered           , date_modified           , modified_user_id              , created_by              , description              , deleted              , assigned_user_id              , type              , trigger_type              , trigger_event              , conditions              , scheduled_tasks              , scheduled_type               , subprocess_type                           {$query_domains_columns})
							VALUES                  ('{$event_id}', '{$event_name}', '{$event_date_entered}', '{$event_date_modified}', '{$event['modified_user_id']}', '{$event['created_by']}', '{$event['description']}', '{$event['deleted']}', '{$event['assigned_user_id']}', '{$event['type']}', '{$event['trigger_type']}', '{$event['trigger_event']}', '{$event['conditions']}', '{$event['scheduled_tasks']}', '{$event['scheduled_type']}' , '{$event['subprocess_type']}'             {$query_domains_values})
						");

				$old_ids__and__new_ids__event__array[$event['id']] = $event_id;

				$event_relationship_id = create_guid();
				$event_relationship_date_modified = $current_datetime;
				$event_relationship_ida = $old_ids__and__new_ids__process__array[$parent_process_id];
				$event_relationship_idb = $event_id;

				$db->query("
						DELETE FROM asol_proces_asol_events_c
						WHERE id = '{$event_relationship_id}'  
					");

				$db->query("
						INSERT INTO asol_proces_asol_events_c (id                              , date_modified                              , deleted                              , asol_proce6f14process_ida                              , asol_procea8ca_events_idb                              )
						VALUES                                ('{$event_relationship_id}', '{$event_relationship_date_modified}', '{$event['relationship']['deleted']}', '{$event_relationship_ida}', '{$event_relationship_idb}')
					");
			}
		}
	}


	// Create wfm-activities

	$old_ids__and__new_ids__activity__array = Array();

	if (array_key_exists('activities', $imported_workflows)) {
		foreach ($imported_workflows['activities'] as $parent_event_id => $activities_from_parent_event_id) {
			foreach ($activities_from_parent_event_id as $activity) {

				// wfm_utils::wfm_log('debug', '$old_ids__and__new_ids__activity__array=['.var_export($old_ids__and__new_ids__activity__array, true).']', __FILE__, __METHOD__, __LINE__);
				if (!array_key_exists($activity['id'], $old_ids__and__new_ids__activity__array)) {	// Event duplicity.

					$activity_id = create_guid();
					$activity_name = $activity['name'];
					$activity_date_entered = $current_datetime;
					$activity_date_modified = $current_datetime;
					$query_domains_values = ($isDomainsInstalled) ? wfm_utils::modifySqlImportWorkFlowsWithDomains($activity, $import_domain_type, $explicit_domain) : '';

					$db->query("
							DELETE FROM asol_activity
							WHERE id = '{$activity_id}'  
						");

					$db->query("
								INSERT INTO asol_activity (id                 , name                 , date_entered                 , date_modified                 , modified_user_id                 , created_by                 , description                 , deleted                 , assigned_user_id                 , conditions                 , delay                 , type                 {$query_domains_columns})
								VALUES					  ('{$activity_id}', '{$activity_name}', '{$activity_date_entered}', '{$activity_date_modified}', '{$activity['modified_user_id']}', '{$activity['created_by']}', '{$activity['description']}', '{$activity['deleted']}', '{$activity['assigned_user_id']}', '{$activity['conditions']}', '{$activity['delay']}', '{$activity['type']}'               {$query_domains_values})
						");

					$old_ids__and__new_ids__activity__array[$activity['id']] = $activity_id;
				} else {
					// wfm_utils::wfm_log('debug', "Event duplicity", __FILE__, __METHOD__, __LINE__);
				}

				$activity_relationship_id = create_guid();
				$activity_relationship_date_modified = $current_datetime;
				$activity_relationship_ida = $old_ids__and__new_ids__event__array[$parent_event_id];
				$activity_relationship_idb = $activity_id;

				$db->query("
						DELETE FROM asol_eventssol_activity_c
						WHERE id = '{$activity_relationship_id}'  
					");

				$db->query("
						INSERT INTO asol_eventssol_activity_c (id                                 , date_modified                                 , deleted                                 , asol_event87f4_events_ida                                 , asol_event8042ctivity_idb                                 )
						VALUES                                ('{$activity_relationship_id}', '{$activity_relationship_date_modified}', '{$activity['relationship']['deleted']}', '{$activity_relationship_ida}', '{$activity_relationship_idb}')
					");
			}
		}
	}

	// Create wfm-activities(next_activities)

	//$old_ids__and__new_ids__next_activity__array = Array(); -> activities and next_activities in the same array

	if (array_key_exists('next_activities', $imported_workflows)) {
		foreach ($imported_workflows['next_activities'] as $parent_activity_id => $activities_from_parent_activity_id) {
			foreach ($activities_from_parent_activity_id as $next_activity) {

				$next_activity_id = create_guid();
				$next_activity_name = $next_activity['name'];
				$next_activity_date_entered = $current_datetime;
				$next_activity_date_modified = $current_datetime;
				$query_domains_values = ($isDomainsInstalled) ? wfm_utils::modifySqlImportWorkFlowsWithDomains($next_activity, $import_domain_type, $explicit_domain) : '';

				$db->query("
						DELETE FROM asol_activity
						WHERE id = '{$next_activity_id}'  
					");

				$db->query("
							INSERT INTO asol_activity (id                      , name                      , date_entered                      , date_modified                      , modified_user_id                      , created_by                      , description                      , deleted                      , assigned_user_id                      , conditions                      , delay                      , type                      {$query_domains_columns})
							VALUES					  ('{$next_activity_id}', '{$next_activity_name}', '{$next_activity_date_entered}', '{$next_activity_date_modified}', '{$next_activity['modified_user_id']}', '{$next_activity['created_by']}', '{$next_activity['description']}', '{$next_activity['deleted']}', '{$next_activity['assigned_user_id']}', '{$next_activity['conditions']}', '{$next_activity['delay']}', '{$next_activity['type']}'               {$query_domains_values})
					");

				$old_ids__and__new_ids__activity__array[$next_activity['id']] = $next_activity_id;

				$next_activity_relationship_id = create_guid();
				$next_activity_relationship_date_modified =$current_datetime;
				$next_activity_relationship_ida = $old_ids__and__new_ids__activity__array[$parent_activity_id];
				$next_activity_relationship_idb = $next_activity_id;

				$db->query("
						DELETE FROM asol_activisol_activity_c
						WHERE id = '{$next_activity_relationship_id}'  
					");

				$db->query("
						INSERT INTO asol_activisol_activity_c (id                                      , date_modified                                      , deleted                                      , asol_activ898activity_ida                                      , asol_activ9e2dctivity_idb                                      )
						VALUES                                ('{$next_activity_relationship_id}', '{$next_activity_relationship_date_modified}', '{$next_activity['relationship']['deleted']}', '{$next_activity_relationship_ida}', '{$next_activity_relationship_idb}')
					");
			}
		}
	}

	// Create wfm-tasks

	if (array_key_exists('tasks', $imported_workflows)) {
		foreach ($imported_workflows['tasks'] as $parent_activity_id => $tasks_from_parent_activity_id) {
			foreach ($tasks_from_parent_activity_id as $task) {

				$task_id = create_guid();
				$task_name = $task['name'];
				$task_implementation = $task['task_implementation'];
				$task_date_entered = $current_datetime;
				$task_date_modified = $current_datetime;
				$query_domains_values = ($isDomainsInstalled) ? wfm_utils::modifySqlImportWorkFlowsWithDomains($task, $import_domain_type, $explicit_domain) : '';

				switch ($task['task_type']) {
					case 'php_custom':
						wfm_utils::wfm_SavePhpCustomToFile($task_id, $task['task_implementation']);
						break;
				}

				$db->query("
						DELETE FROM asol_task
						WHERE id = '{$task_id}'  
					");

				$db->query("
							INSERT INTO asol_task (id          , name          , date_entered          , date_modified          , modified_user_id             , created_by             , description             , deleted             , assigned_user_id             , async             , delay_type             , delay             , date             , task_type             , task_order             , task_implementation                     {$query_domains_columns} )
							VALUES                ('{$task_id}', '{$task_name}', '{$task_date_entered}', '{$task_date_modified}', '{$task['modified_user_id']}', '{$task['created_by']}', '{$task['description']}', '{$task['deleted']}', '{$task['assigned_user_id']}', '{$task['async']}', '{$task['delay_type']}', '{$task['delay']}', '{$task['date']}', '{$task['task_type']}', '{$task['task_order']}', '{$task_implementation}'                  {$query_domains_values})
					");

				$task_relationship_id = create_guid();
				$task_relationship_date_modified = $current_datetime;
				$task_relationship_ida = $old_ids__and__new_ids__activity__array[$parent_activity_id];
				$task_relationship_idb = $task_id;

				$db->query("
						DELETE FROM asol_activity_asol_task_c
						WHERE id = '{$task_relationship_id}'  
					");

				$db->query("
						INSERT INTO asol_activity_asol_task_c (id                             , date_modified                             , deleted                             , asol_activ5b86ctivity_ida                             , asol_activf613ol_task_idb                             )
						VALUES                                ('{$task_relationship_id}', '{$task_relationship_date_modified}', '{$task['relationship']['deleted']}', '{$task_relationship_ida}', '{$task_relationship_idb}')
					");
			}
		}
	}

	$beanId = null;
	switch($module) {
		case 'asol_Events':
			$beanId = $event_id;
			break;
		case 'asol_Activity':
			$beanId = $activity_id;
			break;
		case 'asol_Task';
		$beanId = $task_id;
	}

	return $beanId;

}

function manageEventDuplicity(& $event) {
	
	// Manage event-duplicity
	$rel_name = 'asol_events_asol_activity';
	$event->load_relationship($rel_name);

	$childrenActivities = array();
	foreach ($event->$rel_name->getBeans() as $childActivity) {
		$childrenActivities[$childActivity->id] = $childActivity;

		$childActivity = wfm_utils::getBean('asol_Activity', $childActivity->id);
		$childActivity->load_relationship($rel_name);

		$parentEvents = array();
		foreach ($childActivity->$rel_name->getBeans() as $parentEvent) {
			$parentEvents[$parentEvent->id] = $parentEvent;
		}

		if (count($parentEvents) > 1) { // Event-duplicity
			$event->$rel_name->delete($event->id, $childActivity->id);
		}
	}
}

function clean_incoming_data_AsolFixFor641() {

	$req = Array();
	
	if (get_magic_quotes_gpc() == 1) {
		$req  = array_map("preprocess_param_AsolFixFor641", $_REQUEST);
	}
	
	// PHP cannot stomp out superglobals reliably
	foreach($req  as $k => $v) {
		 $_REQUEST[$k] = $v;
	}
}

function preprocess_param_AsolFixFor641($value, $callFromItself = false){
	
	if(is_string($value) && ($callFromItself)){
		if(get_magic_quotes_gpc() == 1){
			$value = stripslashes($value);
		}

		$value = securexss($value);
	} else if (is_array($value)){
	    foreach ($value as $key => $element) {
	        $value[$key] = preprocess_param_AsolFixFor641($element, true);
	    }
	}

	return $value;
}

function remove_activity_to_activity_relationship($activity_id) {
	
	global $db;
	
	$sql = "
		SELECT asol_activ898activity_ida AS parent_activity_id
		FROM asol_activisol_activity_c
		WHERE asol_activ9e2dctivity_idb = '{$activity_id}' AND deleted = 0
	";
	$query = $db->query($sql);
	$row = $db->fetchByAssoc($query);
	$parent_activity_id = $row['parent_activity_id'];
	//wfm_utils::wfm_log('debug', '$parent_activity_id=['.var_export($parent_activity_id, true).']', __FILE__, __METHOD__, __LINE__);
		
	$date_modified = gmdate('Y-m-d H:i:s');
	
	$sql = "
		UPDATE asol_activisol_activity_c
		SET deleted = 1, date_modified = '{$date_modified}'
		WHERE asol_activ9e2dctivity_idb = '{$activity_id}' AND asol_activ898activity_ida = '{$parent_activity_id}'
	";
	//wfm_utils::wfm_log('debug', '$sql=['.var_export($sql, true).']', __FILE__, __METHOD__, __LINE__);
	$query = $db->query($sql);
}
