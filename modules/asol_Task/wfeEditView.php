<?php 
require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

wfm_utils::wfm_log('debug', '$_REQUEST=['.var_export($_REQUEST, true).']', __FILE__, __METHOD__, __LINE__);

// FIXME sugarcrm 7.5
//require_once('include/Smarty/plugins/function.sugar_help.php');
//$sugar_smarty = new Sugar_Smarty();

global $mod_strings, $app_list_strings, $app_strings, $sugar_config;

$focus = new asol_Task();
$focusId = (isset($_REQUEST['record'])) ? $_REQUEST['record'] : '';

if (!empty($focusId)) { // Modify
	$focus->retrieve($focusId);
	
} else { // Create
	
}

// Get sugarcrm Theme
$themeObject = SugarThemeRegistry::current();
$css = $themeObject->getCSS();
$js = $themeObject->getJS();

?>

<html lang="<?php echo $sugar_config['default_language']; ?>">

	<head>
	
		<script	src="modules/asol_Process/___common_WFM/plugins_js_css_images/jsLab/LAB.min.js?version=<?php wfm_utils::echoVersionWFM(); ?>" ></script>
	
		<script>
			var viewType = 'wfeEditView';
		</script>
	
		<!-- BEGIN - SUGARCRM JS -->
			<?php 
				if (!is_file(sugar_cached("include/javascript/sugar_grp1.js")) || !is_file(sugar_cached("include/javascript/sugar_grp1_yui.js")) || !is_file(sugar_cached("include/javascript/sugar_grp1_jquery.js"))) {
					$_REQUEST['root_directory'] = ".";
					require_once("jssource/minify_utils.php");
					ConcatenateFiles(".");
				}
				if (is_file(sugar_cached("include/javascript/sugar_grp1_jquery.js"))) echo getVersionedScript('cache/include/javascript/sugar_grp1_jquery.js');
				echo getVersionedScript('cache/include/javascript/sugar_grp1_yui.js');
				echo getVersionedScript('cache/include/javascript/sugar_grp1.js');
				
				echo wfm_utils::_getModLanguageJS('asol_Task');
				echo wfm_utils::getAppStringsCache();
			?>
		<!-- END - SUGARCRM JS -->
		
		<script>
			if (typeof jQuery === "undefined") {
				$LAB.script("modules/asol_Process/___common_WFM/js/jquery.min.js");
			}
		</script>
	
		<!-- BEGIN - SUGARCRM THEME -->
			<?php echo $css; ?>
			<!-- <?php echo $js; ?>	 -->
		<!-- END - SUGARCRM THEME -->
		
		<script src="modules/asol_Events/js/module_fields.js?version=<?php wfm_utils::echoVersionWFM(); ?>" ></script>
		<script src="modules/asol_Task/js/asol_task.js?version=<?php wfm_utils::echoVersionWFM(); ?>" type="text/javascript"></script>
		<script src="modules/asol_Process/___common_WFM/js/common_event_activity_task.js?version=<?php wfm_utils::echoVersionWFM(); ?>" type="text/javascript"></script>
		
		<link href="modules/asol_Process/_flowChart/wfeEditView.css?version=<?php wfm_utils::echoVersionWFM(); ?>" rel="stylesheet" type="text/css" />
		<script	src='modules/asol_Process/_flowChart/wfeEditView.js?version=<?php wfm_utils::echoVersionWFM(); ?>'></script>
		
		<link href="modules/asol_Task/css/asol_task_style.css?version=<?php wfm_utils::echoVersionWFM(); ?>" rel="stylesheet" type="text/css" />
	</head>
	
	<body>
		<table cellspacing="1" cellpadding="0" width="100%" border="0" class="yui3-skin-sam edit view panelContainer" id="Default_asol_Process_Subpanel">
			<tbody>
				<tr>
					<td width="5%" valign="top" scope="col" id="id_label"> <?php echo $mod_strings['LBL_ID']; ?>: </td>
					<td width="20%" valign="top">
						<?php echo $focus->id; ?>
					</td>
					<?php
						if (wfm_domains_utils::wfm_isDomainsInstalled()) {
							echo "
								<td width='5%' valign='top' scope='col' id='asol_domain_name_label'>
									{$mod_strings['LBL_ASOL_DOMAIN_NAME']}
								</td>
								<td width='20%' valign='top'>
									{$focus->asol_domain_name}
								</td>
							";
						}
					?>
				</tr>
				<tr>
					<td width="5%" valign="top" scope="col" id="date_entered_label"> <?php echo $mod_strings['LBL_DATE_ENTERED']; ?>: </td>
					<td width="20%" valign="top">
						<?php echo $focus->date_entered; ?>
					</td>
					<td width="5%" valign="top" scope="col" id="date_modified_label"> <?php echo $mod_strings['LBL_DATE_MODIFIED']; ?>: </td>
					<td width="20%" valign="top">
						<?php echo $focus->date_modified; ?>
					</td>
				</tr>
				<tr>
					<td width="5%" valign="top" scope="col" id="created_by_name_label"> <?php echo $mod_strings['LBL_CREATED']; ?>: </td>
					<td width="20%" valign="top">
						<?php echo $focus->created_by_name; ?>
					</td>
					<td width="5%" valign="top" scope="col" id="modified_by_name_label"> <?php echo $mod_strings['LBL_MODIFIED_NAME']; ?>: </td>
					<td width="20%" valign="top">
						<?php echo $focus->modified_by_name; ?>
					</td>
				</tr>
			</tbody>
		</table>
		
		<br>
	
		<table style="width:100%">
			<tbody>
				<tr>
					<td>
					<div class="moduleTitle">
						<h2><span class="pointer">»</span><?php echo $app_strings['LBL_EDIT_BUTTON_LABEL']; ?> </h2>
					</div>
					<script>
						/*
		                $(document).ready(function() {
		                    $("ul.clickMenu").each(function(index, node) {
		                        $(node).sugarActionMenu();
		                    });
		                });
		                */
					</script><div class="clear"></div>
					<form id="EditView" name="EditView" method="POST" action="">
						<table cellspacing="0" cellpadding="0" width="100%" border="0" class="dcQuickEdit">
							<tbody>
								<tr>
									<td class="buttons">
										<input type="hidden" value="asol_Task" name="module">
										<input type="hidden" value="<?php echo $focus->id; ?>" name="record">
										<input type="hidden" value="false" name="isDuplicate">
										<input type="hidden" name="action">
										<input type="hidden" value="asol_Task" name="return_module">
										<input type="hidden" value="DetailView" name="return_action">
										<input type="hidden" value="14d56582-18e2-edd1-829d-542a75b6ca7e" name="return_id">
										<input type="hidden" name="module_tab">
										<input type="hidden" name="contact_role">
										<input type="hidden" value="asol_Task" name="relate_to">
										<input type="hidden" value="14d56582-18e2-edd1-829d-542a75b6ca7e" name="relate_id">
										<input type="hidden" value="1" name="offset">
										<!-- to be used for id for buttons with custom code in def files-->
										<div class="action_buttons">
											<input type="submit" id="SAVE_HEADER" value="<?php echo $app_strings['LBL_SAVE_BUTTON_LABEL']; ?>" name="button" class="button primary" accesskey="a" title="<?php echo $app_strings['LBL_SAVE_BUTTON_TITLE']; ?>" onclick="">
										</div>
									</td>
									<td align="right"></td>
								</tr>
							</tbody>
						</table>
						<span id="tabcounterJS">
							<script>
								/*
		                        SUGAR.TabFields = new Array();
		                        //this will be used to track tabindexes for references
		                        */
							</script>
						</span>
						<div id="EditView_tabs">
							<div>
								<div id="detailpanel_1">
									<table cellspacing="1" cellpadding="0" width="100%" border="0" class="yui3-skin-sam edit view panelContainer" id="Default_asol_Task_Subpanel">
										<tbody>
											<tr>
												<td width="5%" valign="top" scope="col" id="name_label"> <?php echo $mod_strings['LBL_NAME']; ?>: <span class="required">*</span></td>
												<td width="15%" valign="top">
													<?php require_once("modules/asol_Task/customFields/name.php"); ?>
												</td>
												
												<td width="5%" valign="top" scope="col" id="async_label">
													<?php echo $mod_strings['LBL_ASYNC']; ?>:<?php echo wfm_utils::smarty_function_sugar_help(array("text"=>$mod_strings['LBL_POPUPHELP_FOR_FIELD_ASYNC']),$sugar_smarty); ?> 
												</td>
												<td width="95%" valign="top" colspan="">
													<?php require_once("modules/asol_Task/customFields/async.php"); ?>
												</td>
											</tr>
											<tr>
												<td width="5%" valign="top" scope="col" id="delay_type_label">
													<?php echo $mod_strings['LBL_DELAY_TYPE']; ?>:<?php echo wfm_utils::smarty_function_sugar_help(array("text"=>$mod_strings['LBL_POPUPHELP_FOR_FIELD_DELAY_TYPE']),$sugar_smarty); ?> 
												</td>
												<td width="15%" valign="top" colspan="">
													<?php require_once("modules/asol_Task/customFields/delay_type.php"); ?>
												</td>
												
												<td width="5%" valign="top" scope="col" id="delay_label"> <?php echo $mod_strings['LBL_DELAY']; ?>: </td>
												<td width="15%" valign="top" >
													<?php require_once("modules/asol_Task/customFields/delay.php"); ?>
												</td>
												
												<td width="5%" valign="top" scope="col" id="date_label"> <?php echo $mod_strings['LBL_DATE']; ?>: </td>
												<td width="95%" valign="top" >
													<?php require_once("modules/asol_Task/customFields/date.php"); ?>
												</td>
											</tr>
											<tr>
												<td width="5%" valign="top" scope="col" id="description_label"> <?php echo $mod_strings['LBL_DESCRIPTION']; ?>: </td>
												<td width="15%" valign="top">
													<?php require_once("modules/asol_Process/customFields/description.php"); ?>
												</td>
												
												<td width="5%" valign="top" scope="col" id="task_order_label"> <?php echo $mod_strings['LBL_TASK_ORDER']; ?>: </td>
												<td width="95%" valign="top">
													<?php require_once("modules/asol_Task/customFields/task_order.php"); ?>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="edit view edit508  expanded" id="detailpanel_2">
									<h4>&nbsp;&nbsp; <a onclick="collapsePanel(2);" class="collapseLink" href="javascript:void(0)"> <img border="0" src="modules/asol_Process/___common_WFM/images/basic_search.gif?v=ttn-4I-G5zA_ijZVX7YRVg" id="detailpanel_2_img_hide"></a><a onclick="expandPanel(2);" class="expandLink" href="javascript:void(0)"> <img border="0" src="modules/asol_Process/___common_WFM/images/advanced_search.gif?v=ttn-4I-G5zA_ijZVX7YRVg" id="detailpanel_2_img_show"></a> <?php echo translate('LBL_TASK_IMPLEMENTATION_PANEL', 'asol_Task'); ?>
									<script>
		                                document.getElementById('detailpanel_2').className += ' expanded';
									</script></h4>
									<table cellspacing="1" cellpadding="0" width="100%" border="0" class="yui3-skin-sam edit view panelContainer" id="LBL_TASK_IMPLEMENTATION_PANEL">
										<tbody>
											<tr>
												
												<td width="5%" valign="top" scope="col" id="task_type_label">
													<?php echo $mod_strings['LBL_TASK_TYPE']; ?>:<?php echo wfm_utils::smarty_function_sugar_help(array("text"=>$mod_strings['LBL_POPUPHELP_FOR_FIELD_TASK_TYPE']),$sugar_smarty); ?> 
												</td>
												<td width="15%" valign="top" colspan="3">
													<?php require_once("modules/asol_Task/customFields/task_type.php"); ?>
												</td>
												
												<td width="5%" valign="top" scope="col" id="task_implementation_label">
													<?php echo $mod_strings['LBL_TASK_IMPLEMENTATION']; ?>:<?php echo wfm_utils::smarty_function_sugar_help(array("text"=>$mod_strings['LBL_POPUPHELP_FOR_FIELD_TASK_IMPLEMENTATION']),$sugar_smarty); ?> 
												</td>
												<td width="75%" valign="top" colspan="3">
													<?php require_once("modules/asol_Task/customFields/task_implementation.php"); ?>
												</td>
												
											</tr>
										</tbody>
									</table>
									<script type="text/javascript">
		                                SUGAR.util.doWhen("typeof initPanel == 'function'", function() {
		                                    initPanel(2, 'expanded');
		                                });
									</script>
								</div>
							</div>
						</div>
						<script language="javascript">
							/*
		                    var _form_id = 'EditView';
		
		                    SUGAR.util.doWhen(function() {
		                        _form_id = (_form_id == '') ? 'EditView' : _form_id;
		                        return document.getElementById(_form_id) != null;
		                    }, SUGAR.themes.actionMenu);
		                    */
		
						</script>
						<!-- to be used for id for buttons with custom code in def files-->
						<div class="buttons">
							<div class="action_buttons">
								<input type="submit" id="SAVE_FOOTER" value="<?php echo $app_strings['LBL_SAVE_BUTTON_LABEL']; ?>" name="button" class="button primary" accesskey="a" title="<?php echo $app_strings['LBL_SAVE_BUTTON_TITLE']; ?>" onclick="">
							</div>
						</div>
					</form>
					<script language="JavaScript" type="text/javascript"></script>
					<script>
						/*
		                SUGAR.util.doWhen("document.getElementById('EditView') != null", function() {
		                    SUGAR.util.buildAccessKeyLabels();
		                });
		                */
					</script>
					<script type="text/javascript">
						/*
		                YAHOO.util.Event.onContentReady("EditView", function() {
		                    initEditView(document.forms.EditView)
		                });
		                //window.setTimeout(, 100);
		                window.onbeforeunload = function() {
		                    return onUnloadEditView();
		                };
		                // bug 55468 -- IE is too aggressive with onUnload event
		                if ($.browser.msie) {
		                    $(document).ready(function() {
		                        $(".collapseLink,.expandLink").click(function(e) {
		                            e.preventDefault();
		                        });
		                    });
		                }
		                */
					</script>
					<script type="text/javascript">
		                addForm('EditView');
		                addToValidate('EditView', 'name', 'name', true, 'Name');
		                /*
		                addToValidate('EditView', 'date_entered_date', 'date', false, 'Date Created');
		                addToValidate('EditView', 'date_modified_date', 'date', false, 'Date Modified');
		                addToValidate('EditView', 'modified_user_id', 'assigned_user_name', false, 'Modified By');
		                addToValidate('EditView', 'modified_by_name', 'relate', false, 'Modified By');
		                addToValidate('EditView', 'created_by', 'assigned_user_name', false, 'Created By');
		                addToValidate('EditView', 'created_by_name', 'relate', false, 'Created By');
		                addToValidate('EditView', 'description', 'text', false, 'Description');
		                addToValidate('EditView', 'deleted', 'bool', false, 'Deleted');
		                addToValidate('EditView', 'assigned_user_id', 'relate', false, 'Assigned User Id');
		                addToValidate('EditView', 'assigned_user_name', 'relate', false, 'User');
		                addToValidate('EditView', 'delay_type', 'enum', false, 'Delay Type');
		                addToValidate('EditView', 'delay', 'varchar', false, 'Delay');
		                addToValidate('EditView', 'task_type', 'enum', false, 'Task Type');
		                addToValidate('EditView', 'task_order', 'int', false, 'Order');
		                addToValidate('EditView', 'task_implementation', 'text', false, 'Task Implementation');
		                addToValidate('EditView', 'asol_activity_asol_task_name', 'relate', false, 'Activity');
		                addToValidate('EditView', 'asol_process_asol_task_name', 'relate', false, 'Process');
		                addToValidateBinaryDependency('EditView', 'assigned_user_name', 'alpha', false, 'No match for field: Assigned to', 'assigned_user_id');
		                */
					</script>
					<?php 
						// WFM Variable Generator
						echo '<br>';
						echo wfm_reports_utils::managePremiumFeature("openWFMVariableGenerator", "wfm_utils_premium.php", "openWFMVariableGenerator", $extraParams);
					?>
					<script>
						/*
		                secondsSinceLoad = 0;
		                alertList = [];
		                if (!alertsTimeoutId) {
		                    checkAlerts();
		                }
		                */
					</script><!--end body panes--></td>
				</tr>
			</tbody>
		</table>
		
		<link href="modules/asol_Task/css/asol_task_style.css?version=<?php wfm_utils::echoVersionWFM(); ?>" rel="stylesheet" type="text/css" />
	</body>
	
</html>
