<?php

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");

// moduleList
$app_list_strings['moduleList']['asol_WorkFlowManagerCommon'] = 'WorkFlow Manager Common';
$app_list_strings['moduleList']['asol_Activity'] = 'WFM Activity';
$app_list_strings['moduleList']['asol_Events'] = 'WFM Event';
$app_list_strings['moduleList']['asol_Process'] = 'WFM Process';
$app_list_strings['moduleList']['asol_Task'] = 'WFM Task';
$app_list_strings['moduleList']['asol_ProcessInstances'] = 'WFM Process Instances';
$app_list_strings['moduleList']['asol_WorkingNodes'] = 'WFM Working Nodes';
$app_list_strings['moduleList']['asol_OnHold'] = 'WFM On Hold';
wfm_utils::addPremiumAppListStrings($app_list_strings, 'en_us', 'addAppListStrings_loginAudit');

// wfm_process_status_list
$app_list_strings['wfm_process_status_list']['active'] = 'Active';
$app_list_strings['wfm_process_status_list']['inactive'] = 'Inactive';

// wfm_process_async_list
$app_list_strings['wfm_process_async_list']['sync'] = 'Synchronous';
$app_list_strings['wfm_process_async_list']['async_curl'] = 'Asynchronous - cURL';
$app_list_strings['wfm_process_async_list']['async_sugar_job_queue'] = 'Asynchronous - SugarCRM job queue';

// wfm_process_data_source_list
$app_list_strings['wfm_process_data_source_list']['database'] = 'Database';
$app_list_strings['wfm_process_data_source_list']['form'] = 'Form';

// wfm_trigger_type_list
$app_list_strings['wfm_trigger_type_list']['logic_hook'] = 'Logic Hook';
$app_list_strings['wfm_trigger_type_list']['scheduled'] = 'Scheduled';
$app_list_strings['wfm_trigger_type_list']['subprocess'] = 'Subprocess';
$app_list_strings['wfm_trigger_type_list']['subprocess_local'] = 'Local Subprocess';

// wfm_trigger_type_list_for_audit [deprecated]
$app_list_strings['wfm_trigger_type_list_for_audit']['scheduled'] = 'Scheduled';
$app_list_strings['wfm_trigger_type_list_for_audit']['subprocess'] = 'Subprocess';
$app_list_strings['wfm_trigger_type_list_for_audit']['subprocess_local'] = 'Local Subprocess';

// wfm_trigger_type_list_for_data_source_form [deprecated]
$app_list_strings['wfm_trigger_type_list_for_data_source_form']['logic_hook'] = 'Logic Hook';
$app_list_strings['wfm_trigger_type_list_for_data_source_form']['subprocess'] = 'Subprocess';
$app_list_strings['wfm_trigger_type_list_for_data_source_form']['subprocess_local'] = 'Local Subprocess';

// wfm_trigger_event_list
$app_list_strings['wfm_trigger_event_list']['on_create'] = 'On Create';
$app_list_strings['wfm_trigger_event_list']['on_modify'] = 'On Modify';
$app_list_strings['wfm_trigger_event_list']['on_modify__before_save'] = 'On Modify Before Save';
$app_list_strings['wfm_trigger_event_list']['on_delete'] = 'On Delete';
$app_list_strings['wfm_trigger_event_list']['on_init'] = 'On Init';
$app_list_strings['wfm_trigger_event_list']['before_submit'] = 'Before Submit';
$app_list_strings['wfm_trigger_event_list']['on_submit'] = 'On Submit';
$app_list_strings['wfm_trigger_event_list']['after_submit'] = 'After Submit';
wfm_utils::addPremiumAppListStrings($app_list_strings, 'en_us', 'addAppListStrings_loginAuditEvents');

