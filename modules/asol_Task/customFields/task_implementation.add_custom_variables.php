<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

wfm_utils::wfm_log('debug', 'ENTRY', __FILE__);

?>

<div id='task_implementation.default' class="yui-navset detailview_tabs yui-navset-top" style='display: none'>  
</div>

<div id='task_implementation.add_custom_variables' style='display: block'>
	<table class='edit view taskImplementationTable'>
		<tr>
	 		<td>
	 		
	 			<?php 
	 			
	 			$data_source = $focus->getDataSource();
	 			
	 			switch ($data_source) {
	 				
	 				case 'form':
	 					
	 					$asol_forms_id_c = $focus->getAsolFormsIdC();
	 					$form_id = $asol_forms_id_c;
	 						
	 					$form_disabled = true;
	 						
	 					if (!empty($form_id)) {
	 						$form_bean = wfm_utils::getBean('asol_Forms', $form_id);
	 						$form_name = $form_bean->name;
	 					} else {
	 						$form_name = '';
	 					}
	 					
	 					echo translate('LBL_FORM', 'asol_Process');
 						echo wfm_utils::wfm_generate_field_relate('asol_forms_id_c', $form_id, 'form', $form_name, 'asol_Forms', $form_disabled);
	 					
	 					break;
	 					
	 				case 'database':
	 					
	 					echo $mod_strings['LBL_ASOL_OBJECT_MODULE'];
	 					require_once('modules/asol_Task/customFields/object_module.add_custom_variables.php');
	 						
	 					if (wfm_reports_utils::hasPremiumFeatures()) {
	 						require_once('modules/asol_Process/___common_WFM_premium/modules/asol_Task/customFields/html_for_field_audit.enterprise.php');
	 					} else {
	 						require_once('modules/asol_Task/customFields/html_for_field_audit.community.php');
	 					}
	 					
	 					break;
	 			}
					
				?>
	 		</td>
	 		<td>
	 		</td>
	 	</tr>
	 	<tr>
	 		<td>
	 			<?php require_once('modules/asol_Task/customFields/module_fields.add_custom_variables.php'); ?>
	 		</td>
	 		<td>
	 			<?php require_once('modules/asol_Task/customFields/values.add_custom_variables.php'); ?>
	 		</td>
	 	</tr>
	 	<tr style='display: none;'>
			<td>
				<h4><?php echo $mod_strings['LBL_ADD_NOT_A_FIELD_TITLE']; ?></h4>
			</td>
		</tr>
	 	<tr>
	 		<td>
	 			<input type='button' id='acv_add_button' onClick='onClick_addNotAField_button();' value='<?php echo $mod_strings['LBL_ADD_NOT_A_FIELD_BUTTON']; ?>' title='<?php echo $mod_strings['LBL_ADD_NOT_A_FIELD_BUTTON']; ?>'>
	 		</td>
	 	</tr>
	 </table>
</div>