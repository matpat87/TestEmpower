<?php

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
wfm_utils::wfm_log('debug', 'ENTRY', __FILE__);

global $mod_strings;

?>

<link href="modules/asol_Process/css/asol_process_style.css?version=<?php  echo wfm_utils::echoVersionWFM(); ?>" rel="stylesheet" type="text/css" />
<script src="modules/asol_Process/___common_WFM/js/jquery.min.js?version=<?php wfm_utils::echoVersionWFM(); ?>" type="text/javascript"></script>

<script>
 	$(document).ready(function () {
 		$("#clean_wfm_working_tables_check").change(function() {
 	 		if (this.checked) {
 	 			$('#clean_broken_working_nodes').prop('checked', true);
 	 		} else {
 	 			$('#clean_broken_working_nodes, #clean_wfm_working_tables').prop('checked', false);
 	 		}
 		});

 		$("#execution_type_check").change(function() {
 	 		if (this.checked) {
 	 			$('#execute_queries_automatically').prop('checked', true);
 	 		} else {
 	 			$('#execute_queries_automatically, #only_print_queries').prop('checked', false);
 	 		}
 		});

 		$("#clean_wfm_definitions_check").change(function() {
 	 		$('#clean_deleted_wfm_entities, #clean_unrelated_wfm_entities').prop('checked', this.checked);
 		});

 		$("#others_check").change(function() {
 	 		$('#clean_deleted_login_audit, #clean_deleted_email_templates').prop('checked', this.checked);
 		});
 	});
</script>

<div>
	<h1><?php echo $mod_strings['LBL_CLEAN_WFM_TITLE']; ?></h1>
	<br>
	<h3><?php echo $mod_strings['LBL_CLEAN_WFM_STEP1']; ?></h3>
</div>
<br>
<form id='cleanWFM' name='cleanWFM' action='index.php?module=asol_Process&action=cleanWFM.step2' method='post' enctype='multipart/form-data'>
	<table id="clean_wfm_definitions" class="cleanWFM">
		<tr class='cleanWFM_border_bottom'>
			<th>
				<input type="checkbox" id="clean_wfm_definitions_check" name="clean_wfm_definitions_check" />
				<span><?php echo $mod_strings['LBL_CLEAN_WFM_DEFINITIONS']; ?></span>
			</th>
		</tr>
		<tr class='cleanWFM_border_bottom'>
			<td>
				<input type="checkbox" id="clean_deleted_wfm_entities" name="clean_deleted_wfm_entities"  /> <?php echo $mod_strings['LBL_CLEAN_DELETED_WFM_ENTITIES']; ?>
			</td>
		</tr>
		<tr>
			<td>
				<input type="checkbox" id="clean_unrelated_wfm_entities" name="clean_unrelated_wfm_entities"  /> <?php echo $mod_strings['LBL_CLEAN_UNRELATED_WFM_ENTITIES']; ?>
			</td>
		</tr>
	</table>
	
	<br>
	
	<table id="clean_wfm_working_tables" class='cleanWFM'>
		<tr class='cleanWFM_border_bottom'>
			<th>
				<input type="checkbox" id="clean_wfm_working_tables_check" name="clean_wfm_working_tables_check" />
				<span><?php echo $mod_strings['LBL_CLEAN_WFM_WORKING_TABLES_TITLE']; ?></span>
			</th>
		</tr>
		<tr class='cleanWFM_border_bottom'>
			<td>
				<input type='radio' name='clean_wfm_working_tables_type' value='clean_broken_working_nodes' id='clean_broken_working_nodes' /> <?php echo $mod_strings['LBL_CLEAN_BROKEN_WORKING_NODES']; ?>
			</td>
		</tr>
		<tr>
			<td>
				<input type='radio' name='clean_wfm_working_tables_type' value='clean_wfm_working_tables' id='clean_wfm_working_tables'/> <?php echo $mod_strings['LBL_CLEAN_WFM_WORKING_TABLES']; ?>
			</td>
		</tr>
	</table>
	
	<br>
	
	<table id="others" class="cleanWFM">
		<tr class='cleanWFM_border_bottom'>
			<th>
				<input type="checkbox" id="others_check" name="others_check" />
				<span><?php echo $mod_strings['LBL_OTHERS']; ?></span>
			</th>
		</tr>
		<tr class='cleanWFM_border_bottom'>
			<td>
				<input type="checkbox" id="clean_deleted_login_audit" name="clean_deleted_login_audit" /> <?php echo $mod_strings['LBL_CLEAN_DELETED_LOGIN_AUDIT']; ?>
			</td>
		</tr>
		<tr>
			<td>
				<input type="checkbox" id="clean_deleted_email_templates" name="clean_deleted_email_templates" /> <?php echo $mod_strings['LBL_CLEAN_DELETED_EMAIL_TEMPLATES']; ?>
			</td>
		</tr>
	</table>
	
	<br>
	
	<input id='cleanWFM' type='submit'  value='<?php echo $mod_strings['LBL_CLEANWFM_BUTTON']; ?>' /> [<?php echo $mod_strings['LBL_CLEANWFM_WARNING']; ?>]
</form>

<?php 
wfm_utils::wfm_log('debug', 'EXIT', __FILE__);
?>