// wfm_trigger_event_list_not_users
$app_list_strings['wfm_trigger_event_list_not_users']['on_create'] = 'On Create';
$app_list_strings['wfm_trigger_event_list_not_users']['on_modify'] = 'On Modify';
$app_list_strings['wfm_trigger_event_list_not_users']['on_modify__before_save'] = 'On Modify Before Save';
$app_list_strings['wfm_trigger_event_list_not_users']['on_delete'] = 'On Delete';

// wfm_trigger_event_list_for_data_source_form
$app_list_strings['wfm_trigger_event_list_for_data_source_form']['on_init'] = 'On Init';
$app_list_strings['wfm_trigger_event_list_for_data_source_form']['before_submit'] = 'Before Submit';
$app_list_strings['wfm_trigger_event_list_for_data_source_form']['on_submit'] = 'On Submit';
$app_list_strings['wfm_trigger_event_list_for_data_source_form']['after_submit'] = 'After Submit';

// wfm_events_type_list
wfm_utils::addPremiumAppListStrings($app_list_strings, 'en_us', 'addAppListStrings_initialize');
$app_list_strings['wfm_events_type_list']['start'] = 'Start';
$app_list_strings['wfm_events_type_list']['intermediate'] = 'Intermediate';
$app_list_strings['wfm_events_type_list']['cancel'] = 'Cancel';

// wfm_scheduled_type_list
$app_list_strings['wfm_scheduled_type_list']['sequential'] = 'Sequential';
$app_list_strings['wfm_scheduled_type_list']['parallel'] = 'Parallel';

// wfm_subprocess_type_list
$app_list_strings['wfm_subprocess_type_list']['sequential'] = 'Sequential';
$app_list_strings['wfm_subprocess_type_list']['parallel'] = 'Parallel';

// wfm_working_node_priority
$app_list_strings['wfm_working_node_priority']['logic_hook']['initialize'] = 0;
$app_list_strings['wfm_working_node_priority']['logic_hook']['start'] = -1;
$app_list_strings['wfm_working_node_priority']['subprocess']['sequential'] = -2;
$app_list_strings['wfm_working_node_priority']['subprocess']['parallel'] = -3;
$app_list_strings['wfm_working_node_priority']['subprocess_local']['sequential'] = -4;
$app_list_strings['wfm_working_node_priority']['subprocess_local']['parallel'] = -5;
$app_list_strings['wfm_working_node_priority']['logic_hook']['intermediate'] = -6;
$app_list_strings['wfm_working_node_priority']['logic_hook']['cancel'] = -7;
$app_list_strings['wfm_working_node_priority']['scheduled']['sequential'] = -8;
$app_list_strings['wfm_working_node_priority']['scheduled']['parallel'] = -9;

// wfm_activity_type_list
//$app_list_strings['wfm_activity_type_list']['no_foreach'] = 'No Foreach';
$app_list_strings['wfm_activity_type_list']['foreach_ingroup'] = 'Foreach In Group';
//$app_list_strings['wfm_activity_type_list']['foreach_inrelationship'] = 'Foreach In Relationship';

// wfm_task_delay_type_list
$app_list_strings['wfm_task_delay_type_list']['no_delay'] = 'No Delay';
$app_list_strings['wfm_task_delay_type_list']['on_creation'] = 'On Creation';
$app_list_strings['wfm_task_delay_type_list']['on_modification'] = 'On Modification';
$app_list_strings['wfm_task_delay_type_list']['on_finish_previous_task'] = 'On Finish Previous Task';
$app_list_strings['wfm_task_delay_type_list']['on_date'] = 'On Date';

// wfm_task_async_list
$app_list_strings['wfm_task_async_list']['sync'] = 'Synchronous';
$app_list_strings['wfm_task_async_list']['async_sugar_job_queue'] = 'Asynchronous - SugarCRM job queue';

