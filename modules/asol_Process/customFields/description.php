<?php

global $mod_strings, $sugar_config;

if (isset($sugar_config['WFM_useTinyMCE']) && $sugar_config['WFM_useTinyMCE']) {
	require_once("modules/asol_Process/customFields/description.tinymce.php");
} else {
	
	switch ($_REQUEST['action']) {
		case 'wfeEditView':
		case 'EditView':
			echo "<textarea cols='120' rows='6' name='description' id='description' class='wfm_description_textarea' >{$focus->description}</textarea>";
			break;
		case 'DetailView':
			echo "<span name='description' id='description'>".nl2br($focus->description)."</span>";
			break;
	}
}