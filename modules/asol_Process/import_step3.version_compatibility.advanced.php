<?php

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");
wfm_utils::wfm_log('debug', 'ENTRY', __FILE__);

$imported_workflows = $_SESSION['imported_workflows'];

$workflows_version = isset($imported_workflows['version']) ? $imported_workflows['version'] : null;

?>

<link href="modules/asol_Process/css/asol_process_style.css?version=<?php  echo wfm_utils::echoVersionWFM(); ?>" rel="stylesheet" type="text/css" />

<div>
	<h1><?php echo translate('LBL_IMPORT_TITLE_ADVANCED', 'asol_Process'); ?></h1>
	<br>
	<h3><?php echo translate('LBL_IMPORT_STEP3_VERSION_COMPATIBILITY_ADVANCED', 'asol_Process'); ?></h3>
</div>

<br>

<?php 

	if ($workflows_version === null) {
		echo 'The file was exported from a WFM version prior to the introduction of "automatically migrate workflows when importing exported-workflows-file" (WFM v5.11.0)';
		echo '<br>';
		echo 'Tip: Do not migrate';
	} else {
	
		if (version_compare($workflows_version, wfm_utils::$wfm_release_version, '<')) { // Migrate
			echo "Workflow's version < WFM's version";
			echo '<br>';
			echo 'Tip: Migrate';
		} elseif (version_compare($workflows_version, wfm_utils::$wfm_release_version, '>')) { // Do not migrate // Not possible // ¿Force migrate?
			echo "Workflow's version > WFM's version";
			echo '<br>';
			echo 'Tip: Do not migrate';
		} elseif (version_compare($workflows_version, wfm_utils::$wfm_release_version, '==')) { // Do not migrate // Not needed
			echo "Workflow's version = WFM's version";
			echo '<br>';
			echo 'Tip: Do not migrate';
		}
	}

?>

<br>
<br>

<form id='import_form' name='import_form' action='index.php?module=asol_Process&action=import_step_final.advanced' method='post' enctype='multipart/form-data'>
	
	<input type='radio' name='version_compatibility_type' value='migrate' checked /><?php echo 'Migrate' ?>
	<br>
	<input type='radio' name='version_compatibility_type' value='do_not_migrate' /><?php echo 'Do not migrate'; ?>
	
	<br>
	<br>
	
	<input id='import' type='submit'  value='<?php echo translate('LBL_IMPORT_ADVANCED', 'asol_Process'); ?>' />
</form>

<?php 

$_SESSION['import_type'] = $import_type = $_REQUEST['import_type'];
$_SESSION['rename_type'] = $rename_type = $_REQUEST['rename_type'];
$prefix = ($import_type == 'clone') ? $_REQUEST['prefix'] : '';
$_SESSION['prefix'] = $prefix = ($rename_type == 'keep_names') ? '' : $prefix;
$suffix = ($import_type == 'clone') ? $_REQUEST['suffix'] : '';
$_SESSION['suffix'] = $suffix = ($rename_type == 'keep_names') ? '' : $suffix;
$_SESSION['set_status_type'] = $set_status_type = $_REQUEST['set_status_type'];

$_SESSION['import_email_template_type'] = $import_email_template_type = $_REQUEST['import_email_template_type'];
$_SESSION['if_email_template_already_exists'] = $if_email_template_already_exists = $_REQUEST['if_email_template_already_exists'];

$_SESSION['import_domain_type'] = $import_domain_type = $_REQUEST['import_domain_type'];
$_SESSION['explicit_domain'] = $explicit_domain = $_REQUEST['explicit_domain'];

wfm_utils::wfm_log('debug', 'EXIT', __FILE__);