// wfm_task_type_list
$app_list_strings['wfm_task_type_list']['send_email'] = 'Send Email';
$app_list_strings['wfm_task_type_list']['php_custom'] = 'PHP Custom';
$app_list_strings['wfm_task_type_list']['continue'] = 'Continue';
$app_list_strings['wfm_task_type_list']['end'] = 'End';
$app_list_strings['wfm_task_type_list']['create_object'] = 'Create Object';
$app_list_strings['wfm_task_type_list']['modify_object'] = 'Modify Object';
$app_list_strings['wfm_task_type_list']['call_process'] = 'Call Process';
$app_list_strings['wfm_task_type_list']['add_custom_variables'] = 'Add Custom Variables';
$app_list_strings['wfm_task_type_list']['get_objects'] = 'Get Objects';
$app_list_strings['wfm_task_type_list']['forms_response'] = 'Forms Response';
$app_list_strings['wfm_task_type_list']['forms_error_message'] = 'Forms Error Message';

// login_audit
$app_list_strings['wfm_login_audit_action_list']['login_failed'] = 'Login Failed';
$app_list_strings['wfm_login_audit_action_list']['after_login'] = 'Login';
$app_list_strings['wfm_login_audit_action_list']['before_logout'] = 'Logout';

// add_custom_variables_type
$app_list_strings['wfm_add_custom_variables_type']['sql'] = 'SQL';
$app_list_strings['wfm_add_custom_variables_type']['php_eval'] = 'PHP eval';
$app_list_strings['wfm_add_custom_variables_type']['literal'] = 'Literal';

// delay
$app_list_strings['wfm_delay_time']['minutes'] = 'Minutes';
$app_list_strings['wfm_delay_time']['hours'] = 'Hours';
$app_list_strings['wfm_delay_time']['days'] = 'Days';
$app_list_strings['wfm_delay_time']['weeks'] = 'Weeks';
$app_list_strings['wfm_delay_time']['months'] = 'Months';

// delay
$app_list_strings['wfm_delay_time_amount']['minutes'] = 60;
$app_list_strings['wfm_delay_time_amount']['hours'] = 24;
$app_list_strings['wfm_delay_time_amount']['days'] = 31;
$app_list_strings['wfm_delay_time_amount']['weeks'] = 4;
$app_list_strings['wfm_delay_time_amount']['months'] = 12;

// working_node status
$app_list_strings['wfm_working_node_status']['not_started'] = 'Not Started';
$app_list_strings['wfm_working_node_status']['executing'] = 'Executing';
$app_list_strings['wfm_working_node_status']['delayed_by_activity'] = 'Delayed By Activity';
$app_list_strings['wfm_working_node_status']['delayed_by_task'] = 'Delayed By Task';
$app_list_strings['wfm_working_node_status']['in_progress'] = 'In Progress';
$app_list_strings['wfm_working_node_status']['terminated'] = 'Terminated';
$app_list_strings['wfm_working_node_status']['held'] = 'Held';
$app_list_strings['wfm_working_node_status']['corrupted'] = 'Corrupted';

// wfm_working_node_type_list
$app_list_strings['wfm_working_node_type_list']['initialize'] = 'Initilialize';
$app_list_strings['wfm_working_node_type_list']['start'] = 'Start';
$app_list_strings['wfm_working_node_type_list']['intermediate'] = 'Intermediate';
$app_list_strings['wfm_working_node_type_list']['cancel'] = 'Cancel';
$app_list_strings['wfm_working_node_type_list']['subprocess'] = 'Subprocess';

// TRICK: DISABLE AJAX-UI
$sugar_config['addAjaxBannedModules'][] = "asol_Process";
$sugar_config['addAjaxBannedModules'][] = "asol_Events";
$sugar_config['addAjaxBannedModules'][] = "asol_Activity";
$sugar_config['addAjaxBannedModules'][] = "asol_Task";
$sugar_config['addAjaxBannedModules'][] = "asol_ProcessInstances";
$sugar_config['addAjaxBannedModules'][] = "asol_WorkingNodes";
$sugar_config['addAjaxBannedModules'][] = "asol_OnHold";

?>