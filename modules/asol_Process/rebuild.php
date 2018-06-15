<?php

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
wfm_utils::wfm_log('debug', 'ENTRY', __FILE__);

wfm_utils::wfm_log('debug', '$_REQUEST=['.var_export($_REQUEST, true).']', __FILE__, __METHOD__, __LINE__);

global $mod_strings, $current_user, $app_list_strings;

$modules_all = ACLAction::getUserActions($current_user->id);
						
$logic_hooks_for_all_modules = Array('before_save', 'after_save', 'before_delete');
$logic_hooks_for_only_module_users = Array('after_login', 'before_logout', 'login_failed');
$logic_hooks_for_only_modules_calls_and_tasks = Array('after_save', 'before_delete');

$action_execute_process = array(2, "wfm_hook", "custom/include/wfm_hook.php", "wfm_hook_process", "execute_process"); // 2 instead 1 because of on_hold
$action_wakeup_on_hold = array(1, "WakeUp Holded Item", "custom/include/wfm_on_hold.php", "wfm_hook_on_hold", "wakeup_on_hold");



$lengthModules = count($modules_all);

if (isset($_REQUEST['update_logic_hooks'])) {
	
	$action = "action_execute_process";
	
	foreach ($modules_all as $moduleKey => $moduleValue) {
		foreach ($logic_hooks_for_all_modules as $logic_hook) {
			if (isset($_REQUEST["check_{$moduleKey}_{$logic_hook}_{$action}"])) {
				check_logic_hook_file($moduleKey, $logic_hook, $action_execute_process);
			} else {
				remove_logic_hook($moduleKey, $logic_hook, $action_execute_process);
			}
		}
	}
	
	$moduleKey = 'Users';
	
	foreach ($logic_hooks_for_only_module_users as $logic_hook_for_only_module_users) {
		if (isset($_REQUEST["check_{$moduleKey}_{$logic_hook_for_only_module_users}_{$action}"])) {
			check_logic_hook_file($moduleKey, $logic_hook_for_only_module_users, $action_execute_process);
		} else {
			remove_logic_hook($moduleKey, $logic_hook_for_only_module_users, $action_execute_process);
		}
	}
	
	$action = "action_wakeup_on_hold";
	
	$moduleKey = 'Calls';
	
	foreach ($logic_hooks_for_only_modules_calls_and_tasks as $logic_hook_for_only_modules_calls_and_tasks) {
		if (isset($_REQUEST["check_{$moduleKey}_{$logic_hook_for_only_modules_calls_and_tasks}_{$action}"])) {
			check_logic_hook_file($moduleKey, $logic_hook_for_only_modules_calls_and_tasks, $action_wakeup_on_hold);
		} else {
			remove_logic_hook($moduleKey, $logic_hook_for_only_modules_calls_and_tasks, $action_wakeup_on_hold);
		}
	}
	
	$moduleKey = 'Tasks';
	
	foreach ($logic_hooks_for_only_modules_calls_and_tasks as $logic_hook_for_only_modules_calls_and_tasks) {
		if (isset($_REQUEST["check_{$moduleKey}_{$logic_hook_for_only_modules_calls_and_tasks}_{$action}"])) {
			check_logic_hook_file($moduleKey, $logic_hook_for_only_modules_calls_and_tasks, $action_wakeup_on_hold);
		} else {
			remove_logic_hook($moduleKey, $logic_hook_for_only_modules_calls_and_tasks, $action_wakeup_on_hold);
		}
	}
	
}

?>

<link href="modules/asol_Process/css/asol_process_style.css?version=<?php  echo wfm_utils::echoVersionWFM(); ?>" rel="stylesheet" type="text/css" />
<script src="modules/asol_Process/___common_WFM/js/jquery.min.js?version=<?php wfm_utils::echoVersionWFM(); ?>" type="text/javascript"></script>
<script src="modules/asol_Process/js/rebuild.js?version=<?php wfm_utils::echoVersionWFM(); ?>" type="text/javascript"></script>

<div>
	<div>
		<h1><?php echo $mod_strings['LBL_ASOL_REBUILD_TITLE']; ?></h1>
	</div>
