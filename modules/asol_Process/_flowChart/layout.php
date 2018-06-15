<?php 

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
require_once("modules/asol_Process/_flowChart/flowChartFunctions.php");

wfm_utils::set_error_reporting_level();

wfm_utils::cleanCacheIfNeeded();

global $sugar_config, $app_list_strings, $mod_strings, $db;

/* BEGIN - wfmModulesLogicHookEnabled */
$wfmModules = Array(
	'asol_Process' => 'asol_Process',
	'asol_Events' => 'asol_Events',
	'asol_Activity' => 'asol_Activity',
	'asol_Task' => 'asol_Task',
);

foreach ($wfmModules as $mod => $value) {
	$wfmModulesLogicHookEnabled = wfm_utils::hasLogicHook($mod);
	
	if ($wfmModulesLogicHookEnabled) {
		break;
	}
}

wfm_utils::setWfmModulesLogicHookEnabled(false);

if ($wfmModulesLogicHookEnabled && false) { // fix -> setWfmModulesLogicHookEnabled is not fast enough
	$wfmModulesLogicHookEnabledHtmlChecked = 'checked';
	$wfmModulesLogicHookEnabledWarning = translate('LBL_WFE_WFM_MODULES_LOGIC_HOOK_ENABLED_WARNING_SLOW', 'asol_Process');
} else {
	$wfmModulesLogicHookEnabledHtmlChecked = '';
	$wfmModulesLogicHookEnabledWarning = translate('LBL_WFE_WFM_MODULES_LOGIC_HOOK_ENABLED_WARNING_FAST', 'asol_Process');
}
/* END - wfmModulesLogicHookEnabled */

$site_url = (isset($sugar_config['WFM_site_url'])) ? $sugar_config['WFM_site_url'] : $sugar_config['site_url'];
$site_url = str_replace(array('https:', 'http:'), array('', ''), $site_url);// Avoid Blocked loading mixed active content

// workflowHeader

$processId = $_REQUEST['uid'];

