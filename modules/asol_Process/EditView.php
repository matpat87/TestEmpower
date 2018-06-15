<?php 
require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

require_once("modules/asol_Process/___common_WFM/php/checkConfigurationDefsFunctions.php");

if (wfm_utils::isCommonBaseInstalled()) {
	wfm_utils::initWFMFunctions();
} else {
	echo asol_CheckConfigurationDefsFunctions::checkModuleDependence('AlineaSolCommonBase', wfm_utils::$common_version, true);
	return;
}

wfm_utils::wfm_log('debug', '$_REQUEST=['.var_export($_REQUEST, true).']', __FILE__, __METHOD__, __LINE__);

// FIXME sugarcrm 7.5 compatibility
//require_once('include/Smarty/plugins/function.sugar_help.php');
//$sugar_smarty = new Sugar_Smarty();

global $mod_strings, $app_list_strings, $app_strings;

$focus = new asol_Process();
$focusId = (isset($_REQUEST['record'])) ? $_REQUEST['record'] : '';

if (!empty($focusId)) { // Modify
	$focus->retrieve($focusId);
	
	$validationForTriggerModule = '';
} else { // Create
	$validationForTriggerModule = "addToValidate('EditView', 'trigger_module', 'enum', false, 'Module');";
}

// Get sugarcrm Theme
$themeObject = SugarThemeRegistry::current();
$css = $themeObject->getCSS();
$js = $themeObject->getJS();

?>