</div>
<br>
<div>
	<form action="index.php?module=asol_Process&action=rebuild" method='post' enctype='multipart/form-data'>
		<input type='hidden' name="update_logic_hooks" />
		<div>
			
			<h3>
				action=execute_process (<?php echo $mod_strings['LBL_REBUILD_SUBTITLE_1']; ?>)
			</h3>
			
			<table id="table_1" class="wfm_rebuild_logic_hooks">
				<thead>
					<tr class='wfm_validate_border_bottom'>
						<th>
							<input id="check_uncheck_all_modules_1"  type='checkbox' title="check_uncheck_all_modules" />
						</th>
						<th>
							<?php echo $mod_strings['LBL_TRIGGER_MODULE']; ?>
						</th>
						<th>
							before_save
						</th>
						<th>
							after_save
						</th>
						<th>
							before_delete
						</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					
						$action = "action_execute_process";
					
						$moduleIteration = 1;
						
						foreach ($modules_all as $moduleKey => $moduleValue) {
							
							$row = ($moduleIteration < $lengthModules) ? "<tr class='wfm_validate_border_bottom'>" : "<tr>";
							
							$moduleLabel = (isset($app_list_strings['moduleList'][$moduleKey])) ? $app_list_strings['moduleList'][$moduleKey] : $moduleKey;
							
							$row .= "<td>";
							$row .= "	<input class='check_uncheck_this_module_1' module='{$moduleKey}' type='checkbox' title='check_uncheck_this_module' />";
							$row .= "</td>";
							
							$row .= "<td>";
							$row .= $moduleLabel;
							$row .= "</td>";
							
							foreach ($logic_hooks_for_all_modules as $logic_hook) {
								$hasLogicHook = wfm_utils::hasLogicHook($moduleKey, $logic_hook, $action_execute_process);
								
								$checked = ($hasLogicHook) ? "checked" : "";
								
								$row .= "<td>";
								$row .= "	<input class='logic_hook' module='{$moduleKey}' type='checkbox' name='check_{$moduleKey}_{$logic_hook}_{$action}' {$checked} />";
								$row .= "</td>";
							}
							
							$row .= "</tr>";
							
							$moduleIteration++;
							
							echo $row;
						}
					?>
				</tbody>
			</table>
			
			<br>
			
			<h3>
				action=execute_process (<?php echo $mod_strings['LBL_REBUILD_SUBTITLE_1']; ?>)
			</h3>
			
			<table id="table_2" class="wfm_rebuild_logic_hooks">
				<thead>
					<tr class='wfm_validate_border_bottom'>
						<th>
							<input id="check_uncheck_all_modules_2"  type='checkbox' title="check_uncheck_all_modules" />
						</th>
						<th>
							<?php echo $mod_strings['LBL_TRIGGER_MODULE']; ?>
						</th>
						<th>
							after_login
						</th>
						<th>
							before_logout
						</th>
						<th>
							login_failed
						</th>
					</tr>
				</thead>
				<tbody>
					<?php 
							
						$action = "action_execute_process";
						
						$moduleKey = 'Users';
						
						$row = "<tr>";
						
						$moduleLabel = (isset($app_list_strings['moduleList'][$moduleKey])) ? $app_list_strings['moduleList'][$moduleKey] : $moduleKey;
						
						$row .= "<td>";
						$row .= "	<input class='check_uncheck_this_module_2' module='{$moduleKey}' type='checkbox' title='check_uncheck_this_module' />";
						$row .= "</td>";
						
						$row .= "<td>";
						$row .= $moduleLabel;
						$row .= "</td>";
							
						foreach ($logic_hooks_for_only_module_users as $logic_hook_for_only_module_users) {
							$hasLogicHook = wfm_utils::hasLogicHook($moduleKey, $logic_hook_for_only_module_users, $action_execute_process);
						
							$checked = ($hasLogicHook) ? "checked" : "";
							$value_displayed = (isset($app_list_strings['moduleList'][$moduleKey])) ? $app_list_strings['moduleList'][$moduleKey] : $moduleKey;
							
							$row .= "<td>";
							$row .= "	<input class='logic_hook' module='{$moduleKey}' type='checkbox' name='check_{$moduleKey}_{$logic_hook_for_only_module_users}_{$action}' {$checked} />";
							$row .= "</td>";
						}
							
						$row .= "</tr>";
						
						echo $row;
						
					?>
				</tbody>
			</table>
			
			<br>
			
			<h3>
				action=wakeup_on_hold (<?php echo $mod_strings['LBL_REBUILD_SUBTITLE_2']; ?>)
			</h3>
			
			<table id="table_3" class="wfm_rebuild_logic_hooks">
				<thead>
					<tr class='wfm_validate_border_bottom'>
						<th>
							<input id="check_uncheck_all_modules_3"  type='checkbox' title="check_uncheck_all_modules" />
						</th>
						<th>
							<?php echo $mod_strings['LBL_TRIGGER_MODULE']; ?>
						</th>
						<th>
							after_save
						</th>
						<th>
							before_delete
						</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					
						$action = "action_wakeup_on_hold";
							
						$moduleKey = 'Calls';
						
						$row = "<tr>";
						
						$moduleLabel = (isset($app_list_strings['moduleList'][$moduleKey])) ? $app_list_strings['moduleList'][$moduleKey] : $moduleKey;
						
						$row .= "<td>";
						$row .= "	<input class='check_uncheck_this_module_3' module='{$moduleKey}' type='checkbox' title='check_uncheck_this_module' />";
						$row .= "</td>";
						
						$row .= "<td>";
						$row .= $moduleLabel;
						$row .= "</td>";
							
						foreach ($logic_hooks_for_only_modules_calls_and_tasks as $logic_hook_for_only_modules_calls_and_tasks) {
							$hasLogicHook = wfm_utils::hasLogicHook($moduleKey, $logic_hook_for_only_modules_calls_and_tasks, $action_wakeup_on_hold);
						
							$checked = ($hasLogicHook) ? "checked" : "";
							$value_displayed = (isset($app_list_strings['moduleList'][$moduleKey])) ? $app_list_strings['moduleList'][$moduleKey] : $moduleKey;
							
							$row .= "<td>";
							$row .= "	<input class='logic_hook' module='{$moduleKey}' type='checkbox' name='check_{$moduleKey}_{$logic_hook_for_only_modules_calls_and_tasks}_{$action}' {$checked} />";
							$row .= "</td>";
						}
							
						$row .= "</tr>";
						
						echo $row;
						
					?>
					
					<?php 
					
						$action = "action_wakeup_on_hold";
							
						$moduleKey = 'Tasks';
						
						$row = "<tr>";
						
						$moduleLabel = (isset($app_list_strings['moduleList'][$moduleKey])) ? $app_list_strings['moduleList'][$moduleKey] : $moduleKey;
						
						$row .= "<td>";
						$row .= "	<input class='check_uncheck_this_module_3' module='{$moduleKey}' type='checkbox' title='check_uncheck_this_module' />";
						$row .= "</td>";
						
						$row .= "<td>";
						$row .= $moduleLabel;
						$row .= "</td>";
							
						foreach ($logic_hooks_for_only_modules_calls_and_tasks as $logic_hook_for_only_modules_calls_and_tasks) {
							$hasLogicHook = wfm_utils::hasLogicHook($moduleKey, $logic_hook_for_only_modules_calls_and_tasks, $action_wakeup_on_hold);
						
							$checked = ($hasLogicHook) ? "checked" : "";
							$value_displayed = (isset($app_list_strings['moduleList'][$moduleKey])) ? $app_list_strings['moduleList'][$moduleKey] : $moduleKey;
							
							$row .= "<td>";
							$row .= "	<input class='logic_hook' module='{$moduleKey}' type='checkbox' name='check_{$moduleKey}_{$logic_hook_for_only_modules_calls_and_tasks}_{$action}' {$checked} />";
							$row .= "</td>";
						}
							
						$row .= "</tr>";
						
						echo $row;
						
					?>
				</tbody>
			</table>
			
		</div>
		<br>
		<br>
		<div>
			<input type='submit' value='<?php echo $mod_strings['LBL_ASOL_REBUILD_SEND']; ?>' />
		</div>
		
	</form>
</div>

<br>
<br>

<?php 
	echo '<code>gmdate=['.gmdate('Y-m-d H:i:s').']</code>';
?>