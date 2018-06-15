<script>

function sugarcrmSave() {
	
	// I m using tinyMCE for textareas and POSTing form through AJAX. But when I m trying to save textarea value, it is taking old values on first click, but it takes updated values on second click
	if (typeof tinymce !== 'undefined') {
		tinymce.triggerSave();
	}
	
	if (!wfm_save()) {
		return false;
	}
	
	var _form = document.getElementById('EditView');
	_form.action.value = 'Save';
	if (check_form('EditView'))
		SUGAR.ajaxUI.submitForm(_form);
	return false;
}

function buttonSaveOnClick() {
	
	$("#EditView .primary").each(function() {
		this.setAttribute("onclick", '');
	});
	
	$("#EditView").submit(function(e) {
		console.log('submit');
		
		switch (asol_var['_REQUEST']['action']) {
			case 'wfeEditView':
				save();
				break;
			case 'EditView':
			default:
				sugarcrmSave();
				break;
		}
		
		return false;
	});
}

function loadJqueryScripts() {

	// Load javascript-libraries only if needed
	if (typeof jQuery === "undefined") {
		$LAB.script("modules/asol_Process/___common_WFM/js/jquery.min.js")
		.wait().script("modules/asol_Process/___common_WFM/plugins_js_css_images/jquery.ui/js/jquery.ui.min.js")
		.wait(function(){ main(); });
	} else if (typeof jQuery.ui === "undefined") {
		$LAB.script("modules/asol_Process/___common_WFM/plugins_js_css_images/jquery.ui/js/jquery.ui.min.js")
		.wait(function(){ main(); });
	} else {
		 main();
	}
}

function openSelectedItemInPopup(item_id, module, left, top) {
    
    var url = 'index.php?module='+module+'&offset=1&stamp=1368534347003501000&return_module=EmailTemplates&action=DetailView&record='+item_id;
    
    var popup = window.open(url, item_id, 'width=500, height=500, top='+top+', left='+left+', location=no, menubar=no, resizable=yes, scrollbars=yes, status=no, titlebar=no, toolbar=no');
    popup.focus();
}



// ! Deprecated
function rewriteOnClickCode_saveButton() {

	// Rewrite the onclick-code of the Save-button (because of ajaxUI-sugarcrm; but in EditView only exist ajax-submit-call-to-javascript-function, not ajaxUI-load-page)
	$("#EditView .primary").each(function() {
		var onclickCode = this.getAttribute("onclick");
		var new_onclickCode = "wfm_save();" + onclickCode;
		$(this).removeAttr("onclick");// setAttribute needs removeAttr before. Probably a bug.
		this.setAttribute("onclick", new_onclickCode);
	});

	/**
	 **** Old way to collect conditions info
	 	$("#EditView").bind("submit", function () { document.getElementById("activity_conditions").value=format_conditions(\'conditions_Table\'); } );
	*/
}

</script>
