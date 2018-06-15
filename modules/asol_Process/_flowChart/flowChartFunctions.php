<?php

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");

class flowChart {

	// draw-information for Events
	static $draw_information_event;
	static $top_Process;
	static $left_Process;
	static $height_Event;
	static $width_Event;
	static $separation_vertical_Event;
	// draw-information for Activities
	static $draw_information_activity;
	static $separation_horizontal_Event; // for activity loop
	static $separation_horizontal_Activity;// for next_activity loop
	static $height_Activity;
	static $number_of_pixels_to_susbstrate_from_width_Activity;
	static $width_Activity_depending_on_number_of_tasks_Default; // width for two tasks (no padding, no border).
	static $width_Activity_depending_on_number_of_tasks_Maximum; // to get the nex_activity location
	static $separation_vertical_Activity;
	//
	static $draw_Activities;
	static $connections;
	//
	static $data_source;
	static $form_id;
	static $form_language;
	static $form_dropdowns;

	static function init() {

		// draw-information for Events
		self::$draw_information_event = Array();
		self::$top_Process = 80;
		self::$left_Process = 50;
		self::$height_Event = 0+1+5+90+5+1+0; // 102
		self::$width_Event = 0+1+5+90+5+1+0; // 102
		self::$separation_vertical_Event = 50;
		// draw-information for Activities
		self::$draw_information_activity = Array();
		self::$top_Process = self::$top_Process;
		self::$separation_horizontal_Event = 100;// for activity loop
		self::$separation_horizontal_Activity = 100;// for next_activity loop
		self::$left_Process = self::$left_Process + self::$width_Event + self::$separation_horizontal_Event;
		self::$height_Activity = 0+1+5+90+5+1+0;
		self::$number_of_pixels_to_susbstrate_from_width_Activity = 0;
		self::$width_Activity_depending_on_number_of_tasks_Default = 92; // width for two tasks (no padding, no border).
		self::$width_Activity_depending_on_number_of_tasks_Maximum = self::$width_Activity_depending_on_number_of_tasks_Default; // to get the nex_activity location
		self::$separation_vertical_Activity = 50;
		//
		self::$draw_Activities = '';
		self::$connections = '';
		
		// forms
		self::$data_source = null;
		self::$form_id = null;
		self::$form_language = null;
	}
}