<html>

	<head>
		
		<script	src="modules/asol_Process/___common_WFM/plugins_js_css_images/jsLab/LAB.min.js?version=<?php wfm_utils::echoVersionWFM(); ?>" ></script>
		
		<script>
			var viewType = 'EditView';
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
				
				echo wfm_utils::_getModLanguageJS('asol_Process');
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
		
		<link href="modules/asol_Process/_flowChart/wfeEditView.css?version=<?php wfm_utils::echoVersionWFM(); ?>" rel="stylesheet" type="text/css" />
		<script	src='modules/asol_Process/_flowChart/wfeEditView.js?version=<?php wfm_utils::echoVersionWFM(); ?>'></script>
		
		<link href="modules/asol_Process/css/asol_process_style.css?version=<?php wfm_utils::echoVersionWFM(); ?>" rel="stylesheet" type="text/css" />
		
	</head>
	
	<body>
		<table style="width:100%">
			<tbody>
				<tr>
					<td>
					<div class="moduleTitle">
						<h2><span class="pointer">»</span><?php echo $app_strings['LBL_EDIT_BUTTON_LABEL']; ?></h2>
					</div>
					<script>
						/*
                        $(document).ready(function() {
                            $("ul.clickMenu").each(function(index, node) {
                                $(node).sugarActionMenu();
                            });
                        });
                        */
					</script>
					<div class="clear"></div>
					<form id="EditView" name="EditView" method="POST" action="index.php">
						<table cellspacing="0" cellpadding="0" width="100%" border="0" class="dcQuickEdit">
							<tbody>
								<tr>
									<td class="buttons">
										<input type="hidden" value="asol_Process" name="module">
										<input type="hidden" value="<?php echo $focus->id; ?>" name="record">
										<input type="hidden" value="false" name="isDuplicate">
										<input type="hidden" name="action">
										<input type="hidden" value="asol_Process" name="return_module">
										<input type="hidden" value="EditView" name="return_action">
										<input type="hidden" value="" name="return_id">
										<input type="hidden" name="module_tab">
										<input type="hidden" name="contact_role">
										<input type="hidden" value="asol_Process" name="relate_to">
										<input type="hidden" value="" name="relate_id">
										<input type="hidden" value="1" name="offset">
										<!-- to be used for id for buttons with custom code in def files-->
										<div class="action_buttons">
											<input type="submit" id="SAVE_HEADER" value="<?php echo $app_strings['LBL_SAVE_BUTTON_LABEL']; ?>" name="button" onclick="" class="button primary" accesskey="a" title="">
											<input type="button" id="CANCEL_HEADER" value="<?php echo $app_strings['LBL_CANCEL_BUTTON_LABEL']; ?>" name="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=index&module=asol_Process');" class="button" accesskey="l" title="">
											<div class="clear"></div>
										</div>
									</td>
									<td align="right">
									</td>
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
									<table cellspacing="1" cellpadding="0" width="100%" border="0" class="yui3-skin-sam edit view panelContainer" id="Default_asol_Process_Subpanel">
										<tbody>
											<tr>
												<td width="5%" valign="top" scope="col" id="name_label"> <?php echo $mod_strings['LBL_NAME']; ?>: <span class="required">*</span></td>
												<td width="5%" valign="top">
													<?php require_once("modules/asol_Process/customFields/name.php"); ?>
												</td>
												<td width="3%" valign="top" scope="col" id="status_label"> <?php echo $mod_strings['LBL_STATUS']; ?>: <?php echo wfm_utils::smarty_function_sugar_help(array("text"=>$mod_strings['LBL_POPUPHELP_FOR_FIELD_STATUS']),$sugar_smarty); ?>
												</td>
												<td width="15%" valign="top">
													<?php require_once("modules/asol_Process/customFields/status.php"); ?>
												</td>
												<td width="3%" valign="top" scope="col" id="async_label"> <?php echo $mod_strings['LBL_ASYNC']; ?>: <?php echo wfm_utils::smarty_function_sugar_help(array("text"=>$mod_strings['LBL_POPUPHELP_FOR_FIELD_ASYNC']),$sugar_smarty); ?>
												</td>
												<td width="15%" valign="top">
													<?php require_once("modules/asol_Process/customFields/async.php"); ?>
												</td>
												<td width="3%" valign="top" scope="col" id="data_source_label"> <?php echo $mod_strings['LBL_DATA_SOURCE']; ?>: <?php echo wfm_utils::smarty_function_sugar_help(array("text"=>$mod_strings['LBL_POPUPHELP_FOR_FIELD_DATA_SOURCE']),$sugar_smarty); ?>
												</td>
												<td width="50%" valign="top">
													<?php require_once("modules/asol_Process/customFields/data_source.php"); ?>
												</td>
											</tr>
											<tr>
												<td width="5%" valign="top" scope="col" id="description_label"> <?php echo $mod_strings['LBL_DESCRIPTION']; ?>: </td>
												<td width="50" valign="top" >
													<?php require_once("modules/asol_Process/customFields/description.php"); ?>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="edit view edit508  expanded" id="detailpanel_2">
									<h4>&nbsp;&nbsp; <a onclick="collapsePanel(2);" class="collapseLink" href="javascript:void(0)"> <img border="0" src="modules/asol_Process/___common_WFM/images/basic_search.gif?v=ttn-4I-G5zA_ijZVX7YRVg" id="detailpanel_2_img_hide"></a><a onclick="expandPanel(2);" class="expandLink" href="javascript:void(0)"> <img border="0" src="modules/asol_Process/___common_WFM/images/advanced_search.gif?v=ttn-4I-G5zA_ijZVX7YRVg" id="detailpanel_2_img_show"></a> <?php echo translate('LBL_DB_CONFIGURATION_PANEL', 'asol_Process'); ?>
									<script>
                                        document.getElementById('detailpanel_2').className += ' expanded';
									</script></h4>
									<table cellspacing="1" cellpadding="0" width="100%" border="0" class="yui3-skin-sam edit view panelContainer" id="LBL_DB_CONFIGURATION_PANEL">
										<tbody>
											<tr>
												<td width="3%" valign="top" scope="col" id="alternative_database_label">
													<?php echo $mod_strings['LBL_REPORT_USE_ALTERNATIVE_DB']; ?>:<?php echo wfm_utils::smarty_function_sugar_help(array("text"=>$mod_strings['LBL_POPUPHELP_FOR_FIELD_ALTERNATIVE_DATABASE']),$sugar_smarty); ?> 
												</td>
												<td width="15%" valign="top">
													<?php require_once("modules/asol_Process/customFields/alternative_database.php"); ?>
												</td>
												<td width="3%" valign="top" scope="col" id="trigger_module_label"> 
													<?php echo $mod_strings['LBL_TRIGGER_MODULE']; ?>: <span class="required">*</span><?php echo wfm_utils::smarty_function_sugar_help(array("text"=>$mod_strings['LBL_POPUPHELP_FOR_FIELD_TRIGGER_MODULE']),$sugar_smarty); ?>
												</td>
												<td width="10%" valign="top">
													<?php require_once("modules/asol_Process/customFields/trigger_module.php"); ?>
												</td>
												
												<?php 
													if (wfm_reports_utils::hasPremiumFeatures()) {
														require_once('modules/asol_Process/___common_WFM_premium/modules/asol_Process/customFields/html_for_field_audit.enterprise.php');
													} else {
														require_once('modules/asol_Process/customFields/html_for_field_audit.community.php');
													}
												?>
												
											</tr>
										</tbody>
									</table>
									<script type="text/javascript">
                                        SUGAR.util.doWhen("typeof initPanel == 'function'", function() {
                                            initPanel(2, 'expanded');
                                        });
									</script>
								</div>
								<div class="edit view edit508  expanded" id="detailpanel_3">
									<h4>
										&nbsp;&nbsp; <a onclick="collapsePanel(3);" class="collapseLink" href="javascript:void(0)"> <img border="0" src="modules/asol_Process/___common_WFM/images/basic_search.gif?v=ttn-4I-G5zA_ijZVX7YRVg" id="detailpanel_3_img_hide"></a><a onclick="expandPanel(3);" class="expandLink" href="javascript:void(0)"> <img border="0" src="modules/asol_Process/___common_WFM/images/advanced_search.gif?v=ttn-4I-G5zA_ijZVX7YRVg" id="detailpanel_3_img_show"></a> <?php echo translate('LBL_FORM_PANEL', 'asol_Process'); ?>
										<script>
								        	document.getElementById('detailpanel_3').className += ' expanded';
										</script>
									</h4>
									<table cellspacing="1" cellpadding="0" width="100%" border="0" class="yui3-skin-sam edit view panelContainer" id="LBL_FORM_PANEL">
										<tbody>
											<tr>
												<td width="3%" valign="top" scope="col" id="form_label"> 
													<?php echo translate('LBL_FORM', 'asol_Process'); ?>: <span class="required">*</span><?php echo wfm_utils::smarty_function_sugar_help(array("text"=> translate('LBL_POPUPHELP_FOR_FIELD_FORM', 'asol_Process')),$sugar_smarty); ?>
												</td>
												<td width="90%" valign="top">
													<?php require_once("modules/asol_Process/customFields/form.php"); ?>
												</td>
											</tr>
										</tbody>
									</table>
									<script type="text/javascript">
								        SUGAR.util.doWhen("typeof initPanel == 'function'", function() {
								            initPanel(3, 'expanded');
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
								<input type="submit" id="SAVE_FOOTER" value="<?php echo $app_strings['LBL_SAVE_BUTTON_LABEL']; ?>" name="button" onclick="" class="button primary" accesskey="a" title="<?php echo $app_strings['LBL_SAVE_BUTTON_TITLE']; ?>">
								<input type="button" id="CANCEL_HEADER" value="<?php echo $app_strings['LBL_CANCEL_BUTTON_LABEL']; ?>" name="button" onclick="SUGAR.ajaxUI.loadContent('index.php?action=index&module=asol_Process');" class="button" accesskey="l" title="">
								<div class="clear"></div>
							</div>
						</div>
					</form><script language="JavaScript" type="text/javascript"></script>
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
                        <?php echo $validationForTriggerModule; ?>
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
                        addToValidate('EditView', 'status', 'enum', false, 'Status');
                        addToValidate('EditView', 'alternative_database', 'varchar', false, 'Use Database');
                        addToValidateBinaryDependency('EditView', 'assigned_user_name', 'alpha', false, 'No match for field: Assigned to', 'assigned_user_id');
                        */
					</script>
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
		
		<link href="modules/asol_Process/css/asol_process_style.css?version=<?php wfm_utils::echoVersionWFM(); ?>" rel="stylesheet" type="text/css" />
	</body>
	
</html>
