<?php 

function printFormFieldsSelect($form_id, $multiple, $show_idRelationships) {

	wfm_utils::wfm_log('asol_debug', '$form_id=['.var_export($form_id, true).']', __FILE__, __METHOD__, __LINE__);
	
	global $db, $beanList, $beanFiles, $mod_strings, $timedate, $sugar_config;
	
	$rhs_key = null;
	
	$formFields = wfm_utils::getFormFields($form_id);
	
	$fields = (isset($formFields['fields'])) ? $formFields['fields'] : null;
	$fields_labels = (isset($formFields['fields_labels'])) ? $formFields['fields_labels'] : null;
	$fields_type = (isset($formFields['fields_type'])) ? $formFields['fields_type'] : null;
	$fields_options = (isset($formFields['fields_options'])) ? $formFields['fields_options'] : null;
	$fields_options_db = (isset($formFields['fields_options_db'])) ? $formFields['fields_options_db'] : null;
	$fields_enum_operators = (isset($formFields['fields_enum_operators'])) ? $formFields['fields_enum_operators'] : null;
	$fields_enum_references = (isset($formFields['fields_enum_references'])) ? $formFields['fields_enum_references'] : null;
	$has_related = (isset($formFields['has_related'])) ? $formFields['has_related'] : null;
	$fields_labels_key = (isset($formFields['fields_labels_key'])) ? $formFields['fields_labels_key'] : null;
	$is_required = (isset($formFields['is_required'])) ? $formFields['is_required'] : null;
	$dropdowns = (isset($formFields['dropdowns'])) ? $formFields['dropdowns'] : null;
	
	$fieldsSelect = wfm_utils::wfm_generate_formFields_selectFields($fields, $rhs_key, $has_related, $fields_labels, $fields_labels_key, $multiple, $show_idRelationships);
	
	echo "
		<!-- Form Fields Select -->
	
		<table border=0 width='100%'>
			<tbody>
				<tr>
					<td>
						<table>
							<tr>
								<td>
									<h4>
										{$mod_strings['LBL_ASOL_FIELDS']}
									</h4>
								</td>
							</tr>
							<tr>
								<td>
									{$fieldsSelect}
								</td>
							</tr>
							<tr>
								<td>
									<input type='button' title='{$mod_strings['LBL_ASOL_ADD_FIELDS']}'	class='button' name='fields_button'	value='{$mod_strings['LBL_ASOL_ADD_FIELDS']}' onClick='onClick_addFormFields_button();'>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	";
									
	return Array(
		'fields' => $fields,
		'fields_labels' => $fields_labels,
		'fields_type' => $fields_type,
		'fields_options' => $fields_options,
		'fields_options_db' => $fields_options_db,
		'fields_enum_operators' => $fields_enum_operators,
		'fields_enum_references' => $fields_enum_references,
		'has_related' => $has_related,
		'fields_labels_key' => $fields_labels_key,
		'is_required' => $is_required,
		'dropdowns' => $dropdowns,
	);
}
?>