// SEARCH FOR EVENTS
function searchEvents(& $export_array) {

	global $db;

	if (!empty($export_array['processes'])) { // It is always only one process for the flowChart
		foreach ($export_array['processes'] as $key_process => $value_process) {

			$event_from_process__query = $db->query("
														SELECT asol_events.*
														FROM asol_proces_asol_events_c
														INNER JOIN asol_events ON (asol_proces_asol_events_c.asol_procea8ca_events_idb = asol_events.id)
														WHERE (asol_proces_asol_events_c.asol_proce6f14process_ida = '{$value_process['id']}') AND (asol_events.deleted = 0) AND (asol_proces_asol_events_c.deleted = 0)
														ORDER BY
															CASE asol_events.type
																WHEN 'initialize' THEN 1
															    WHEN 'start' THEN 2
															    WHEN 'intermediate' THEN 3
															    WHEN 'cancel' THEN 4
															    ELSE 5
															END,
															asol_events.name ASC
													");
			while ($event_from_process__row = $db->fetchByAssoc($event_from_process__query)) {
				$export_array['events'][$value_process['id']][] = $event_from_process__row;
			}
		}
	}

	//// wfm_utils::wfm_log('debug', "2 FINAL \$export_array=[".print_r($export_array,true)."]", __FILE__, __METHOD__, __LINE__);
}

// SEARCH FOR ACTIVITIES
function searchActivities(& $export_array) {

	global $db;

	if (!empty($export_array['events'])) {
		foreach ($export_array['events'] as $key_parent_process => $value_parent_process) {
			foreach ($value_parent_process as $key_event => $value_event) {

				$activity_from_event__query = $db->query("
															SELECT asol_activity.*
															FROM asol_eventssol_activity_c
															INNER JOIN asol_activity ON (asol_eventssol_activity_c.asol_event8042ctivity_idb = asol_activity.id)
															WHERE (asol_eventssol_activity_c.asol_event87f4_events_ida = '{$value_event['id']}') AND (asol_activity.deleted = 0) AND (asol_eventssol_activity_c.deleted = 0)
															ORDER BY asol_activity.name ASC
														");
				while ($activity_from_event__row = $db->fetchByAssoc($activity_from_event__query)) {
					$activity_from_event__row['relationship'] = 'asol_eventssol_activity_c';
					$export_array['activities'][$value_event['id']][] = $activity_from_event__row;
				}

				if (is_array($export_array['activities'])) { // Avoid php-warning array_key_exists
					if (!array_key_exists($value_event['id'], $export_array['activities'])) {
						$export_array['activities'][$value_event['id']][] = "empty_token";
					}
				} else {
					$export_array['activities'][$value_event['id']][] = "empty_token";
				}
			}
		}
	}

	//// wfm_utils::wfm_log('debug', "3 FINAL \$export_array=[".print_r($export_array,true)."]", __FILE__, __METHOD__, __LINE__);
}


// SEARCH FOR NEXT_ACTIVITIES FROM ACTIVITIES(FROM EVENTS)
function searchNextActivities(& $export_array) {

	global $db;

	//---------------WHEN SEARCHING FOR NEXT_ACTIVITIES -> CALCULATE Y-COORDENATE FOR THE ACTIVITIES AND FOR EVENTS

	// search for next_activities
	if (!empty($export_array['activities'])) {
		$activity_ids_event_duplicity = Array();

		foreach ($export_array['activities'] as $key_parent_event => $value_parent_event) {

			flowChart::$draw_information_event[$key_parent_event] = flowChart::$top_Process;

			if ($export_array['activities'][$key_parent_event][0] == "empty_token") {
				flowChart::$top_Process = flowChart::$top_Process + flowChart::$height_Event + flowChart::$separation_vertical_Event;
				continue;
			}

			$aux_only_event_duplicity_for_this_event = true;

			foreach ($value_parent_event as $key_activity => $value_activity) {

				//// wfm_utils::wfm_log('debug', "\$activity_ids=[".print_r($activity_ids,true)."]", __FILE__, __METHOD__, __LINE__);
				if (!in_array($value_activity['id'], $activity_ids_event_duplicity)) {	// Event duplicity.

					// Calculate Y-coordenate for activity(from events)
					flowChart::$draw_information_activity[$value_activity['id']]['y'] = flowChart::$top_Process;

					$next_activity_ids_all_tree = wfm_utils::getNextActivities($value_activity['id']);
					//// wfm_utils::wfm_log('debug', "\$next_activity_ids_all_tree".print_r($next_activity_ids_all_tree,true), __FILE__, __METHOD__, __LINE__);

					foreach($next_activity_ids_all_tree as $key => $value) {

						//// wfm_utils::wfm_log('debug', "\$value".print_r($value,true), __FILE__, __METHOD__, __LINE__);

						$next_activity_query = $db->query ("
																SELECT *
																FROM asol_activity
																WHERE id = '{$value}'
															");
						$next_activity_row = $db->fetchByAssoc($next_activity_query);

						$parent_activity_query = $db->query("
																SELECT asol_activ898activity_ida   AS parent_activity_id
																FROM asol_activisol_activity_c
																WHERE asol_activ9e2dctivity_idb  = '{$next_activity_row['id']}' AND deleted = 0
															");
						$parent_activity_row = $db->fetchByAssoc($parent_activity_query);

						$export_array['next_activities'][$parent_activity_row['parent_activity_id']][] = $next_activity_row;

						// Calculate Y-coordenate for next_activity(from activity and from next_activity)
						$number_of_child = 0;
						$next_activity_for_number_query =  $db->query ("
																			SELECT asol_activ9e2dctivity_idb AS next_activity_id
																			FROM asol_activisol_activity_c
																			WHERE asol_activ898activity_ida = '{$parent_activity_row['parent_activity_id']}' AND deleted = 0
																		");
						while ($next_activity_for_number_row = $db->fetchByAssoc($next_activity_for_number_query)) {
							$number_of_child++;
							if ($next_activity_for_number_row['next_activity_id'] == $next_activity_row['id']) {
								break;
							}
						}

						if ($number_of_child > 1) { // if == 1 then $top_Process = $top_Process -> i.e. the first next_activity has the same $top as its parent
							flowChart::$top_Process = flowChart::$top_Process +flowChart:: $height_Activity + flowChart::$separation_vertical_Activity;
						}

						flowChart::$draw_information_activity[$next_activity_row['id']]['y'] = flowChart::$top_Process;
					}

					// separation between the last next_activity of the current activity and the following activity
					flowChart::$top_Process = flowChart::$top_Process + flowChart::$height_Activity + flowChart::$separation_vertical_Activity;

					// event duplicity
					$activity_ids_event_duplicity[] = $value_activity['id'];
					$aux_only_event_duplicity_for_this_event = false;

				} else {
					// wfm_utils::wfm_log('debug', "Event duplicity", __FILE__, __METHOD__, __LINE__);
				}
			}

			if ($aux_only_event_duplicity_for_this_event) { // Can be more than one activity pointed for several events for one event -> flowChart must only draw space for one activity
				flowChart::$top_Process = flowChart::$top_Process + flowChart::$height_Event + flowChart::$separation_vertical_Event;
			}
		}
	}

	//// wfm_utils::wfm_log('debug', "4 FINAL \$export_array=[".print_r($export_array,true)."]", __FILE__, __METHOD__, __LINE__);

}


// SEARCH FOR TASKS FROM ACTIVITIES( from [event, activity, next_activity] )
function searchTasks(& $export_array) {

	global $db;

	$event_duplicity = Array();

	$activity_type = Array('activities', 'next_activities');
	foreach ($activity_type as $key_activity_type => $value_activity_type) {

		if (!empty($export_array[$value_activity_type])) {
			foreach ($export_array[$value_activity_type] as $key_parent => $value_parent) {// parent -> [event, activity, next_activity]

				if ($export_array[$value_activity_type][$key_parent][0] == "empty_token") {
					continue;
				}

				foreach($value_parent as $key_activity => $value_activity) {

					if (in_array($value_activity['id'], $event_duplicity)) {
						continue;
					}
					$event_duplicity[] = $value_activity['id'];

					// asol_Task-structure
					// id 	name 	date_entered 	date_modified 	modified_user_id 	created_by 	description 	deleted 	assigned_user_id 	delay_type 	delay date task_type 	task_order 	task_implementation
					$tasks_from_activity__array = Array();
					$tasks_from_activity__query = $db->query("
																SELECT asol_task.*
																FROM asol_activity_asol_task_c
																INNER JOIN asol_task ON (asol_activity_asol_task_c.asol_activf613ol_task_idb = asol_task.id AND asol_activity_asol_task_c.deleted = 0)
																WHERE asol_activity_asol_task_c.asol_activ5b86ctivity_ida = '{$value_activity['id']}' AND asol_activity_asol_task_c.deleted = 0
																ORDER BY asol_task.task_order ASC, asol_task.name ASC
															");
					while ($tasks_from_activity__row = $db->fetchByAssoc($tasks_from_activity__query)) {
						$tasks_from_activity__array[] = $tasks_from_activity__row;
					}

					$export_array['tasks'][$value_activity['id']] = $tasks_from_activity__array;
				}
			}
		}
	}

	//// wfm_utils::wfm_log('debug', "5 FINAL \$export_array=[".print_r($export_array,true)."]", __FILE__, __METHOD__, __LINE__);

}

// DRAW ALL ACTIVITIES(AND NEXT_ACTIVITIES) AND THEIR TASKS
function drawActivitiesAndTasks($export_array, $type) {

	$event_duplicity = Array();
	$aux_counter = 0;

	flowChart::$draw_Activities = "";
	flowChart::$connections = "";

	$activity_type = Array('activities', 'next_activities');
	foreach ($activity_type as $key_activity_type => $value_activity_type) {

		switch ($type) {
			case 'workflow':
				//flowChart::$top_Process = 120;
				//$separation_horizontal_Event = 100;// for activity loop
				//$separation_horizontal_Activity = 100;// for next_activity loop
				flowChart::$left_Process = flowChart::$left_Process + flowChart::$width_Event +flowChart:: $separation_horizontal_Event;
				//$height_Activity = 1+7+90+7+1;
				//$number_of_pixels_to_susbstrate_from_width_Activity = 13;
				//$width_Activity_depending_on_number_of_tasks_Default = 94;// default
				//$width_Activity_depending_on_number_of_tasks_Maximum = $width_Activity_depending_on_number_of_tasks_Default; // to get the nex_activity location
				//$separation_vertical_Activity = 50;
				break;
			case 'recycleBinEvents':
				flowChart::$top_Process = 50;
				//$separation_horizontal_Event = 100;// for activity loop
				//$separation_horizontal_Activity = 100;// for next_activity loop
				flowChart::$left_Process = flowChart::$left_Process + flowChart::$width_Event +flowChart:: $separation_horizontal_Event;
				//$height_Activity = 1+7+90+7+1;
				//$number_of_pixels_to_susbstrate_from_width_Activity = 13;
				//$width_Activity_depending_on_number_of_tasks_Default = 94;// default
				//$width_Activity_depending_on_number_of_tasks_Maximum = $width_Activity_depending_on_number_of_tasks_Default; // to get the nex_activity location
				//$separation_vertical_Activity = 50;
				break;
			case 'recycleBinActivities':
				//flowChart::$top_Process = 50;
				//$separation_horizontal_Event = 100;// for activity loop
				//$separation_horizontal_Activity = 100;// for next_activity loop
				//flowChart::$left_Process = flowChart::$left_Process + flowChart::$width_Event +flowChart:: $separation_horizontal_Event;
				//$height_Activity = 1+7+90+7+1;
				//$number_of_pixels_to_susbstrate_from_width_Activity = 13;
				//$width_Activity_depending_on_number_of_tasks_Default = 94;// default
				//$width_Activity_depending_on_number_of_tasks_Maximum = $width_Activity_depending_on_number_of_tasks_Default; // to get the nex_activity location
				//$separation_vertical_Activity = 50;
				break;
			case 'recycleBinTasks':
				//flowChart::$top_Process = 90;
				//$separation_horizontal_Event = 100;// for activity loop
				//$separation_horizontal_Activity = 100;// for next_activity loop
				//flowChart::$left_Process = flowChart::$left_Process + flowChart::$width_Event +flowChart:: $separation_horizontal_Event;
				//$height_Activity = 1+7+90+7+1;
				//$number_of_pixels_to_susbstrate_from_width_Activity = 13;
				//$width_Activity_depending_on_number_of_tasks_Default = 94;// default
				//$width_Activity_depending_on_number_of_tasks_Maximum = $width_Activity_depending_on_number_of_tasks_Default; // to get the nex_activity location
				//$separation_vertical_Activity = 50;
				break;
		}



		$number_of_connection = 0;

		if (array_key_exists($value_activity_type, $export_array)) {
			foreach ($export_array[$value_activity_type] as $key_parent => $value_parent) {// parent -> [event, activity, next_activity]

				if ($export_array[$value_activity_type][$key_parent][0] == "empty_token") {
					continue;
				}

				foreach ($value_parent as $key_activity => $value_activity) {

					if ($key_parent != 'auxId') {
						if (in_array($value_activity['id'], $event_duplicity)) {
							// wfm_utils::wfm_log('debug', "Event duplicity", __FILE__, __METHOD__, __LINE__);
							flowChart::$connections .= drawConnection($type, $key_parent, $value_activity['id'], $number_of_connection);
							continue;
						} else  {
							flowChart::$connections .= drawConnection($type, $key_parent, $value_activity['id'], $number_of_connection);
						}

						$event_duplicity[] = $value_activity['id'];
						//// wfm_utils::wfm_log('debug', "\$event_duplicity=[".print_r($event_duplicity,true)."]", __FILE__, __METHOD__, __LINE__);
						//// wfm_utils::wfm_log('debug', "\$aux_counter=[".print_r($aux_counter++,true)."]", __FILE__, __METHOD__, __LINE__);
					}

					$bottom_Tasks_of_this_activity = 4;
					$left_Tasks_of_this_activity = 5;
					$xCoordinateTasks = $left_Tasks_of_this_activity;
					$right_Tasks_of_this_activity = 5;
					$height_Tasks_of_this_activity = 0+1+0+51+2+1+0;
					$width_Tasks_of_this_activity = 1+1+5+32+5+1+1; // 46
					$separation_Tasks_of_this_activity = 0;

					$width_Activity_depending_on_number_of_tasks = 0;

					$draw_Tasks_of_this_activity = "";
					$counter_Tasks_of_this_activity = 0;

					// Draw tasks for this activity
					if (array_key_exists('tasks', $export_array)) {
						foreach ($export_array['tasks'] as $key_parent_activity => $value_parent_activity) {
							if ($key_parent_activity == $value_activity['id']) {

								foreach ($value_parent_activity as $key_task => $value_task) {
									$draw_Tasks_of_this_activity .= generate_Task_HTML('workflow', $value_task['id'], $value_task['name'], $value_task['description'], $value_task['task_type'], null, $bottom_Tasks_of_this_activity, $xCoordinateTasks, $value_task['async'], $value_task['delay_type'], $value_task['delay'], $value_task['date'], $value_task['task_order'], $value_task['task_implementation']);
									$counter_Tasks_of_this_activity++;

									switch ($counter_Tasks_of_this_activity) {
										case (count($value_parent_activity)):
											$width_Activity_depending_on_number_of_tasks += $width_Tasks_of_this_activity + $right_Tasks_of_this_activity;
											break;
										case 1:
											$width_Activity_depending_on_number_of_tasks += $left_Tasks_of_this_activity + $width_Tasks_of_this_activity/* + $separation_Tasks_of_this_activity*/;
											break;
										default:
											$width_Activity_depending_on_number_of_tasks += $width_Tasks_of_this_activity/* + $separation_Tasks_of_this_activity*/;
											break;
									}

									$xCoordinateTasks = $width_Activity_depending_on_number_of_tasks;
								}
									
								if ($width_Activity_depending_on_number_of_tasks < flowChart::$width_Activity_depending_on_number_of_tasks_Default) {
									$width_Activity_depending_on_number_of_tasks = flowChart::$width_Activity_depending_on_number_of_tasks_Default + 10;
								}
									
								$width_Activity_depending_on_number_of_tasks = $width_Activity_depending_on_number_of_tasks - 10;
							}
						}
					}

					// Calculate X-coordinate and Width-property for this activity(or next_activity)
					if ($value_activity_type == 'activities') {
						flowChart::$draw_information_activity[$value_activity['id']]['x'] = flowChart::$left_Process;
					} else  {
						flowChart::$draw_information_activity[$value_activity['id']]['x'] = flowChart::$draw_information_activity[$key_parent]['x'] + flowChart::$draw_information_activity[$key_parent]['w'] + flowChart::$separation_horizontal_Activity;
					}
					flowChart::$draw_information_activity[$value_activity['id']]['w'] = $width_Activity_depending_on_number_of_tasks;

					// Draw activity(or next_activity) and connections. Information about delays and conditions inside the activity.
					flowChart::$draw_Activities .= generate_Activity_HTML($value_activity['id'], $value_activity['name'], $value_activity['description'], flowChart::$draw_information_activity[$value_activity['id']]['y'], flowChart::$draw_information_activity[$value_activity['id']]['x'], $width_Activity_depending_on_number_of_tasks, $draw_Tasks_of_this_activity, $counter_Tasks_of_this_activity, $value_activity['conditions'], $value_activity['delay'], $export_array['processes'][0]['trigger_module'], $value_activity['relationship'], flowChart::$data_source, flowChart::$form_id, flowChart::$form_language);


					$number_of_connection++;
					//$top_Process = $top_Process + $height_Activity + $separation_vertical_Activity;
				}
			}
		}
	}

	//// wfm_utils::wfm_log('debug', "7 TEST DRAW \$export_array=[".print_r($export_array,true)."]", __FILE__, __METHOD__, __LINE__);
	//// wfm_utils::wfm_log('debug', "7 TEST DRAW \$draw_information_event=[".print_r($draw_information_event,true)."]", __FILE__, __METHOD__, __LINE__);
	//// wfm_utils::wfm_log('debug', "7 TEST DRAW \$draw_information_activity=[".print_r($draw_information_activity,true)."]", __FILE__, __METHOD__, __LINE__);

}



//////////////////////////////////
//*************DRAW*************//
//////////////////////////////////

// JSPLUMB-CALL-FUNCTIONS
function drawConnection ($jsPlumbInstance, $source, $target, $number_of_connection) {

	switch ($jsPlumbInstance) {
		case 'workflow':
			$jsPlumbInstance = 'uiLayoutCenter';
			$anchor = "[ [1, 0.5, 0, 1, 0, -1] , [0, 0.5, 0, 1, 0, -1] ]";
			break;
		default:
			$anchor = "[ [1, 0.5, 0, 1, -1, -1] , [0, 0.5, 0, 1, -1, -1] ]";
			break;
	}

	return "{$jsPlumbInstance}.connect({
								source:'{$source}', target: '{$target}', anchor: {$anchor}
							});
	";
}

function drawCondition($id) {
	return '
			var targetEndpoint = { 
									endpoint:["Image", { src:"modules/asol_Process/_flowChart/images/condition_icon_16.png" } ],
									anchor:"LeftMiddle", 
								 };
			jsPlumb.addEndpoint( "'.$id.'", targetEndpoint );
	';
}

function drawDelay($id) {
	return '
			var targetEndpoint = { 
									endpoint:["Image", { src:"modules/asol_Process/_flowChart/images/delay_icon_24.png" } ],
									anchor:"TopCenter", 
								 };
			var delay = jsPlumb.addEndpoint( "'.$id.'", targetEndpoint );
			
			delay.bind("mouseenter", function(delay) {
				console.log("[delay.bind(mouseenter)] you clicked on ", delay);
				console.log("[delay.bind(mouseenter)] you clicked on id ", delay.id);
				console.log("[delay.bind(mouseenter)] you clicked on id ", delay.elementId);
			});
			
	';
}

//-------------------DRAW NODE FUNCTIONS-----------------------//

//window.opener.location=\'index.php?module=asol_Process&action=DetailView&record='.$id.'\';
function generate_Process_HTML($id, $name, $alternative_database, $trigger_module, $status, $description, $async, $audit, $data_source, $form_id) {

	$top = 10;
	$left = 10;
	$qtip_info = generate_process_info_HTML($alternative_database, $trigger_module, $status, $description, $async, $audit, $data_source, $form_id);

	return "
		<div module='asol_Process' id='{$id}' class='jstree-drop'>
			<table>
				<tr>
					<td>
						<img style='margin-bottom: -4px; height: 24px; padding-bottom: 2px; padding-top: 0px;' src='modules/asol_Process/_flowChart/images/process_{$status}_32.png'>
					</td>
					<td style='padding-bottom: 0px;'>
						<span class='process_name' style='padding-top: 0px; padding-bottom: 0px;'>
							<a class='redirectLink' link_module='asol_Process' link_record='{$id}' qtip_info='{$qtip_info}'>{$name}</a>
						</span>
					</td>
				</tr>
			</table>
		</div>		
	";
}

function generate_Event_HTML($id, $name, $description, $top, $left, $event_conditions, $type, $trigger_type, $alternative_database, $trigger_event, $scheduled_type, $subprocess_type, $module, $data_source, $form_id, $form_language) {

	global $app_list_strings;

	$draw_Condition = "";
	if (!($event_conditions == "")) {
		$conditions_to_print = generate_conditions_HTML($event_conditions, $module);
		//// wfm_utils::wfm_log('debug', "\$conditions_to_print=[".print_r($conditions_to_print,true)."]", __FILE__, __METHOD__, __LINE__);

		$draw_Condition .= '
							<span class="condition_icon_for_events">
								<img node_name="'.$name.'" qtip_info="'.$conditions_to_print.'" src="modules/asol_Process/_flowChart/images/condition_icon_24.png">
							</span>
						';
	}

	$qtip_info = generate_event_info_HTML($name, $description, $type, $trigger_type, $alternative_database, $trigger_event, $scheduled_type, $subprocess_type);

	$triggerTypeDiv = (!empty($app_list_strings['wfm_trigger_type_list'][$trigger_type])) ? wfm_utils::generateHtmlEventOptionsDiv($app_list_strings['wfm_trigger_type_list'][$trigger_type]) : '';
	$triggerEventDiv = (!empty($app_list_strings['wfm_trigger_event_list'][$trigger_event])) ? wfm_utils::generateHtmlEventOptionsDiv($app_list_strings['wfm_trigger_event_list'][$trigger_event]) : '';
	$scheduledTypeDiv = (!empty($app_list_strings['wfm_scheduled_type_list'][$scheduled_type])) ? wfm_utils::generateHtmlEventOptionsDiv($app_list_strings['wfm_scheduled_type_list'][$scheduled_type]) : '';
	$subprocessTypeDiv = (!empty($app_list_strings['wfm_subprocess_type_list'][$subprocess_type])) ? wfm_utils::generateHtmlEventOptionsDiv($app_list_strings['wfm_subprocess_type_list'][$subprocess_type]) : '';
	$typeDiv = (!empty($app_list_strings['wfm_events_type_list'][$type])) ? wfm_utils::generateHtmlEventOptionsDiv($app_list_strings['wfm_events_type_list'][$type]) : '';

	$icons = wfm_utils::generateHtmlEventOptionsImgs($trigger_type, $trigger_event, $scheduled_type, $subprocess_type);

	$wfm_module = 'asol_Events';

	return "
		<div module='{$wfm_module}' id='{$id}' trigger_type='{$trigger_type}' trigger_event='{$trigger_event}' scheduled_type='{$scheduled_type}' subprocess_type='{$subprocess_type}' type='{$type}' class='asol_Event jstree-drop' style='top: {$top}px; left: {$left}px;'>
			<div class='eventButtons'>
		    </div>
		
			<div class='event_name aux_name_overflow overflow_ellipsis_enabled'>
				<a class='redirectLink' link_module='{$wfm_module}' link_record='{$id}' qtip_info='{$qtip_info}'>{$name}</a>
			</div>
			
			{$icons}
			
			{$draw_Condition}
		</div>
	";
}

function generate_Activity_HTML($id, $name, $description, $top, $left, $width, $draw_Tasks_of_this_activity, $counter_Tasks_of_this_activity, $activity_conditions, $delay, $module, $relationship, $data_source, $form_id, $form_language) {

	$draw_Delay = "";
	if (!( ($delay == 'minutes - 0') || ($delay == 'hours - 0') || ($delay == 'days - 0') || ($delay == 'weeks - 0') || ($delay == 'months - 0') )) {
		$draw_Delay .= '
						<span class="delay_icon">
							<img alt="'.generate_delay($delay).'" src="modules/asol_Process/_flowChart/images/delay_icon_24.png">
						</span>
					';
	}

	$draw_Condition = "";
	if (!($activity_conditions == "")) {
		$conditions_to_print = generate_conditions_HTML($activity_conditions, $module);
		$draw_Condition .= '
							<span class="condition_icon">
								<img node_name="'.$name.'" qtip_info="'.$conditions_to_print.'" src="modules/asol_Process/_flowChart/images/condition_icon_24.png">
							</span>
						';
	}

	$qtip_info = generate_name_and_description_HTML($name, $description);
	$nameWidth = $width + 4;

	$wfm_module = 'asol_Activity';

	return "
		<div module='{$wfm_module}' id='{$id}' relationship='{$relationship}' class='{$wfm_module} jstree-drop' style='top:{$top}px; left:{$left}px; width:auto; min-width:{$width}px'>
			<div class='activityButtons'>
		    </div>
			<div>
			{$draw_Delay}
			{$draw_Condition}
				<span class='activity_name aux_name_overflow overflow_ellipsis_enabled' style=''>
					<a class='redirectLink' link_module='asol_Activity' link_record='{$id}' onclick='' qtip_info='{$qtip_info}'>{$name}</a>
				</span>
			</div>
			<div class='activity_container_of_tasks'>
			{$draw_Tasks_of_this_activity}
			</div>
		</div>
	";

}

function generate_Task_HTML($generateTaskHtmlType, $id, $name, $description, $task_type, $top, $bottom, $left, $async, $delay_type, $delay, $date, $order, $task_implementation) {

	global $app_list_strings;
	
	$delayTypeHtml = '';
	if ($delay_type == 'on_finish_previous_task') {
		$delayTypeHtml = "
			<img class='delayType' src='modules/asol_Process/_flowChart/images/on_finish_previous_task.png' title='{$app_list_strings['wfm_task_delay_type_list']['on_finish_previous_task']}' />
		";
	}
	
	$draw_Delay = "";
	switch ($delay_type) {
		case 'no_delay':
			break;
			
		case 'on_creation':
		case 'on_modification':
		case 'on_finish_previous_task':
			
			$draw_Delay .= '
							<span class="delay_icon_for_task">
								<img alt="'.generate_delay($delay).'" src="modules/asol_Process/_flowChart/images/delay_icon_16.png">
							</span>
						';
			
			break;
			
		case 'on_date':
			
			$datetimeParsed = wfm_utils::parseDatetime($date);
			
			$rowIndex = 'forFieldDate';
			$baseDatetime_forFieldDate = $datetimeParsed['baseDatetime_forFieldDate'];
			$offsetSign_forFieldDate = $datetimeParsed['offsetSign_forFieldDate'];
			$date_start_years_forFieldDate = $datetimeParsed['date_start_years_forFieldDate'];
			$date_start_months_forFieldDate = $datetimeParsed['date_start_months_forFieldDate'];
			$date_start_days_forFieldDate = $datetimeParsed['date_start_days_forFieldDate'];
			$date_start_hours_forFieldDate = $datetimeParsed['date_start_hours_forFieldDate'];
			$date_start_minutes_forFieldDate = $datetimeParsed['date_start_minutes_forFieldDate'];
			
			$fieldDate .= wfm_utils::generate_DateTime_Field_HTML_and_Remember_DataBase_if_needed($rowIndex, $baseDatetime_forFieldDate, $offsetSign_forFieldDate, $date_start_years_forFieldDate, $date_start_months_forFieldDate, $date_start_days_forFieldDate, $date_start_hours_forFieldDate, $date_start_minutes_forFieldDate);
			
			$draw_Delay .= '
							<span class="delay_icon_for_task">
								<img alt="'.$fieldDate.'" src="modules/asol_Process/_flowChart/images/delay_icon_16.png">
							</span>
						';
			
			break;
			
	}
	if ($delay_type != 'no_delay') {
		
	}

	$draw_Call_process_open_subprocess = "";
	if ($task_type == 'call_process') {
			
		$task_implementation = str_replace("&quot;", '"', $task_implementation);

		$task_implementation_array = json_decode($task_implementation, true);
		
		$process_id = $task_implementation_array['process_id'];
		$process_name = $task_implementation_array['process_name'];
		$event_id = $task_implementation_array['event_id'];
		$event_name = $task_implementation_array['event_name'];
		$object_module = $task_implementation_array['object_module'];
		$object_ids = $task_implementation_array['object_ids'];
		$execute_subprocess_immediately = $task_implementation_array['execute_subprocess_immediately'];
			
		$process_name = urldecode($process_name);
		$event_name = urldecode($event_name);
		
		$subprocess_info .= '<tr>';
		$subprocess_info .= "<td><b>&nbsp; ".'SubProcess'." &nbsp;</b></td>";
		$subprocess_info .= "<td>&nbsp; ".$process_name." &nbsp;</td>";
		$subprocess_info .= '</tr>';
		
		$subprocess_info .= '<tr>';
		$subprocess_info .= "<td><b>&nbsp; ".'SubEvent'." &nbsp;</b></td>";
		$subprocess_info .= "<td>&nbsp; ".$event_name." &nbsp;</td>";
		$subprocess_info .= '</tr>';
			
		if (!empty($event_id)) {
			$draw_Call_process_open_subprocess .= "
				<span class='task_call_process_open_subprocess_icon'>
					<a class='redirectLink' link_module='asol_Events' link_record='{$event_id}' onclick='' qtip_info='{$subprocess_info}'>
						<img src='modules/asol_Process/_flowChart/images/task_call_process_open_subprocess_16.png'>
					</a>
				</span>
			";
		} else {
			$draw_Call_process_open_subprocess .= "
				<span class='task_call_process_open_subprocess_icon'>
					<a class='not_open' onclick='' qtip_info='{$subprocess_info}'>
						<img src='modules/asol_Process/_flowChart/images/task_call_process_open_subprocess_16.png'>
					</a>
				</span>
			";
		}
	}

	$qtip_info = generate_info_for_Task_HTML($name, $description, $delay_type, $order, $async);

	$wfm_module = 'asol_Task';

	switch ($generateTaskHtmlType) {
		case 'workflow':
			$style = "";
			//$style = "bottom: {$bottom}px; left: {$left}px;";
			break;
		case 'recycleBinTasks':
			$style = "float: left; margin: 4px; position: relative";
			break;
	}

	return "
		<div module='{$wfm_module}' id='{$id}' class='{$wfm_module}' style='{$style}' task_order='{$order}'>
			<div class='taskButtons'>
		    </div>
			<div class='task_name overflow_ellipsis_enabled'>
				<a class='redirectLink' link_module='{$wfm_module}' link_record='{$id}' qtip_info='{$qtip_info}'>{$name}</a>
			</div>
			<img  src='modules/asol_Process/_flowChart/images/task_{$task_type}_32.png' title='{$app_list_strings['wfm_task_type_list'][$task_type]}' alt='{$app_list_strings['wfm_task_type_list'][$task_type]}'>
			{$draw_Delay}
			{$delayTypeHtml}
			{$draw_Call_process_open_subprocess}
		</div>
	";
}

//-------------------AUX FUNCTIONS FOR DRAW NODE FUNCTIONS-----------------------//

function generate_delay($delay) {

	$delay_array = explode(' - ', $delay);

	switch ($delay_array[0]) {
		case 'minutes':
			$delay_label = translate('LBL_ASOL_MINUTES', 'asol_Activity');
			break;
		case 'hours':
			$delay_label = translate('LBL_ASOL_HOURS', 'asol_Activity');
			break;
		case 'days':
			$delay_label = translate('LBL_ASOL_DAYS', 'asol_Activity');
			break;
		case 'weeks':
			$delay_label = translate('LBL_ASOL_WEEKS', 'asol_Activity');
			break;
		case 'months':
			$delay_label = translate('LBL_ASOL_MONTHS', 'asol_Activity');
			break;
	}

	$delay_label = $delay_array[1]." ".$delay_label;

	return $delay_label;
}

function generate_name_and_description_HTML($name, $description) {

	// generate HTML
	$info = "";
	$info .= '<tr>';
	$info .= "<td><b>&nbsp; ".translate('LBL_NAME', 'asol_Process')." &nbsp;</b></td>";
	$info .= "<td>&nbsp; ".$name." &nbsp;</td>";
	$info .= '</tr>';
	$info .= '<tr>';
	$info .= "<td><b>&nbsp; ".translate('LBL_DESCRIPTION', 'asol_Process')." &nbsp;</b></td>";
	$info .= "<td>&nbsp; ".$description." &nbsp;</td>";
	$info .= '</tr>';

	return $info;
}

function generate_info_for_Task_HTML($name, $description, $delay_type, $order, $async) {

	global $app_list_strings;

	// generate HTML
	$info = "";
	$info .= '<tr>';
	$info .= "<td><b>&nbsp; ".translate('LBL_NAME', 'asol_Task')." &nbsp;</b></td>";
	$info .= "<td>&nbsp; ".$name." &nbsp;</td>";
	$info .= '</tr>';
	$info .= '<tr>';
	$info .= "<td><b>&nbsp; ".translate('LBL_ASYNC', 'asol_Task')." &nbsp;</b></td>";
	$info .= "<td>&nbsp; ".$app_list_strings['wfm_task_async_list'][$async]." &nbsp;</td>";
	$info .= '</tr>';
	$info .= '<tr>';
	$info .= "<td><b>&nbsp; ".translate('LBL_DELAY_TYPE', 'asol_Task')." &nbsp;</b></td>";
	$info .= "<td>&nbsp; ".$app_list_strings['wfm_task_delay_type_list'][$delay_type]." &nbsp;</td>";
	$info .= '</tr>';
	$info .= '<tr>';
	$info .= "<td><b>&nbsp; ".translate('LBL_TASK_ORDER', 'asol_Task')." &nbsp;</b></td>";
	$info .= "<td>&nbsp; ".$order." &nbsp;</td>";
	$info .= '</tr>';
	$info .= '<tr>';
	$info .= "<td><b>&nbsp; ".translate('LBL_DESCRIPTION', 'asol_Task')." &nbsp;</b></td>";
	$info .= "<td>&nbsp; ".$description." &nbsp;</td>";
	$info .= '</tr>';

	return $info;
}


function generate_process_info_HTML($alternative_database, $trigger_module, $status, $description, $async, $audit, $data_source, $form_id) {
	// wfm_utils::wfm_log('debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);

	global $app_list_strings;
	
	switch ($data_source) {
		case 'form':
			$form_bean = wfm_utils::getBean('asol_Forms', $form_id);
			$form_name = $form_bean->name;
			$trigger_module = '';
			break;
		case 'database':
			$trigger_module = ($alternative_database == '-1') ? $app_list_strings['moduleList'][$trigger_module] : $trigger_module;
			break;
	}

	// generate HTML
	$process_info = "";
	$process_info .= '<tr>';
	$process_info .= "<td><b>&nbsp; ".translate('LBL_DATA_SOURCE', 'asol_Process')." &nbsp;</b></td>";
	$process_info .= "<td>&nbsp; ".$app_list_strings['wfm_process_data_source_list'][$data_source]." &nbsp;</td>";
	$process_info .= '</tr>';
	$process_info .= '<tr>';
	$process_info .= "<td><b>&nbsp; ".translate('LBL_FORM', 'asol_Process')." &nbsp;</b></td>";
	$process_info .= "<td>&nbsp; ".$form_name." &nbsp;</td>";
	$process_info .= '</tr>';
	$process_info .= '<tr>';
	$process_info .= "<td><b>&nbsp; ".translate('LBL_ASOL_TRIGGER_MODULE', 'asol_Process')." &nbsp;</b></td>";
	$process_info .= "<td>&nbsp; ".$trigger_module." &nbsp;</td>";
	$process_info .= '</tr>';
	$process_info .= '<tr>';
	$process_info .= "<td><b>&nbsp; ".translate('LBL_STATUS', 'asol_Process')." &nbsp;</b></td>";
	$process_info .= "<td>&nbsp; ".$app_list_strings['wfm_process_status_list'][$status]." &nbsp;</td>";
	$process_info .= '</tr>';
	$process_info .= '<tr>';
	$process_info .= "<td><b>&nbsp; ".translate('LBL_ASYNC', 'asol_Process')." &nbsp;</b></td>";
	$process_info .= '<td>&nbsp; '.$app_list_strings['wfm_process_async_list'][$async].' &nbsp;</td>';
	$process_info .= '</tr>';
	if (wfm_reports_utils::hasPremiumFeatures()) {
		$process_info .= '<tr>';
		$process_info .= "<td><b>&nbsp; ".translate('LBL_AUDIT', 'asol_Process')." &nbsp;</b></td>";
		$process_info .= '<td>&nbsp; '.(($audit) ? translate('LBL_YES', 'asol_Process'): translate('LBL_NO', 'asol_Process')).' &nbsp;</td>';
		$process_info .= '</tr>';
	}
	$process_info .= '<tr>';
	$process_info .= "<td><b>&nbsp; ".translate('LBL_DESCRIPTION', 'asol_Process')." &nbsp;</b></td>";
	$process_info .= "<td>&nbsp; ".$description." &nbsp;</td>";
	$process_info .= '</tr>';

	return $process_info;
}

function generate_event_info_HTML($name, $description, $type, $trigger_type, $alternative_database, $trigger_event, $scheduled_type, $subprocess_type) {
	// wfm_utils::wfm_log('debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);

	global $app_list_strings;

	if ($alternative_database == '-1') {
		$trigger_event = (!empty($app_list_strings['wfm_trigger_event_list'][$trigger_event])) ? $app_list_strings['wfm_trigger_event_list'][$trigger_event] : $app_list_strings['wfm_trigger_event_list_only_users'][$trigger_event];
	} else {
		$trigger_event = $trigger_event;
	}

	// generate HTML
	$event_info = "";
	$event_info .= '<tr>';
	$event_info .= "<td><b>&nbsp; ".translate('LBL_NAME', 'asol_Events')." &nbsp;</b></td>";
	$event_info .= "<td>&nbsp; ".$name." &nbsp;</td>";
	$event_info .= '</tr>';
	$event_info .= '<tr>';
	$event_info .= "<td><b>&nbsp; ".translate('LBL_TRIGGER_TYPE', 'asol_Events')." &nbsp;</b></td>";
	$event_info .= "<td>&nbsp; ".$app_list_strings['wfm_trigger_type_list'][$trigger_type]." &nbsp;</td>";
	$event_info .= '</tr>';
	$event_info .= '<tr>';
	$event_info .= "<td><b>&nbsp; ".translate('LBL_ASOL_TRIGGER_EVENT', 'asol_Events')." &nbsp;</b></td>";
	$event_info .= "<td>&nbsp; ".$trigger_event." &nbsp;</td>";
	$event_info .= '</tr>';
	$event_info .= '<tr>';
	$event_info .= "<td><b>&nbsp; ".translate('LBL_TYPE', 'asol_Events')." &nbsp;</b></td>";
	$event_info .= "<td>&nbsp; ".$app_list_strings['wfm_events_type_list'][$type]." &nbsp;</td>";
	$event_info .= '</tr>';
	$event_info .= '<tr>';
	$event_info .= "<td><b>&nbsp; ".translate('LBL_SCHEDULED_TYPE', 'asol_Events')." &nbsp;</b></td>";
	$event_info .= "<td>&nbsp; ".$app_list_strings['wfm_scheduled_type_list'][$scheduled_type]." &nbsp;</td>";
	$event_info .= '</tr>';
	$event_info .= '<tr>';
	$event_info .= "<td><b>&nbsp; ".translate('LBL_SUBPROCESS_TYPE', 'asol_Events')." &nbsp;</b></td>";
	$event_info .= "<td>&nbsp; ".$app_list_strings['wfm_subprocess_type_list'][$subprocess_type]." &nbsp;</td>";
	$event_info .= '</tr>';
	$event_info .= '<tr>';
	$event_info .= "<td><b>&nbsp; ".translate('LBL_DESCRIPTION', 'asol_Events')." &nbsp;</b></td>";
	$event_info .= "<td>&nbsp; ".$description." &nbsp;</td>";
	$event_info .= '</tr>';

	return $event_info;
}

function generate_conditions_TableBegin_HTML() {

	return '
		<table id=\'conditions_Table\' class=\'gradient-style\'>
			<thead>
				<tr>
			
					<th  scope=\'col\'>
						<div align=\'left\' width=\'100%\' style=\'white-space: nowrap;\'>
						'.translate('LBL_ASOL_LOGICAL_OPERATORS', 'asol_Events').'
						</div>
					</th>
				
					<th  scope=\'col\'>
						<div align=\'left\' width=\'100%\' style=\'white-space: nowrap;\'>
						'.translate('LBL_ASOL_DATABASE_FIELD', 'asol_Events').'
						</div>
					</th>
					
					<th  scope=\'col\'>
						<div align=\'left\' width=\'100%\' style=\'white-space: nowrap;\'>
						'.translate('LBL_ASOL_OLD_BEAN_NEW_BEAN_CHANGED', 'asol_Events').'
						</div>
					</th>
					
					<th  scope=\'col\'>
						<div align=\'left\' width=\'100%\' style=\'white-space: nowrap;\'>
						'.translate('LBL_IS_CHANGED', 'asol_Events').'
						</div>
					</th>
			
					<th  scope=\'col\'>
						<div align=\'left\' width=\'100%\' style=\'white-space: nowrap;\'>
						'.translate('LBL_ASOL_OPERATOR', 'asol_Events').'
						</div>
					</th>
			
					<th  scope=\'col\'>
						<div align=\'left\' width=\'100%\' style=\'white-space: nowrap;\'>
						'.translate('LBL_ASOL_FIRST_PARAMETER', 'asol_Events').'
						</div>
					</th>
			
					<th  scope=\'col\'>
						<div align=\'left\' width=\'100%\' style=\'white-space: nowrap;\'>
						'.translate('LBL_ASOL_SECOND_PARAMETER', 'asol_Events').'
						</div>
					</th>
			
				</tr>
			</thead>
			<tbody>
	';
}

function generate_conditions_TableEnd_HTML() {

	return '
			</tbody>
		</table>
	';
}

function generate_conditions_HTML($conditions_string, $module) {

	$conditions_to_print = "";
	$conditions_to_print .= generate_conditions_TableBegin_HTML();

	$conditions = explode("\${pipe}",$conditions_string);
	wfm_utils::wfm_log('asol_debug', "\$conditions=[".print_r($conditions,true)."]", __FILE__, __METHOD__, __LINE__);

	foreach ($conditions as $key => $value) {
			
		$values = explode("\${dp}",$conditions[$key]);
		// BEGIN - values array
		$fieldName = $values[0];
		$fieldName_array = explode("\${comma}", $fieldName);
		$OldBean_NewBean_Changed = $values[1];
		$OldBean_NewBean_Changed = stripcslashes($OldBean_NewBean_Changed);
		$isChanged = $values[2];
		$operator = $values[3];
		$Param1 = $values[4];
		$Param2 = $values[5]; 
		$Param2 = str_replace('\_', '_', $Param2);
		$fieldType = $values[6];
		$key = $values[7];
		$isRelated = $values[8];
		$fieldIndex = $values[9];// index of module_fields, not rowIndex
		//$options_string = $values[10];
		//$options = $values[10].split("|");
		//$options_db_string = $values[11];
		//$options_db = $values[11].split("|");
		$enum_operator = $values[10];
		$enum_reference = $values[11];
		$logical_parameters = $values[12];
		// END - values array
			
		$condition_HTML = "";
		$condition_HTML .= "<tr>";
		$condition_HTML .= "<td>&nbsp; ".generate_Logical_Parameters($logical_parameters)." &nbsp;</td>";
		$condition_HTML .= "<td><b>&nbsp; ".generate_Name_of_the_Field($key, $fieldName_array, $module)." &nbsp;</b></td>";
		$condition_HTML .= "<td>&nbsp; ".(($isRelated == 'false') ? generate_OldBean_NewBean_Changed($OldBean_NewBean_Changed) : "")." &nbsp;</td>";
		$condition_HTML .= "<td>&nbsp; ".(($OldBean_NewBean_Changed == 'changed') ? generate_IsChanged($isChanged) : "") ." &nbsp;</td>";
		$condition_HTML .= "<td>&nbsp; ".(($OldBean_NewBean_Changed != 'changed') ? generate_Operator($operator) : "") ." &nbsp;</td>";
		$condition_HTML .= "<td>&nbsp; ".(($OldBean_NewBean_Changed != 'changed') ? generate_Param1($Param1, $enum_reference, $fieldType, $operator, $fieldName_array[0]) : "") ." &nbsp;</td>";
		$condition_HTML .= "<td>&nbsp; ".(($OldBean_NewBean_Changed != 'changed') ? $Param2 : "") ." &nbsp;</td>";
		$condition_HTML .= "</tr>";

		$conditions_to_print .= $condition_HTML;
	}

	$conditions_to_print .= generate_conditions_TableEnd_HTML();

	return $conditions_to_print;
}

//-------------------LANGUAGE AUX FUNCTIONS FOR DRAW NODE FUNCTIONS-----------------------//

function generate_Logical_Parameters($logical_parameters) {

	//// wfm_utils::wfm_log('debug', "\$logical_parameters=[".print_r($logical_parameters,true)."]", __FILE__, __METHOD__, __LINE__);

	$lbl_and = translate("LBL_ASOL_AND", 'asol_Events');
	$lbl_or = translate("LBL_ASOL_OR", 'asol_Events');

	$selectedValues = explode(':', $logical_parameters);
	$parenthesis = $selectedValues[0];
	$logicalOperator = $selectedValues[1];

	switch ($logicalOperator) {
		case 'AND':
			$operator_label = $lbl_and;;
			break;
		case 'OR':
			$operator_label = $lbl_or;
			break;
	}

	$parenthesis_array = Array(
		'0' => '',
		'1' => '(',
		'2' => '((',
		'3' => '(((',
		'-1' => '..)',
		'-2' => '..))',
		'-3' => '..)))',
	);

	$label = $parenthesis_array[$parenthesis].'&nbsp;&nbsp;&nbsp;&nbsp;'.$operator_label;

	return $label;
}

function generate_Name_of_the_Field($key, $fieldName_array, $trigger_module) {

	global $app_list_strings, $sugar_config;
	
	$data_source = flowChart::$data_source;
	$form_id = flowChart::$form_id;
	$form_language = flowChart::$form_language;

	// Whether translate or not variable for all this php-file
	$translateFieldLabels = ((!isset($sugar_config['WFM_TranslateLabels'])) || ($sugar_config['WFM_TranslateLabels'])) ? true : false;

	//// wfm_utils::wfm_log('debug', "\$fieldName_array=[".print_r($fieldName_array,true)."]", __FILE__, __METHOD__, __LINE__);

	$value = $fieldName_array[0];
	$label_key = $fieldName_array[1];
	$label = $fieldName_array[2];

	$value_array = explode('.',$value);
	$label_key_array = explode('.',$label_key);

	if (count($value_array) == 2) { // not a regular_field

		if (strpos($value_array[0], '_cstm') !== false) { // custom_field

			if (count($label_key_array) == 2) { // custom_field(from related_field)
				$module = $label_key_array[0];
				$lbl_module = $app_list_strings['moduleList'][$module];
				if (empty($lbl_module)) {
					$lbl_module = $module;
				}

				$field = $value_array[1];
				$lbl_field = translate($label_key_array[1], $module);
				if (empty($lbl_field)) {
					$lbl_field = $field;
				}

				if ($translateFieldLabels) {
					$inner_html = $lbl_module.'_cstm.'.$lbl_field;
				} else {
					$inner_html = $value;
				}
			} else { // custom_field(from regular_field)
				$module = $trigger_module;
				$lbl_module = $app_list_strings['moduleList'][$module];
				if (empty($lbl_module)) {
					$lbl_module = $module;
				}

				$field = $value_array[1];
				$lbl_field = translate($label_key, $module);
				if (empty($lbl_field)) {
					$lbl_field = $field;
				}

				if ($translateFieldLabels) {
					$inner_html = $lbl_module.'_cstm.'.$lbl_field;
				} else {
					$inner_html = $value;
				}
			}
		} else { // related_field

			$relatedModule = $label_key_array[0];
			$lbl_relatedModule = $app_list_strings['moduleList'][$relatedModule];
			if (empty($lbl_relatedModule)) {
				$lbl_relatedModule = $relatedModule;
			}
			if (empty($lbl_relatedModule)) {
				$lbl_relatedModule = $value_array[0];
			}

			$fieldRelatedModule = $value_array[1];
			$lbl_fieldRelatedModule = translate($label_key_array[1], $relatedModule);
			if (empty($lbl_fieldRelatedModule)) {
				$lbl_fieldRelatedModule = $fieldRelatedModule;
			}

			if ($translateFieldLabels) {
				$inner_html = $lbl_relatedModule.'.'.$lbl_fieldRelatedModule;
			} else {
				$inner_html = $value;
			}
		}
	} else  { // regular_field

		if ($data_source == 'form') {
			$field = $value;
			$lbl_field = $form_language[$field];
			
			if (empty($lbl_field)) {
				$lbl_field = $field;
			}
			
		} else {
		
			$module = $trigger_module;
	
			$field = $value;
			$lbl_field = translate($label_key, $module);
			
			if ($lbl_field == $label_key) {
		    	switch ($label_key) {
			        case 'LBL_AUDIT_REPORT_PARENT_ID':
			        case 'LBL_AUDIT_REPORT_DATA_TYPE':
			        	$lbl_field = translate($label_key, 'asol_Process');
			        	break;
			        case 'LBL_DATE_ENTERED':
			        case 'LBL_CREATED_BY':
			        case 'LBL_FIELD_NAME':
			        	$lbl_field = translate($label_key, 'Audit');
			        	break;
			        case 'LBL_OLD_NAME_String':
			        	$lbl_field = translate('LBL_OLD_NAME', 'Audit') . ' String';
			        	break;
			        case 'LBL_NEW_VALUE_String':
			        	$lbl_field = translate('LBL_NEW_VALUE', 'Audit') . ' String';
			        	break;
			        case 'LBL_OLD_NAME_Text':
			        	$lbl_field = translate('LBL_OLD_NAME', 'Audit') . ' Text';
			        	break;
			        case 'LBL_NEW_VALUE_Text':
			        	$lbl_field = translate('LBL_NEW_VALUE', 'Audit') . ' Text';
			        	break;
		    	}
		    	
				if ($lbl_field == $label_key) {
					$lbl_field = $field;
				}
			}
		}
	}
	
	if ($translateFieldLabels) {
		$inner_html = $lbl_field;
	} else {
		$inner_html = $value;
	}

	$label = trim($inner_html);
	$label = (substr($label, -1) == ':') ? substr($label, 0, -1) : $label;// remove colon

	$label = ($key != '') ? "{$label} ({$key})" : $label;// related_fields

	return $label;
}

function generate_OldBean_NewBean_Changed($OldBean_NewBean_Changed) {

	$lbl_asol_old_bean = translate("LBL_ASOL_OLD_BEAN", 'asol_Events');
	$lbl_asol_new_bean = translate("LBL_ASOL_NEW_BEAN", 'asol_Events');
	$lbl_asol_changed = translate("LBL_ASOL_CHANGED", 'asol_Events');

	switch ($OldBean_NewBean_Changed) {
		case 'old_bean':
			$label = $lbl_asol_old_bean;
			break;
		case 'new_bean':
			$label = $lbl_asol_new_bean;
			break;
		case 'changed':
			$label = $lbl_asol_changed;
			break;
		default:
			$label = "";
			break;
	}

	return $label;
}

function generate_IsChanged($isChanged) {

	$lbl_asol_true = translate("LBL_ASOL_TRUE", 'asol_Events');
	$lbl_asol_false = translate("LBL_ASOL_FALSE", 'asol_Events');

	switch ($isChanged) {
		case 'true':
			$label = $lbl_asol_true;
			break;
		case 'false':
			$label = $lbl_asol_false;
			break;
		default:
			$label = "";
			break;
	}

	return $label;
}

function generate_Operator($operator) {

	//enum
	$lbl_event_equals = translate("LBL_EVENT_EQUALS", 'asol_Events');
	$lbl_event_not_equals = translate("LBL_EVENT_NOT_EQUALS", 'asol_Events');
	$lbl_event_one_of = translate("LBL_EVENT_ONE_OF", 'asol_Events');
	$lbl_event_not_one_of = translate("LBL_EVENT_NOT_ONE_OF", 'asol_Events');
	//int
	$lbl_event_less_than = translate("LBL_EVENT_LESS_THAN", 'asol_Events');
	$lbl_event_more_than = translate("LBL_EVENT_MORE_THAN", 'asol_Events');
	//datetime
	$lbl_event_before_date = translate("LBL_EVENT_BEFORE_DATE", 'asol_Events');
	$lbl_event_after_date = translate("LBL_EVENT_AFTER_DATE", 'asol_Events');
	$lbl_event_between = translate("LBL_EVENT_BETWEEN", 'asol_Events');
	$lbl_event_not_between = translate("LBL_EVENT_NOT_BETWEEN", 'asol_Events');
	$lbl_event_last = translate("LBL_EVENT_LAST", 'asol_Events');
	$lbl_event_not_last = translate("LBL_EVENT_NOT_LAST", 'asol_Events');
	$lbl_event_this = translate("LBL_EVENT_THIS", 'asol_Events');
	$lbl_event_not_this = translate("LBL_EVENT_NOT_THIS", 'asol_Events');
	$lbl_event_next = translate("LBL_EVENT_NEXT", 'asol_Events');
	$lbl_event_not_next = translate("LBL_EVENT_NOT_NEXT", 'asol_Events');
	//default
	$lbl_event_like = translate("LBL_EVENT_LIKE", 'asol_Events');
	$lbl_event_not_like = translate("LBL_EVENT_NOT_LIKE", 'asol_Events');

	switch ($operator) {
		//enum
		case 'equals':
			$label = $lbl_event_equals;
			break;
		case 'not equals':
			$label = $lbl_event_not_equals;
			break;
		case 'one of':
			$label = $lbl_event_one_of;
			break;
		case 'not one of':
			$label = $lbl_event_not_one_of;
			break;
			//int
		case 'less than':
			$label = $lbl_event_less_than;
			break;
		case 'more than':
			$label = $lbl_event_more_than;
			break;
			//datetime
		case 'before date':
			$label = $lbl_event_before_date;
			break;
		case 'after date':
			$label = $lbl_event_after_date;
			break;
		case 'between':
			$label = $lbl_event_between;
			break;
		case 'not between':
			$label = $lbl_event_not_between;
			break;
		case 'last':
			$label = $lbl_event_last;
			break;
		case 'not last':
			$label = $lbl_event_not_last;
			break;
		case 'this':
			$label = $lbl_event_this;
			break;
		case 'not this':
			$label = $lbl_event_not_this;
			break;
		case 'next':
			$label = $lbl_event_next;
			break;
		case 'not next':
			$label = $lbl_event_not_next;
			break;
			//default
		case 'like':
			$label = $lbl_event_like;
			break;
		case 'not like':
			$label = $lbl_event_not_like;
			break;
		default:
			$label = "";
			break;
	}

	return $label;
}

function generate_Param1($Param1, $enum_reference, $fieldType, $operator, $fieldName_array_0) {
	
	wfm_utils::wfm_log('asol_debug', 'get_defined_vars=['.var_export(get_defined_vars(), true).']', __FILE__, __METHOD__, __LINE__);

	$form_dropdowns = flowChart::$form_dropdowns;
	wfm_utils::wfm_log('asol_debug', '$form_dropdowns=['.var_export($form_dropdowns, true).']', __FILE__, __METHOD__, __LINE__);
	
	global $app_list_strings;

	//// wfm_utils::wfm_log('debug', "\$Param1=[".print_r($Param1,true)."]", __FILE__, __METHOD__, __LINE__);

	$label = "";

	switch ($fieldType) {
		case 'enum':
			
			if (flowChart::$data_source == 'form') {
				$dropdown = $form_dropdowns[$fieldName_array_0];
			} else {
				$dropdown = $app_list_strings[$enum_reference];
			}
			
			wfm_utils::wfm_log('asol_debug', '$dropdown=['.var_export($dropdown, true).']', __FILE__, __METHOD__, __LINE__);
			
			$Param1_array = explode("\${dollar}", $Param1);
			foreach ($Param1_array as $key => $value) {
				$label .=  $dropdown[$value] . "<br>"."&nbsp;&nbsp;";
			}
			$label = substr($label, 0, (-4-6-6));
			
			break;

		case "int":
		case "double":
		case "currency":
		case "decimal":
			$label = $Param1;
			break;

		case "datetime":
		case "datetimecombo":
		case "date":

			switch ($operator) {
				case "last":
				case "this":
				case "next":
				case "not last":
				case "not this":
				case "not next":
					$lbl_event_day = translate("LBL_EVENT_DAY", 'asol_Events');
					$lbl_event_week = translate("LBL_EVENT_WEEK", 'asol_Events');
					$lbl_event_month = translate("LBL_EVENT_MONTH", 'asol_Events');
					$lbl_event_nquarter = translate("LBL_EVENT_NQUARTER", 'asol_Events');
					$lbl_event_fquarter = translate("LBL_EVENT_FQUARTER", 'asol_Events');
					$lbl_event_nyear = translate("LBL_EVENT_NYEAR", 'asol_Events');
					$lbl_event_fyear = translate("LBL_EVENT_FYEAR", 'asol_Events');

					switch ($Param1) {
						case 'day':
							$label = $lbl_event_day;
							break;
						case 'week':
							$label = $lbl_event_week;
							break;
						case 'month':
							$label = $lbl_event_month;
							break;
						case 'Nquarter':
							$label = $lbl_event_nquarter;
							break;
						case 'Fquarter':
							$label = $lbl_event_fquarter;
							break;
						case 'Nyear':
							$label = $lbl_event_nyear;
							break;
						case 'Fyear':
							$label = $lbl_event_fyear;
							break;
					}
					break;

				default: // [between, not between]
					$label = $Param1;
					break;
			}

			break;

		case "tinyint(1)":
		case "bool":
			$lbl_event_true = translate("LBL_EVENT_TRUE", 'asol_Events');
			$lbl_event_false = translate("LBL_EVENT_FALSE", 'asol_Events');

			switch ($Param1) {
				case 'true':
					$label = $lbl_event_true;
					break;
				case 'false':
					$label = $lbl_event_false;
					break;
				default:
					$label = "";
					break;
			}

			break;

		default:
			$label = $Param1;
			break;
	}

	$label = str_replace('\_', '_', $label);
	return $label;
}

function generateFlowChart($processId) {

	global $db;

	$draw_Process = '';

	$export_array = Array();

	// SEARCH FOR PROCESS
	$process_query = $db->query ("
									SELECT *
									FROM asol_process
									WHERE id = '{$processId}'
								");
	$process_row = $db->fetchByAssoc($process_query);

	$export_array['processes'][] = $process_row;
	//// wfm_utils::wfm_log('debug', "1 FINAL \$export_array=[".print_r($export_array,true)."]", __FILE__, __METHOD__, __LINE__);

	searchEvents($export_array);
	searchActivities($export_array);

	flowChart::init();
	flowChart::$top_Process = 50;
	flowChart::$left_Process = 50;

	searchNextActivities($export_array);
	searchTasks($export_array);

	// DRAW PROCESS
	if (!empty($export_array['processes'])) {
		$workflowHeader = generate_Process_HTML($export_array['processes'][0]['id'], $export_array['processes'][0]['name'], $export_array['processes'][0]['alternative_database'],$export_array['processes'][0]['trigger_module'],  $export_array['processes'][0]['status'], $export_array['processes'][0]['description'], $export_array['processes'][0]['async'], $export_array['processes'][0]['audit'], $export_array['processes'][0]['data_source'], $export_array['processes'][0]['asol_forms_id_c']);
	}
	
	$data_source = $export_array['processes'][0]['data_source'];
	$form_id = $export_array['processes'][0]['asol_forms_id_c'];
	
	if (($data_source == 'form') && (!empty($form_id))) {
		$formFields = wfm_utils::getFormFields($form_id);
		$fields = (isset($formFields['fields'])) ? $formFields['fields'] : null;
		$fields_labels = (isset($formFields['fields_labels'])) ? $formFields['fields_labels'] : null;
		$dropdowns = (isset($formFields['dropdowns'])) ? $formFields['dropdowns'] : null;
		$form_language = array_combine($fields, $fields_labels);
		$form_dropdowns = array_combine($fields, $dropdowns);
	} else {
		$form_language = null;
		$form_dropdowns = null;
	}
	
	wfm_utils::wfm_log('asol_debug', '$form_dropdowns=['.var_export($form_dropdowns, true).']', __FILE__, __METHOD__, __LINE__);
	
	flowChart::$data_source = $data_source;
	flowChart::$form_id = $form_id;
	flowChart::$form_language = $form_language;
	flowChart::$form_dropdowns = $form_dropdowns;

	// DRAW ALL EVENTS

	//$height_Event = 1+7+90+7+1;
	//$width_Event = 1+7+90+7+1; // = 106
	//$separation_vertical_Event = 50;

	$draw_Events = "";
	if (array_key_exists('events', $export_array)) {
		foreach ($export_array['events'] as $key_parent_process => $value_parent_process) {
			foreach ($value_parent_process as $key_event => $value_event) {
				$draw_Events .= generate_Event_HTML($value_event['id'], $value_event['name'], $value_event['description'], flowChart::$draw_information_event[$value_event['id']], flowChart::$left_Process, $value_event['conditions'], $value_event['type'], $value_event['trigger_type'], $export_array['processes'][0]['alternative_database'], $value_event['trigger_event'], $value_event['scheduled_type'], $value_event['subprocess_type'], $export_array['processes'][0]['trigger_module'], $data_source, $form_id, $form_language);
				//$top_Process = $top_Process + $height_Event + $separation_vertical_Event;
			}
		}
	}

	drawActivitiesAndTasks($export_array, 'workflow');

	$versionWFM = wfm_utils::$wfm_code_version;
	$draw_Activities = flowChart::$draw_Activities;
	$connections = flowChart::$connections;

	// RESPONSE 1 // workflow

	$responseUiLayoutCenter = "
	<meta http-equiv='X-UA-Compatible' content='IE=9' /> <!-- needed for border-radius IE -->
	<html>
		<head>

			<title>WF</title>
			
			
			
			<script>
				function generateConnectionsUiLayoutCenter() {
				$connections
				}
			</script>
			
			
		</head>

		<body>

		$draw_Process
		$draw_Events
		$draw_Activities

			<a id='scrollToTop' href='#' class='scrollToTop'></a>

		</body>

	</html>
";

		// RESPONSE 2 // recycleBinEvents

		$hasRecycleBinEvents = false;

		$export_array = Array();
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
			$export_array['events']['auxID'][] = $row;
			$hasRecycleBinEvents = true;
		}

		searchActivities($export_array);

		flowChart::init();
		flowChart::$top_Process = 50;
		flowChart::$left_Process = 50;

		searchNextActivities($export_array);
		searchTasks($export_array);

		// DRAW ALL EVENTS

		//$height_Event = 1+7+90+7+1;
		//$width_Event = 1+7+90+7+1; // = 106
		//$separation_vertical_Event = 50;

		$draw_Events = "";
		if (array_key_exists('events', $export_array)) {
			foreach ($export_array['events'] as $key_parent_process => $value_parent_process) {
				foreach ($value_parent_process as $key_event => $value_event) {
					$draw_Events .= generate_Event_HTML($value_event['id'], $value_event['name'], $value_event['description'], flowChart::$draw_information_event[$value_event['id']], flowChart::$left_Process, $value_event['conditions'], $value_event['type'], $value_event['trigger_type'], $export_array['processes'][0]['alternative_database'], $value_event['trigger_event'], $value_event['scheduled_type'], $value_event['subprocess_type'], $export_array['processes'][0]['trigger_module'], $data_source, $form_id, $form_language);
					//$top_Process = $top_Process + $height_Event + $separation_vertical_Event;
				}
			}
		}

		drawActivitiesAndTasks($export_array, 'recycleBinEvents');

		$versionWFM = wfm_utils::$wfm_code_version;
		$draw_Activities = flowChart::$draw_Activities;
		$connections = flowChart::$connections;

		$responseRecycleBinEvents = "
	<script>
		function generateConnectionsRecycleBinEvents() {
		$connections
		}
	</script>

	$draw_Events
	$draw_Activities
";

	// RESPONSE 3 // recycleBinActivities

	$hasRecycleBinActivities = false;

	$export_array = Array();

	$sql = "
	SELECT asol_activity.*
	FROM asol_activity
	INNER JOIN asol_process_asol_activity_c ON asol_process_asol_activity_c.asol_process_asol_activityasol_activity_idb = asol_activity.id
	WHERE asol_process_asol_activity_c.asol_process_asol_activityasol_process_ida = '{$processId}' AND asol_process_asol_activity_c.deleted = 0 AND asol_activity.deleted = 0
	ORDER BY asol_process_asol_activity_c.date_modified DESC
";
	$query = $db->query($sql);
	while ($row = $db->fetchByAssoc($query)) {
		$row['relationship'] = 'asol_process_asol_activity_c';
		$export_array['activities']['auxId'][] = $row;
		$hasRecycleBinActivities = true;
	}

	flowChart::init();
	flowChart::$top_Process = 50;
	flowChart::$left_Process = 50;

	searchNextActivities($export_array);
	searchTasks($export_array);


	//$height_Event = 1+7+90+7+1;
	//$width_Event = 1+7+90+7+1; // = 106
	//$separation_vertical_Event = 50;

	drawActivitiesAndTasks($export_array, 'recycleBinActivities');

	$versionWFM = wfm_utils::$wfm_code_version;
	$draw_Activities = flowChart::$draw_Activities;
	$connections = flowChart::$connections;

	$responseRecycleBinActivities = "
	<script>
		function generateConnectionsRecycleBinActivities() {
		$connections
		}
	</script>

	$draw_Activities
";

	// RESPONSE 4 // recycleBinTasks

	$hasRecycleBinTasks = false;

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
		$hasRecycleBinTasks = true;
	}

	$drawTasks = '';
	$left = 0;
	$top = 0;
	$taskHeight = 0+1+0+51+2+1+0;
	$taskVerticalSeparation = 20;

	foreach ($tasks as $keyTask => $task) {
		$drawTasks .= generate_Task_HTML('recycleBinTasks', $task['id'], $task['name'], $task['description'], $task['task_type'], $top, null, $left, $task['async'], $task['delay_type'], $task['delay'], $task['date'], $task['order'], $task['task_implementation']);
		$top += $taskHeight + $taskVerticalSeparation;
	}

	$responseRecycleBinTasks = "
	$drawTasks
";			


	// RESPONSE
	$response = Array(
		'workflowHeader' => $workflowHeader,
		'responseUiLayoutCenter' => $responseUiLayoutCenter,
		'hasRecycleBinEvents' => $hasRecycleBinEvents,
		'responseRecycleBinEvents' => $responseRecycleBinEvents,
		'hasRecycleBinActivities' => $hasRecycleBinActivities,
		'responseRecycleBinActivities' => $responseRecycleBinActivities,
		'hasRecycleBinTasks' => $hasRecycleBinTasks,
		'responseRecycleBinTasks' => $responseRecycleBinTasks
	);

	return $response;
}

//////////////////////////////////////////////////////////////////////////////////////////
//**************************************DRAW********************************************//
//////////////////////////////////////////////////////////////////////////////////////////