$process_query = $db->query ("
								SELECT *
								FROM asol_process
								WHERE id = '{$processId}'
							");
$process_row = $db->fetchByAssoc($process_query);

$export_array['processes'][] = $process_row;

$wfe_operation_counter = intval($process_row['wfe_operation_counter']);

$data_source = $export_array['processes'][0]['data_source'];

switch($data_source) {
									
	case 'form':
		
		
		break;
		
	case 'database':
		
		$audit = $export_array['processes'][0]['audit'];
		$audit = ($audit == '1') ? true : false;
		
		$alternative_database = $export_array['processes'][0]['alternative_database'];
		
		break;
		
}



// DRAW PROCESS
if (!empty($export_array['processes'])) {
	$workflowHeader = generate_Process_HTML($export_array['processes'][0]['id'], $export_array['processes'][0]['name'], $export_array['processes'][0]['alternative_database'],$export_array['processes'][0]['trigger_module'],  $export_array['processes'][0]['status'], $export_array['processes'][0]['description'], $export_array['processes'][0]['async'], $export_array['processes'][0]['audit'], $export_array['processes'][0]['data_source'], $export_array['processes'][0]['asol_forms_id_c']);
}

?>

<!DOCTYPE html>
<HTML>
	<HEAD>
		<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	
		<TITLE><?php echo translate('LBL_WFE_WORKFLOW_EDITOR', 'asol_Process'); ?></TITLE>
		
		<link rel="icon" href="modules/asol_Process/___common_WFM/images/flowChart.png" type="image/png" sizes="16x16">
	
		<!-- ******************************** BEGIN CSS ************************************* -->
	
			<link rel="stylesheet" type="text/css" href="modules/asol_Process/___common_WFM/plugins_js_css_images/jquery.ui/css/jquery.ui.min.css?version=<?php wfm_utils::echoVersionWFM(); ?>">
			<link rel="stylesheet" type="text/css" href="modules/asol_Process/___common_WFM/plugins_js_css_images/layout/layout-default.css?version=<?php wfm_utils::echoVersionWFM(); ?>">
			<link rel="stylesheet" type="text/css" href='modules/asol_Process/___common_WFM/plugins_js_css_images/qTip2/jquery.qtip.min.css?version=<?php wfm_utils::echoVersionWFM(); ?>'>
			
			<link rel="stylesheet" type="text/css" href="modules/asol_Process/_flowChart/layout.css?version=<?php wfm_utils::echoVersionWFM(); ?>">
			<link rel="stylesheet" type="text/css" href='modules/asol_Process/_flowChart/flowChart.css?version=<?php wfm_utils::echoVersionWFM(); ?>'>
		
		<!-- ******************************** END CSS ************************************* -->
	
		<!-- ******************************** BEGIN JS ************************************* -->
	
			<script src="modules/asol_Process/___common_WFM/plugins_js_css_images/jsLab/LAB.min.js?version=<?php wfm_utils::echoVersionWFM(); ?>" ></script>
			<script	src="modules/asol_Process/___common_WFM/js/jquery.min.js?version=<?php wfm_utils::echoVersionWFM(); ?>"	></script>
			
		
	
			<!-- BEGIN - CONFIGURATION -->
				<script>
					var site_url = '<?php echo $site_url; ?>';
					var entryPoint = 'wfm_flowChartActions';
					var uid = '<?php echo $_REQUEST['uid']; ?>';
					var wfe_operation_counter = <?php echo $wfe_operation_counter; ?>;
				
				</script>
			<!-- END - CONFIGURATION -->
			
			<!-- BEGIN - SUGARCRM JS -->
				<?php 
					if (!is_file(sugar_cached("include/javascript/sugar_grp1.js")) || !is_file(sugar_cached("include/javascript/sugar_grp1_yui.js")) || !is_file(sugar_cached("include/javascript/sugar_grp1_jquery.js"))) {
						$_REQUEST['root_directory'] = ".";
						require_once("jssource/minify_utils.php");
						ConcatenateFiles(".");
					}
					//if (is_file(sugar_cached("include/javascript/sugar_grp1_jquery.js"))) echo getVersionedScript('cache/include/javascript/sugar_grp1_jquery.js');
					echo getVersionedScript('cache/include/javascript/sugar_grp1_yui.js');
					echo getVersionedScript('cache/include/javascript/sugar_grp1.js');
					
					echo wfm_utils::_getModLanguageJS('asol_Process');
				?>
			<!-- END - SUGARCRM JS -->
			
			<script>
				//if (typeof jQuery === "undefined") {
					//$LAB.script("modules/asol_Process/___common_WFM/js/jquery.min.js");
				//}
			</script>
			
			<!-- BEGIN - General -->
			
				<script src="modules/asol_Process/___common_WFM/plugins_js_css_images/jquery.ui/js/jquery.ui.min.js?version=<?php wfm_utils::echoVersionWFM(); ?>" ></script>
				<script	src='modules/asol_Process/___common_WFM/js/jquery.ui-contextmenu.min.js?version=<?php wfm_utils::echoVersionWFM(); ?>' ></script>
				<script	src="modules/asol_Process/___common_WFM/plugins_js_css_images/jquery.blockUI/jquery.blockUI.js?version=<?php wfm_utils::echoVersionWFM(); ?>" ></script>
				<script src="modules/asol_Process/___common_WFM/plugins_js_css_images/layout/jquery.layout-1.4.3.js?version=<?php wfm_utils::echoVersionWFM(); ?>"></script>
				<script src="modules/asol_Process/___common_WFM/plugins_js_css_images/layout/plugins/jquery.layout.resizePaneAccordions-1.2.min.js?version=<?php wfm_utils::echoVersionWFM(); ?>"></script>
				<script src="modules/asol_Process/___common_WFM/plugins_js_css_images/jstree/jquery.jstree.js?version=<?php wfm_utils::echoVersionWFM(); ?>"></script>
				<script	src='modules/asol_Process/___common_WFM/js/jquery.jsPlumb.min.js?version=<?php wfm_utils::echoVersionWFM(); ?>' ></script>
				<script	src='modules/asol_Process/___common_WFM/plugins_js_css_images/qTip2/jquery.qtip.min.js?version=<?php wfm_utils::echoVersionWFM(); ?>' ></script>
				<script	src='modules/asol_Process/___common_WFM/js/screenfull.min.js?version=<?php wfm_utils::echoVersionWFM(); ?>' ></script>
				
				<script src="modules/asol_Process/_flowChart/layout.js?version=<?php wfm_utils::echoVersionWFM(); ?>" ></script>
				<script	src='modules/asol_Process/_flowChart/flowChart.js?version=<?php wfm_utils::echoVersionWFM(); ?>' ></script>
				
			<!-- END - General -->
		
		<!-- ******************************** END JAVASCRIPT ************************************* -->
	
	</HEAD>
	
<BODY>

	<DIV id="workflow" class="ui-layout-center">
		<div id="workflowHeader" class="ui-widget-header">
			
			<!-- FLOAT RIGHT -->
			<span id="workflowHeaderStaticContent" style="float: right;">
				<img id="minimize" class="" src="modules/asol_Process/_flowChart/images/minimize.png" alt="<?php echo translate('LBL_WFE_MINIMIZE', 'asol_Process'); ?>" title="<?php echo translate('LBL_WFE_MINIMIZE', 'asol_Process'); ?>" />
				<img id="maximize" class="" src="modules/asol_Process/_flowChart/images/maximize.png" alt="<?php echo translate('LBL_WFE_MAXIMIZE', 'asol_Process'); ?>" title="<?php echo translate('LBL_WFE_MAXIMIZE', 'asol_Process'); ?>" />
			</span>
			
			<span id="workflowHeaderDynamicContent">
				<?php echo $workflowHeader; ?>
			</span>
			
		</div>
		
		<div id="workflowContent" class="ui-layout-content" style="overflow: auto">
		</div>
	</DIV>
	
	<DIV class="ui-layout-west">
		<div class="ui-widget-header">
			<img src="modules/asol_Process/_flowChart/images/new_24px.png" title=""/>
			<span><?php echo translate('LBL_WFE_NEW', 'asol_Process'); ?></span>
			<img id="expand_all" class="" src="modules/asol_Process/___common_WFM/images/expand_all.gif" title="<?php echo translate('LBL_WFE_EXPAND_ALL', 'asol_Process'); ?>" onclick="$('#newObjects').jstree('open_all');" />
			<img id="collapse_all" class="" src="modules/asol_Process/___common_WFM/images/collapse_all.gif" title="<?php echo translate('LBL_WFE_COLLAPSE_ALL', 'asol_Process'); ?>" onclick="$('#newObjects').jstree('close_all');" />
		</div>
	
		<div class="ui-layout-content">
			
			<input id="jstree_search" class="clearable" type="text" placeholder="<?php echo translate('LBL_WFE_SEARCH', 'asol_Process'); ?>"  value="">
			
			<div id="newObjects">
				<ul>
					<li rel="asol_Event" >
						<a href="#"><?php echo translate('LBL_WFE_EVENTS', 'asol_Process'); ?></a>
						<ul>
						
							<?php 
							
								switch($data_source) {
									
									case 'form':
										
										foreach ($app_list_strings['wfm_trigger_event_list_for_data_source_form'] as $key => $value) {
											echo "
												<li rel='asol_Events_'>
													<a href='#' layoutId='newObjects' module='asol_Events' trigger_type='logic_hook' trigger_event='{$key}' scheduled_type='' subprocess_type=''>
														{$app_list_strings['wfm_trigger_type_list']['logic_hook']}
														{$app_list_strings['wfm_trigger_event_list'][$key]}
													</a>
												</li>
											";
										}
										
										break;
										
									case 'database':
										
										if ((!$audit) && ($alternative_database == '-1')) {
											echo "
												<li rel='asol_Events_'>
													<a href='#' layoutId='newObjects' module='asol_Events' trigger_type='logic_hook' trigger_event='on_create' scheduled_type='' subprocess_type=''>
														{$app_list_strings['wfm_trigger_type_list']['logic_hook']}
														{$app_list_strings['wfm_trigger_event_list']['on_create']}
													</a>
												</li>
												<li rel='asol_Events_'>
													<a href='#' layoutId='newObjects' module='asol_Events' trigger_type='logic_hook' trigger_event='on_modify' scheduled_type='' subprocess_type=''>
														{$app_list_strings['wfm_trigger_type_list']['logic_hook']}
														{$app_list_strings['wfm_trigger_event_list']['on_modify']}
													</a>
												</li>
												<li rel='asol_Events_'>
													<a href='#' layoutId='newObjects' module='asol_Events' trigger_type='logic_hook' trigger_event='on_delete' scheduled_type='' subprocess_type=''>
														{$app_list_strings['wfm_trigger_type_list']['logic_hook']}
														{$app_list_strings['wfm_trigger_event_list']['on_delete']}
													</a>
												</li>
											";
										}
										
										echo "
											<li rel='asol_Events_'>
												<a href='#' layoutId='newObjects' module='asol_Events' trigger_type='scheduled' trigger_event='' scheduled_type='sequential' subprocess_type=''>
													{$app_list_strings['wfm_trigger_type_list']['scheduled']}
													{$app_list_strings['wfm_scheduled_type_list']['sequential']}
												</a>
											</li>
											<li rel='asol_Events_'>
												<a href='#' layoutId='newObjects' module='asol_Events' trigger_type='scheduled' trigger_event='' scheduled_type='parallel' subprocess_type=''>
													{$app_list_strings['wfm_trigger_type_list']['scheduled']}
													{$app_list_strings['wfm_scheduled_type_list']['parallel']}
												</a>
											</li>
										";
										
										break;
								}
							
							?>
							
							<li rel="asol_Events_">
								<a href="#" layoutId="newObjects" module="asol_Events" trigger_type="subprocess" trigger_event="" scheduled_type="" subprocess_type="sequential">
									<?php echo "
										{$app_list_strings['wfm_trigger_type_list']['subprocess']}
										{$app_list_strings['wfm_subprocess_type_list']['sequential']}
									"; ?>
								</a>
							</li>
							<li rel="asol_Events_">
								<a href="#" layoutId="newObjects" module="asol_Events" trigger_type="subprocess" trigger_event="" scheduled_type="" subprocess_type="parallel">
									<?php echo "
										{$app_list_strings['wfm_trigger_type_list']['subprocess']}
										{$app_list_strings['wfm_subprocess_type_list']['parallel']}
									"; ?>
								</a>
							</li>
							<li rel="asol_Events_">
								<a href="#" layoutId="newObjects" module="asol_Events" trigger_type="subprocess_local" trigger_event="" scheduled_type="" subprocess_type="sequential">
									<?php echo "
										{$app_list_strings['wfm_trigger_type_list']['subprocess_local']}
										{$app_list_strings['wfm_subprocess_type_list']['sequential']}
									"; ?>
								</a>
							</li>
							<li rel="asol_Events_">
								<a href="#" layoutId="newObjects" module="asol_Events" trigger_type="subprocess_local" trigger_event="" scheduled_type="" subprocess_type="parallel">
									<?php echo "
										{$app_list_strings['wfm_trigger_type_list']['subprocess_local']}
										{$app_list_strings['wfm_subprocess_type_list']['parallel']}
									"; ?>
								</a>
							</li>
						</ul>
					</li>
					
					<li rel="asol_Activity">
						<a href="#"><?php echo translate('LBL_WFE_ACTIVITIES', 'asol_Process'); ?></a>
						<ul>
							<li rel="asol_Activity_1">
								<a href="#" layoutId="newObjects" module="asol_Activity" type="foreach_ingroup"><?php echo $app_list_strings['wfm_activity_type_list']['foreach_ingroup']; ?></a>
							</li>
						</ul>
					</li>
					
					<li rel="asol_Task">
						<a href="#"><?php echo translate('LBL_WFE_TASKS', 'asol_Process'); ?></a>
						<ul>
							
							<?php
							
								$task_type_list = wfm_utils::getTaskTypeList($data_source, $audit, $alternative_database);
								
								foreach ($task_type_list as $task_type => $label) {
									echo "
										<li rel='asol_Task_{$task_type}'>
											<a href='#' layoutId='newObjects' layoutId='newObjects' module='asol_Task' task_type='{$task_type}'>
												{$app_list_strings['wfm_task_type_list'][$task_type]}
											</a>
										</li>
									";
								}
							
							 ?>
						</ul>
					</li>
				</ul>
			</div>
			
		</div>
	</DIV>
	
	<DIV id="recycleBin" class="ui-layout-east">
		<div class="ui-widget-header">
			<img id="recycleBinIcon" src="modules/asol_Process/_flowChart/images/recycleBinEmpty_24px.png" title="" />
			<span><?php echo translate('LBL_WFE_RECYCLE_BIN', 'asol_Process'); ?></span>
		</div>
		
		<div class="ui-layout-content">
			<div id="accordion" class="basic">
	
				<h3><a href="#"><?php echo translate('LBL_WFE_EVENTS', 'asol_Process'); ?></a></h3>
				<div id="recycleBinEvents" class="recycleBin" >
					
				</div>
	
				<h3><a href="#"><?php echo translate('LBL_WFE_ACTIVITIES', 'asol_Process'); ?></a></h3>
				<div id="recycleBinActivities" class="recycleBin" >
					
				</div>
	
				<h3><a href="#"><?php echo translate('LBL_WFE_TASKS', 'asol_Process'); ?></a></h3>
				<div id="recycleBinTasks" class="recycleBin" >
					
				</div>
	
			</div>
		</div>
	</DIV>
	
	<DIV class="ui-layout-north"> 
		<div class="control_panel">
			<span class="control_panel_action">
				<img id="flowchart_info" class="control_panel_icon nice persistent" src="modules/asol_Process/___common_WFM/images/flowchart_info.png" alt="<?php echo translate('LBL_ASOL_INFO_TITLE', 'asol_Process'); ?>" title="<?php echo translate('LBL_ASOL_INFO_TITLE', 'asol_Process'); ?>" />
			</span>
			<span class="control_panel_action">
				<img class="control_panel_icon" id="refresh" src="modules/asol_Process/___common_WFM/images/flowchart_refresh.png" alt="<?php echo translate('LBL_ASOL_REFRESH', 'asol_Process'); ?>" title="<?php echo translate('LBL_ASOL_REFRESH', 'asol_Process'); ?>" onclick="refreshWfe();" />
			</span>
			<span class="control_panel_action">
				<img class="control_panel_icon" src="modules/asol_Process/___common_WFM/images/overflow_ellipsis.png" alt="<?php echo translate('LBL_ASOL_TEXT_OVERFLOW_ELLIPSIS', 'asol_Process'); ?>" title="<?php echo translate('LBL_ASOL_TEXT_OVERFLOW_ELLIPSIS', 'asol_Process'); ?>" onclick="toggleEllipsis();" />
			</span>
			
			<HR width=1, size=14 class="hr_effect"> 
			
			<span class="control_panel_action">
				<label for="dragAndDropAction"><?php echo translate('LBL_WFE_DRAG_AND_DROP_ACTION', 'asol_Process'); ?>:</label>
				<select name="dragAndDropAction" id="dragAndDropAction">
					<option value="moveNode" selected><?php echo translate('LBL_WFE_MOVE_NODE', 'asol_Process'); ?></option>
					<option value="cloneOnlyNode" ><?php echo translate('LBL_WFE_CLONE_ONLY_NODE', 'asol_Process'); ?></option>
					<option value="cloneNodeAndDescendants" ><?php echo translate('LBL_WFE_CLONE_NODE_AND_DESCENDANTS', 'asol_Process'); ?></option>
					<option value="orderTasks" ><?php echo translate('LBL_WFE_ORDER_TASKS', 'asol_Process'); ?></option>
				</select>
			</span>
			
			<HR width=1, size=14 class="hr_effect"> 
			
			<span class="control_panel_action">
				<label for="dragAndDropContainer"><?php echo translate('LBL_WFE_DRAG_AND_DROP_CONTAINER', 'asol_Process'); ?>:</label>
				<select name="dragAndDropContainer" id="dragAndDropContainer">
					<option value="window" ><?php echo translate('LBL_WFE_WINDOW', 'asol_Process'); ?></option>
					<option value="panel" ><?php echo translate('LBL_WFE_PANEL', 'asol_Process'); ?></option>
				</select>
			</span>
			
			<HR width=1, size=14 class="hr_effect">
				
			<span class="control_panel_action">
				<label for="wfmModulesLogicHookEnabled"><?php echo translate('LBL_WFE_WFM_MODULES_LOGIC_HOOK_ENABLED', 'asol_Process'); ?>:</label>
				<input type="checkbox" id="wfmModulesLogicHookEnabled" <?php echo $wfmModulesLogicHookEnabledHtmlChecked; ?> />
				<label for="wfmModulesLogicHookEnabled" id="wfmModulesLogicHookEnabledWarning"><?php echo $wfmModulesLogicHookEnabledWarning; ?></label>
			</span>
			
			<HR width=1, size=14 class="hr_effect">
			
			<!-- FLOAT RIGHT -->
			<span class="control_panel_action" style="float: right; margin-top: 1px;">
				<img id="closeWFE" class="control_panel_icon nice persistent" src="modules/asol_Process/_flowChart/images/closeWindow.png" alt="<?php echo translate('LBL_WFE_CLOSE_WFE', 'asol_Process'); ?>" title="<?php echo translate('LBL_WFE_CLOSE_WFE', 'asol_Process'); ?>" />
			</span>
			<span class="control_panel_action" style="float: right; margin-top: 1px;">
				<img id="fullscreen" class="control_panel_icon nice persistent" src="modules/asol_Process/_flowChart/images/fullscreen.png" alt="<?php echo translate('LBL_WFE_FULLSCREEN', 'asol_Process'); ?>" title="<?php echo translate('LBL_WFE_FULLSCREEN', 'asol_Process'); ?>" />
			</span>
			<hr width="1," size="14" class="hr_effect" style="display: inline; float: right; width: 4px; margin-top: 0px; height: 22px;">
			<span class="" style="float: right; margin-top: 1px;">
				<img class="control_panel_icon nice persistent" src="modules/asol_Process/_flowChart/images/alinea1.png" style="width: auto;" />
			</span>
		</div>
	</DIV>
	
	<IFRAME  id="objectEditor" class="ui-layout-south" scrolling="auto" src="">
	</IFRAME>
	 
	<style>
		.helperForJstree .jstree-default li, .helperForJstree  .jstree-default ins {
			background-image: none;
		}
		
		.helperForJstree.jstree li {
			margin-left: 0;
		} 
	</style>
	 
	</BODY>
</HTML>