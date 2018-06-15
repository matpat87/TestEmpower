<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

wfm_utils::wfm_log('debug', 'ENTRY', __FILE__);

?>

<div id='task_implementation.default' class="yui-navset detailview_tabs yui-navset-top" style='display: none'>  
</div>

<div id='task_implementation.get_objects' style='display: block'>
	<div>
		<label for="custom_variable_get_objects_name"><?php echo $mod_strings['LBL_CUSTOM_VARIABLE_GET_OBJECTS_NAME']; ?></label>
		<input type="text" id="custom_variable_get_objects_name" />
	</div>
	
	<br>
	<br>

	<table class='edit view taskImplementationTable'>
		<tr>
	 		<td>
	 			<?php echo $mod_strings['LBL_ASOL_OBJECT_MODULE']; require_once('modules/asol_Task/customFields/object_module.get_objects.php'); ?>
	 		</td>
	 		<td>
	 		</td>
	 	</tr>
	 	<tr>
	 		<td>
	 			<?php require_once('modules/asol_Task/customFields/module_fields.get_objects.php'); ?>
	 		</td>
	 		<td>
	 			<?php require_once('modules/asol_Task/customFields/module_conditions.get_objects.php'); ?>
	 		</td>
	 	</tr>
	 	
	 </table>
</div>