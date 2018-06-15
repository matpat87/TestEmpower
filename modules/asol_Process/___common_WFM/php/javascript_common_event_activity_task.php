<script>

function fill_info_icon() {

	var task_type_array = ['send_email', 'php_custom', 'continue', 'end', 'call_process'];
	var lbl_asol_info_icon_array = [];
	for (var i in task_type_array) {
		lbl_asol_info_icon_array[task_type_array[i]] = SUGAR.language.get('asol_Task', 'LBL_ASOL_INFO_ICON_'+task_type_array[i].toUpperCase());
	}

	$("#info_icon").attr("qtip_info", lbl_asol_info_icon_array[$("#task_type").val()]);

	
	$('#info_icon').qtip({
		content: {
			attr: 'qtip_info'
		},
		style: {
			classes: 'ui-tooltip-rounded ui-tooltip-shadow myTooltip'
		},
		position: {
			my: 'bottom right',
			at: 'top left'
		}
	});
}

function onClick_showRelated_button(button) {
	
	window.onbeforeunload = function () {
		return;
	};

	var fields_dropdown = document.getElementById('fields');
	if ((fields_dropdown.options[fields_dropdown.selectedIndex].style.color == 'blue')) {
		button.form.action.value = asol_var['_REQUEST']['action'];
		button.form.rhs_key.value = fields_dropdown.value;

		if (button.form.scheduled_tasks_hidden !== undefined)  {
			button.form.scheduled_tasks_hidden.value = format_tasks();
		}
		if (button.form.conditions !== undefined) {
			button.form.conditions.value = format_conditions('conditions_Table');
		}
		if (button.form.task_implementation_hidden !== undefined) {
			button.form.task_implementation_hidden.value = format_taskImplementation('task_type');
		}
		button.form.submit();
	} 
}

function generateTitleForFieldName(fieldLabel, fieldInternalName, relatedKey) {
	
	var title = '';
	title += SUGAR.language.get(wfm_module, 'LBL_FIELD_LABEL') + ": " + fieldLabel;
	title += "\n";
	title += SUGAR.language.get(wfm_module, 'LBL_FIELD_INTERNAL_NAME') + ": " + fieldInternalName;
	if (relatedKey.length > 0) {
		title += "\n";
		title += SUGAR.language.get(wfm_module, 'LBL_RELATED_KEY') + ": " + relatedKey;
	}
	
	return title;
}

</script>