<?php

$mod_strings = array (

// General
'LBL_ASSIGNED_TO_ID' => 'Assigned User Id',
'LBL_ASSIGNED_TO_NAME' => 'User',
'LBL_ID' => 'ID',
'LBL_DATE_ENTERED' => 'Date Created',
'LBL_DATE_MODIFIED' => 'Date Modified',
'LBL_MODIFIED' => 'Modified By',
'LBL_MODIFIED_ID' => 'Modified By Id',
'LBL_MODIFIED_NAME' => 'Modified By',
'LBL_CREATED' => 'Created By',
'LBL_CREATED_ID' => 'Created By Id',
'LBL_DESCRIPTION' => 'Description',
'LBL_DELETED' => 'Deleted',
'LBL_NAME' => 'Name',
'LBL_CREATED_USER' => 'Created by User',
'LBL_MODIFIED_USER' => 'Modified by User',
'LBL_LIST_NAME' => 'Name',
'LBL_LIST_FORM_TITLE' => 'WFM Process List',
'LBL_MODULE_NAME' => 'WFM Process',
'LBL_MODULE_TITLE' => 'WFM Process',
'LBL_HOMEPAGE_TITLE' => 'My WFM Processes',
'LNK_NEW_RECORD' => 'Create WFM Process',
'LNK_LIST' => 'View WFM Process',
'LNK_IMPORT_ASOL_PROCESS' => 'Import WFM Process',
'LBL_SEARCH_FORM_TITLE' => 'Search WFM Process',
'LBL_HISTORY_SUBPANEL_TITLE' => 'View History',
'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activities',
'LBL_ASOL_PROCESS_SUBPANEL_TITLE' => 'WFM Process',
'LBL_NEW_FORM_TITLE' => 'New WFM Process',
'LBL_YES' => 'Yes',
'LBL_NO' => 'No',

// Menu
'LBL_ASOL_VIEW_ASOL_PROCESSES' => 'View WFM Processes',
'LBL_ASOL_CREATE_ASOL_PROCESS' => 'Create WFM Process',
'LBL_ASOL_VIEW_ASOL_EVENTS' => 'View WFM Events',
'LBL_ASOL_CREATE_ASOL_EVENT' => 'Create WFM Event',
'LBL_ASOL_VIEW_ASOL_ACTIVITIES' => 'View WFM Activities',
'LBL_ASOL_CREATE_ASOL_ACTIVITY' => 'Create WFM Activity',
'LBL_ASOL_VIEW_ASOL_TASKS' => 'View WFM Tasks',
'LBL_ASOL_CREATE_ASOL_TASK' => 'Create WFM Task',
'LBL_ASOL_VIEW_ASOL_LOGINAUDIT' => 'View WFM Login Audit',
'LBL_ASOL_ALINEASOL_WFM_MONITOR' => 'AlineaSol WFM Monitor',

// Miscellaneous
'LBL_DB_CONFIGURATION_PANEL' => 'Module Panel',
'LBL_REPORT_NATIVE_DB' => 'CRM Native Database',
		
// Form panel
'LBL_FORM_PANEL' => 'Form panel',
'LBL_FORM' => 'Form',

// Fields
'LBL_STATUS' => 'Status',
'LBL_ASYNC' => 'Async',
'LBL_TRIGGER_MODULE' => 'Module',
'LBL_AUDIT' => 'Audit',
'LBL_ASOL_TRIGGER_MODULE' => 'Module',
'LBL_REPORT_USE_ALTERNATIVE_DB' => 'Use Database',
'LBL_DATA_SOURCE' => 'Data source',

// Rebuild logic_hooks
'LBL_ASOL_REBUILD_TITLE' => 'Check the logic_hooks you want AlineaSol WFM to supervise and click on "Update" at the bottom.',
'LBL_ASOL_REBUILD_SEND' => 'Update',
'LBL_ASOL_REBUILD_DONE' => 'DONE',
'LBL_REBUILD_SUBTITLE_1' => 'Required in order to use workflows with wfm-events of trigger_type=logic_hook',
'LBL_REBUILD_SUBTITLE_2' => 'Required in order to use workflows with wfm-tasks of delay_type=on_finish_previous_task',

// Repair php-custom files
'LBL_REPAIR_PHP_CUSTOM_DONE' => 'DONE',

// Import Advanced
'LBL_IMPORT_ADVANCED' => 'Import',
'LBL_IMPORT_STEP1_ADVANCED' => 'Step 1: Check if WorkFlows already exist.',
'LBL_IMPORT_STEP2_WORKFLOWS_EXIST_ADVANCED' => 'Step 2: WorkFlows already exist. Choose your options and Import.',
'LBL_IMPORT_STEP2_WORKFLOWS_NOT_EXIST_ADVANCED' => 'Step 2: WorkFlows do not exist. Import.',
'LBL_IMPORT_CHECK_ADVANCED' => 'Check',
'LBL_IMPORT_TYPE_REPLACE_ADVANCED' => 'Replace WFs',
'LBL_IMPORT_TYPE_CLONE_ADVANCED' => 'Clone WFs',
'LBL_IMPORT_TYPE_CLONE_PREFIX_ADVANCED' => 'Prefix',
'LBL_IMPORT_TYPE_CLONE_SUFFIX_ADVANCED' => 'Suffix',
'LBL_IMPORT_DOMAIN_TYPE_KEEP_DOMAIN_ADVANCED' => 'Keep domain',
'LBL_IMPORT_DOMAIN_TYPE_USE_CURRENT_USER_DOMAIN_ADVANCED' => 'Use current domain',
'LBL_IMPORT_DOMAIN_TYPE_USE_EXPLICIT_DOMAIN_ADVANCED' => 'Use explicit domain',
'LBL_IMPORT_EXPLICIT_DOMAIN_ADVANCED' => 'Explicit domain',
'LBL_IMPORT_RENAME_KEEP_NAMES_ADVANCED' => 'Keep names',
'LBL_IMPORT_RENAME_WFM_PROCESS_ONLY_ADVANCED' => 'Rename wfm-process only',
'LBL_IMPORT_RENAME_ALL_WFM_ENTITIES_ADVANCED' => 'Rename all wfm-entities',
'LBL_IMPORT_TITLE_ADVANCED' => 'Import WorkFlows Advanced (admin-users only)',
'LBL_IMPORT_WORKFLOWS_ADVANCED' => 'Import WFs Advanced',
'LBL_IMPORT_SET_STATUS_TYPE_KEEP_STATUS_ADVANCED' => 'Keep WFs status',
'LBL_IMPORT_SET_STATUS_TYPE_INACTIVATE_ADVANCED' => 'Inactivate WFs',
'LBL_IMPORT_SET_STATUS_TYPE_ACTIVATE_ADVANCED' => 'Activate WFs',
'LBL_IMPORT_EMAIL_TEMPLATE_TYPE_IMPORT_ADVANCED' => 'Import EmailTemplates',
'LBL_IMPORT_EMAIL_TEMPLATE_TYPE_DO_NOT_IMPORT_ADVANCED' => 'Do Not Import EmailTemplates',
'LBL_IMPORT_IF_EMAIL_TEMPLATE_ALREADY_EXISTS_REPLACE_ADVANCED' => 'If EmailTemplate already exists then Replace',
'LBL_IMPORT_IF_EMAIL_TEMPLATE_ALREADY_EXISTS_CLONE_ADVANCED' => 'If EmailTemplate already exists then Clone',
'LBL_IMPORT_STEP3_VERSION_COMPATIBILITY_ADVANCED' => 'Version compatibility',
'LBL_IMPORT_CHECK_VERSION_COMPATIBILITY' => 'Check version compatibility',
		
// Import Standard Without Context
'LBL_IMPORT_WORKFLOWS_STANDARD_WITHOUT_CONTEXT' => 'Import WFs',
'LBL_IMPORT_TITLE_STANDARD_WITHOUT_CONTEXT' => 'Import WorkFlows Without Context',
'LBL_IMPORT_STEP1_STANDARD_WITHOUT_CONTEXT' => 'Import: Clone WorkFlows (wfm-process->status = inactive, wfm-process->asol_domain_id = $current_user->asol_default_domain)',
'LBL_IMPORT_STANDARD_WITHOUT_CONTEXT' => 'Import WFs',

// Import Standard In Context
'LBL_IMPORT_WORKFLOWS_STANDARD_IN_CONTEXT' => 'Import WF',
'LBL_IMPORT_TITLE_STANDARD_IN_CONTEXT' => 'Import WorkFlow In Context',
'LBL_IMPORT_STEP1_STANDARD_IN_CONTEXT' => 'Import: Replace WorkFlow (replace, keep_names, keep_status)',
'LBL_IMPORT_STANDARD_IN_CONTEXT' => 'Import WF',

// Export
'LBL_EXPORTED_WORKFLOWS_FILENAME' => 'Exported_WorkFlows',

// flowChart
'LBL_ASOL_REFRESH' => 'Refresh',
'LBL_ASOL_TEXT_OVERFLOW_ELLIPSIS' => 'Complete names',
'LBL_ASOL_INFO_TITLE' => 'Info',
'LBL_ASOL_INFO_TEXT' => '- In the WFE there is a lot of hidden-information about the workflow-definition. If you hover the cursor over the items(icons and element-names) you will get some info. You have to click over the condition_icon in order to show the condition_info, and click again over the condition_icon in order to hide the condition_info.<br>- A click over the name of a element will redirect south-panel to the definition of the element in the sugarcrm. This is useful to change values and see the WF at the same time.<br>- Complete names -> this will show the whole-name of an element (for events and activities, not tasks).<br>- Events are ordered first by type and second by name. Activities are ordered by name (not for next_activities). Tasks are ordered first by task_order and second by name.<br>- Ctrl+Space => Complete names',

// popupHelp
'LBL_POPUPHELP_FOR_FIELD_DATA_SOURCE' => "<table class='popupHelp'><tr><th>Data Source</th><th>Description</th></tr><tr><td>Database</td><td>Sugarcrm's modules and external databases</td></tr><tr><td>[Enterprise only] Form</td><td>Use forms (AlineaSol's Forms&Views module)</td></tr></table>",
'LBL_POPUPHELP_FOR_FIELD_STATUS' => "<table class='popupHelp'><tr><th>Status</th><th>Description</th></tr><tr><td>Active</td><td>WFM instanciates processes.</td></tr><tr><td>Inactive</td><td>WFM does not instanciate processes. But it will execute processes already instanciated and stored in database.</td></tr></table>",
'LBL_POPUPHELP_FOR_FIELD_ASYNC' => "<table class='popupHelp'><tr><th>Async (Asynchronous)</th><th>Description</th></tr><tr><td>Synchronous</td><td>Synchronous execution.<br>wfm-events trigger_type=logic_hook will NOT use cURL: both WFM and sugarcrm are executed in the same php-process, this means that the WFM will execute the WorkFlow before the user gets the sugarcrm response in his browser. Example: if you have defined a WorkFlow that modifies an object when this object is modified by the user (wfm-event on_modify, wfm-task modify_object) then you need to NOT use cURL in order to show to the user the sugarcrm response with the changes done by the WFM.<br>In case a php-error is thrown by WFM (Ex: the user has defined a wfm-task php_custom that uses a php-function that is not defined), the WFM will handle this error (the browser will be redirected to the current object adding the following text '&_________WFM_phpError_________' to the url, instead of showing a blank page).</td></tr><tr><td>Asynchronous - cURL</td><td>Asynchronous execution through cURL request.<br>wfm-events trigger_type=logic_hook will use cURL in order to execute the WorkFlow, this means that the WFM will be executed in an independent php-script-instance from sugarcrm (sugarcrm is executed in one php-process and WFM is executed in another php-process, so in case WFM execution throws an issue, this issue will not affect sugarcrm execution).</td><tr><td>Asynchronous - SugarCRM job queue</td><td>Asynchronous execution through SugarCRM job queue.<br> In order to work you need that the CRON calls SugarCRM and you need to set to true \$sugar_config['WFM_enable_async_sugar_job_queue']</td></tr></table>",
'LBL_POPUPHELP_FOR_FIELD_TRIGGER_MODULE' => "<table class='popupHelp'><tr><td>This is the trigger module for the Workflow.<br>When modifying a wfm-process you can not change the module because of security measures.<br>Example 1: If you create a wfm-process with a specific module and then you create a wfm-task of type=modify_object. Note that a field that you want the WFM to modify for the first module could not exist for the second module.<br>Example 2: If you define a condition(wfm-event/wfm-activity) for a module, this could not work if you change the module (because the field does not exist in this new module).</td></tr></table>",
'LBL_POPUPHELP_FOR_FIELD_ALTERNATIVE_DATABASE' => "<table class='popupHelp'><tr><td>- External non CRM databases (the databases access must be configured in an array within config_override.php file): \$sugar_config['WFM_AlternativeDbConnections'] </td></tr></table>",
'LBL_POPUPHELP_FOR_FIELD_AUDIT' => "<table class='popupHelp'><tr><th>Audit</th><th>Description</th></tr><tr><td>Yes</td><td>Access to the module's audit-table (Ex: If module=Accounts then table=accounts_audit. This workflow will not get Account objects [table accounts], it will get records of the Account's \"Change Log\" [table accounts_audit]).</td></tr><tr><td>No</td><td>Access to the module's table (Ex: If module=Accounts then table=accounts. This workflow will get Account objects [table accounts]).</td></tr></table>",
		
// Variables
'LBL_WFM_VARIABLES' => 'WFM Variables',

// WORKFLOWS_ERROR
'LBL_DELETE_WORKFLOWS_ERROR' => '<b>Error when deleting WorkFlows.</b>',
'LBL_IMPORT_WORKFLOWS_ERROR' => '<b>Error when importing WorkFlows.</b>',

// WORKFLOWS_OK
'LBL_ACTIVATE_WORKFLOWS_OK' => '<b>WorkFlows have been successfully activated.</b>',
'LBL_INACTIVATE_WORKFLOWS_OK' => '<b>WorkFlows have been successfully inactivated.</b>',
'LBL_DELETE_WORKFLOWS_OK' => '<b>WorkFlows have been successfully deleted.</b>',
'LBL_IMPORT_WORKFLOWS_OK' => '<b>WorkFlows have been successfully imported.</b>',

// WORKFLOWS_BUTTON
'LBL_FLOWCHARTS_BUTTON' => 'View WFs',
'LBL_VALIDATE_WORKFLOWS_BUTTON' => 'Validate WFs',
'LBL_ACTIVATE_WORKFLOWS_BUTTON' => 'Activate WFs',
'LBL_INACTIVATE_WORKFLOWS_BUTTON' => 'Inactivate WFs',
'LBL_DELETE_WORKFLOWS_BUTTON' => 'Delete WFs',
'LBL_EXPORT_WORKFLOWS_BUTTON' => 'Export WFs',

// WORKFLOW_BUTTON
'LBL_FLOWCHART_BUTTON' => 'View WF',
'LBL_VALIDATE_WORKFLOW_BUTTON' => 'Validate WF',
'LBL_ACTIVATE_WORKFLOW_BUTTON' => 'Activate WF',
'LBL_INACTIVATE_WORKFLOW_BUTTON' => 'Inactivate WF',
'LBL_DELETE_WORKFLOW_BUTTON' => 'Delete WF',
'LBL_EXPORT_WORKFLOW_BUTTON' => 'Export WF',
'LBL_IMPORT_WORKFLOW_BUTTON' => 'Import WF',
'LBL_ACTIVATE_INACTIVATE_WORKFLOW_BUTTON' => 'Act/Desact WF',

// WORKFLOW_WARNING
'LBL_ACTIVATE_WORKFLOW_WARNING' => 'WorkFlow is going to be activated. Are you sure?',
'LBL_INACTIVATE_WORKFLOW_WARNING' => 'WorkFlow is going to be inactivated. Are you sure?',
'LBL_DELETE_WORKFLOW_WARNING' => 'WorkFlow is going to be deleted. Are you sure?',
'LBL_IMPORT_WORKFLOW_WARNING' => 'WorkFlow is going to be imported. Are you sure?',

// WORKFLOWS_WARNING
'LBL_ACTIVATE_WORKFLOWS_WARNING' => 'WorkFlows are going to be activated. Are you sure?',
'LBL_INACTIVATE_WORKFLOWS_WARNING' => 'WorkFlows are going to be inactivated. Are you sure?',
'LBL_DELETE_WORKFLOWS_WARNING' => 'WorkFlows are going to be deleted. Are you sure?',

// WORKFLOWS_PLEASE
'LBL_FLOWCHART_PLEASE' => 'Please select at least 1 record to proceed.',
'LBL_VALIDATE_WORKFLOWS_PLEASE' => 'Please select at least 1 record to proceed.',
'LBL_ACTIVATE_WORKFLOWS_PLEASE' => 'Please select at least 1 record to proceed.',
'LBL_INACTIVATE_WORKFLOWS_PLEASE' => 'Please select at least 1 record to proceed.',
'LBL_EXPORT_WORKFLOWS_PLEASE' => 'Please select at least 1 record to proceed.',
'LBL_DELETE_WORKFLOWS_PLEASE' => 'Please select at least 1 record to proceed.',

// WFM Variable Generator
'LBL_WFM_VARIABLE_GENERATOR_BUTTON' => 'WFM Variable Generator',
'LBL_CUSTOM_VARIABLE_PREDEFINED_BUTTON' => 'Add Custom Variables Predefined',
'LBL_CUSTOM_VARIABLE_USER_DEFINED_BUTTON' => 'Add Custom Variables User Defined',
'LBL_DATETIME_BUTTON' => 'Add Current Datetime/Date',

// VALIDATE
'LBL_VALIDATE_TITLE' => 'Validate WorkFlows',
'LBL_VALIDATE_STEP1' => 'Step 1: Choose validations.',
'LBL_VALIDATE_BUTTON' => 'Validate',
'LBL_VALIDATE_ALL' => 'All',
'LBL_VALIDATE_SEND_EMAIL_REFERENCES_EXISTING_EMAIL_TEMPLATE' => 'Task SendEmail references existing EmailTemplate',
'LBL_VALIDATE_SEND_EMAIL_REFERENCES_EXISTING_EMAIL_TEMPLATE_ERROR' => 'Task SendEmail does NOT reference existing EmailTemplate',
'LBL_VALIDATE_WORKFLOW_IS_ACTIVE' => 'WorkFlow is active',
'LBL_VALIDATE_LOGIC_HOOK_IS_SET' => 'Logic Hook is set',
'LBL_VALIDATE_VALIDATION' => 'Validation',
'LBL_VALIDATE_RESULT' => 'Result',

// CLEAN WFM
'LBL_CLEAN_WFM_TITLE' => 'Clean WFM',
'LBL_CLEAN_WFM_STEP1' => 'Choose.',
'LBL_CLEAN_WFM_DEFINITIONS' => 'Clean WFM definitions',
'LBL_CLEAN_DELETED_WFM_ENTITIES' => 'Clean deleted=1 wfm-entities ({wfm-process, wfm-event, wfm-activity, wfm-task}) and relationships between them.',
'LBL_CLEAN_UNRELATED_WFM_ENTITIES' => 'Clean unrelated wfm-entities (example: wfm-activity does not belong to any wfm-event).',
'LBL_CLEAN_WFM_WORKING_TABLES_TITLE' => 'Clean WFM working tables',
'LBL_CLEAN_BROKEN_WORKING_NODES' => 'Clean broken working-nodes ({status=executing and older than 1 hour, status=corrupted}).',
'LBL_CLEAN_WFM_WORKING_TABLES' => 'Clean wfm working-tables ({wfm-proces_instances, wfm-working_nodes, wfm-on_hold}).',
'LBL_OTHERS' => 'Others',
'LBL_CLEAN_DELETED_LOGIN_AUDIT' => 'Clean deleted=1 login_audit.',
'LBL_CLEAN_DELETED_EMAIL_TEMPLATES' => 'Clean deleted=1 email_templates.',
'LBL_CLEANWFM_BUTTON' => 'Clean WFM',
'LBL_CLEANWFM_WARNING' => 'Warning: You should remove temporarily (not mandatory) wfm-modules\' logic-hooks ({wfm-process, wfm-event, wfm-activity, wfm-task}, Go to Administration->"AlineaSol WFM rebuild-logic_hooks").',

// WFE
'LBL_WFE_WORKFLOW_EDITOR' => 'WorkFlow Editor',
'LBL_WFE_GO_TO_LISTVIEW' => 'Go to Listview',
'LBL_WFE_NEW' => 'Components',
'LBL_WFE_EXPAND_ALL' => 'Expand All',
'LBL_WFE_COLLAPSE_ALL' => 'Collapse All',
'LBL_WFE_SEARCH' => 'Search',
'LBL_WFE_EVENTS' => 'Events',
'LBL_WFE_ACTIVITIES' => 'Activities',
'LBL_WFE_TASKS' => 'Tasks',
'LBL_WFE_RECYCLE_BIN' => 'Recycle Bin',
'LBL_WFE_DRAG_AND_DROP_ACTION' => 'Drag&Drop action',
'LBL_WFE_MOVE_NODE' => 'Move Node',
'LBL_WFE_CLONE_ONLY_NODE' => 'Clone Only Node',
'LBL_WFE_CLONE_NODE_AND_DESCENDANTS' => 'Clone Node And Descendants',
'LBL_WFE_DRAG_AND_DROP_CONTAINER' => 'Drag&Drop Container',
'LBL_WFE_WINDOW' => 'Window',
'LBL_WFE_PANEL' => 'Panel',
'LBL_WFE_EMPTY_ALL' => 'Empty All',
'LBL_WFE_EMPTY_EVENTS' => 'Empty Events',
'LBL_WFE_EMPTY_ACTIVITIES' => 'Empty Activities',
'LBL_WFE_EMPTY_TASKS' => 'Empty Tasks',
'LBL_WFE_REMOVE' => 'Remove',
'LBL_WFE_DELETE' => 'Delete',
'LBL_WFE_ARE_YOU_SURE' => 'Are you sure?',
'LBL_WFE_CLONE' => 'Clone',
'LBL_WFE_ONLY_NODE' => 'Only Node',
'LBL_WFE_NODE_AND_DESCENDANTS' => 'Node And Descendants',
'LBL_WFE_FULLSCREEN' => 'Fullscreen',
'LBL_WFE_MAXIMIZE' => 'Maximize',
'LBL_WFE_MINIMIZE' => 'Minimize',
'LBL_WFE_DELETE_RELATIONSHIP' => 'Delete Relationship',
'LBL_WFE_CLOSE_WFE' => 'Close WFE',
'LBL_WFE_ORDER_TASKS' => 'Order Tasks',
'LBL_WFE_CLOSE' => 'Close',
'LBL_WFE_CONDITIONS' => 'Conditions for ',
'LBL_WFE_WFM_MODULES_LOGIC_HOOK_ENABLED' => 'WFM modules logic-hook enabled ',
'LBL_WFE_WFM_MODULES_LOGIC_HOOK_ENABLED_WARNING_SLOW' => ' (WFE slow)',
'LBL_WFE_WFM_MODULES_LOGIC_HOOK_ENABLED_WARNING_FAST' => ' (WFE fast)',
'LBL_WFE_WFE_OPERATION_COUNTER_ERROR' => 'Error: Other user is modifying this WF. WFE is going to be reloaded.',
'LBL_WFE_GENERIC_ERROR' => 'Generic Error. WFE is going to be reloaded.',
'LBL_WFE_FATAL_ERROR' => 'Fatal Error. WFE is going to be reloaded.',

// Audit
'LBL_AUDIT_REPORT_PARENT_ID' => 'Parent Name',
'LBL_AUDIT_REPORT_DATA_TYPE' => 'Data type',
		
// WFM VARIABLE GENERATOR
'LBL_VG_VARIABLE_TYPES' => 'WFM variable types',
'LBL_VG_VARIABLE_TYPES_CUSTOM_VARIABLE_PREDEFINED' => 'Custom variable predefined (system) ',
'LBL_VG_VARIABLE_TYPES_CUSTOM_VARIABLE_USER_DEFINED' => 'Custom variable user defined',
'LBL_VG_VARIABLE_TYPES_DATES' => 'Dates',
'LBL_VG_VARIABLE_TYPES_DATA_SOURCE_IS_DATABASE' => 'Data source is "database"',
'LBL_VG_VARIABLE_TYPES_DATA_SOURCE_IS_FORM' => 'Data source is "form"',
'LBL_VG_FATAL_ERROR' => 'Fatal Error. Variable generator is going to be reloaded.',

);
?>
